<?php

namespace App\Http\Controllers\Home\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function showLoginForm()
    {
        return view('home.auth.login');
    }

    public function login(Request $request)
    {
        //邮箱登录
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $remember = $request->get('remember', 0) == 1;
        //手机登录
        $rst = Auth::attempt(['mobile' => $request->get('username'), 'password' => $request->get('password')],$remember);

        //邮箱登录
        if (!$rst) {
            $rst = Auth::attempt(['email' => $request->get('username'), 'password' => $request->get('password')],$remember);
        }

        //用户名登录
        if (!$rst) {
            $rst = Auth::attempt(['email' => $request->get('username'), 'password' => $request->get('password')],$remember);
        }

        if ($rst) {
            $message = [
                'error' => 0
            ];
        } else {
            $message = [
                'error' => 1
            ];
        }

        return response()->json($message);
    }
}
