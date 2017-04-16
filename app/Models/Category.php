<?php

namespace App\Models;

use Baum\Node;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Category extends Model implements Transformable
{
    use TransformableTrait;

    protected $primaryKey = 'cate_id';
    protected $parentColumn = 'parent_id';

    protected $fillable = [
        "parent_id",
        "name",
        "price_range",
        "description",
        "keywords",
        "is_show",
        "is_nav",
        "url",
        "state",
        "order",
        'logo_path'
    ];

    //hasMany 商品
    public function products()
    {
        return $this->hasMany(Product::class,'cate_id');
    }


    //belongsToMany 品牌
    public function brands()
    {
        return $this->belongsToMany(Brand::class,'category_brands','brand_id','cate_id');
    }


    //获取分类树
    public static function cate_tree($pid = 0)
    {
        $cates = Category::orderBy('order')->get()->toArray();
        //dd($cates);
        $cate_tree = self::tree($cates,$pid);
        return $cate_tree;
    }

    public static function tree($cates, $pid = 0, $depth = 0, $prefix = '|——')
    {
        $arr = [];
        foreach ($cates as $cate) {
            if ($cate['parent_id'] == $pid) {
                if ($depth > 0) {
                    $cate['name'] = str_repeat('　　', $depth) . $prefix . $cate['name'];
                }
                $arr[] = $cate;
                $_depth = $depth + 1;
                $arr = array_merge($arr, self::tree($cates, $cate['cate_id'], $_depth));
            }
        }
        return $arr;
    }

    /*public static function tree($cates, $pid, $depth = 0, $prefix = '|——')
    {
        $arr = [];
        foreach ($cates as $cate) {
            if ($cate['parent_id'] == $pid) {
                if ($cate['depth'] > 0) {
                    $cate['name'] = str_repeat('　　', $cate['depth']) . $prefix . $cate['name'];
                }
                $arr[] = $cate;
                $_depth = $depth + 1;
                $arr = array_merge($arr, self::tree($cates, $cate['cate_id'], $_depth));
            }
        }
        return $arr;
    }*/

}
