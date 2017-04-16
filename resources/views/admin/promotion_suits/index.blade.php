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
                            <a class="btn btn-primary" href="{{ route('promotion_suit.create') }}"><i
                                        class="fa fa-plus"></i> 新增</a>
                            <a class="btn btn-info" href=" {{ route('promotion_suit.index') }}"><i
                                        class="fa fa-refresh"></i> 刷新</a>
                        </div>
                    </div>
                    <div class="col-sm-3 pull-right">
                        <div class="input-group">
                            <input type="text" id="name" class="form-control input-sm"
                                   placeholder="促销名">

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
                            <th>
                                <input type="checkbox" id="all">
                            </th>
                            <th>促销名</th>
                            <th>状态</th>
                            <th>开始时间</th>
                            <th>结束时间</th>

                            <th>操作</th>
                        </tr>
                        </thead>
                        @foreach($promotion_suits as $promotion_suit)
                            <tr>
                                <td>
                                    <input type="checkbox" value="{{ $promotion_suit->pm_id }}">
                                </td>

                                <td>{{ $promotion_suit->name }}</td>

                                <td>
                                    @if($promotion_suit->state)
                                        <label class="label label-primary">开启</label>
                                    @else
                                        <label class="label label-default">关闭</label>
                                    @endif
                                </td>
                                <td>
                                    {{ $promotion_suit->start_time}}
                                </td>
                                <td>
                                    {{ $promotion_suit->end_time}}
                                </td>
                                <td>

                                    <a href="{{ route('promotion_suit.edit',['id'=>$promotion_suit->pm_id]) }}"
                                       class="">[编辑] </a>
                                    <a href="javascript:;" class="delete" data-id="{{ $promotion_suit->pm_id }}">[删除] </a>
                                    <a href="{{ route('promotion_suit.products',['pm_id'=>$promotion_suit->pm_id]) }}"
                                       class="">[添加商品] </i> </a>
                                </td>
                            </tr>
                        @endforeach

                    </table>
                    <div class="pull-right">
                        {{$promotion_suits->render()}}
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

        //delete
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
                url: "{{ url('admin/promotion_suit') }}" + "/" + id,
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
                    toastr.error('删除失败');
                }
            });
        });

        // 批量删除
        $('#batch_delete').click(function () {
            swal({
                title: '确认删除?',
                showCancelButton: true,
            }, function (isConfirm) {
                if (isConfirm) {
                    batch_delete();
                }
            });
        });

        // 条件筛选
        $('#search').click(function () {
            var name = $('#name').val();
            if ($.trim(name).length < 1) {
                alert('请输入品牌名');
                return false;
            }
            //http://prettus.local/?search=lorem&searchFields=name:like;email
            self.location = "{{ route('promotion_suit.index') }}" + "?search=" + name + "&searchFields=name:like"
        });

        //批量删除
        function batch_delete() {
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
                url: "{{ route('promotion_suit.batch_delete') }}",
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
                    toastr.error('删除失败');
                }
            });
        }
    </script>
@stop
