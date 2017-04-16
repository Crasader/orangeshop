@extends('home.layouts.user.layout')

@section('head')
    <link href="/index/css/footstyle.css" rel="stylesheet" type="text/css">
@stop
@section('content')
    <div class="main-wrap">

        <div class="user-foot">
            <!--标题 -->
            <div class="am-cf am-padding">
                <div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">我的足迹</strong> /
                    <small>Browser&nbsp;History</small>
                </div>
            </div>
            <hr/>

            <!--足迹列表 -->
            @foreach($today_histories as $today_history)

                <div class="goods">
                    <div class="goods-date" data-date="2015-12-21">
                        @if($loop->index == 0 )
                            <span><i class="month-lite"></i><i class="day-lite"></i><i
                                        class="date-desc">今天</i></span>
                            <del class="am-icon-trash"></del>
                        @endif
                        <s class="line"></s>
                    </div>

                    <div class="goods-box first-box">
                        <div class="goods-pic">
                            <div class="goods-pic-box">
                                <a class="goods-pic-link" target="_blank" href="#">
                                    <img src="{{ $today_history->images()->where('is_main',1)->first()->path }}"
                                         class="goods-img"></a>
                            </div>
                            <a class="goods-delete" href="javascript:void(0);"><i class="am-icon-trash"></i></a>
                            @if($today_history->state == 0)
                                <div class="goods-status goods-status-show"><span class="desc">宝贝已下架</span></div>@endif
                        </div>

                        <div class="goods-attr">
                            <div class="good-title">
                                <a class="title" href="#" target="_blank">{{ $today_history->name }}</a>
                            </div>
                            <div class="goods-price">
										<span class="g_price">                                    
                                        <span>¥</span><strong>{{ $today_history->shop_price }}</strong>
										</span>
                                <span class="g_price g_price-original">
                                        <span>¥</span><strong>{{ $today_history->market_price }}</strong>
										</span>
                            </div>
                            <div class="clear"></div>
                            <div class="goods-num">
                                <div class="match-recom">
                                    <a href="#" class="match-recom-item">找相似</a>
                                    <a href="#" class="match-recom-item">找搭配</a>
                                    <i><em></em><span></span></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="clear"></div>
            @foreach($week_histories as $week_history)
                <div class="goods">
                    <div class="goods-date" data-date="2015-12-17">
                        @if($loop->index == 0)
                            <span><i class="month-lite"></i><i class="day-lite"></i>	<i
                                        class="date-desc">一周内</i></span>
                            <del class="am-icon-trash"></del>
                        @endif
                        <s class="line"></s>
                    </div>
                    <div class="goods-box">
                        <div class="goods-pic">
                            <div class="goods-pic-box">
                                <a class="goods-pic-link" target="_blank" href="#">
                                    <img src="{{ $week_history->images()->where('is_main',1)->first()->path }}"
                                         class="goods-img"></a>
                            </div>
                            <a class="goods-delete" href="javascript:void(0);"><i class="am-icon-trash"></i></a>
                            @if($week_history->state == 0)
                                <div class="goods-status goods-status-show"><span class="desc">宝贝已下架</span></div>
                            @endif
                        </div>

                        <div class="goods-attr">
                            <div class="good-title">
                                <a class="title" href="#" target="_blank">{{$week_history->name}}</a>
                            </div>
                            <div class="goods-price">
										<span class="g_price">                                    
                                        <span>¥</span><strong>{{ $week_history->shop_price }}</strong>
										</span>
                                <span class="g_price g_price-original">
                                        <span>¥</span><strong>{{ $week_history->market_price }}</strong>
										</span>
                            </div>
                            <div class="clear"></div>
                            <div class="goods-num">
                                <div class="match-recom">
                                    <a href="#" class="match-recom-item">找相似</a>
                                    <a href="#" class="match-recom-item">找搭配</a>
                                    <i><em></em><span></span></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@stop