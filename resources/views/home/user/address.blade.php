@extends('home.layouts.user.layout')

@section('head')
    @parent
    <link href="/index/css/addstyle.css" rel="stylesheet" type="text/css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        select {
            min-height: 22px;
            min-width: 160px;
            max-height: 200px;
            overflow-y: auto;
        }
    </style>
@stop

@section('content')
    <div class="main-wrap">

        <div class="user-address">
            <!--标题 -->
            <div class="am-cf am-padding">
                <div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">地址管理</strong> /
                    <small>Address&nbsp;list</small>
                </div>
            </div>
            <hr/>
            @if($addresses->count()>0)
                <ul class="am-avg-sm-1 am-avg-md-3 am-thumbnails">
                    @foreach($addresses as $address)
                        @if($address->is_default == 1)
                            <li class="user-addresslist defaultAddr">
                                <span class="new-option-r" data-address="{{ $address->address_id }}"><i
                                            class="am-icon-check-circle"></i>默认地址</span>
                                <p class="new-tit new-p-re">
                                    <span class="new-txt">{{ $address->consignee }}</span>
                                    <span class="new-txt-rd2">{{ $address->mobile }}</span>
                                </p>
                                <div class="new-mu_l2a new-p-re">
                                    <p class="new-mu_l2cw">
                                        <span class="title">地址：</span>
                                        <span class="province">{{ $address->province }}</span>
                                        <span class="city">{{ $address->city }}</span>
                                        <span class="dist">{{ $address->district }}</span>
                                        <span class="street">{{ $address->address }}</span></p>
                                </div>
                                <div class="new-addr-btn">
                                    <a href="#"><i class="am-icon-edit"></i>编辑</a>
                                    <span class="new-addr-bar">|</span>
                                    <a href="javascript:void(0);" class="delete" data-address="{{ $address->address_id }}"><i
                                                class="am-icon-trash"></i>删除</a>
                                </div>
                            </li>
                        @else
                            <li class="user-addresslist">
                                <span class="new-option-r" data-address="{{ $address->address_id }}"><i
                                            class="am-icon-check-circle"></i>设为默认</span>
                                <p class="new-tit new-p-re">
                                    <span class="new-txt">{{ $address->consignee }}</span>
                                    <span class="new-txt-rd2">{{ $address->mobile }}</span>
                                </p>
                                <div class="new-mu_l2a new-p-re">
                                    <p class="new-mu_l2cw">
                                        <span class="title">地址：</span>
                                        <span class="province">{{ $address->province }}</span>
                                        <span class="city">{{ $address->city }}</span>
                                        <span class="dist">{{ $address->district }}</span>
                                        <span class="street">{{ $address->address }}</span></p>
                                </div>
                                <div class="new-addr-btn">
                                    <a href="#"><i class="am-icon-edit"></i>编辑</a>
                                    <span class="new-addr-bar">|</span>
                                    <a href="javascript:void(0);" class="delete" data-address="{{ $address->address_id }}"><i
                                                class="am-icon-trash"></i>删除</a>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif
            <div class="clear"></div>
            <a class="new-abtn-type" data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0}">添加新地址</a>
            <!--例子-->
            <div class="am-modal am-modal-no-btn" id="doc-modal-1">

                <div class="add-dress">

                    <!--标题 -->
                    <div class="am-cf am-padding">
                        <div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">新增地址</strong> /
                            <small>Add&nbsp;address</small>
                        </div>
                    </div>
                    <hr/>

                    <div class="am-u-md-12 am-u-lg-8" style="margin-top: 20px;">
                        <form class="am-form am-form-horizontal" action="/user/address" method="post">
                            {{csrf_field()}}
                            <div class="am-form-group">
                                <label for="user-name" class="am-form-label">收货人</label>
                                <div class="am-form-content">
                                    <input type="text" id="user-name" placeholder="收货人" name="consignee">
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label for="user-phone" class="am-form-label">手机号码</label>
                                <div class="am-form-content">
                                    <input id="user-phone" placeholder="手机号必填" type="tel" name="mobile">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="user-address" class="am-form-label">所在地</label>
                                <div class="am-form-content address">
                                    <select data-am-selected="" id="province" name="province_id">
                                        @foreach($provinces as $province)
                                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                    <select data-am-selected="" id="city" name="city_id">

                                    </select>
                                    <select data-am-selected="" id="district" name="district_id">

                                    </select>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label for="user-intro" class="am-form-label">详细地址</label>
                                <div class="am-form-content">
                                    <textarea class="" rows="3" id="user-intro" placeholder="输入详细地址"
                                              name="address"></textarea>
                                    <small>100字以内写出你的详细地址...</small>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label for="user-zipcode" class="am-form-label">邮编</label>
                                <div class="am-form-content">
                                    <input id="user-zipcode" placeholder="邮编" type="text" name="zipcode">
                                </div>
                            </div>

                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3">
                                    <button type="submit" class="am-btn am-btn-danger">保存</button>
                                    <button type="reset" class=" am-btn am-btn-danger">取消</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

            </div>

        </div>

        <script type="text/javascript">
            $(document).ready(function () {
                $(".new-option-r").click(function () {
                    var self = this;
                    //修改默认地址
                    $.ajax({
                        url: '/user/address/update',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            address_id: $(self).data('address')
                        },
                        success: function (data) {
                            if (data.error == 0) {
                                swal({
                                    title: '',
                                    text: '设置成功',
                                    type: 'success'
                                });
                                $(self).parent('.user-addresslist').addClass("defaultAddr").siblings().removeClass("defaultAddr");
                            } else {
                                swal({
                                    title: '',
                                    text: '设置失败',
                                    type: 'warning'
                                })
                            }
                        },
                        error: function () {
                            swal({
                                title: '',
                                text: '设置失败',
                                type: 'warning'
                            })
                        }
                    })
                });

                var $ww = $(window).width();
                if ($ww > 640) {
                    $("#doc-modal-1").removeClass("am-modal am-modal-no-btn")
                }

            })
        </script>

        <div class="clear"></div>
    </div>
@stop

@section('script')
    <script>
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

                    $('#city').change();
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

        $('.delete').click(function () {
            var self = this;
            $.ajax({
                url: '/user/address/delete',
                type: 'delete',
                dataType: 'json',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    address_id: $(self).data('address')
                },
                success: function (data) {
                    if (data.error == 0) {
                        swal({
                            title: '',
                            text: '设置成功',
                            type: 'success'
                        });
                        $(self).closest('li').remove();
                    } else {
                        swal({
                            title: '',
                            text: '删除失败',
                            type: 'warning'
                        })
                    }
                },
                error: function () {
                    swal({
                        title: '',
                        text: '删除失败',
                        type: 'warning'
                    })
                }
            });
        });
    </script>
@stop