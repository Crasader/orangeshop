@extends('admin.layouts.layout')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            新增属性
                        </h3>
                        <a href="{{ route('attribute.index') }}" class="btn btn-default pull-right">
                            <i class="fa fa-list"></i> 列表
                        </a>
                    </div>
                    <div class="box-body no-padding">
                        @include('admin.layouts.message')
                        <form class="form-horizontal"
                              action="{{ route('attribute.store') }}"
                              method="post">
                            {{ csrf_field() }}
                            {{ method_field('post') }}
                            <div class="form-group">
                                <label class="col-sm-2 control-label">属性名</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="属性名"
                                           name="name" value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">显示方式</label>

                                <div class="col-sm-8">
                                    <label for=""><input class="form-control" type="radio" name="show_type"
                                                         value="0" @if(old('show_type') == 0)checked @endif> 文本 </label>
                                    <label for=""><input class="form-control" type="radio" name="show_type"
                                                         value="1" @if(old('show_type') == 1)checked @endif> css块
                                    </label>
                                    <label for=""><input class="form-control" type="radio" name="show_type"
                                                         value="2" @if(old('show_type') == 2)checked @endif> 图片 </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">筛选？</label>

                                <div class="col-sm-8">
                                    <label for=""><input class="form-control" type="radio" name="is_filter"
                                                         value="1"
                                                         @if(old('is_filter') == 1)checked @endif>是</label>
                                    <label for=""><input class="form-control" type="radio" name="is_filter"
                                                         value="0"
                                                         @if(old('is_filter') == 0)checked @endif>否</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">排序</label>

                                <div class="col-sm-8">
                                    <input type="number" class="form-control" placeholder="排序"
                                           name="order" value="{{ old('order',0) }}">
                                </div>
                            </div>
                            <div class="box-footer col-sm-push-2 col-sm-8">
                                <button type="submit" class="btn btn-primary">OK</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop