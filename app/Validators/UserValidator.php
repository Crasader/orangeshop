<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class UserValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
        ],
        ValidatorInterface::RULE_UPDATE => [
            "username"=>'required',
            "email"=>'email',
            "password"=>'required|confirmed',
            "mobile"=>'mobile',
            "verify_email"=>'in:0,1',
            "verify_mobile"=>'in:0,1',
            "level_id"=>'integer',
            "last_visit_time",
            "last_visit_ip"=>'ip',
            "register_ip"=>'ip',
            "register_rg_id"=>'ip',
            "sex"=>'in:0,1',
            'state'=>'in:0,1',
        ],
   ];
}
