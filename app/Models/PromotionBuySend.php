<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class PromotionBuySend extends Model implements Transformable
{
    use TransformableTrait;
    protected $primaryKey = 'pm_id';
    protected $table = 'promotion_buy_send';

    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'type',
        'buy_count',
        'send_count',
        'state',
    ];

    //商品 n:n
    public function products()
    {
        return $this->belongsToMany(Product::class,'promotion_buy_send_products','pm_id','pid');
    }

}
