@extends('admin.layouts.layout')
@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <style>
        .child {
            padding-left: 30px;
        }
    </style>
@stop
@section('content')
    <section class="content">
        <div class="row">
            <div class="box box-primary">
                <div class="box-body">

                    <div class="col-sm-5">
                        @include('admin.layouts.message')
                        <form class="form-horizontal" action="{{ route('role.store') }}"
                              method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-sm-3 control-label">角色名</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="角色名"
                                           name="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">显示名</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="显示名"
                                           name="display_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">描述</label>

                                <div class="col-sm-8">
                                    <textarea name="description" rows="4" style="width: 100%"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                @foreach($permissions as $permission)
                                    <label class="col-xs-12">
                                        <input type="checkbox" class="all"
                                               value="{{ $permission->id }}">{{ $permission->display_name }}
                                    </label>
                                    <div class="child">
                                        @foreach($permission->child_checkbox as $child)
                                            <label class="col-xs-4"><input type="checkbox" name="permission[]"
                                                                           value="{{ $child->id }}">{{ $child->display_name }}
                                            </label>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>


                            <div class="form-group">
                                <div class="col-sm-push-4 col-sm-8">
                                    <button type="submit" class="btn btn-primary">添加</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-7">
                        <table class="table table-bordered table-stripped">
                            <tr>
                                <th>ID</th>
                                <th>角色名</th>
                                <th>展示名</th>
                                <th>描述</th>
                                <th>操作</th>
                            </tr>
                            @foreach($roles as  $role)
                                <tr @if($role['parent_id'] != 0) class="hidden" @else class="parent" @endif>
                                    <td>{{$role['id']}}</td>
                                    <td>{{$role['name']}}</td>
                                    <td>{{$role['display_name']}}</td>
                                    <td>{{$role['description']}}</td>

                                    <td>
                                        <a href="{{ route('role.edit',['id'=>$role['id']]) }}">[编辑]</a>
                                        <a href="javascript:;" class="delete"
                                           data-id="{{$role['id']}}">[删除]</a>
                                    </td>
                                </tr>
                            @endforeach

                        </table>
                        <div>{{ $roles->render() }}</div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@stop

@section('script')
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script>
        var pid = '';
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
        $(document).ready(function () {
            //同步一下数据
            $('input[name="name"]').change(function () {
                if ($('input[name="display_name"]').val() == '') {
                    $('input[name="display_name"]').val($(this).val());
                }
            });


            $('.all').on({
                ifChecked: function () {
                    $(this).closest('label').next('.child').find('input').iCheck('check');
                },
                ifUnchecked: function () {
                    $(this).closest('label').next('.child').find('input').iCheck('uncheck');
                }
            })
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
                url: "{{ url('admin/role') }}" + '/' + id,
                method: 'delete',
                dataType: 'json',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data.error == 1) {
                        toastr.error(data.message);
                    } else {
                        toastr.success(data.message);
                        window.location.reload();
                    }
                },
                error: function () {
                    toastr.error('删除失败');
                }
            });
        });
    </script>
@stop
