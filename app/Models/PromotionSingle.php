<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class PromotionSingle extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'promotion_single';
    protected $primaryKey = 'pm_id';

    protected $fillable = [
        "name",
        "pid",
        "start_time",
        "end_time",
        "slogan",
        "discount_type",
        "discount_value",
        "state",
    ];

    // 单品 1:1
    public function product()
    {
        return $this->hasOne(Product::class,'pid')->where('state',1);
    }

}
