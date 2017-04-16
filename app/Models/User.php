<?php

namespace App\Models;

use App\Models\OrderProduct;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $fillable = [
        "username",
        "email",
        "password",
        "mobile",
        "verify_email",
        "verify_mobile",
        "level_id",
        "last_visit_time",
        "last_visit_ip",
        "register_ip",
        "register_rg_id",
        "sex",
        'state',
        "remember_token",
    ];

    //hasMany 购物车
    public function order_products()
    {
        return $this->hasMany(OrderProduct::class,'uid');
    }

    //1:n 订单
    public function orders()
    {
        return $this->hasMany(Order::class,'uid');
    }

    //1:n 地址
    public function addresses()
    {
        return $this->hasMany(Address::class,'user_id');
    }

    //浏览历史
    public function product_histories(){
        return $this->belongsToMany(Product::class,'user_browse_histories','uid','pid')->withTimestamps()->withPivot('time');
    }
}
