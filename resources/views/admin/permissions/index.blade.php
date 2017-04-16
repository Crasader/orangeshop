@extends('admin.layouts.layout')
@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@stop
@section('content')
    <section class="content">
        <div class="row">
            <div class="box box-primary">
                <div class="box-body">

                    <div class="col-sm-4">
                        @include('admin.layouts.message')
                        <form class="form-horizontal" action="{{ route('permission.store') }}"
                              method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-sm-4 control-label">显示名</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="权限名"
                                           name="display_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">权限</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="权限"
                                           name="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">从属权限</label>

                                <div class="col-sm-8">
                                    <select class="form-control select2" style="width: 100%;" name="parent_id">
                                        <option value="0" selected>--顶级菜单--</option>
                                        @foreach(array_pluck($permissions_tree,'display_name','id') as $key=>$display_name)
                                            <option value="{{ $key }}">{{ $display_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">菜单?</label>

                                <div class="col-sm-8">
                                    <input type="checkbox" class="form-control" placeholder="排序"
                                           name="is_menu" value="1">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">排序</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="排序"
                                           name="order" value="0">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">描述</label>

                                <div class="col-sm-8">
                                    <textarea name="description" rows="4" style="width: 100%"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-push-4 col-sm-8">
                                    <button type="submit" class="btn btn-primary">添加</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-8">
                        <table class="table table-bordered table-stripped">
                            <tr>
                                <th>ID</th>
                                <th>排序</th>
                                <th>展示名</th>
                                <th>权限</th>
                                <th>菜单?</th>
                                <th>操作</th>
                            </tr>
                            @foreach($permissions_tree as  $permission)
                                <tr @if($permission['parent_id'] != 0) class="hidden" @else class="parent" @endif>
                                    <td>{{$permission['id']}}</td>
                                    <td><input type="number" data-id="{{$permission['id']}}" class="order"
                                               value="{{$permission['order']}}" style="width: 60px"></td>
                                    <td>
                                        <label  @if($permission['parent_id'] == 0)class="label label-warning show_children" @endif >
                                            {{$permission['display_name']}}
                                        </label>
                                    </td>
                                    <td>{{$permission['name']}}</td>
                                    <td>
                                        @if($permission['is_menu'] == 1)
                                            <label class="label label-primary">是</label>
                                        @else
                                            <label class="label label-default">否</label>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('permission.edit',['id'=>$permission['id']]) }}">[编辑]</a>
                                        <a href="javascript:;" class="delete"
                                           data-id="{{$permission['id']}}">[删除]</a>
                                    </td>
                                </tr>
                            @endforeach

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </section>
@stop

@section('script')
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/select2/select2.full.min.js') }}"></script>
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
            $('.select2').select2();
            //$('input[name="is_menu"]').iCheck('check')

            //折叠
            $('.show_children').click(function () {
                var dom_children = $(this).parents('tr').nextUntil('.parent');
                dom_children.toggleClass('hidden');
            });
        });

        //更新排序
        $('.order').change(function () {
            var order = $(this).val();
            var id = $(this).data('id');
            $.ajax({
                url: "{{ url('admin/permission') }}" + '/' + id,
                method: 'put',
                dataType: 'json',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    order: order
                },
                success: function (data) {
                    if (data.error == 1) {
                        toastr.error(data.message);
                    } else {
                        toastr.success(data.message);
                    }
                },
                error: function () {
                    toastr.error('更新排序失败');
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
                url: "{{ url('admin/permission') }}" + '/' + id,
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
