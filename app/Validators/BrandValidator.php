<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class BrandValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|max:20',
            'order' => 'required|numeric',
            'state' => 'required|numeric',
            'logo_path' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'max:20',
            'order' => 'numeric',
            'state' => 'numeric',
        ],
   ];
}
