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
                            {{--  <a class="btn btn-danger" href="javascript:;" id="batch_delete"><i
                                          class="fa fa-trash"></i>
                                  删除</a>--}}
                            <a class="btn btn-primary" href="{{ route('category.create') }}"><i
                                        class="fa fa-plus"></i> 新增</a>
                            <a class="btn btn-info" href=" {{ route('category.index') }}"><i
                                        class="fa fa-refresh"></i> 刷新</a>
                        </div>
                    </div>
                    <div class="col-sm-3 pull-right">
                        <div class="input-group">
                            <input type="text" id="name" class="form-control input-sm"
                                   placeholder="品牌名">

                            <span class="input-group-btn">
                                        <a href="javascript:;" type="button" class="btn btn-sm btn-primary" id="search"> 搜索</a>
                                    </span>
                        </div>
                    </div>
                </div>

                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            {{-- <th>
                                 <input type="checkbox" id="all">
                             </th>--}}
                            <th>排序</th>
                            <th>分类名</th>
                            <th>价格区间</th>
                            <th>显示?</th>
                            <th>导航?</th>
                            <th>状态</th>
                            <th>创建时间</th>
                            <th>更新时间</th>

                            <th>操作</th>
                        </tr>
                        </thead>
                        @foreach($categories as $category)
                            <tr>
                                {{-- <td>
                                     <input type="checkbox" value="{{ $category['cate_id'] }}">
                                 </td>--}}
                                <td>
                                    <input type="number" class="text-center" value="{{ $category['order'] }}"
                                           data-id="{{ $category['cate_id'] }}"
                                           style="width: 50px">
                                </td>
                                <td>{{ $category['name'] }}</td>
                                <td>{{ $category['price_range'] }}</td>
                                <td>
                                    @if($category['is_show'] == 1)
                                        <label class="label label-primary">是</label>
                                    @else
                                        <label class="label label-warning">否</label>
                                    @endif
                                </td>
                                <td>
                                    @if($category['is_nav'] == 1)
                                        <label class="label label-primary">是</label>
                                    @else
                                        <label class="label label-warning">否</label>
                                    @endif
                                </td>
                                <td>
                                    @if($category['state'] == 1)
                                        <label class="label label-primary">开启</label>
                                    @else
                                        <label class="label label-warning">关闭</label>
                                    @endif
                                </td>

                                <td>{{ $category['created_at']}}</td>
                                <td>{{ $category['updated_at']}}</td>
                                <td>
                                    <a href="{{ route('category.edit',['id'=>$category['cate_id']]) }}" class=""><i
                                                class="fa fa-edit"></i> </a>
                                    <a href="javascript:;" class="delete" data-id="{{ $category['cate_id'] }}"><i
                                                class="fa fa-trash"></i> </a>
                                </td>
                            </tr>
                        @endforeach

                    </table>
                    <div class="pull-right">
                        {{$categories->render()}}
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
            var rst = confirm('子分类会被同时删除，确认删除？');
            if (!rst) {
                return false;
            }
            var id = $(this).data('id');
            if (!$.isNumeric(id)) {
                return false;
            }
            $.ajax({
                url: "{{ url('admin/category') }}" + "/" + id,
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
                        //如果是删除没有子节点的，那么返回的数组就是一个元素，直接删除tr
                        // 否则就查找含有被删除cate_id的tr，删除
                        if (data.deleted.length == 1) {
                            $(_that).parents('tr:eq(0)').remove();
                        } else {
                            var tr_delete = $('tr').filter(function () {
                                return $.inArray($(this).find('input[type="number"]').data('id'), data.deleted) > -1
                            });
                            tr_delete.remove();
                        }

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
            var url = "{{ url('admin/category') }}" + "/" + id;
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
                url: "{{ route('category.batch_delete') }}",
                type: 'delete',
                data: {
                    ids: ids,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },

                success: function (data) {
                    if (data.state == 1) {
                        arr_doms.parents('tr').remove();
                        toastr.success(data.message);
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function () {

                }
            });
        });

        /**
         * 条件筛选
         */
        $('#search').click(function () {
            var name = $('#name').val();
            if ($.trim(name).length < 1) {
                alert('请输入分类名');
                return false;
            }
            //http://prettus.local/?search=lorem&searchFields=name:like;email
            self.location = "{{ route('category.index') }}" + "?search=" + name + "&searchFields=name:like"
        });
    </script>
@stop
