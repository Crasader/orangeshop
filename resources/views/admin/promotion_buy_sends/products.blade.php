@extends('admin.layouts.layout')
@section('head')
    <meta name="_token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <style>
        [v-cloak] {
            display: none;
        }

    </style>
@stop
@section('content')
    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">新增买赠产品</h3>
                <a href="{{ route('promotion_buy_send.index') }}" class="btn btn-default pull-right">
                    <i class="fa fa-list"></i> 列表
                </a>
            </div>
            <div class="box-body" id="products">
                <div class="col-xs-12">
                    @include('admin.layouts.message')
                    <form action="" class="form-inline">
                        <div class="form-group">
                            <label class="control-label">关键字</label>
                                <input type="text" id="condition" class="form-control">
                        </div>
                        <div class="form-group">
                                <label><input type="radio" name="type" value="0" class="type" checked>按商品</label>
                                <label><input type="radio" name="type" value="1" class="type">按品牌</label>
                                <label><input type="radio" name="type" value="2" class="type">按分类</label>
                        </div>
                        <button id="search" class="btn btn-primary col-xs-push-2">搜索</button>
                    </form>
                </div>
                {{--显示区--}}
                <div class="col-xs-6">
                    <table class="table table-bordered table-stripped" v-cloak>
                        <caption>已添加商品</caption>
                        <tr>
                            <th>ID</th>
                            <th>商品</th>
                            <th>价格</th>
                            <th>操作</th>
                        </tr>
                        <tr v-for="(product,index) in products_table">
                            <td>@{{ product.pid }}</td>
                            <td>@{{ product.name }}</td>
                            <td>@{{ product.shop_price }}</td>
                            <td>
                                <button class="btn btn-xs btn-danger" @click='remove_product(index,$event)' :data-pid="
                                product.pid" data-pm_id = {{ $promotion_buy_send->pm_id }}>
                                <i class="fa fa-minus"> 移除</i>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                {{--添加区--}}
                <div class="col-xs-6">
                    <table class="table table-bordered table-stripped" v-cloak=>
                        <caption>未添加商品</caption>
                        <tr>
                            <th>商品</th>
                            <th>操作</th>

                        </tr>
                        <tr v-for="(product,index) in products">
                            <td>@{{ product.name }}</td>
                            <td>
                                <button class="btn btn-warning  btn-xs" @click="add_product(index,$event)" data-pm_id=
                                "{{ $promotion_buy_send->pm_id }}" :data-pid="product.pid">
                                <i class="fa fa-plus"> 添加</i>
                                </button>
                            </td>
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
    <script src="{{ asset('js/vue.js') }}"></script>

    <script>
        $(function () {

            //初始化vue
            var vue = new Vue({
                el: '#products',
                data: {
                    products: [],
                    products_table: {!! $promotion_buy_send->products !!}
                },
                methods: {
                    add_product: function (index, event) {
                        console.log(11);
                        //禁用btn
                        var btn = $(event.currentTarget);
                        var pm_id = btn.data('pm_id');
                        var pid = btn.data('pid');
                        var self = this;
                        //添加商品
                        $.ajax({
                            url: '/admin/promotion_buy_send/' + pm_id + '/add_product',
                            type: 'post',
                            dataType: 'json',
                            data: {
                                _token: $('meta[name="_token"]').attr('content'),
                                pid: pid
                            },
                            success: function (data) {
                                if (data.error == 0) {
                                    toastr.success('添加成功');
                                    //数据添加到 table中
                                    self.products_table.push(self.products[index]);
                                    btn.remove();
                                } else {
                                    toastr.error(data.message);
                                }
                            },
                            error: function () {
                                toastr.error('添加失败');
                            }
                        })

                    },
                    remove_product: function (index, event) {
                        var btn_delete = $(event.currentTarget);
                        var pm_id = btn_delete.data('pm_id');
                        var pid = btn_delete.data('pid');
                        var self = this;
                        //发送ajax进行移除商品
                        $.ajax({
                            url: '/admin/promotion_buy_send/' + pm_id + '/remove_product',
                            type: 'delete',
                            dataType: 'json',
                            data: {
                                _token: $('meta[name="_token"]').attr('content'),
                                pid: pid
                            },
                            success: function (data) {
                                if (data.error == 0) {
                                    toastr.success('移除成功');
                                    //数据移除 table
                                    self.products_table.splice(index, 1);
                                } else {
                                    toastr.error(data.message);
                                }
                            },
                            error: function () {
                                toastr.error('移除失败');
                            }
                        });

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
            $('#promotion_buy_send').submit(function () {
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