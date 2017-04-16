<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $email = '';
    protected $code = '';
    protected $username = '';
    protected $is_admin = false;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $username, $code, $is_admin = false)
    {
        $this->email = $email;
        $this->code = $code;
        $this->username = $username;
        $this->is_admin = $is_admin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->is_admin){
            $data = [
                'url' => url('admin/active?') . 'email=' . $this->email . '&code=' . $this->code,
                'slot' => '尊敬的' . $this->username . ',您注册了orangeshop，点击该链接，激活用户,有效时间为1个小时'
            ];
        }else{
            $data = [
                'url' => url('active?') . 'email=' . $this->email . '&code=' . $this->code,
                'slot' => '尊敬的' . $this->username . ',您注册了orangeshop，点击该链接，激活用户,有效时间为1个小时'
            ];
        }

        return $this->subject('来自orangeshop的激活邮箱')
            ->view('vendor.mail.html.promotion.button')
            ->with($data);
    }
}
