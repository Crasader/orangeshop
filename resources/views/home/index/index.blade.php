@extends('home.layouts.layout')
@section('head')
    @parent
    <link href="/index/css/hmstyle.css" rel="stylesheet" type="text/css"/>
@stop

@section('banner')
    <div class="banner">
        <!--轮播 -->
        <div class="am-slider am-slider-default scoll" data-am-flexslider id="demo-slider-0">
            <ul class="am-slides">
                <li class="banner1"><a href="introduction.html"><img src="/index/images/ad1.jpg"/></a></li>
                <li class="banner2"><a><img src="/index/images/ad2.jpg"/></a></li>
                <li class="banner3"><a><img src="/index/images/ad3.jpg"/></a></li>
                <li class="banner4"><a><img src="/index/images/ad4.jpg"/></a></li>

            </ul>
        </div>
        <div class="clear"></div>
    </div>
@stop

@section('shop_nav')
    <div class="shopNav">
        <div class="slideall">
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

            <!--侧边导航 -->
            <div id="nav" class="navfull">
                <div class="area clearfix">
                    <div class="category-content" id="guide_2">

                        <div class="category">
                            <ul class="category-list" id="js_climit_li">
                                @foreach($cates as $cate)
                                    <li class="appliance js_toggle relative @if($loop->first) first @endif @if($loop->last) last @endif ">
                                        <div class="category-info">
                                            <h3 class="category-name b-category-name"><i><img
                                                            src="{{ $cate->logo_path }}"></i><a
                                                        class="ml-22" title="">{{ $cate->name }}</a></h3>
                                            <em>&gt;</em></div>
                                        <div class="menu-item menu-in top">
                                            <div class="area-in">
                                                <div class="area-bg">
                                                    <div class="menu-srot">
                                                        <div class="sort-side">
                                                            <dl class="dl-sort">
                                                                <dt><span title=""></span></dt>
                                                                @foreach($cate->products as $product)
                                                                    <dd><a title="" target="_blank"
                                                                           href="/introduction/{{ $product->pid }}"><span>{{ $product->name }}</span></a>
                                                                    </dd>
                                                                    @break($loop->index==9)
                                                                @endforeach
                                                            </dl>
                                                        </div>
                                                        <div class="brand-side">
                                                            <dl class="dl-sort">
                                                                @if(!$cate->brands->isEmpty())
                                                                    <dt><span>经典品牌</span></dt>
                                                                    @foreach($cate->brands as $brand)
                                                                        <dd>
                                                                            <a rel="nofollow" title="" target="_blank"
                                                                               href="#">
                                                                                <span class="red">{{ $brand->name }}</span>
                                                                            </a>
                                                                        </dd>
                                                                        @break($loop->index==9)
                                                                    @endforeach
                                                                @endif
                                                            </dl>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <b class="arrow"></b>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
            </div>


            <!--轮播-->

            <script type="text/javascript">
                (function () {
                    $('.am-slider').flexslider();
                });
                $(document).ready(function () {
                    $("li").hover(function () {
                        $(".category-content .category-list li.first .menu-in").css("display", "none");
                        $(".category-content .category-list li.first").removeClass("hover");
                        $(this).addClass("hover");
                        $(this).children("div.menu-in").css("display", "block")
                    }, function () {
                        $(this).removeClass("hover")
                        $(this).children("div.menu-in").css("display", "none")
                    });
                })
            </script>


            <!--小导航 -->
            <div class="am-g am-g-fixed smallnav">
                <div class="am-u-sm-3">
                    <a href="sort.html"><img src="/index/images/navsmall.jpg"/>
                        <div class="title">商品分类</div>
                    </a>
                </div>
                <div class="am-u-sm-3">
                    <a href="#"><img src="/upload/image/201703050631278322.jpg"/>
                        <div class="title">大聚惠</div>
                    </a>
                </div>
                <div class="am-u-sm-3">
                    <a href="#"><img src="/index/images/mansmall.jpg"/>
                        <div class="title">个人中心</div>
                    </a>
                </div>
                <div class="am-u-sm-3">
                    <a href="#"><img src="/index/images/moneysmall.jpg"/>
                        <div class="title">投资理财</div>
                    </a>
                </div>
            </div>

            <!--走马灯 -->

            <div class="marqueen">
                <span class="marqueen-title">商城头条</span>
                <div class="demo">

                    <ul>
                        <li class="title-first"><a target="_blank" href="#">
                                <img src="/index/images/TJ2.jpg"/>
                                <span>[特惠]</span>商城爆品1分秒
                            </a></li>
                        <li class="title-first"><a target="_blank" href="#">
                                <span>[公告]</span>商城与广州市签署战略合作协议
                                <img src="/index/images/TJ.jpg"/>
                                <p>XXXXXXXXXXXXXXXXXX</p>
                            </a></li>

                        <div class="mod-vip">
                            <div class="m-baseinfo">
                                <a href="/index/person/index.html">
                                    <img src="/index/images/getAvatar.do.jpg">
                                </a>
                                <em>
                                    Hi,<span class="s-name">小叮当</span>
                                    <a href="#"><p>点击更多优惠活动</p></a>
                                </em>
                            </div>
                            <div class="member-logout">
                                <a class="am-btn-warning btn" href="/login">登录</a>
                                <a class="am-btn-warning btn" href="/register">注册</a>
                            </div>
                            <div class="member-login">
                                <a href="#"><strong>0</strong>待收货</a>
                                <a href="#"><strong>0</strong>待发货</a>
                                <a href="#"><strong>0</strong>待付款</a>
                                <a href="#"><strong>0</strong>待评价</a>
                            </div>
                            <div class="clear"></div>
                        </div>

                        <li><a target="_blank" href="#"><span>[特惠]</span>洋河年末大促，低至两件五折</a></li>
                        <li><a target="_blank" href="#"><span>[公告]</span>华北、华中部分地区配送延迟</a></li>
                        <li><a target="_blank" href="#"><span>[特惠]</span>家电狂欢千亿礼券 买1送1！</a></li>

                    </ul>
                    <div class="advTip"><img src="/index/images/advTip.jpg"/></div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <script type="text/javascript">
            if ($(window).width() < 640) {
                function autoScroll(obj) {
                    $(obj).find("ul").animate({
                        marginTop: "-39px"
                    }, 500, function () {
                        $(this).css({
                            marginTop: "0px"
                        }).find("li:first").appendTo(this);
                    })
                }

                $(function () {
                    setInterval('autoScroll(".demo")', 3000);
                })
            }
        </script>
    </div>
