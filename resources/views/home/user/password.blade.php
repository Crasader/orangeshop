@extends('home.layouts.user.layout')

@section('head')
    @parent
    <link href="/index/css/stepstyle.css" rel="stylesheet" type="text/css">
@stop

@section('content')
    <div class="main-wrap">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">修改密码</strong> /
                <small>Password</small>
            </div>
        </div>
        <hr/>
        <!--进度条-->
        <div class="m-progress">
            <div class="m-progress-list">
							<span class="step-1 step">
                                <em class="u-progress-stage-bg"></em>
                                <i class="u-stage-icon-inner">1<em class="bg"></em></i>
                                <p class="stage-name">重置密码</p>
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
        <form class="am-form am-form-horizontal" id="password_reset" action="/user/password" method="post">
            {{ csrf_field() }}
            <div class="am-form-group">
                <label for="user-old-password" class="am-form-label">原密码</label>
                <div class="am-form-content">
                    <input type="password" id="old_password" placeholder="请输入原登录密码" name="password">
                </div>
            </div>
            <div class="am-form-group">
                <label for="user-new-password" class="am-form-label">新密码</label>
                <div class="am-form-content">
                    <input type="password" id="new_password" placeholder="由数字、字母组合" name="new_password">
                </div>
            </div>
            <div class="am-form-group">
                <label for="user-confirm-password" class="am-form-label">确认密码</label>
                <div class="am-form-content">
                    <input type="password" id="confirm_password" placeholder="请再次输入上面的密码"
                           name="new_password_confirmation">
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
        $('#password_reset').submit(function () {
            var old_pwd = $('#old_password').val();
            var new_pwd = $('#new_password').val();
            var confirm_pwd = $('#confirm_password').val();
            if (old_pwd.trim().length == 0 || new_pwd.trim().length == 0 || new_pwd != confirm_pwd) {
                swal({
                    title: '',
                    text: '请确认一下填写内容',
                    type: 'warning'
                });
                return false;
            }
        });
    </script>
@stop