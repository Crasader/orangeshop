<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class PromotionBuySendValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name'=>'required',
            'start_time'=>'required|date',
            'end_time'=>'required|date|after:start_time',
            'type'=>'required|in:0,1,2',
            'buy_count'=>'required|integer',
            'send_count'=>'required|integer',
            'state'=>'required|in:0,1',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name'=>'required',
            'start_time'=>'required|date',
            'end_time'=>'required|date|after:start_time',
            'type'=>'required|in:0,1,2',
            'buy_count'=>'required|integer',
            'send_count'=>'required|integer',
            'state'=>'required|in:0,1',
        ],
   ];
}
