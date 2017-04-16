<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Mail\RegisterMail;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class AuthController extends Controller
{
    use SendsPasswordResetEmails,ThrottlesLogins,AuthenticatesUsers;

    protected $redirectPath = '/admin/index';

    protected $redirectAfterLogout = '/admin';

    protected $guard = 'admin';

    protected $loginView = 'admin.auth.login';

    protected $registerView = 'admin.auth.register';

    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => 'logout']);
    }

    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $data = [
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'verify_email' => 1,
            'state' => 1
        ];

        if(Auth::guard('admin')->attempt($data)){
            //验证通过，更新登录时间和ip字段
            $admin = Admin::find($data['email']);
            $admin->last_visit_time = Carbon::now()->toDateTimeString();
            $admin->last_visit_ip = $request->ip();
            $admin->save();
            return redirect('admin/product');
        }else{
            return redirect()->back()->withErrors(['message'=>'当前用户禁止登陆,请联系管理员']);
        }
    }

    public function showRegister()
    {
        return view('admin.auth.register');
    }

    public function register(Request $request)
    {
        $rules = [
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ];
        $this->validate($request, $rules);
        $data = [
            'last_visit_ip' => $request->ip(),
        ];
        $data = array_merge($data, $request->all());
        $rst = Admin::create($data);
        if ($rst) {
            //发送邮件
            //获取邮箱验证时的随机串
            $code = encrypt($rst->created_at);
            Mail::to($request->get('email'))
                ->queue(new RegisterMail($request->get('email'), $request->get('username'), $code));

            return back()->with(['message' => '验证邮箱已发送，请查看邮件']);
        } else {
            return back()->withErrors(['message' => '注册失败，请稍后重试']);
        }
    }

    public function showPassword()
    {

    }

    public function password()
    {

    }

    public function active(Request $request)
    {
        $admin = Admin::findOrFail($request->get('email'));
        $expire = decrypt($request->get('code'));
        $hours = Carbon::now()->diffInHours($expire);
        if ($hours > 1) {
            //说明连接失效，删除已经注册的用户，重新注册
            if($admin->verify_email == 0){
                $admin->delete();
            }
            return redirect('admin/register')->withErrors(['message' => '连接已经失效，请重新注册']);
        } else {
            $admin->verify_email = 1;
            $admin->save();
            return redirect('admin/login')->with(['message' => '邮箱激活成功，管理员审查通过后，请登录系统']);
        }
    }
}
