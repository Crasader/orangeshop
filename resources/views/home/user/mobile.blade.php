@extends('home.layouts.user.layout')

@section('head')
    @parent
    <link href="/index/css/stepstyle.css" rel="stylesheet" type="text/css">
@stop

@section('content')
    <div class="main-wrap">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">绑定手机</strong> /
                <small>Bind&nbsp;Phone</small>
            </div>
        </div>
        <hr/>
        <!--进度条-->
        <div class="m-progress">
            <div class="m-progress-list">
							<span class="step-1 step">
                                <em class="u-progress-stage-bg"></em>
                                <i class="u-stage-icon-inner">1<em class="bg"></em></i>
                                <p class="stage-name">绑定手机</p>
                            </span>
                <span class="step-2 step">
                                <em class="u-progress-stage-bg"></em>
                                <i class="u-stage-icon-inner">2<em class="bg"></em></i>
                                <p class="stage-name">完成</p>
                            </span>
                <span class="u-progress-placeholder"></span>
            </div>
            <div class="u-progress-bar total-steps-2">
                <div class="u-progress-bar-inner"></div>
            </div>
        </div>
        <form class="am-form am-form-horizontal" action="/user/mobile" method="post">
            {{ csrf_field() }}
                <input type="hidden" name="mobile">
                <div class="am-form-group bind">
                    <label for="user-phone" class="am-form-label">验证手机</label>
                    <div class="am-form-content">
                        <span id="user-phone">{{ $user->mobile }}</span>
                    </div>
                </div>
                <div class="am-form-group code">
                    <label for="user-code" class="am-form-label">验证码</label>
                    <div class="am-form-content">
                        <input type="tel" id="user-code" placeholder="短信验证码">
                    </div>
                    <a class="btn" href="javascript:void(0);" onclick="sendMobileCode();" id="sendMobileCode">
                        <div class="am-btn am-btn-danger">验证码</div>
                    </a>
                </div>
            <div class="am-form-group">
                <label for="user-new-phone" class="am-form-label">验证手机</label>
                <div class="am-form-content">
                    <input type="tel" id="user-new-phone" placeholder="绑定新手机号">
                </div>
            </div>

            <div class="info-btn">
                <button type="submit" class="am-btn am-btn-danger">保存修改</button>
            </div>
        </form>
    </div>
@stop

@section('script')
    <script>
        function sendMobileCode() {

        }
    </script>
@stop