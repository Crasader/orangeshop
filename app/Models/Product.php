<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Product extends Model implements Transformable
{
    use TransformableTrait;
    protected $primaryKey = 'pid';

    protected $fillable = [
        'name',
        'cate_id',
        'brand_id',
        'order',
        'weight',
        'stock',
        'stock_limit',
        'cost_price',
        'market_price',
        'shop_price',
        'state',
        'is_best',
        'is_hot',
        'is_new',
        'is_free_shipping',
        'is_on_sale',
        'on_time',
        'description',
        'keywords',
        'sale_count',
        'visit_count',
        'review_count',
    ];

    // belongsTo 分类
    public function category()
    {
        return $this->belongsTo(Category::class,'cate_id');
    }

    // belongsTo 分类
    public function brand()
    {
        return $this->belongsTo(Brand::class,'brand_id');
    }

    //belongsToMany 属性
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class,'product_attributes','pid','attr_id');

    }

    //belongsToMany 属性值
    public function attribute_values()
    {
        return $this->belongsToMany(AttributeValue::class,'product_attributes','pid','attr_value_id')
            ->withPivot(['add_money','attr_id']);
    }

    //hasMany 图片
    public function images()
    {
        return $this->hasMany(Image::class,'pid');
    }
    //belongsToMany 自己 相关产品
    public function related_products()
    {
        return $this->belongsToMany($this,'product_relate','pid','related_pid');
    }

    //活动
    //单品活动 1:n
    public function promotion_singles()
    {
        return $this->hasMany(PromotionSingle::class,'pid');
    }

    //买赠活动 n:n
    public function promotion_buy_sends()
    {
        return $this->belongsToMany(PromotionBuySend::class,'promotion_buy_send_products','pid','pm_id');
    }

    //满赠活动 n:n
    public function promotion_full_sends()
    {
        return $this->belongsToMany(PromotionFullSend::class,'promotion_full_send_products','pid','pm_id')->withPivot('type');
    }

    //套装活动 n:n
    public function promotion_suits()
    {
        return $this->belongsToMany(PromotionSuit::class,'promotion_suit_products','pid','pm_id');
    }
}
