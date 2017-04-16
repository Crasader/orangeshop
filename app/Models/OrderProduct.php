<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $primaryKey = 'record_id';

    protected $fillable = [
        "order_id",
        "uid",
        "pid",
        "cate_id",
        "brand_id",
        "name",
        "img",
        "discount_price",
        "cost_price",
        "shop_price",
        "real_count",
        "buy_count",
        "send_count",
        "type",
        "number",
        "ext_code1",
        "ext_code2",
        "ext_code3",
        "ext_code4",
        "ext_code5",
    ];

    //n:n 属性值
    public function attr_values()
    {
        return $this->belongsToMany(AttributeValue::class, 'order_product_attr_values', 'order_product_id','attr_value_id');
    }

    //n:1
    public function user()
    {
        return $this->belongsTo(User::class, 'uid');
    }

    //n:1 商品
    public function product()
    {
        return $this->belongsTo(Product::class,'pid');
    }
}
