<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class ProductValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            "name" => 'required',
            "cate_id" => 'required|integer',
            "brand_id" => 'required|integer',
            "order" => 'integer',
            "cost_price" => 'required|numeric',
            "market_price" => 'required|numeric',
            'state'=>'required|in:0,1',
            "shop_price" => 'required|numeric',
            "weight" => 'required|numeric',
            "stock" => 'required|integer',
            "stock_limit" => 'required|integer',
            'is_hot' => 'in:1',
            'is_new' => 'in:1',
            'is_best' => 'in:1',
            "description" => '',

        ],
        ValidatorInterface::RULE_UPDATE => [],
   ];
}
