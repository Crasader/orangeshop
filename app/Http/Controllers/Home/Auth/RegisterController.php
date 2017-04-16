<?php

namespace App\Http\Controllers\Home\Auth;

use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            //'username' => 'bail|required|max:255',
            'email' => 'bail|required|email|max:255|unique:users',
            'password' => 'bail|required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => '商城用户',
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'register_ip' => \Request::ip(),
            'last_visit_ip'=>\Request::ip(),
            'last_visit_time'=>Carbon::now()->toDateTimeString()
        ]);
    }

    //邮箱注册的用户需要邮箱激活
    public function active(Request $request )
    {
        $user = User::where('email',$request->get('email'))->first();
        //已经激活的不要处理，防止重复连接点击
        if($user->verify_email == 1){
            return redirect('/login')->with(['message' => '邮箱已被激活，请登录商城']);
        }

        $expire = decrypt($request->get('code'));
        $hours = Carbon::now()->diffInHours($expire);
        if ($hours > 1) {
            //说明连接失效，删除未验证的，重新注册
            if($user->verify_email == 0){
                $user->delete();
            }
            return redirect('/register')->withErrors(['message' => '连接已经失效，请重新注册']);
        } else {
            $user->verify_email = 1;
            $user->save();
            Auth::login($user);
        }
    }

    public function showRegistrationForm()
    {
        return view('home.auth.register');
    }
}
