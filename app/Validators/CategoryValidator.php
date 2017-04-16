<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class CategoryValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|max:30',
            'parent_id' =>'required|integer',
            'is_show' => 'required|in:0,1',
            'is_nav' => 'required|in:0,1',
            'state' => 'required|in:0,1',
            'order' => 'required|integer'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|max:30',
            'parent_id' =>'required|integer',
            'is_show' => 'required|in:0,1',
            'is_nav' => 'required|in:0,1',
            'state' => 'required|in:0,1',
            'order' => 'required|integer'
        ],
    ];
}
