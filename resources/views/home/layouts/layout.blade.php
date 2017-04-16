<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <title>首页</title>

    <link href="/index/AmazeUI-2.4.2/assets/css/amazeui.css" rel="stylesheet" type="text/css"/>
    <link href="/index/basic/css/demo.css" rel="stylesheet" type="text/css"/>
    <script src="/index/AmazeUI-2.4.2/assets/js/jquery.min.js"></script>
    <link href="/plugins/sweetalert/dist/sweetalert.css" rel="stylesheet" type="text/css">
    <script src="/plugins/sweetalert/dist/sweetalert.min.js"></script>
    <script src="/js/cal.js"></script>

    @section('head')
        <script src="/index/AmazeUI-2.4.2/assets/js/amazeui.min.js"></script>
    @show
</head>

<body>
@section('search')
    <!--顶部导航条 -->
    <div class="am-container header">
        <ul class="message-l">
            <div class="topMessage">
                @if(!Auth::check())
                    <div class="menu-hd">
                        <a href="/login" target="_top" class="h">亲，请登录</a>
                        <a href="/register" target="_top">免费注册</a>
                    </div>
                @else
                    <div class="menu-hd">
                        <span class="h">欢迎，</span><a href="/user/index" target="_top" class="h">{{ Auth::user()->username? Auth::user()->username:'顾客'}}</a>
                    </div>
                @endif
            </div>
        </ul>
        <ul class="message-r">
            <div class="topMessage home">
                <div class="menu-hd"><a href="/" target="_top" class="h">商城首页</a></div>
            </div>
            <div class="topMessage my-shangcheng">
                <div class="menu-hd MyShangcheng"><a href="/user/index" target="_top"><i class="am-icon-user am-icon-fw"></i>个人中心</a>
                </div>
            </div>
            <div class="topMessage mini-cart">
                <div class="menu-hd"><a id="mc-menu-hd" href="/user/cart" target="_top"><i
                                class="am-icon-shopping-cart  am-icon-fw"></i><span>购物车</span>(<strong
                                id="J_MiniCartNum"
                                class="h">{{ Auth::check()?Auth::user()->order_products->count():0 }}</strong>)</a>
                </div>
            </div>
        </ul>
    </div>

    <!--悬浮搜索框-->

    <div class="nav white">
        <div class="logo"><img src="/index/images/logo.png"/></div>
        <div class="logoBig">
            <li><img src="/index/images/logobig.png"/></li>
        </div>

        <div class="search-bar pr">
            <a name="index_none_header_sysc" href="#"></a>
            <form>
                <input id="searchInput" name="index_none_header_sysc" type="text" placeholder="搜索"
                       autocomplete="off">
                <input id="ai-topsearch" class="submit am-btn" value="搜索" index="1" type="submit">
            </form>
        </div>
    </div>

    <div class="clear"></div>
@show

@section('banner')
    <div class="banner">
        <!--轮播 -->
        <div class="am-slider am-slider-default scoll" data-am-flexslider id="demo-slider-0">
            <ul class="am-slides">
                <li class="banner1"><a href="introduction.html"><img src="../images/ad1.jpg"/></a></li>
                <li class="banner2"><a><img src="../images/ad2.jpg"/></a></li>
                <li class="banner3"><a><img src="../images/ad3.jpg"/></a></li>
                <li class="banner4"><a><img src="../images/ad4.jpg"/></a></li>

            </ul>
        </div>
        <div class="clear"></div>
    </div>

@show

@section('shop_nav')
@show

@section('content')
@show

<script>
    window.jQuery || document.write('<script src="/index/basic/js/jquery.min.js "><\/script>');
</script>
<script type="text/javascript " src="/index/basic/js/quick_links.js "></script>

@section('script')
@show
</body>

</html>