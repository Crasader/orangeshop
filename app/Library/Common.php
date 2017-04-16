<?php
/**
 * Created by PhpStorm.
 * User: yangyida
 * Date: 2017/3/7
 * Time: 14:21
 */

namespace App\Library;


use App\Models\Product;
use App\Models\PromotionBuySend;
use Carbon\Carbon;

class Common
{
    //单品促销
    public static function lastestPromotionSingle(Product $product)
    {
        $promotion_singles = $product->promotion_singles->filter(function ($value, $key) {
            return Carbon::now()->between(Carbon::parse($value->start_time), Carbon::parse($value->end_time));
        });

        return $promotion_singles->sortByDesc('start_time')->first();
    }

    //买赠促销
    public static function promotionBuySend(Product $product)
    {
        //查找该期间的所有买赠活动
        $promotion_buy_sends = PromotionBuySend::get()->filter(function ($value, $key) {
            return Carbon::now()->between(Carbon::parse($value->start_time), Carbon::parse($value->end_time)) && $value->state == 1;
        });
        //遍历买赠活动，查找当前商品能参与买赠的活动
        $promotion_buy_send = $promotion_buy_sends->filter(function ($value) use ($product) {
            switch ($value->type) {
                //部分参与，通过活动找出商品，判断是否出现
                case 1:
                    $products = $value->products;
                    if ($products->contains($product)) {
                        return true;
                    }
                    break;
                //部分不参与，返回满足不在集合条件的活动
                case 2:
                    $products = $value->products;
                    if (!$products->contains($product)) {
                        return true;
                    }
                    break;
                //全部参与，直接返回
                default:
                    return true;
                    break;
            }
        })->sortByDesc('start_time')->first();

        return $promotion_buy_send;
    }

    //满赠
    public static function promotionFullSend(Product $product)
    {
        $promotion_full_send = $product->promotion_full_sends->filter(function ($value) {
            return Carbon::now()->between(Carbon::parse($value->start_time), Carbon::parse($value->end_time)) &&
                $value->state == 1 &&
                $value->pivot->type == 1;
        })->sortByDesc('start_time')->first();

        return $promotion_full_send;
    }

    //套装
    public static function promotionSuits(Product $product)
    {
        $promotion_suits = $product->promotion_suits->filter(function ($value) {
            return Carbon::now()->between(Carbon::parse($value->start_time), Carbon::parse($value->end_time)) && $value->state == 1;
        });
        foreach ($promotion_suits as &$promotion_suit) {
            $total = 0;
            $total_discount = 0;
            foreach ($promotion_suit->products as $prod) {
                $total += $prod->pivot->discount * $prod->shop_price * $prod->pivot->number;
                $total_discount += (1 - $prod->pivot->discount) * $prod->shop_price * $prod->pivot->number;
            }
            $promotion_suit['total'] = $total;
            $promotion_suit['total_discount'] = $total_discount;
        }

        return $promotion_suits;
    }
}