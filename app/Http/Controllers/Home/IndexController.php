<?php

namespace App\Http\Controllers\Home;

use App\Library\Common;
use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\Product;
use App\Models\PromotionBuySend;
use App\Models\PromotionFullSend;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class IndexController extends Controller
{
    public function index()
    {
        //Auth::logout();
        $cates = $this->catesAndProducts();

        $brands = $this->brandsAndProducts();

        return view('home.index.index', compact('cates', 'brands'));
    }

    //获取导航
    private function catesAndProducts($count = 10)
    {
        $cates = Cache::get('cates', function () use ($count) {
            $cates = Category::with([

                'brands' => function ($query) {
                    $query->orderBy('order')->get()->take(100);
                },

                'products' => function ($query) {
                    $query->orderBy('order')->limit(100);
                }])
                ->orderBy('order')
                ->get()
                ->take($count);

            return $cates;
        });

        return $cates;
    }

    //获取内容区域的品牌和产品
    private function brandsAndProducts($count = 10)
    {
        $brands = Brand::has('products')->with([
            'products' => function ($query) {
                $query->with(['images' => function ($query) {
                    $query->where('is_main', 1);
                }])->orderBy('order')->limit(100);
            },
            'categories' => function ($query) {
                $query->orderBy('order')->limit(100);
            }])
            ->orderBy('order')
            ->get()
            ->take($count);

        return $brands;
    }

    //商品详情
    public function introduction(Request $request, $pid)
    {
        //商品
        $product = Product::findOrFail($pid);

        //如果登录，加入浏览历史，访问次数加1
        if(Auth::check()){
            $user = $request->user();
            $request->user()->product_histories()->syncWithoutDetaching([$pid=>['updated_at' => Carbon::now()->toDateTimeString()]]);
            DB::table('user_browse_histories')->where(['uid'=>$user->id,'pid'=>$pid])->increment('time',1);
        }

        $product->increment('visit_count',1);
        //图片
        $images = $product->images()->orderBy('is_main')->get(['path']);
        $attrs = DB::table('product_attributes')
            ->join('attributes','product_attributes.attr_id','=','attributes.attr_id')
            ->where('pid',$pid)->select('attributes.attr_id','attributes.name','show_type')->distinct()->get();

        //地区
        $provinces = Cache::get('provinces',function(){
            return City::where('level',1)->get();
        });

        //组装属性和属性值
        $attr_values = $product->attribute_values;
        foreach ($attrs as &$attr) {
            $temp = [];
            foreach ($attr_values as $attr_value){
                if($attr->attr_id == $attr_value->pivot->attr_id){
                    $temp[] = $attr_value;
                }
            }
            $attr->attr_values = $temp;
        }

        //参与活动，时间段和状态，如果有重叠的，返回start_time最大的
        //1、单品，一个
        /*$promotion_singles = $product->promotion_singles->filter(function ($value, $key) {
            return Carbon::now()->between(Carbon::parse($value->start_time), Carbon::parse($value->end_time));
        });*/

        $lastest_promotion_single = Common::lastestPromotionSingle($product);

        if ($lastest_promotion_single) {
            if ($lastest_promotion_single->discount_type == 0) {
                $price = $product->shop_price - $lastest_promotion_single->discount_value;
            } else {
                $price = $product->shop_price * $lastest_promotion_single->discount_value;
            }
        }

        //2、买赠，一个
        $promotion_buy_send = Common::promotionBuySend($product);

        //3、满赠，一个
        $promotion_full_send = Common::promotionFullSend($product);

        //4、套装,可以多个
        $promotion_suits =Common::promotionSuits($product);

        //相关产品
        $related_products = $product->related_products->take(3);

        //用户浏览的产品，cookie
        //$history = $request->cookie('history',[]);
        //推荐的产品

        //需要返回：
        //产品，图片（主、辅），相关产品
        //活动后价格(单品)，买赠活动信息，满赠活动信息,套装活动
        return view('home.index.introduction', compact('product', 'images','related_products',
            'attrs','price', 'promotion_buy_send', 'promotion_full_send', 'promotion_suits','provinces'));
    }
}
