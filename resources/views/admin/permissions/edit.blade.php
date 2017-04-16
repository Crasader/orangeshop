@extends('admin.layouts.layout')
@section('content')
    <section class="content">
        <div class="row">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="col-sm-6">
                        @include('admin.layouts.message')
                        <form class="form-horizontal" action="{{ route('permission.update',['id'=>$permission->id]) }}"
                              method="post">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            <div class="form-group">
                                <label class="col-sm-4 control-label">ID</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="权限名"
                                           name="display_name" disabled value="{{ $permission->id }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">显示名</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="权限名"
                                           name="display_name" value="{{ $permission->display_name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">权限</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="权限"
                                           name="name" value="{{ $permission->name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">从属权限</label>

                                <div class="col-sm-8">
                                    <select class="form-control select2" style="width: 100%;" name="parent_id">
                                        <option value="0" selected>--顶级菜单--</option>
                                        @foreach(array_pluck($permissions_tree,'display_name','id') as $key=>$display_name)
                                            <option value="{{ $key }}"
                                                    @if($permission->parent_id == $key) selected @endif>{{ $display_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">菜单?</label>

                                <div class="col-sm-8">
                                    <input type="checkbox" class="form-control" name="is_menu" value="1" data-v="{{ $permission->is_menu }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">排序</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="排序"
                                           name="order" value="{{$permission->order  }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">描述</label>

                                <div class="col-sm-8">
                                    <textarea name="description" rows="4" style="width: 100%">{{ $permission->description }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-push-4 col-sm-8">
                                    <button type="submit" class="btn btn-primary">修改</button>
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
    <script src="{{ asset('AdminLTE/plugins/select2/select2.full.min.js') }}"></script>
    <script>

        $(document).ready(function () {
            $('.select2').select2();
            var dom_checkbox = $('input[name="is_menu"]')
            if(dom_checkbox.data('v') == 1){
                $('input[name="is_menu"]').iCheck('check')
            }
        });

    </script>
@stop
