<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Notifications\Notifiable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class Admin extends Authenticatable implements Transformable
{
    use TransformableTrait, EntrustUserTrait,Notifiable;

    protected $primaryKey = 'user_id';
    protected $fillable = [
        "username",
        "email",
        "password",
        "is_super",
        "mobile",
        "verify_email",
        "verify_mobile",
        "state",
        "last_visit_time",
        "last_visit_ip",
        "remember_token",
    ];

}
