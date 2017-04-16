<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Admin\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/brand';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => 'logout']);
    }

    /**
     * 如果账户和密码都正确，验证邮箱和state状态.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->verify_email == 0 || $user->state == 0) {
            $this->guard()->logout();
            $request->session()->flush();
            $request->session()->regenerate();
            if ($user->verify_email == 0) {
                $response = ['message' => '邮箱未验证'];
            } else {
                $response = ['message' => '审查未通过，请联系管理员'];
            }

            return redirect('/admin/login')->withErrors($response);
        }
    }

    // 重写登录
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    //重写获取guard
    protected function guard()
    {
        return Auth::guard('admin');
    }

    //重写logout
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/admin/login');
    }

}
