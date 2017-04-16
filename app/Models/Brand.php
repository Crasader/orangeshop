<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Models\Brand
 *
 * @mixin \Eloquent
 */
class Brand extends Model implements Transformable
{
    use TransformableTrait;

    protected $primaryKey = 'brand_id';
    protected $fillable = [
        'name',
        'state',
        'logo_path',
        'description',
        'order',
        'country_id'
    ];

    //hasMany 产品
    public function products()
    {
        return $this->hasMany(Product::class,'brand_id');
    }

    //belongsToMany 分类
    public function categories()
    {
        return $this->belongsToMany(Category::class,'category_brands','cate_id','brand_id');
    }



}
