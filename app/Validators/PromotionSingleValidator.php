<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class PromotionSingleValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            "name"=>'required',
            "pid"=>'required|integer',
            "start_time"=>'required|date',
            "end_time"=>'required|date|after:start_time',
            "slogan"=>'required',
            "discount_type"=>'required|in:0,1',
            "discount_value"=>'required|numeric',
            "state"=>'in:0,1',
        ],
        ValidatorInterface::RULE_UPDATE => [
            "name"=>'required',
            "pid"=>'required|integer',
            "start_time"=>'required|date',
            "end_time"=>'required|date|after:start_time',
            "slogan"=>'required',
            "discount_type"=>'required|in:0,1',
            "discount_value"=>'required|numeric',
            "state"=>'in:0,1',
        ],
   ];
}
