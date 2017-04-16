@extends('admin.layouts.layout')
@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <style>
        .btn_picker {
            width: 40px;
            height: 34px;
            float: right;
        }

        .webuploader-pick {
            padding: 5px !important;
        }

        tr img {
            width: 40px;
            height: 40px;
            border: 1px dashed transparent;
        }

        .img_preview {
            width: 100px;
            height: 100px;
            border: 1px solid #c0c0c0;
        }
    </style>
@stop
@section('content')
    <section class="content">
        <div class="row">
            <div class="box box-primary">
                <div class="box-body">
                    @include('admin.layouts.message')
                    <table class="table table-bordered table-stripped">
                        <tr>
                            <th>ID</th>

                            <th>产品名</th>
                            <th>操作</th>
                        </tr>
                        @foreach($product->related_products as $related)
                            <tr>
                                <td>{{$related->pid}}</td>

                                <td>{{$related->name}}</td>
                                <td>
                                    <a href="javascript:;" class="delete_related" data-id="{{$related->pid}}">[取消关联]</a>
                                </td>
                            </tr>
                        @endforeach

                    </table>
                </div>
                <div class="box-footer">
                    <div class="col-sm-12" id="source">
                        <div class="header">
                            所有产品
                        </div>
                        @foreach($products as $product)
                            <div class="col-sm-4">
                                <label>
                                    <input type="checkbox" data-id="{{$product->pid}}">
                                    {{ $product->name }}
                                </label>
                            </div>
                        @endforeach
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
        var pid = {{$pid}};
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
            //禁用已经关联的产品的checkbox 和 自己
            var related = [];
            $('table').find('input').each(function () {
                related.push($(this).data('id'));
            });
            related.push(pid);

            $('#source').find('input').each(function () {
                var state = $.inArray($(this).data('id'), related);
                if (state > -1) {
                    $(this).iCheck('disable');
                }
            });

            //连接跳转进行数据处理
            $('.pagination').find('a').click(function (event) {
                event.preventDefault();
                var selected = [];

                $('#source').find('input:checked').each(function () {
                    selected.push( $(this).data('id'));
                });
                var href = $(this).attr('href');

                if (selected.length > 0) {
                    $.ajax({
                        url: "{{ route('product.store_related',['pid'=> $pid]) }}",
                        dataType: 'json',
                        method: 'post',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            selected: selected
                        },
                        success: function (data) {
                            if (data.error) {
                                toastr.error('关联失败，请重新再试');
                            } else {
                                toastr.success('关联成功');
                                window.location.href = href;
                            }
                        },
                        error: function () {
                            toastr.error('关联失败，请重新再试');
                        }
                    });
                } else {
                    window.location.href = href;
                }

            });
        });

        /**
         * delete
         */
        $('.delete_related').click(function () {
            var _that = this;
            var rst = confirm('确认取消关联？');
            if (!rst) {
                return false;
            }
            var related_pid = $(this).data('id');
            if (!$.isNumeric(related_pid)) {
                return false;
            }
            //console.log(related_pid);
            $.ajax({
                url: "{{ url('admin/product') }}" + "/" + pid + "/related",
                type: 'delete',
                dataType: 'json',
                data: {
                    related_pid: related_pid,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data.error || data.error == 1) {
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
                    toastr.error('删除失败')
                }
            });
        });
    </script>
@stop
