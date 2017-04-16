@extends('admin.layouts.layout')
@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@stop
@section('content')
    <section class="content">
        <div class="row">
            <div class="box box-primary">
                <div class="box-header with-border ">
                    <div class="col-sm-5">
                        <div class="btn-group btn-group-sm">
                            <a class="btn btn-primary" href="{{ route('product.create') }}"><i
                                        class="fa fa-plus"></i> 新增</a>
                            <a class="btn btn-info" href=" {{ route('product.index') }}"><i
                                        class="fa fa-refresh"></i> 刷新</a>
                        </div>
                    </div>
                    <div class="col-sm-3 pull-right">
                        <div class="input-group">
                            <input type="text" id="name" class="form-control input-sm"
                                   placeholder="产品名">

                            <span class="input-group-btn">
                                        <a href="javascript:;" type="button" class="btn btn-sm btn-primary" id="search"> 搜索</a>
                                    </span>
                        </div>
                    </div>
                </div>

                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>

                            <th>排序</th>
                            <th>产品名</th>
                            <th>状态</th>
                            <th>库存</th>
                            <th>库存预警</th>
                            <th>销量</th>
                            <th>访问量</th>
                            <th>创建时间</th>
                            <th>更新时间</th>
                            <th>操作</th>
                        </tr>
                        @foreach($products as $product)
                            <tr>

                                <td>
                                    <input type="number" class="text-center" value="{{ $product->order }}"
                                           data-id="{{ $product->pid }}"
                                           style="width: 50px">
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>
                                    @if($product->state == 1)
                                        <label class="label label-primary">开启</label>
                                    @else
                                        <label class="label label-warning">关闭</label>
                                    @endif
                                </td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->stock_limit }}</td>
                                <td>{{ $product->sale_count }}</td>
                                <td>{{ $product->visit_count }}</td>


                                <td>
                                    {{ $product->created_at }}
                                </td>
                                <td>
                                    {{ $product->updated_at }}
                                </td>
                                <td>
                                    <a href="{{ route('product.show_image',['id'=>$product->pid]) }}"
                                       class="">[图片] </a>
                                    <a href="{{ route('product.show_related',['id'=>$product->pid]) }}"
                                       class="">[关联]</a>
                                    <a href="{{ route('product.edit',['id'=>$product->pid]) }}"
                                       class=""><i
                                                class="fa fa-edit"></i> </a>
                                    <a href="javascript:;" class="delete" data-id="{{ $product->pid }}"><i
                                                class="fa fa-trash"></i> </a>
                                </td>
                            </tr>
                        @endforeach

                    </table>
                    <div class="pull-right">
                        {{$products->render()}}
                    </div>
                </div>

            </div>
        </div>
    </section>
@stop

@section('script')
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script>
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
        /**
         * 全选
         */
        $('#all').on('ifChecked', function (event) {
            $('td').find('input[type="checkbox"]').iCheck('check');
        });
        //全不选
        $('#all').on('ifUnchecked', function (event) {
            $('td').find('input[type="checkbox"]').iCheck('uncheck');
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
                url: "{{ url('admin/product') }}" + "/" + id,
                type: 'delete',
                dataType: 'json',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data.error) {
                        var error = '删除失败!<br>';
                        for (msg in data.message) {
                            error += data.message[msg].join(',') + '<br>';
                        }
                        toastr.error(error);
                    } else {
                        //如果成功,提醒并删除
                        toastr.success(data.message);
                        $(_that).parents('tr:eq(0)').remove();
                    }
                },
                error: function () {

                }
            });
        });
        /**
         * ajax update order
         */
        $('input[type="number"]').change(function () {
            var id = $(this).data('id');
            var order = $(this).val();
            if (!id || !$.isNumeric(id) || !$.isNumeric(order)) {

                return false;
            }

            var url = "{{ url('admin/product') }}" + "/" + id;
            $.ajax({
                url: url,
                type: 'PUT',
                data: {
                    order: order,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }
                ,
                dataType: 'json',
                success: function (data) {
                    if (data.error) {
                        for (msg in data.message) {
                            toastr.error(data.message[msg]);
                        }
                    } else {
                        toastr.success(data.message);
                    }
                }
                ,
                error: function () {

                }
            })
        });

        /**
         * 搜索
         */
        $('#search').click(function () {
            var filter = $('#name').val();
            if (filter.trim().length < 1) {
                return false;
            }
            window.location.href = "{{ url('admin/product') }}" + "?name=" + filter + "&searchFields=name:like";
        });
    </script>
@stop
