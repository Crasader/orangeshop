<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class PromotionFullSendValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            "name"=>'required',
            "start_time"=>'required|date',
            "end_time"=>'required|date|after:start_time',
            "state"=>'in:0,1',
            "limit_money"=>'required|numeric',
        ],
        ValidatorInterface::RULE_UPDATE => [],
   ];
}
