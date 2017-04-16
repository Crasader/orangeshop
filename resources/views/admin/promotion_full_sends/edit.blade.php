@extends('admin.layouts.layout')
@section('head')
    <meta name="_token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
    <style>
        [v-cloak] {
            display: none;
        }

        .clicked {
            border: 2px #3c8dbc solid !important;
        }
    </style>
@stop
@section('content')
    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">编辑买赠活动</h3>
                <a href="{{ route('promotion_full_send.index') }}" class="btn btn-default pull-right">
                    <i class="fa fa-list"></i> 列表
                </a>
            </div>
            <div class="box-body">
                <div class="col-xs-12">
                    @include('admin.layouts.message')
                    <form class="form-horizontal"
                          action="{{ route('promotion_full_send.update',['id'=>$promotion_full_send->pm_id]) }}"
                          id="promotion_full_send"
                          method="post">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        <div class="form-group">
                            <label class="col-sm-2 control-label">买赠活动名</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control"
                                       name="name" value="{{ $promotion_full_send->name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">限额</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control"
                                       name="limit_money" value="{{ $promotion_full_send->limit_money }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">时间段:</label>

                            <div class="col-sm-4">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="datetime" name="start_time" class="form-control pull-right"
                                           id="start"
                                           data-date-format="yyyy-mm-dd hh:ii:ss" value="{{ $promotion_full_send->start_time }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="datetime" name="end_time" class="form-control pull-right" id="end"
                                           data-date-format="yyyy-mm-dd hh:ii:ss" value="{{ $promotion_full_send->end_time }}">
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">状态</label>
                            <div class="col-sm-8">
                                <label class="control-label">
                                    <input type="radio" name="state" value="1" @if($promotion_full_send->state == 1) checked @endif>开启
                                </label>
                                <label class="control-label">
                                    <input type="radio" name="state" value="0" @if($promotion_full_send->state == 0) checked @endif>关闭
                                </label>
                            </div>
                        </div>
                        <div class="box-footer col-sm-push-2 col-sm-8">
                            <button type="submit" class="btn btn-primary">OK</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop

@section('script')
    <!-- date-range-picker -->
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('js/vue.js') }}"></script>


    <script>
        $(function () {
            //初始化时间选择器
            $('#start,#end').datetimepicker();
        });
    </script>
@stop