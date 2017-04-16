<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $primaryKey = 'oid';
    protected $fillable = [
        "osn",
        "uid",
        "state_code_id",
        "product_amount",
        "order_amount",
        "coupon_price",
        "surplus_money",
        "parent_id",
        "shipping_id",
        "shipping_sn",
        "shipping_time",
        "pay_id",
        "pay_sn",
        "pay_time",
        "region_id",
        "consignee",
        "mobile",
        "code",
        "address",
        "ship_fee",
        "full_cut",
        "discount",
        "remark",
        "ip",

    ];

    //1:n 用户
    public function user()
    {
        return $this->belongsTo(User::class,'uid');
    }
}
