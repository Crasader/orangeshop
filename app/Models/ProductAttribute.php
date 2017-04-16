<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $table = 'product_attributes';
    protected $primaryKey = 'record_id';
    public $timestamps = false;

    protected $fillable = [
        'pid','attr_id','attr_value_id','add_money'
    ];
}
