@extends('home.layouts.layout')

@section('head')
    @parent
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="/index/basic/css/demo.css" rel="stylesheet" type="text/css"/>
    <link href="/index/css/optstyle.css" type="text/css" rel="stylesheet"/>
    <link href="/index/css/style.css" type="text/css" rel="stylesheet"/>

    <script type="text/javascript" src="/index/js/jquery.imagezoom.min.js"></script>
    <script type="text/javascript" src="/index/js/jquery.flexslider.js"></script>
    <script type="text/javascript" src="/index/js/list.js"></script>

    <style>
        .attr_css, .attr_img {
            display: block;
            width: 24px;
            height: 24px;
        }

        .am-selected-list {
            min-height: 22px;
            min-width: 160px;
            max-height: 200px;
            overflow-y: auto;
        }

        .sweet-alert {
            z-index: 999999999;
        }
    </style>
@stop


@section('search')
    @parent
    <div class="clear"></div>
    <b class="line"></b>
@stop

@section('banner')
@stop

@section('shop_nav')
@stop

@section('content')
    <div class="listMain">

        <!--分类-->
        <div class="nav-table">
            <div class="long-title"><span class="all-goods">全部分类</span></div>
            <div class="nav-cont">
                <ul>
                    <li class="index"><a href="#">首页</a></li>
                    <li class="qc"><a href="#">闪购</a></li>
                    <li class="qc"><a href="#">限时抢</a></li>
                    <li class="qc"><a href="#">团购</a></li>
                    <li class="qc last"><a href="#">大包装</a></li>
                </ul>
                <div class="nav-extra">
                    <i class="am-icon-user-secret am-icon-md nav-user"></i><b></b>我的福利
                    <i class="am-icon-angle-right" style="padding-left: 10px;"></i>
                </div>
            </div>
        </div>
        <ol class="am-breadcrumb am-breadcrumb-slash">
            <li><a href="#">首页</a></li>
            <li><a href="#">分类</a></li>
            <li class="am-active">内容</li>
        </ol>
        <script type="text/javascript">
            $(function () {
            });
            $(window).load(function () {
                $('.flexslider').flexslider({
                    animation: "slide",
                    start: function (slider) {
                        $('body').removeClass('loading');
                    }
                });
            });
        </script>
        <div class="scoll">
            <section class="slider">
                <div class="flexslider">

                    <div class="flex-viewport" style="overflow: hidden; position: relative;">
                        <ul class="slides"
                            style="width: 1000%; transition-duration: 0.6s; transform: translate3d(-1012px, 0px, 0px);">
                            @foreach($images as $image)
                                <li class="clone" aria-hidden="true" style="width: 506px; float: left; display: block;">
                                    <img src="{{ $image->path }}" draggable="false">
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <ol class="flex-control-nav flex-control-paging">
                        <li><a class="">1</a></li>
                        <li><a class="flex-active">2</a></li>
                        <li><a class="">3</a></li>
                    </ol>
                    <ul class="flex-direction-nav">
                        <li class="flex-nav-prev"><a class="flex-prev" href="#">Previous</a></li>
                        <li class="flex-nav-next"><a class="flex-next" href="#">Next</a></li>
                    </ul>
                </div>
            </section>
        </div>

        <!--放大镜-->

        <div class="item-inform">
            <div class="clearfixLeft" id="clearcontent">

                <div class="box">
                    <script type="text/javascript">
                        $(document).ready(function () {
                            $(".jqzoom").imagezoom();
                            $("#thumblist li a").click(function () {
                                $(this).parents("li").addClass("tb-selected").siblings().removeClass("tb-selected");
                                $(".jqzoom").attr('src', $(this).find("img").attr("mid"));
                                $(".jqzoom").attr('rel', $(this).find("img").attr("big"));
                            });
                        });
                    </script>

                    <div class="tb-booth tb-pic tb-s310">
                        <a href="{{$images->first()->path}}"><img src="{{$images->first()->path}}" alt=""
                                                                  rel="{{$images->first()->path}}"
                                                                  class="jqzoom" style="cursor: crosshair;"></a>
                    </div>
                    <ul class="tb-thumb" id="thumblist">
                        @foreach($images as $image)
                            @if($loop->index == 0)
                                <li class="tb-selected">
                                    <div class="tb-pic tb-s40">
                                        <a href="#"><img src="{{ $image->path }}" mid="{{ $image->path }}"
                                                         big="{{ $image->path }}"></a>
                                    </div>
                                </li>
                            @else
                                <li>
                                    <div class="tb-pic tb-s40">
                                        <a href="#"><img src="{{ $image->path }}" mid="{{ $image->path }}"
                                                         big="{{ $image->path }}"></a>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>

                <div class="clear"></div>
            </div>

            <div class="clearfixRight">

                <!--规格属性-->
                <!--名称-->
                <div class="tb-detail-hd">
                    <h1>
                        {{ $product->name }}
                    </h1>
                </div>
                <div class="tb-detail-list">
                    <!--价格-->
                    <div class="tb-detail-price">
                        <li class="price iteminfo_price">
                            <dl>
                                <dt>促销价</dt>
                                <dd><em>¥</em><b
                                            class="sys_item_price" id="price"
                                            data-price="{{ isset($price)? $price:$product->shop_price }}">{{ isset($price)? $price:$product->shop_price }}</b>
                                </dd>
                            </dl>
                        </li>
                        <li class="price iteminfo_mktprice">
                            <dl>
                                <dt>原价</dt>
                                <dd><em>¥</em><b class="sys_item_mktprice">{{ $product->market_price }}</b></dd>
                            </dl>
                        </li>
                        <div class="clear"></div>
                    </div>

                    <!--地址-->
                    <dl class="iteminfo_parameter freight">
                        <dt>配送至</dt>
                        <div class="iteminfo_freprice">
                            <div class="am-form-content address">
                                <select data-am-selected="" style="display: none;" id="province">
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                                <select data-am-selected="" style="display: none;" id="city">

                                </select>
                                <select data-am-selected="" style="display: none;" id="district">

                                </select>
                            </div>
                            <div class="pay-logis">
                                快递<b class="sys_item_freprice">{{ $product->is_free_shipping == 1?0:10 }}</b>元
                            </div>
                        </div>
                    </dl>
                    <div class="clear"></div>

                    <!--销量-->
                    <ul class="tm-ind-panel">
                        <li class="tm-ind-item tm-ind-sellCount canClick">
                            <div class="tm-indcon"><span class="tm-label">累计浏览</span><span
                                        class="tm-count">{{ $product->visit_count }}</span>
                            </div>
                        </li>
                        <li class="tm-ind-item tm-ind-sumCount canClick">
                            <div class="tm-indcon"><span class="tm-label">累计销量</span><span
                                        class="tm-count">{{ $product->sale_count }}</span>
                            </div>
                        </li>
                        <li class="tm-ind-item tm-ind-reviewCount canClick tm-line3">
                            <div class="tm-indcon"><span class="tm-label">累计评价</span><span class="tm-count">640</span>
                            </div>
                        </li>
                    </ul>
                    <div class="clear"></div>

                    <!--各种规格-->
                    <dl class="iteminfo_parameter sys_item_specpara">
                        <dt class="theme-login"><span class="cart-title">可选规格<span
                                        class="am-icon-angle-right"></span></span></dt>
                        <dd>
                            <!--操作页面-->

                            <div class="theme-popover-mask"></div>

                            <div class="theme-popover">
                                <div class="theme-span"></div>
                                <div class="theme-poptit">
                                    <a href="javascript:;" title="关闭" class="close">×</a>
                                </div>
                                <div class="theme-popbod dform">
                                    <form class="theme-signin" name="loginform" action="" method="post">

                                        <div class="theme-signin-left">

                                            @foreach($attrs as $attr)
                                                @if(count($attr->attr_values)>0)
                                                    <div class="theme-options">
                                                        <div class="cart-title">{{ $attr->name }}</div>
                                                        <ul>
                                                            @foreach($attr->attr_values as $attr_value)
                                                                @if($attr->show_type == 2)
                                                                    <li class="sku-line"
                                                                        data-valueid="{{$attr_value->attr_value_id}}"
                                                                        data-money="{{$attr_value->pivot->add_money}}">
                                                                        <img src="{{  $attr_value->attr_value_2 }}"
                                                                             alt="" class="attr_img">
                                                                        <i></i></li>
                                                                @elseif($attr->show_type == 1)
                                                                    <li class="sku-line"
                                                                        data-valueid="{{$attr_value->attr_value_id}}"
                                                                        data-money="{{$attr_value->pivot->add_money}}">
                                                                        <span class="attr_css"
                                                                              style="background-color: {{ $attr_value->attr_value_1 }}"></span>
                                                                        <i></i></li>
                                                                @else
                                                                    <li class="sku-line"
                                                                        data-valueid="{{$attr_value->attr_value_id}}"
                                                                        data-money="{{$attr_value->pivot->add_money}}">{{ $attr_value->attr_value_0 }}
                                                                        <i></i></li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            @endforeach
                                            <div class="theme-options count">
                                                <div class="cart-title number">数量</div>
                                                <dl>
                                                    <dd>
                                                        <input id="min" class="am-btn am-btn-default" name=""
                                                               type="button" value="-"
                                                               disabled="disabled">
                                                        <input id="text_box" name="" type="text" value="1"
                                                               style="width:30px;">
                                                        <input id="add" class="am-btn am-btn-default" name=""
                                                               type="button" value="+">
                                                        <span id="Stock" class="tb-hidden">库存<span
                                                                    class="stock">{{ $product->stock }}</span>件</span>
                                                    </dd>
                                                </dl>
                                            </div>
                                            <div class="clear"></div>

                                            <div class="btn-op">
                                                <div class="btn am-btn am-btn-warning" id="confirm">确认</div>
                                                <div class="btn close am-btn am-btn-warning">取消</div>
                                            </div>
                                        </div>
                                        <div class="theme-signin-right">
                                            <div class="img-info">
                                                <img src="{{$images->first()->path}}">
                                            </div>
                                            <div class="text-info">
                                                <span class="J_Price price-now">¥39.00</span>
                                                <span id="Stock" class="tb-hidden">库存<span
                                                            class="stock">1000</span>件</span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </dd>
                    </dl>

                    <div class="clear"></div>
                    <!--活动	-->
                    @if($promotion_buy_send)
                        <div class="shopPromotion gold">
                            <div class="hot">
                                <dt class="tb-metatit">店铺优惠</dt>
                                <div class="gold-list">
                                    <p>
                                        该商品购满{{ $promotion_buy_send->buy_count}}件,送{{ $promotion_buy_send->send_count}}件
                                        @if($promotion_full_send)
                                            <span>更多优惠<i class="am-icon-sort-down"></i></span>
                                        @endif
                                    </p>

                                </div>
                            </div>
                            <div class="clear"></div>
                            @if($promotion_full_send)
                                <div class="coupon">
                                    <span>该商品购满{{$promotion_full_send->limit_money  }}元，送</span>
                                    <dt class="tb-metatit"></dt>
                                    <div class="gold-list">
                                        <ul>
                                            @foreach($promotion_full_send->products()->wherePivot('type',0)->get() as $full_send_product)
                                                <li> {{ str_limit($full_send_product->name,30) }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                </div>

                <div class="pay">
                    <div class="pay-opt">
                        <a href="home.html"><span class="am-icon-home am-icon-fw">首页</span></a>
                    </div>
                    <ul>
                        <li>
                            <div class="clearfix tb-btn tb-btn-buy theme-login">
                                @if($product->stock < 1)
                                    <a id="" title="" href="javascript:;">暂无库存</a>
                                @else
                                    <a id="LikBuy" title="点此按钮到下一步确认购买信息" href="javascript:;">立即购买</a>
                                @endif
                            </div>
                        </li>
                        <li>
                            <div class="clearfix tb-btn tb-btn-basket theme-login">
                                <a id="LikBasket" title="加入购物车" href="javascript:;"><i></i>加入购物车</a>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="clear"></div>

        </div>
    @if($promotion_suits->count() > 0)
        <!--优惠套装-->
            <div class="match">
                <div class="match-title">优惠套装</div>
                <div class="match-comment">
                    @foreach($promotion_suits as $promotion_suit)
                        <ul class="like_list">
                            @foreach($promotion_suit->products as $prod)
                                <li>
                                    <div class="s_picBox">
                                        <a class="s_pic" href="#"><img
                                                    src="{{ $prod->images->where('is_main',1)->first()->path }}"></a>
                                    </div>
                                    <a class="txt" target="_blank" href="#">{{ str_limit($prod->name,30),40,'.' }}</a>
                                    <div class="info-box"><span
                                                class="info-box-price">¥ {{ $prod->shop_price * $prod->pivot->discount }}
                                            ×{{ $prod->pivot->number}}</span> <span
                                                class="info-original-price">￥ {{ $prod->shop_price }}
                                            ×{{ $prod->pivot->number}}</span>
                                    </div>
                                </li>
                                @if($loop->remaining == 0)
                                    <li class="plus_icon"><i>=</i></li>
                                @else
                                    <li class="plus_icon"><i>+</i></li>
                                @endif
                            @endforeach

                            <li class="total_price">
                                <p class="combo_price"><span
                                            class="c-title">套餐价:</span><span>￥{{ $promotion_suit['total'] }}</span></p>
                                <p class="save_all">共省:<span>￥{{ $promotion_suit['total_discount'] }}</span></p> <a
                                        href="#" class="buy_now">立即购买</a></li>
                            <li class="plus_icon"><i class="am-icon-angle-right"></i></li>
                        </ul>
                    @endforeach
                </div>
            </div>
            <div class="clear"></div>
    @endif

    <!-- introduce-->

        <div class="introduce">
            <div class="browse">
                <div class="mc">
                    <ul>
                        <div class="mt">
                            <h2>相关产品</h2>
                        </div>
                        @foreach($related_products as $related)
                            <li class="first">
                                <div class="p-img">
                                    <a href="#"> <img class=""
                                                      src="{{ $related->images->where('is_main',1)->first()->path}}">
                                    </a>
                                </div>
                                <div class="p-name"><a href="#">
                                        {{ str_limit($related->name,20) }}
                                    </a>
                                </div>
                                <div class="p-price"><strong>￥{{ $related->shop_price }}</strong></div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="introduceMain">
                <div class="am-tabs" data-am-tabs="">
                    <ul class="am-avg-sm-3 am-tabs-nav am-nav am-nav-tabs" otop="994.78125">
                        <li class="am-active">
                            <a href="#">
                                <span class="index-needs-dt-txt">宝贝详情</span></a>
                        </li>

                        <li>
                            <a href="#">
                                <span class="index-needs-dt-txt">全部评价</span></a>
                        </li>

                        <li>
                            <a href="#">
                                <span class="index-needs-dt-txt">猜你喜欢</span></a>
                        </li>
                    </ul>

                    <div class="am-tabs-bd"
                         style="touch-action: pan-y; -webkit-user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">

                        <div class="am-tab-panel am-fade am-in am-active">
                            {{--<div class="J_Brand">

                                <div class="attr-list-hd tm-clear">
                                    <h4>产品参数：</h4></div>
                                <div class="clear"></div>
                                <ul id="J_AttrUL">
                                    <li title="">产品类型:&nbsp;烘炒类</li>
                                    <li title="">原料产地:&nbsp;巴基斯坦</li>
                                    <li title="">产地:&nbsp;湖北省武汉市</li>
                                    <li title="">配料表:&nbsp;进口松子、食用盐</li>
                                    <li title="">产品规格:&nbsp;210g</li>
                                    <li title="">保质期:&nbsp;180天</li>
                                    <li title="">产品标准号:&nbsp;GB/T 22165</li>
                                    <li title="">生产许可证编号：&nbsp;QS4201 1801 0226</li>
                                    <li title="">储存方法：&nbsp;请放置于常温、阴凉、通风、干燥处保存</li>
                                    <li title="">食用方法：&nbsp;开袋去壳即食</li>
                                </ul>
                                <div class="clear"></div>
                            </div>--}}

                            <div class="details">
                                <div class="attr-list-hd after-market-hd">
                                    <h4>商品细节</h4>
                                </div>
                                <div class="twlistNews">
                                    {!! $product->description !!}
                                </div>
                            </div>
                            <div class="clear"></div>

                        </div>

                        <div class="am-tab-panel am-fade">

                            <div class="actor-new">
                                <div class="rate">
                                    <strong>100<span>%</span></strong><br> <span>好评度</span>
                                </div>
                                <dl>
                                    <dt>买家印象</dt>
                                    <dd class="p-bfc">
                                        <q class="comm-tags"><span>味道不错</span><em>(2177)</em></q>
                                        <q class="comm-tags"><span>颗粒饱满</span><em>(1860)</em></q>
                                        <q class="comm-tags"><span>口感好</span><em>(1823)</em></q>
                                        <q class="comm-tags"><span>商品不错</span><em>(1689)</em></q>
                                        <q class="comm-tags"><span>香脆可口</span><em>(1488)</em></q>
                                        <q class="comm-tags"><span>个个开口</span><em>(1392)</em></q>
                                        <q class="comm-tags"><span>价格便宜</span><em>(1119)</em></q>
                                        <q class="comm-tags"><span>特价买的</span><em>(865)</em></q>
                                        <q class="comm-tags"><span>皮很薄</span><em>(831)</em></q>
                                    </dd>
                                </dl>
                            </div>
                            <div class="clear"></div>
                            <div class="tb-r-filter-bar">
                                <ul class=" tb-taglist am-avg-sm-4">
                                    <li class="tb-taglist-li tb-taglist-li-current">
                                        <div class="comment-info">
                                            <span>全部评价</span>
                                            <span class="tb-tbcr-num">(32)</span>
                                        </div>
                                    </li>

                                    <li class="tb-taglist-li tb-taglist-li-1">
                                        <div class="comment-info">
                                            <span>好评</span>
                                            <span class="tb-tbcr-num">(32)</span>
                                        </div>
                                    </li>

                                    <li class="tb-taglist-li tb-taglist-li-0">
                                        <div class="comment-info">
                                            <span>中评</span>
                                            <span class="tb-tbcr-num">(32)</span>
                                        </div>
                                    </li>

                                    <li class="tb-taglist-li tb-taglist-li--1">
                                        <div class="comment-info">
                                            <span>差评</span>
                                            <span class="tb-tbcr-num">(32)</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="clear"></div>

                            <ul class="am-comments-list am-comments-list-flip">
                                <li class="am-comment">
                                    <!-- 评论容器 -->
                                    <a href="">
                                        <img class="am-comment-avatar" src="/index/images/hwbn40x40.jpg">
                                        <!-- 评论者头像 -->
                                    </a>

                                    <div class="am-comment-main">
                                        <!-- 评论内容容器 -->
                                        <header class="am-comment-hd">
                                            <!--<h3 class="am-comment-title">评论标题</h3>-->
                                            <div class="am-comment-meta">
                                                <!-- 评论元数据 -->
                                                <a href="#link-to-user" class="am-comment-author">b***1 (匿名)</a>
                                                <!-- 评论者 -->
                                                评论于
                                                <time datetime="">2015年11月02日 17:46</time>
                                            </div>
                                        </header>

                                        <div class="am-comment-bd">
                                            <div class="tb-rev-item " data-id="255776406962">
                                                <div class="J_TbcRate_ReviewContent tb-tbcr-content ">
                                                    摸起来丝滑柔软，不厚，没色差，颜色好看！买这个衣服还接到诈骗电话，我很好奇他们是怎么知道我买了这件衣服，并且还知道我的电话的！
                                                </div>
                                                <div class="tb-r-act-bar">
                                                    颜色分类：柠檬黄&nbsp;&nbsp;尺码：S
                                                </div>
                                            </div>

                                        </div>
                                        <!-- 评论内容 -->
                                    </div>
                                </li>
                            </ul>

                            <div class="clear"></div>

                            <!--分页 -->
                            <ul class="am-pagination am-pagination-right">
                                <li class="am-disabled"><a href="#">«</a></li>
                                <li class="am-active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#">»</a></li>
                            </ul>
                            <div class="clear"></div>

                            <div class="tb-reviewsft">
                                <div class="tb-rate-alert type-attention">购买前请查看该商品的 <a href="#"
                                                                                        target="_blank">购物保障</a>，明确您的售后保障权益。
                                </div>
                            </div>

                        </div>

                        <div class="am-tab-panel am-fade">
                            <div class="like">
                                <ul class="am-avg-sm-2 am-avg-md-3 am-avg-lg-4 boxes">
                                    <li>
                                        <div class="i-pic limit">
                                            <img src="/index/images/imgsearch1.jpg">
                                            <p>【良品铺子_开口松子】零食坚果特产炒货
                                                <span>东北红松子奶油味</span></p>
                                            <p class="price fl">
                                                <b>¥</b>
                                                <strong>298.00</strong>
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="clear"></div>
                        </div>

                    </div>

                </div>

                <div class="clear"></div>

                @include('home.layouts._footer')
            </div>

        </div>
    </div>

    <div style="display:none;" class="jqPreload0"><img src="/index/images/01.jpg"></div>
    @include('home.layouts._bottom_nav')

    @include('home.layouts._right_sidebar')
@stop



@section('script')
    <script>
        $(function () {
            //计算商品价格
            $('.sku-line').click(function () {

                var dom_money = $('.sku-line.selected');
                var price = $('#price').data('price');

                for (var i = 0; i < dom_money.length; i++) {
                    price =  add(price,dom_money.eq(i).data('money'));
                }
                $('#price').text(price);
            });

            $('#province').change(function () {
                $('#district').children().remove();
                $('#city').children().remove();
                var province_id = $(this).find('option:selected').val();
                $.ajax({
                    url: '/city',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        pid: province_id,
                        level: 2
                    },
                    success: function (data) {
                        for (var item in data) {
                            var temp = $('<option value="' + data[item].id + '">' + data[item].name + '</option>')
                            $('#city').append(temp);
                        }
                    },
                    error: function () {
                        console.log('error');
                    }
                })
            });

            $('#city').change(function () {
                $('#district').children().remove();
                var city_id = $(this).find('option:selected').val();
                $.ajax({
                    url: '/city',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        pid: city_id,
                        level: 3
                    },
                    success: function (data) {
                        for (var item in data) {

                            var temp = $('<option value="' + data[item].id + '">' + data[item].name + '</option>')
                            $('#district').append(temp);
                        }
                    },
                    error: function () {
                        console.log('error');
                    }
                })
            });
            $('#province').change();

            $('#confirm').click(function () {

                //核查属性是否完全
                var dom_attrs = $('.theme-options:not(.count)');
                var attr_value_ids = [];
                for (var i = 0; i < dom_attrs.length; i++) {
                    var selected_values = dom_attrs.eq(i).find('.sku-line.selected');

                    if (selected_values.length < 1) {
                        swal({
                            title: "",
                            text: "请选择商品规格",
                            type: "warning",
                        });
                        return false;
                    }
                    attr_value_ids.push(selected_values.data('valueid'));
                }

                var data = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    attr_value_ids: attr_value_ids,
                    count: $('#text_box').val(),
                    pid:{!! $product->pid !!},
                };

                //发送请求
                $.ajax({
                    url: '/cart/add',
                    type: 'post',
                    dataType: 'json',
                    data: data,
                    success: function (data) {
                        //请先登录
                        if (data.error == 1) {
                            window.location.href = '/login';
                        }
                        if (data.error == 2) {
                            swal({
                                title: "",
                                text: "商品或规格参数出错",
                                type: "warning",
                            });
                            return false;
                        }
                        if (data.error == 0) {
                            //更新一下购物车数量
                            if($('#LikBuy').hasClass('touched')){
                                window.location.href = '/user/cart/'+ data.record_id;
                                return false;
                            }
                            $('#J_MiniCartNum').text(data.total);
                            swal({
                                title: "",
                                text: "添加成功",
                                type: "success",
                            });
                            $('.theme-popover').slideDown(200);
                        }
                    },
                    error: function () {
                        swal({
                            title: "",
                            text: "添加失败",
                            type: "warning",
                        });
                    },
                    complete: function () {
                        dom_attrs.find('.sku-line').removeClass('selected');
                    }
                });
            });


            //移动端上触发确定事件
            $('#LikBasket').click(function () {
                $(this).addClass('touched');
                $('#LikBuy').removeClass('touched');
                var $ww = $(window).width();
                if ($ww < 1025) {
                    $('.theme-login').click();
                }
                //触发关闭

                $('#confirm').click();
            });

            $('#LikBuy').click(function () {
                $(this).addClass('touched');
                $('#LikBasket').removeClass('touched');
                var $ww = $(window).width();
                if ($ww < 1025) {
                    $('.theme-login').click();
                }
                //触发关闭

                $('#confirm').click();
            })
        })
    </script>
@stop