<?php

namespace App\Listeners;

use App\Mail\RegisterMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class RegisteredListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 监听用户注册事件，发送邮件.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        if($event->user->verify_email == 0){
            $code = encrypt($event->user->created_at);
            //应该判断是管理员还是普通用户，分别调用不同的模板
            if($event->user->getTable() == 'users'){
                $is_admin = false;
            }else{
                $is_admin =true;
            }
            Mail::to($event->user->email)
                ->queue(new RegisterMail($event->user->email, $event->user->username, $code,$is_admin));
        }
    }
}
