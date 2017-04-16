@extends('home.layouts.user.layout')
@section('head')
    @parent
    <link href="/index/css/infstyle.css" rel="stylesheet" type="text/css">
@stop

@section('content')
    <div class="main-wrap">
        <!--标题 -->
        <div class="user-safety">
            <div class="am-cf am-padding">
                <div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">账户安全</strong> /
                    <small>Set&nbsp;up&nbsp;Safety</small>
                </div>
            </div>
            <hr/>

            <!--头像 -->
            <div class="user-infoPic">

                <div class="filePic">
                    <img class="am-circle am-img-thumbnail" src="/index/images/getAvatar.do.jpg" alt=""/>
                </div>

                <p class="am-form-help">头像</p>

                <div class="info-m">
                    <div><b>用户名：<i>{{ $user->username }}</i></b></div>
                    <div class="u-level">
									<span class="rank r2">
							             <s class="vip1"></s><a class="classes" href="#">铜牌会员</a>
						            </span>
                    </div>
                    <div class="u-safety">
                        <a href="/user/safety">
                            账户安全
                            <span class="u-profile"><i class="bc_ee0000" style="width: 60px;"
                                                       width="0">60分</i></span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="check">
                <ul>
                    <li>
                        <i class="i-safety-lock"></i>
                        <div class="m-left">
                            <div class="fore1">登录密码</div>
                            <div class="fore2">
                                <small>为保证您购物安全，建议您定期更改密码以保护账户安全。</small>
                            </div>
                        </div>
                        <div class="fore3">
                            <a href="/user/password">
                                <div class="am-btn am-btn-secondary">修改</div>
                            </a>
                        </div>
                    </li>
                    <li>
                        <i class="i-safety-iphone"></i>
                        <div class="m-left">
                            <div class="fore1">手机验证</div>
                            <div class="fore2">
                                @if(isset($user->mobile))
                                    <small>您验证的手机：{{ $user->mobile }} @if($user->verify_mobile == 0) 请完成绑定 @else
                                            若已丢失或停用，请立即更换@endif</small>
                                @else
                                    <small>您还未绑定手机号，请完成绑定</small>
                                @endif
                            </div>
                        </div>
                        <div class="fore3">
                            <a href="/user/mobile">
                                <div class="am-btn am-btn-secondary">绑定</div>
                            </a>
                        </div>
                    </li>
                    <li>
                        <i class="i-safety-mail"></i>
                        <div class="m-left">
                            <div class="fore1">邮箱验证</div>
                            <div class="fore2">
                                @if(isset($user->email))
                                    <small>您验证的邮箱：{{ $user->email }}，可用于快速找回登录密码 @if($user->verify_email == 0) 请完成绑定 @else
                                            若已丢失或停用，请立即更换@endif</small>
                                @else
                                    <small>您还未绑定邮箱，可用于快速找回登录密码，请完成绑定</small>
                                @endif
                            </div>
                        </div>
                        <div class="fore3">
                            <a href="/user/email">
                                <div class="am-btn am-btn-secondary">绑定</div>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </div>
@stop

