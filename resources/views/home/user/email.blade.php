@extends('home.layouts.user.layout')
@section('head')
    @parent
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="/index/css/stepstyle.css" rel="stylesheet" type="text/css">
@stop
@section('content')
    <div class="main-wrap">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">绑定邮箱</strong> /
                <small>Email</small>
            </div>
        </div>
        <hr/>
        <!--进度条-->
        <div class="m-progress">
            <div class="m-progress-list">
							<span class="step-1 step">
                                <em class="u-progress-stage-bg"></em>
                                <i class="u-stage-icon-inner">1<em class="bg"></em></i>
                                <p class="stage-name">验证邮箱</p>
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
        <form class="am-form am-form-horizontal" method="post" action="/user/email">
            {{ csrf_field() }}
            <div class="am-form-group">
                <label for="user-email" class="am-form-label">验证邮箱</label>
                <div class="am-form-content">
                    <input type="email" id="user-email" placeholder="请输入邮箱地址" name="email" value="{{ $user->email }}">
                </div>
            </div>
            <div class="am-form-group code">
                <label for="user-code" class="am-form-label">验证码</label>
                <div class="am-form-content">
                    <input type="tel" id="user-code" placeholder="验证码" name="code">
                </div>
                <a class="btn" href="javascript:void(0);" onclick="sendMobileCode();" id="sendMobileCode">
                    <div class="am-btn am-btn-danger">获取验证码</div>
                </a>
            </div>
            <div class="am-form-group">
                <label for="user-email" class="am-form-label">账户密码</label>
                <div class="am-form-content">
                    <input type="email" id="password" placeholder="请输入原登录密码" name="password" value="">
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
        function sendMobileCode(){
            if($('#user-email').val() == '' ){
                swal({
                    title:'',
                    text:'请输入完整信息',
                    type:'warning'
                });
                return false;
            }

            $.ajax({
                url:'/user/send_email',
                type:'post',
                dataType:'json',
                data:{
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    email:$('#user-email').val(),

                },
                success:function(data){
                    if(data.error == 0){
                        swal({
                            title:'',
                            text:data.message,
                            type:'success'
                        });
                    }
                },
                error:function () {

                },
                complete:function(){

                }
            })
        }
    </script>
@stop