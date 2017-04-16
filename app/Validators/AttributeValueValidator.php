<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class AttributeValueValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'attr_id' => 'required|integer',
            'order' => 'required|integer'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'attr_id' => 'required|integer',
            'order' => 'integer'
        ],
    ];
}
