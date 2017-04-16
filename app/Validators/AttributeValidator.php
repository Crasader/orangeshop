<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class AttributeValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|max:30',
            'show_type' => 'required|integer|in:0,1,2',
            'is_filter' => 'required|integer|in:0,1',
            'order' => 'required|integer'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'max:30',
            'show_type' => 'integer|in:0,1,2',
            'is_filter' => 'integer|in:0,1',
            'order' => 'integer'
        ],
   ];
}
