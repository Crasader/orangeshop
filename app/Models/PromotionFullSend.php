<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class PromotionFullSend extends Model implements Transformable
{
    use TransformableTrait;
    protected $primaryKey = 'pm_id';
    protected $table = 'promotion_full_send';

    protected $fillable = [
        "name",
        "start_time",
        "end_time",
        "state",
        "limit_money",
    ];

    //满赠产品 n:n
    public function products()
    {
        return $this->belongsToMany(Product::class,'promotion_full_send_products','pm_id','pid')
            ->withPivot('type');
    }

}
