@extends('admin.layouts.layout')
@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/toastr/toastr.min.css')}}">
@stop
@section('content')
    <section class="content">
        <div class="row">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">分配角色</h3>
                    <a href="{{ route('admin.index') }}" class="btn btn-default pull-right">
                        <i class="fa fa-list"></i> 列表
                    </a>
                </div>
                <div class="box-body">
                    @include('admin.layouts.message')
                    <form class="form-horizontal" action="{{ route('admin.update',['id'=>$admin->user_id]) }}"
                          method="post">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        <div class="form-group">
                            <label class="col-sm-2 control-label">用户名</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" disabled
                                       value="{{ $admin->username }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">角色</label>

                            <div class="col-sm-8">
                                @foreach($roles as $role)
                                    <label class="col-sm-2"> <input type="checkbox" value="{{ $role->id }}"
                                                                    name="role[]">{{ $role->name }}</label>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit">提交</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
@stop

@section('script')
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            //已经存在的选中

            var perms = "{{ $admin->roles->pluck('id') }}";
            perms = perms.replace('[', '').replace(']', '');
            if (perms.length > 0) {
                perms = perms.split(',');
                console.log(perms);
                for (var i = 0; i < perms.length; i++) {
                    $('input[value=' + perms[i] + ']').iCheck('check');
                }
            }
        });
    </script>
@stop