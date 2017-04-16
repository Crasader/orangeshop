<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class AttributeValue extends Model implements Transformable
{
    use TransformableTrait;
    protected $primaryKey = 'attr_value_id';

    protected $fillable = [
        'attr_id',
        'attr_value_0',
        'attr_value_1',
        'attr_value_2',
        'order'
    ];

    //多对一 belongsTo
    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attr_id','attr_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class,'product_attributes','pid','attr_value_id')
            ->withPivot(['add_money','attr_id']);
    }

}
