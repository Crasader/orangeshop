@extends('admin.layouts.layout')
@section('head')
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
                <div class="box-header">
                    <h3 class="box-title">
                        修改角色
                    </h3>
                    <a href="{{ route('role.index') }}" class="btn btn-default pull-right">
                        <i class="fa fa-list"></i> 列表
                    </a>
                </div>
                <div class="box-body">
                    <div class="col-sm-12">
                        @include('admin.layouts.message')
                        <form class="form-horizontal" action="{{ route('role.update',['id'=>$role->id]) }}"
                              method="post">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            <div class="form-group">
                                <label class="col-sm-2 control-label">角色名</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control"
                                           name="name" value="{{ $role->name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">显示名</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" value="{{ $role->display_name }}"
                                           name="display_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">描述</label>

                                <div class="col-sm-8">
                                    <textarea name="description" rows="4"
                                              style="width: 100%">{{ $role->description }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-8 col-sm-push-2">
                                    @foreach($permissions as $permission)
                                        <label class="col-xs-12">
                                            <input type="checkbox" class="all"
                                                   value="{{ $permission->id }}">{{ $permission->display_name }}
                                        </label>
                                        <div class="child">
                                            @foreach($permission->child_checkbox as $child)
                                                <label class="col-xs-3"><input type="checkbox" name="permission[]"
                                                                               value="{{ $child->id }}">{{ $child->display_name }}
                                                </label>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-push-2 col-sm-8">
                                    <button type="submit" class="btn btn-primary">确定</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            //已经存在的选中

            var perms = "{{ $perms }}";
            perms = perms.replace('[', '').replace(']', '');
            if (perms.length > 0) {
                perms = perms.split(',');
                console.log(perms);
                for (var i = 0; i < perms.length; i++) {
                    $('input[value=' + perms[i] + ']').iCheck('check');
                }
            }


            //全选、全不选
            $('.all').on({
                ifChecked: function () {
                    $(this).closest('label').next('.child').find('input').iCheck('check');
                },
                ifUnchecked: function () {
                    $(this).closest('label').next('.child').find('input').iCheck('uncheck');
                }
            });
        });

    </script>
@stop
