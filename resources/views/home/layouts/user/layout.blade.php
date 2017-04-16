<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=0">

    <title>个人中心</title>

    <link href="/index/AmazeUI-2.4.2/assets/css/admin.css" rel="stylesheet" type="text/css">
    <link href="/index/AmazeUI-2.4.2/assets/css/amazeui.css" rel="stylesheet" type="text/css">
    <link href="/index/css/personal.css" rel="stylesheet" type="text/css">
    <link href="/plugins/sweetalert/dist/sweetalert.css" rel="stylesheet" type="text/css">
    <script src="/plugins/sweetalert/dist/sweetalert.min.js"></script>
    <script src="/js/jquery.min.js"></script>
    @section('head')
        <link href="/index/css/systyle.css" rel="stylesheet" type="text/css">
    @show

</head>

<body>
<!--头 -->
<header>
    <article>
        <div class="mt-logo">
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
                        <div class="menu-hd MyShangcheng"><a href="/user/index" target="_top"><i
                                        class="am-icon-user am-icon-fw"></i>个人中心</a></div>
                    </div>
                    <div class="topMessage mini-cart">
                        <div class="menu-hd"><a id="mc-menu-hd" href="/user/cart" target="_top"><i
                                        class="am-icon-shopping-cart  am-icon-fw"></i><span>购物车</span><strong
                                        id="J_MiniCartNum" class="h">0</strong></a></div>
                    </div>
                </ul>
            </div>

            <!--悬浮搜索框-->

            <div class="nav white">
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
        </div>
        </div>
    </article>
</header>
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
<b class="line"></b>

<div class="center">
    <div class="col-main">
        @section('content')
        @show

        @include('home.layouts._footer')
    </div>
    @include('home.layouts.user.left_menu')
</div>

@section('nav')
    <!--引导 -->
    <div class="navCir">
        <li><a href="/index/index/home.html"><i class="am-icon-home "></i>首页</a></li>
        <li><a href="/index/index/sort.html"><i class="am-icon-list"></i>分类</a></li>
        <li><a href="/index/index/shopcart.html"><i class="am-icon-shopping-basket"></i>购物车</a></li>
        <li class="active"><a href="index.html"><i class="am-icon-user"></i>我的</a></li>
    </div>
@show

@if(count($errors)>0)
    <script>
        swal({
            title: '',
            text: "{!! $errors->first() !!}",
            type: 'warning'
        })
    </script>
@endif
@if(session('message'))
    <script>
        swal({
            title: '',
            text: "{!! session('message') !!}",
            type: "{!! session('type') !!}"
        })
    </script>
@endif

@section('script')
@show

</body>

</html>