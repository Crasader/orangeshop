<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class PromotionSuit extends Model implements Transformable
{
    use TransformableTrait;
    protected $table = 'promotion_suit';
    protected $primaryKey ='pm_id';

    protected $fillable = [
        "name",
        "start_time",
        "end_time",
        "state",
    ];

    //产商品 n:n
    public function products()
    {
        return $this->belongsToMany(Product::class,'promotion_suit_products','pm_id','pid')->withPivot('discount','number');
    }

}
