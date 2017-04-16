<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Models\Attribute
 *
 * @mixin \Eloquent
 */
class Attribute extends Model implements Transformable
{
    use TransformableTrait;
    protected $primaryKey = 'attr_id';

    protected $fillable = [
        'name','is_filter','is_show','show_type','order'
    ];

    //一对多 hasMany
    public function attribute_values()
    {
        return $this->hasMany(AttributeValue::class,'attr_id');
    }

    //belongsToMany 商品
    public function products()
    {
        return $this->belongsToMany(Product::class,'product_attributes','pid','attr_id')
            ->withPivot(['attr_value_id','add_money']);
    }
}
