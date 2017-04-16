@extends('admin.layouts.layout')
@section('content')
    <section class="content">
        <div class="row">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">编辑分类</h3>
                    <a href="{{ route('category.index') }}" class="btn btn-default pull-right">
                        <i class="fa fa-list"></i> 列表
                    </a>
                </div>
                <div class="box-body">
                    @include('admin.layouts.message')
                    <form class="form-horizontal" action="{{ route('category.store') }}"
                          method="post">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="col-sm-2 control-label">分类名</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="分类名" name="name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">父级分类</label>

                            <div class="col-sm-8">
                                <select class="form-control select2" style="width: 100%;" name="parent_id">
                                    @foreach($cate_tree as $key=> $name)
                                        @if($key == 0)
                                            <option selected="selected" value="0">{{ $name }}</option>
                                        @else
                                            <option value="{{ $key }}">{{ $name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">价格区间</label>

                            <div class="col-sm-8">
                                <textarea name="price_range" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">排序</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="排序"
                                       name="order" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">描述</label>

                            <div class="col-sm-8">
                                <textarea name="description" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">关键字</label>

                            <div class="col-sm-8">
                                <textarea name="keywords" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">显示？</label>
                            <div class="col-sm-8">
                                <label class="control-label">
                                    <input type="radio" name="is_show" value="1" checked> 是
                                </label>
                                <label class="control-label">
                                    <input type="radio" name="state" value="0"> 否
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">导航？</label>
                            <div class="col-sm-8">
                                <label class="control-label">
                                    <input type="radio" name="is_nav" value="1" checked> 是
                                </label>
                                <label class="control-label">
                                    <input type="radio" name="state" value="0"> 否
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">状态</label>
                            <div class="col-sm-8">
                                <label class="control-label">
                                    <input type="radio" name="state" value="1" checked> 开启
                                </label>
                                <label class="control-label">
                                    <input type="radio" name="state" value="0"> 关闭
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">url</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="url" name="url">
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
    <script src="{{ asset('AdminLTE/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        $('.select2').select2();
    </script>
@stop
