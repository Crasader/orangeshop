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
                            <a class="btn btn-danger" href="javascript:;" id="batch_delete"><i
                                        class="fa fa-trash"></i>
                                删除</a>
                            <a class="btn btn-primary" href="{{ route('attribute.create') }}"><i
                                        class="fa fa-plus"></i> 新增</a>
                            <a class="btn btn-info" href=" {{ route('attribute.index') }}"><i
                                        class="fa fa-refresh"></i> 刷新</a>
                        </div>
                    </div>
                    <div class="col-sm-3 pull-right">
                        <div class="input-group">
                            <input type="text" id="name" class="form-control input-sm"
                                   placeholder="属性名">

                            <span class="input-group-btn">
                                        <a href="javascript:;" type="button" class="btn btn-sm btn-primary" id="search"> 搜索</a>
                                    </span>
                        </div>
                    </div>
                </div>

                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>
                                <input type="checkbox" id="all" class="i-checks">
                            </th>

                            <th>排序</th>
                            <th>属性名</th>
                            <th>状态</th>
                            <th>显示方式</th>
                            <th>文本属性值</th>
                            <th>css属性值</th>
                            <th>图片属性值</th>
                            <th>筛选？</th>
                            <th>创建时间</th>
                            <th>更新时间</th>
                            <th>操作</th>
                        </tr>
                        @foreach($attributes as $attribute)
                            <tr>
                                <td>
                                    <input type="checkbox" value="{{ $attribute->attr_id }}">
                                </td>

                                <td>
                                    <input type="number" class="text-center" value="{{ $attribute->order }}"
                                           data-id="{{ $attribute->attr_id }}"
                                           style="width: 50px">
                                </td>
                                <td>{{ $attribute->name }}</td>
                                <td>
                                    @if($attribute->state == 1)
                                        <label class="label label-primary">开启</label>
                                    @else
                                        <label class="label label-warning">关闭</label>
                                    @endif
                                </td>

                                <td>
                                    <label class="label label-info">{{ $attribute->show_type ==2? '图片':($attribute->show_type == 1? 'css块':'文本')}}</label>
                                </td>
                                <td>
                                    @foreach($attribute->attribute_values as $attr_value)
                                        @if($attr_value->attr_value_0)
                                            <label class="label label-primary">{{ $attr_value->attr_value_0 }}</label>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($attribute->attribute_values as $attr_value)
                                        @if($attr_value->attr_value_1)
                                            <span style="display:inline-block;background-color: {{ $attr_value->attr_value_1 }};width: 20px;height: 20px"></span>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($attribute->attribute_values as $attr_value)
                                        @if($attr_value->attr_value_2)
                                            <img src="{{ $attr_value->attr_value_2 }}"
                                                 style="width: 20px;height: 20px;margin: 2px">
                                        @endif
                                    @endforeach
                                </td>

                                <td>
                                    @if($attribute->is_filter == 1)
                                        <label class="label label-primary">是</label>
                                    @else
                                        <label class="label label-warning">否</label>
                                    @endif
                                </td>
                                <td>
                                    {{ $attribute->created_at }}
                                </td>
                                <td>
                                    {{ $attribute->updated_at }}
                                </td>
                                <td>
                                    <a href="{{ route('attribute.edit',['id'=>$attribute->attr_id]) }}"
                                       class=""><i
                                                class="fa fa-edit"></i> </a>
                                    <a href="javascript:;" class="delete" data-id="{{ $attribute->attr_id }}"><i
                                                class="fa fa-trash"></i> </a>
                                </td>
                            </tr>
                        @endforeach

                    </table>
                    <div class="pull-right">
                        {{$attributes->render()}}
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
                url: "{{ url('admin/attribute') }}" + "/" + id,
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
            // console.log(id + '-' + order);
            if (!id || !$.isNumeric(id) || !$.isNumeric(order)) {
                return false;
            }
            var url = "{{ url('admin/attribute') }}" + "/" + id;
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
         * 批量删除
         */
        $('#batch_delete').click(function () {
            $rst = confirm('确认删除?');
            if (!$rst) {
                return false;
            }
            //获取id
            var arr_doms = $('input[type="checkbox"]:checked').filter(function () {
                return $.isNumeric($(this).val());
            });
            if (arr_doms.length < 1) {
                return false;
            }

            var ids = [];
            for (var i = 0; i < arr_doms.length; i++) {
                ids.push(arr_doms.eq(i).val());
            }

            //发送请求
            $.ajax({
                url: "{{ route('attribute.batch_delete') }}",
                type: 'delete',
                data: {
                    ids: ids,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },

                success: function (data) {
                    console.log(data);
                    if (data.state == 1) {
                        //删除成功，提示并删除tr
                        toastr.success(data.message);
                        arr_doms.parents('tr').remove();
                    } else {
                        toastr.error(data.message);
                    }

                },
                error: function () {

                }
            });
        });

        /**
         * 搜索
         */
        $('#search').click(function () {
            var filter = $('#name').val();
            if (filter.trim().length < 1) {
                return false;
            }
            window.location.href = "{{ url('admin/attribute') }}" + "?name=" + filter + "&searchFields=name:like";
        });
    </script>
@stop
