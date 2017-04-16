@extends('home.layouts.user.layout')

@section('head')
    @parent
    <link href="/index/css/infstyle.css" rel="stylesheet" type="text/css">
    <script src="/index/AmazeUI-2.4.2/assets/js/jquery.min.js" type="text/javascript"></script>
    <script src="/index/AmazeUI-2.4.2/assets/js/amazeui.js" type="text/javascript"></script>
@stop

@section('content')
    <div class="main-wrap">

        <div class="user-info">
            <!--标题 -->
            <div class="am-cf am-padding">
                <div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">个人资料</strong> /
                    <small>Personal&nbsp;information</small>
                </div>
            </div>
            <hr/>

            <!--头像 -->
            <div class="user-infoPic">

                <div class="filePic">
                    <input type="file" class="inputPic" allowexts="gif,jpeg,jpg,png,bmp" accept="image/*">
                    <img class="am-circle am-img-thumbnail" src="/index/images/getAvatar.do.jpg" alt=""/>
                </div>

                <p class="am-form-help">头像</p>

                <div class="info-m">
                    <div><b>用户名：<i>{{ isset($user->username)? $user->username : '小叮当' }}</i></b></div>
                    <div class="u-level">
									<span class="rank r2">
							             <s class="vip1"></s><a class="classes" href="#">铜牌会员</a>
						            </span>
                    </div>
                    <div class="u-safety">
                        <a href="safety.html">
                            账户安全
                            <span class="u-profile"><i class="bc_ee0000" style="width: 60px;" width="0">60分</i></span>
                        </a>
                    </div>
                </div>
            </div>

            <!--个人信息 -->
            <div class="info-main">
                <form class="am-form am-form-horizontal" action="{{ url('user/information/update') }}" method="post">
                    {{ csrf_field() }}

                    <div class="am-form-group">
                        <label for="user-name2" class="am-form-label">昵称</label>
                        <div class="am-form-content">
                            <input type="text" id="user-name2" placeholder="nickname"
                                   value="{{ $user->username }}" name="username">

                        </div>
                    </div>

                    <div class="am-form-group">
                        <label class="am-form-label">性别</label>
                        <div class="am-form-content sex">
                            <label class="am-radio-inline">
                                <input type="radio" name="sex" value="0"
                                       @if($user->sex == 0) checked @endif > 男
                            </label>
                            <label class="am-radio-inline">
                                <input type="radio" name="sex" value="1"
                                       @if($user->sex == 1) checked @endif> 女
                            </label>
                        </div>
                    </div>
                    <div class="info-btn">
                        <button type="submit" class="am-btn am-btn-danger">保存修改</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop