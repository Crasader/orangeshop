<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Admin\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{


    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/register';
    protected $guard = 'admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'username' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {

        return Admin::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'last_visit_ip' => \Request::ip()
        ]);
    }

    //重写展示登录页面的方法
    public function showRegistrationForm()
    {
        return view('admin.auth.register');
    }

    //重写post注册方法，防止登录
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        return redirect('/admin/register')->with(['message' => '验证邮箱已发送，请查看邮件']);
    }

    //邮箱激活
    public function active(Request $request)
    {
        $admin = Admin::where('email',$request->get('email'))->first();
        //已经激活的不要处理，防止重复连接点击
        if($admin->verify_email == 1){
            return redirect('/admin/login')->with(['message' => '邮箱已被激活，管理员审查通过后，请登录系统']);
        }

        $expire = decrypt($request->get('code'));
        $hours = Carbon::now()->diffInHours($expire);
        if ($hours > 1) {
            //说明连接失效，删除未验证的，重新注册
            if($admin->verify_email == 0){
                $admin->delete();
            }
            return redirect('/admin/register')->withErrors(['message' => '连接已经失效，请重新注册']);
        } else {
            $admin->verify_email = 1;
            $admin->save();
            return redirect('/admin/login')->with(['message' => '邮箱激活成功，管理员审查通过后，请登录系统']);
        }
    }
}
