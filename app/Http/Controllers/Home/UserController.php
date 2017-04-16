<?php

namespace App\Http\Controllers\Home;

use App\Mail\UserEmailReset;
use App\Models\Address;
use App\Models\City;
use App\Models\Product;
use Carbon\Carbon;
use Flc\Alidayu\App;
use Flc\Alidayu\Client;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Session;
use Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        //我的日历
        $carbon = Carbon::now();
        //订单详情：等待付款、等待发货、待收货、退换货
        //0-未处理、1-已收款、2-已发货、3-已完成、4-取消订单
        $user = $request->user();
        $order_before_pay = $user->orders()->where('state_code_id', 0)->get();
        $order_before_send = $user->orders()->where('state_code_id', 2)->get();
        $order_before_receive = $user->orders()->where('state_code_id', 3)->get();

        //我的物流

        //最近新品
        $new_products = Product::where(['is_new' => 1, 'state' => 1])->get();
        $new_products_2 = $new_products->filter(function ($value) {
            return Carbon::parse($value->created_at)->diffInMonths() < 2;
        });
        $new_count = $new_products_2->count();
        $new_product = $new_products->sortBy('updated_at')->first();
        //热门产品
        $hot_products = Product::where(['is_hot' => 1, 'state' => 1])->orderBy('updated_at', 'desc')->take(8)->get();

        return view('home.user.index', compact('hot_products', 'new_count', 'new_product', 'carbon',
            'order_before_pay', 'order_before_send', 'order_before_receive','user'
        ));
    }

    //个人中西
    public function information(Request $request)
    {
        $user = $request->user();

        return view('home.user.information', compact('user'));
    }

    public function update(Request $request)
    {
        //只能更新自己的信息
        $user = $request->user();
        $rst = $user->update($request->all());

        if ($rst) {
            return back()->with(['message' => '修改成功', 'type' => 'success']);
        } else {
            return back()->with(['message' => '修改成功', 'type' => 'warning']);
        }
    }

    //安全设置
    public function safety(Request $request)
    {
        $user = $request->user();

        return view('home.user.safety', compact('user'));
    }

    //密码修改
    public function password()
    {
        return view('home.user.password');
    }

    //修改密码
    public function passwordReset(Request $request)
    {
        $rules = [
            'password' => 'bail|required|min:4',
            'new_password' => 'bail|required|min:4|confirmed',
        ];
        $message = [
            'password.required' => '必须填写原密码',
            'password.min' => '原密码不正确',
            'new_password.required' => '必须填写新密码',
            'new_password.min' => '新密码长度必须大于 :min',
            'new_password.confirmed' => '新密码不匹配'
        ];
        $this->validate($request, $rules, $message);

        $old_password = $request->get('password');
        $new_password = $request->get('new_password');

        $user = $request->user();
        if (hash_equals($user->password, $old_password)) {
            return back()->withErrors(['msg' => '原密码不正确']);
        }

        $user->password = bcrypt($new_password);
        $user->save();

        return back()->with(['message' => '密码修改成功', 'type' => 'success']);
    }

    //绑定、验证邮箱
    public function email(Request $request)
    {
        $user = $request->user();
        return view('home.user.email', compact('user'));
    }

    public function sendEmail(Request $request)
    {
        if ($request->ajax()) {
            $to = $request->get('email');
            $code = str_random(4);
            //保存一下验证码
            Session::put('email_code', $code);

            Mail::to($to)->queue(new UserEmailReset($code));

            return response()->json(['message' => '验证码发送成功，请查收', 'error' => 0]);
        }
    }

    public function emailReset(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'code' => 'required',
            'password' => 'required'
        ];
        $this->validate($request, $rules);

        $email = $request->get('email');
        $code = $request->get('code');
        $password = $request->get('password');

        //获取session中的code
        $session_code = session('email_code', 0);
        if ($session_code == 0) {
            return back()->withErrors(['msg' => '验证码已失效，请重新发送邮件', 'error' => 1]);
        }
        if ($code != $session_code) {
            return back()->withErrors(['msg' => '验证码不正确', 'error' => 1]);
        }

        $user = $request->user();
        if ($user->password != bcrypt($password)) {
            return back()->withErrors(['msg' => '密码不正确', 'error' => 1]);
        }

        try {
            $user->email = $email;
            $user->verify_email = 1;
            $user->save();
        } catch (\Exception $exception) {
            return redirect('/user/safety')->with(['message' => '邮箱换绑失败,请重新再试', 'type' => 'warning']);
        } finally {
            //删除session中的
            session()->forget('email_code');
        }

        return redirect('/user/safety')->with(['message' => '邮箱换绑成功', 'type' => 'success']);
    }

    //绑定、验证手机
    public function mobile(Request $request)
    {
        $user = $request->user();
        return view('home.user.mobile', compact('user'));
    }

    public function sendMobileCode(Request $request)
    {
        if ($request->ajax()) {
            $to = $request->get('mobile');
            $code = str_random(4);
            //保存一下验证码
            Session::put('mobile_code', $code);

            $config = [
                'app_key' => env('ALIDAYU_APP_KEY', 0),
                'app_secret' => env('ALIDAYU_APP_SECRET', 0),
            ];
            Client::configure($config);
            $client = new Client(new App($config));
            $req = new AlibabaAliqinFcSmsNumSend;
            $code = str_random(4);
            $req->setRecNum($to)
                ->setSmsParam([
                    'name' => isset(\Auth::user()->username) ? \Auth::user()->username : 'orangeshop商城用户',
                    'code' => $code
                ])
                ->setSmsFreeSignName('橘子商城')
                ->setSmsTemplateCode('SMS_53530005');

            $resp = $client->execute($req);

            //发送成功，记录
            if ($resp->result->success) {
                return response()->json(['message' => '验证码发送成功，请查收', 'error' => 0]);
            } else {
                Session::forget('mobile_code');
                return response()->json(['message' => '验证码发送失败，请稍后重试', 'error' => 1]);
            }
        }
    }

    public function mobile_reset(Request $request)
    {
        $rules = [
            'mobile' => 'required|email',
            'code' => 'required',
            'password' => 'required'
        ];
        $this->validate($request, $rules);

        $mobile = $request->get('mobile');
        $code = $request->get('code');
        $password = $request->get('password');

        //获取session中的code
        $session_code = session('mobile_code', 0);
        if ($session_code == 0) {
            return back()->withErrors(['msg' => '验证码已失效，请重新发送验证码', 'error' => 1]);
        }
        if ($code != $session_code) {
            return back()->withErrors(['msg' => '验证码不正确', 'error' => 1]);
        }

        $user = $request->user();
        if ($user->password != bcrypt($password)) {
            return back()->withErrors(['msg' => '密码不正确', 'error' => 1]);
        }

        try {
            $user->mobile = $mobile;
            $user->verify_mobile = 1;
            $user->save();
        } catch (\Exception $exception) {
            return redirect('/user/safety')->with(['message' => '手机换绑失败,请重新再试', 'type' => 'warning']);
        } finally {
            //删除session中的
            session()->forget('mobile_code');
        }

        return redirect('/user/safety')->with(['message' => '手机换绑成功', 'type' => 'success']);
    }

    //地址管理
    public function address(Request $request)
    {
        $user = $request->user();
        $addresses = $user->addresses;

        foreach ($addresses as &$address) {
            $address->province = $address->province ? $address->province->name : '';
            $address->city = $address->city ? $address->city->name : '';
            $address->district = $address->district ? $address->district->name : '';
        }

        $provinces = City::where('level', 1)->get();

        return view('home.user.address', compact('arr_addresses', 'addresses', 'provinces'));
    }

    //添加
    public function addressAdd(Request $request)
    {
        $user = $request->user();
        $data = $request->all();
        $data['user_id'] = $user->id;
        if ($user->addresses->count() == 0) {
            $data['is_default'] = 1;
        }

        Address::create($data);

        return redirect('/user/address');
    }

    //更新
    public function addressUpdate(Request $request)
    {
        $address_id = $request->get('address_id');

        //判断是否是授权
        $address = $request->user()->addresses->where('address_id', $address_id)->first();
        if (!$request->user()->can('update', $address)) {
            return response()->json(['message' => '设置失败', 'error' => 1]);
        }

        DB::transaction(function () use ($address_id) {
            DB::table('addresses')->where('is_default', 1)->update(['is_default' => 0]);
            DB::table('addresses')->where('address_id', $address_id)->update(['is_default' => 1]);
        });

        return response()->json(['message' => '设置成功', 'error' => 0]);
    }

    //删除地址
    public function addressDelete(Request $request)
    {
        $address_id = $request->get('address_id');

        //判断是否是授权
        $addresses = $request->user()->addresses;
        $address = $addresses->where('address_id', $address_id)->first();

        if (!$request->user()->can('delete', $address)) {
            return response()->json(['message' => '删除失败', 'error' => 2]);
        }

        $rst = true;
        //判断是否删除的是默认的，如果是，重新定义默认
        if ($address->is_default == 1) {
            $address_default = $addresses->where('is_default', '!=', '1')->first();
            if ($address_default) {
                $address_default->is_default = 1;
                $rst = $address_default->save();
            }
        }

        if ($rst) {
            $address->delete();
            return response()->json(['message' => '删除成功', 'error' => 0]);
        } else {
            return response()->json(['message' => '删除失败', 'error' => 1]);
        }

    }

    //订单管理
    public function order()
    {
        return view('home.user.order');
    }

    //订单详情
    public function orderinfo()
    {
        return view('home.user.orderinfo');
    }

    //浏览历史
    public function history(Request $request)
    {
        $user = $request->user();
        $histories = $user->product_histories;

        //今天
        $today_histories = $histories->filter(function ($vale){
            return Carbon::parse($vale->pivot->updated_at)->day == Carbon::now()->day;
        })->sortBy(['updated_at','desc'])->take(6);

        //一周以内
        $week_histories = $histories->filter(function ($vale){
            return Carbon::parse($vale->pivot->updated_at)->between(Carbon::now()->subDay(7),Carbon::now()->subDay(1));
        })->sortBy(['updated_at','desc'])->take(12);

        return view('home.user.history',compact('today_histories','week_histories'));
    }
}
