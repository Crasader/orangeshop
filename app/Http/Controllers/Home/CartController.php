<?php

namespace App\Http\Controllers\Home;

use App\Library\Common;
use App\Models\AttributeValue;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\PromotionBuySend;
use App\Models\PromotionFullSend;
use App\Models\PromotionSingle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public function __construct()
    {

    }

    //订单列表
    public function index(Request $request, $record_id = null)
    {
        $user = Auth::user();
        $order_products = $user->order_products()->whereNull('order_id')->where('type', 'in', [0, 4])->orderBy('created_at', 'desc')->get();
        foreach ($order_products as &$order_product) {
            $attr_and_values = [];
            foreach ($order_product->attr_values as $attr_value) {
                array_push($attr_and_values, [$attr_value->attribute, $attr_value]);
            }
            $order_product->attr_and_values = $attr_and_values;
            $product = Product::find($order_product->pid);

            //单品,确定最终价格
            $promotion_single = Common::lastestPromotionSingle($product);
            //单品活动类型
            if ($promotion_single->type == 0) {
                //直降
                $order_product->discount_price = $product->shop_price - $promotion_single->discount_value;
            } else {
                //打折
                $order_product->discount_price = $product->shop_price * (1 - $promotion_single->discount_value);
            }

            //买赠，展示赠送产品
            $promotion_buy_send = Common::promotionBuySend($product);
            $order_product->send_count = floor($order_product->buy_count/$promotion_buy_send->buy_count) *$promotion_buy_send->send_count;
        }

        $addresses = $user->addresses;

        foreach ($addresses as &$address) {
            $address->province = $address->province ? $address->province->name : '';
            $address->city = $address->city ? $address->city->name : '';
            $address->district = $address->district ? $address->district->name : '';
        }

        return view('home.user.cart', compact('order_products', 'record_id','addresses'));
    }
    //添加订单
    public function addOrder(Request $request)
    {
        //判断用户是否登录
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => '请先登录', 'error' => 1]);
        }

        //检查参数
        $pid = $request->get('pid');
        $attr_value_ids = $request->get('attr_value_ids', []);
        $count = $request->get('count', 0);
        //判断是否只直接购买
        $redirect = $request->get('redirect', 0);

        if ($pid < 1 || count($attr_value_ids) < 1 || $count < 1) {
            return response()->json(['message' => '产品或规格出错', 'error' => 2]);
        }

        //插入到order_product中
        $product = Product::findOrFail($pid);
        //属性外加值
        $attr_values = $product->attribute_values->filter(function ($value, $key) use ($attr_value_ids) {
            return in_array($value->attr_value_id, $attr_value_ids);
        });
        $price = 0;
        foreach ($attr_values as $attr_value) {
            if ($attr_value->pivot->add_money > 0) {
                $price += $attr_value->pivot->add_money;
            }
        }

        $order_product = new OrderProduct();
        $order_product->uid = $user->id;
        $order_product->pid = $pid;
        $order_product->cate_id = $product->cate_id;
        $order_product->brand_id = $product->brand_id;
        $order_product->name = $product->name;
        $order_product->img = $product->images()->where('is_main', 1)->get()->first()->path;
        $order_product->discount_price = $product->shop_price + $price;
        $order_product->cost_price = $product->cost_price;
        $order_product->shop_price = $product->shop_price;
        $order_product->buy_count = $count;
        $order_product->real_count = 0;
        $order_product->send_count = 0;
        $order_product->type = 0;
        $order_product->number = 0;

        //活动
        //1、单品活动
        /*$lastest_promotion_single = Common::lastestPromotionSingle($product);

        //2、买赠活动
        $promotion_buy_send = Common::promotionBuySend($product);

        //3、满赠活动
        $promotion_full_send = Common::promotionFullSend($product);

        $order_product->ext_code1 = $lastest_promotion_single->pm_id;
        $order_product->ext_code2 = $promotion_buy_send->pm_id;
        $order_product->ext_code4 = $promotion_full_send->pm_id;*/

        //插入数据
        $rst = $order_product->save();

        if ($rst) {
            //属性值更新
            $order_product->attr_values()->sync($attr_value_ids);
            $total = $user->order_products()->where('type', 'in', [1, 4])->count();
            $data = ['message' => '添加成功', 'error' => 0, 'total' => $total, 'record_id' => $order_product->record_id];
        } else {
            $data = ['message' => '添加失败', 'error' => 2];
        }

        return response()->json($data);
    }

    //移除订单
    public function removeOrder(Request $request)
    {
        $user = $request->user();

        if(!$user){
            return response()->json(['message'=>'你竟然没登录','error'=>1]);
        }

        $record_id = $request->get('record_id');

        $order_product = OrderProduct::findOrFail($record_id);
        $order_product->attr_values()->detach();
        $rst = $order_product->delete();
        if ($rst) {
            $response = ['message' => '删除成功', 'error' => 0];
        } else {
            $response = ['message' => '删除失败', 'error' => 1];
        }
        return response()->json($response);
    }

}
