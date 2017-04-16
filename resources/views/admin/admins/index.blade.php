@extends('admin.layouts.layout')
@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="box box-primary">
                <div class="box-header with-border ">
                    <div class="col-sm-5">
                        <div class="btn-group btn-group-sm">
                            <a class="btn btn-info" href=" {{ route('admin.index') }}"><i
                                        class="fa fa-refresh"></i> 刷新</a>
                        </div>
                    </div>
                    <div class="col-sm-3 pull-right">
                        <div class="input-group">
                            <input type="text" id="username" class="form-control input-sm"
                                   placeholder="管理员名">

                            <span class="input-group-btn">
                                        <a href="javascript:;" type="button" class="btn btn-sm btn-primary" id="search"> 搜索</a>
                                    </span>
                        </div>
                    </div>
                </div>

                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>用户名</th>
                            <th>邮箱</th>
                            <th>超级管理员</th>
                            <th>手机</th>
                            <th>邮箱验证？</th>
                            <th>手机验证？</th>
                            <th>启用状态</th>
                            <th>上次访问时间</th>
                            <th>上次访问ip</th>

                            <th>操作</th>
                        </tr>
                        </thead>
                        @foreach($admins as $admin)
                            <tr>
                                <td>{{ $admin->username }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>
                                    <input type="checkbox" data-id="{{ $admin->user_id }}" value="1"
                                           data-v="{{ $admin->is_super}}" class="is_super">
                                </td>
                                <td>{{ $admin->mobile }}</td>
                                <td>
                                    @if($admin->verify_email == 1)
                                        <label class="label label-primary">是</label>
                                    @else
                                        <label class="label label-default">否</label>
                                    @endif
                                </td>
                                <td>
                                    @if($admin->verify_mobile == 1)
                                        <label class="label label-primary">是</label>
                                    @else
                                        <label class="label label-default">否</label>
                                    @endif
                                </td>
                                <td>
                                    <input type="checkbox" data-id="{{ $admin->user_id }}" data-v="{{  $admin->state}}"
                                           value="1" class="state">
                                </td>
                                <td>{{ $admin->last_visit_time}}</td>
                                <td>{{ $admin->last_visit_ip}}</td>
                                <td>
                                    <a href="{{ route('admin.edit',['id'=>$admin->user_id]) }}" class="">[分配角色]</i> </a>

                                    <a href="javascript:;" class="delete" data-id="{{ $admin->user_id }}">[删除]</a>
                                </td>
                            </tr>
                        @endforeach

                    </table>
                    <div class="pull-right">
                        {{$admins->render()}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('script')
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

    <script>
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "positionClass": "toast-top-right",
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        //处理是否是超级管理员和开启状态的checkbox
        $('.is_super,.state').each(function () {
            var self = $(this);
            if (self.data('v') == self.val()) {
                self.iCheck('check');
            }
        });

        //绑定状态更改事件
        $('.is_super').on({
            ifChecked: function () {
                var id = $(this).data('id');
                $.ajax({
                    url: '{{ url("admin/admin") }}' + '/' + id,
                    method: 'put',
                    dataType: 'json',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        is_super: 1
                    },
                    success: function (data) {
                        if (data.error == 0) {
                            toastr.success(data.message);
                        } else {
                            toastr.error(data.message);
                        }
                    },
                    error: function () {
                        toastr.error('更新失败');
                    }
                });
            },
            ifUnchecked: function () {
                var id = $(this).data('id');
                $.ajax({
                    url: '{{ url("admin/admin") }}' + '/' + id,
                    method: 'put',
                    dataType: 'json',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        is_super: 0
                    },
                    success: function (data) {
                        if (data.error == 0) {
                            toastr.success(data.message);
                        } else {
                            toastr.error(data.message);
                        }
                    },
                    error: function () {
                        toastr.error('更新失败');
                    }
                });
            }
        });
        $('.state').on({
            ifChecked: function () {
                var id = $(this).data('id');
                $.ajax({
                    url: '{{ url("admin/admin") }}' + '/' + id,
                    method: 'put',
                    dataType: 'json',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        state: 1
                    },
                    success: function (data) {
                        if (data.error == 0) {
                            toastr.success(data.message);
                        } else {
                            toastr.error(data.message);
                        }
                    },
                    error: function () {
                        toastr.error('更新失败');
                    }
                });
            },
            ifUnchecked: function () {
                var id = $(this).data('id');
                $.ajax({
                    url: '{{ url("admin/admin") }}' + '/' + id,
                    method: 'put',
                    dataType: 'json',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        state: 0
                    },
                    success: function (data) {
                        if (data.error == 0) {
                            toastr.success(data.message);
                        } else {
                            toastr.error(data.message);
                        }
                    },
                    error: function () {
                        toastr.error('更新失败');
                    }
                });
            }
        });


        /**
         * delete
         */
        $('.delete').click(function () {
            var _that = this;
            var rst = confirm('确认删除？');
            if (!rst) {
                return false;
            }
            var id = $(this).data('id');
            if (!$.isNumeric(id)) {
                return false;
            }
            $.ajax({
                url: "{{ url('admin/admin') }}" + "/" + id,
                type: 'delete',
                dataType: 'json',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data.error) {
                        toastr.error(data.message);
                    } else {
                        //如果成功,提醒并删除
                        toastr.success(data.message);
                        $(_that).parents('tr:eq(0)').remove();
                    }
                },
                error: function () {

                }
            });
        });

        /**
         * 条件筛选
         */
        $('#search').click(function () {
            var username = $('#username').val();
            if ($.trim(username).length < 1) {
                alert('请输入品牌名');
                return false;
            }
            //http://prettus.local/?search=lorem&searchFields=name:like;email
            self.location = "{{ route('admin.index') }}" + "?search=" + username + "&searchFields=username:like"
        });
    </script>
@stop