@stop

@section('content')
    <div class="shopMainbg">
        <div class="shopMain" id="shopmain">

            <!--今日推荐 -->

            <div class="am-g am-g-fixed recommendation">
                <div class="clock am-u-sm-3">
                    <img src="/index/images/2016.png"/>
                    <p>今日<br>推荐</p>
                </div>
                <div class="am-u-sm-4 am-u-lg-3 ">
                    <div class="info ">
                        <h3>真的有鱼</h3>
                        <h4>开年福利篇</h4>
                    </div>
                    <div class="recommendationMain one">
                        <a href="introduction.html"><img src="/upload/image/201703050631278322.jpg"/></a>
                    </div>
                </div>
                <div class="am-u-sm-4 am-u-lg-3 ">
                    <div class="info ">
                        <h3>囤货过冬</h3>
                        <h4>让爱早回家</h4>
                    </div>
                    <div class="recommendationMain two">
                        <img src="/upload/image/201703050631278322.jpg"/>
                    </div>
                </div>
                <div class="am-u-sm-4 am-u-lg-3 ">
                    <div class="info ">
                        <h3>浪漫情人节</h3>
                        <h4>甜甜蜜蜜</h4>
                    </div>
                    <div class="recommendationMain three">
                        <img src="/upload/image/201703050631278322.jpg"/>
                    </div>
                </div>
            </div>
            <div class="clear "></div>
            <!--热门活动 -->

            <div class="am-container activity ">
                <div class="shopTitle ">
                    <h4>活动</h4>
                    <h3>每期活动 优惠享不停 </h3>
                    <span class="more ">
                              <a href="# ">全部活动<i class="am-icon-angle-right" style="padding-left:10px ;"></i></a>
                        </span>
                </div>
                <div class="am-g am-g-fixed ">
                    <div class="am-u-sm-3 ">
                        <div class="icon-sale one "></div>
                        <h4>单品促销</h4>
                        <div class="activityMain ">
                            <img src="/upload/image/201703050631278322.jpg "/>
                        </div>
                        <div class="info ">
                            <h3>春节送礼优选</h3>
                        </div>
                    </div>

                    <div class="am-u-sm-3 ">
                        <div class="icon-sale two "></div>
                        <h4>买赠促销</h4>
                        <div class="activityMain ">
                            <img src="/upload/image/201703050631278322.jpg"/>
                        </div>
                        <div class="info ">
                            <h3>春节送礼优选</h3>
                        </div>
                    </div>

                    <div class="am-u-sm-3 ">
                        <div class="icon-sale three "></div>
                        <h4>满赠促销</h4>
                        <div class="activityMain ">
                            <img src="/upload/image/201703050631278322.jpg"/>
                        </div>
                        <div class="info ">
                            <h3>春节送礼优选</h3>
                        </div>
                    </div>

                    <div class="am-u-sm-3 last ">
                        <div class="icon-sale "></div>
                        <h4>套装活动</h4>
                        <div class="activityMain ">
                            <img src="/upload/image/201703050631278322.jpg"/>
                        </div>
                        <div class="info ">
                            <h3>春节送礼优选</h3>
                        </div>
                    </div>

                </div>
            </div>
            <div class="clear "></div>

            @foreach($brands as $brand)
                <div id="f{{ $loop->iteration }}">
                    <div class="am-container ">
                        <div class="shopTitle ">
                            <h4>{{ $brand->name }}</h4>
                            <h3>{{ $brand->description }}</h3>
                            <span class="more ">
                    <a href="# ">更多...<i class="am-icon-angle-right" style="padding-left:10px ;"></i></a>
                        </span>
                        </div>
                    </div>

                    <div class="am-g am-g-fixed floodFour">
                        <div class="am-u-sm-5 am-u-md-4 text-one list ">
                            <div class="word">
                                @foreach($brand->categories as $cate)
                                    <a class="outer" href="#"><span class="inner"><b class="text">{{ $cate->name }}</b></span></a>
                                    @break($loop->index == 5)
                                @endforeach
                            </div>
                            <a href="# ">
                                <div class="outer-con ">
                                    <div class="title ">

                                    </div>
                                    <div class="sub-title ">

                                    </div>
                                </div>
                                <img src="{{ $brand->logo_path }}"/>
                            </a>
                            <div class="triangle-topright"></div>
                        </div>

                        @foreach($brand->products as $product)
                            <div class="@if($loop->index == 0)
                                    am-u-sm-7 am-u-md-4 text-two sug
                                @elseif($loop->index == 1)
                                    am-u-sm-7 am-u-md-4 text-two
                                @elseif($loop->index == 2)
                                    am-u-sm-3 am-u-md-2 text-three big
                                @elseif($loop->index == 3)
                                    am-u-sm-3 am-u-md-2 text-three sug
                                @elseif($loop->index == 4)
                                    am-u-sm-3 am-u-md-2 text-three
                                @elseif($loop->index == 5)
                                    am-u-sm-3 am-u-md-2 text-three last big
                                @endif ">
                                <div class="outer-con ">
                                    <div class="title ">
                                        {{str_limit($product->name,20) }}
                                    </div>
                                    <div class="sub-title ">
                                        {{ $product->shop_price }}
                                    </div>
                                    <i class="am-icon-shopping-basket am-icon-md  seprate"></i>
                                </div>
                                <a href="/introduction/{{$product->pid}}" target="_blank"><img src="{{ $product->images->isEmpty()? '': $product->images->first()->path}}"/></a>
                            </div>
                            @break($loop->index == 5)
                        @endforeach
                        <div class="clear "></div>
                    </div>
                </div>
            @endforeach
            @include('home.layouts._footer')
        </div>
    </div>

    @include('home.layouts._bottom_nav')
@stop




