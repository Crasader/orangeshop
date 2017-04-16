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
                <h3 class="box-title">新增单品活动</h3>
                <a href="{{ route('promotion_single.index') }}" class="btn btn-default pull-right">
                    <i class="fa fa-list"></i> 列表
                </a>
            </div>
            <div class="box-body">
                <div class="col-xs-6">
                    @include('admin.layouts.message')
                    <form class="form-horizontal" action="{{ route('promotion_single.update',['id'=>$promotion_single->pm_id]) }}" id="promotion_single"
                          method="post">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        <input type="hidden" name="pid" id="pid" value="{{ $promotion_single->pid }}">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">活动名</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                       name="name" value="{{ $promotion_single->name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">商品</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                       name="name" value="{{ $promotion_single->product->name }}" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">标语</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                       name="slogan" value="{{ $promotion_single->slogan }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">时间段:</label>

                            <div class="col-sm-5">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="datetime" name="start_time" class="form-control pull-right"
                                           id="start"
                                           data-date-format="yyyy-mm-dd hh:ii:ss"
                                           value="{{ $promotion_single->start_time }}">
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="datetime" name="end_time" class="form-control pull-right" id="end"
                                           data-date-format="yyyy-mm-dd hh:ii:ss"
                                           value="{{ $promotion_single->end_time }}">
                                </div>
                            </div>
                        </div>

                        <div class=" form-group">
                            <label class="col-sm-2 control-label">类型</label>

                            <div class="col-sm-10">
                                <label><input type="radio" value="0"
                                              name="discount_type"
                                              @if($promotion_single->discount_type == 0) checked @endif>直降</label>
                                <label><input type="radio" value="1"
                                              name="discount_type"
                                              @if($promotion_single->discount_type == 1) checked @endif>
                                    打折</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">值</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                       name="discount_value"
                                       value="{{ $promotion_single->discount_value }}">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">状态</label>
                            <div class="col-sm-10">
                                <label class="control-label">
                                    <input type="radio" name="state" value="1" @if($promotion_single->state == 1) checked @endif>
                                    开启
                                </label>
                                <label class="control-label">
                                    <input type="radio" name="state" value="0" @if($promotion_single->state == 0) checked @endif>
                                    关闭
                                </label>
                            </div>
                        </div>
                        <div class="box-footer col-sm-push-2 col-sm-8">
                            <button type="submit" class="btn btn-primary">OK</button>
                        </div>
                    </form>
                </div>
                <div class="col-xs-6">
                    <div class="col-xs-12">
                        <form action="" class="form-horizontal">
                            <div class="form-group">
                                <label class="control-label col-sm-2">关键字</label>
                                <div class="col-xs-10">
                                    <input type="text" id="condition" class="form-control">
                                </div>
                            </div>
                            <div>
                                <label class="control-label col-sm-2">范围</label>
                                <div class="col-xs-10">
                                    <label><input type="radio" name="type" value="0" class="type" checked>按商品</label>
                                    <label><input type="radio" name="type" value="1" class="type">按品牌</label>
                                    <label><input type="radio" name="type" value="2" class="type">按分类</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-push-2 col-xs-10">
                                    <button id="search" class="btn btn-primary col-xs-push-2">搜索</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <table class="table table-bordered table-stripped" id="products" v-cloak>
                        <tr>
                            <th>商品</th>
                            <th>品牌</th>
                            <th>分类</th>
                        </tr>
                        <tr v-for="(product,index) in products" :data-id="product.pid" @click='selected($event)'>
                        <td>@{{ product.name }}</td>
                        <td>@{{ product.brand?product.brand.name:'' }}</td>
                        <td>@{{ product.category?product.category.name:'' }}</td>
                        </tr>
                    </table>
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

            //初始化vue
            var vue = new Vue({
                el: '#products',
                data: {
                    products: []
                },
                methods: {
                    selected: function (event) {
                        $('tr').removeClass('clicked');
                        var dom_tr = $(event.currentTarget)
                        dom_tr.addClass('clicked');
                        $('#pid').val(dom_tr.data('id'));
                    }
                }
            });
            //查询商品
            $('#search').click(function (event) {
                event.preventDefault();

                var condition = $('#condition').val();
                var type = $('.type:checked').val();
                if ($.trim(condition) == '' || !$.isNumeric(type)) {
                    alert('请完善查询条件');
                    return false;
                }
                swal({
                    title: '正在查询...',
                    showConfirmButton: false,
                    imageUrl: '/img/loading.gif'
                });
                //进行ajax商品搜索
                $.ajax({
                    url: "{{ url('admin/product/search_product') }}",
                    type: 'post',
                    dataType: 'json',
                    data: {
                        _token: $('meta[name="_token"]').attr('content'),
                        condition: condition,
                        type: type
                    },
                    success: function (data) {
                        vue.products = data;
                        swal.close();
                    },
                    error: function () {
                        swal({
                            title: '请求出错了...',
                            type: 'warning'
                        })
                    }

                })
            });

            //提交表单
            $('#promotion_single').submit(function () {
                if ($('#pid').val() == "") {
                    swal({
                        title: '没有选择商品...',
                        type: 'warning'
                    });
                    return false;
                }
            })
        });
    </script>
@stop