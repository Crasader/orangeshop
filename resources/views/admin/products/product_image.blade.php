@extends('admin.layouts.layout')
@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/webuploader/css/webuploader.css')}}">
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
                <div class="box-header">
                    <h3 class="box-title">商品图片</h3>
                    <a href="{{ route('product.index') }}" class="btn btn-default pull-right">
                        <i class="fa fa-list"></i> 列表
                    </a>
                </div>
                <div class="box-body">
                    @include('admin.layouts.message')
                    <div class="col-sm-4">
                        <form action="{{ route('product.store_image',['pid'=>$product->pid]) }}" class="form-horizontal"
                              method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-sm-4 control-label">上传</label>

                                <div class="col-sm-8">
                                    <img src="" alt="" class="img_preview">
                                    <div id="btn_picker">选择图片</div>
                                    <div class="progress" style="height: 2px">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="60"
                                             aria-valuemin="0" aria-valuemax="100" style="width: 0;">
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" name="path" id="path">
                                </div>
                            </div>
                            <div class="form-group">

                                <label class="col-sm-4 control-label">排序</label>

                                <div class="col-sm-8">
                                    <input type="number" class="form-control" placeholder="排序"
                                           name="order" value="0">
                                </div>
                            </div>
                            <div class="form-group">

                                <label class="col-sm-4 control-label">主图</label>

                                <div class="col-sm-8">
                                    <label><input type="radio" name="is_main" value="1">是</label>
                                    <label><input type="radio" name="is_main" value="0" checked>否</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-push-4 col-sm-8">
                                    <button type="submit" class="btn btn-primary">确定</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-8">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>排序</th>
                                <th>编号</th>
                                <th>图片</th>
                                <th>主图?</th>
                                <th>操作</th>
                            </tr>
                            @foreach($product->images as $image)
                                <tr>
                                    <td><input type="number" class="order" value="{{ $image->order }}"
                                               style="width: 60px" data-id="{{ $image->img_id }}"></td>
                                    <td>{{ $image->img_id }}</td>
                                    <td><img src="{{ $image->path }}" alt=""></td>
                                    <td>
                                        @if($image->is_main == 1)
                                            <label class="label label-primary">是</label>
                                        @else
                                            <label class="label label-default">否</label>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="javascript:;" data-id="{{ $image->img_id }}" class="delete">[删除]</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </section>
@stop

@section('script')
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <!-- Web Uploader -->
    <script src="{{ asset('plugins/webuploader/dist/webuploader.js') }}"></script>
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
                url: "{{ url('admin/product') }}" + "/" + id + "/image",
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
        $('.order').change(function () {

            var id = $(this).data('id');
            console.log(id);
            var order = $(this).val();
            if (!id || !$.isNumeric(id) || !$.isNumeric(order)) {

                return false;
            }

            var url = "{{ url('admin/product') }}" + "/" + id + "/image";
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

        // webuploader添加全局站点信息
        var BASE_URL = 'plugins/webuploader/dist';
        var SERVER = "{{ route('upload_image') }}";
        var uploader = new WebUploader.Uploader({
            //禁止添加即上传
            auto: true,
            swf: BASE_URL + '/Uploader.swf',
            server: SERVER,
            pick: '#btn_picker',
            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
            // 其他配置项
        });
        var img_preview = $('.img_preview');
        //监听添加文件到队列
        uploader.on('fileQueued', function (file) {
            $('.progress-bar').css('width', 0);
            // 创建缩略图
            // 如果为非图片文件，可以不用调用此方法。
            // thumbnailWidth x thumbnailHeight 为 100 x 100
            uploader.makeThumb(file, function (error, src) {
                if (error) {
                    img_preview.replaceWith('<span>不能预览</span>');
                    return;
                }

                img_preview.attr('src', src);
            }, 200, 100);
        });
        // 文件上传过程中创建进度条实时显示。
        uploader.on('uploadProgress', function (file, percentage) {
            $('.progress-bar').css('width', percentage * 100 + '%');
        });

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on('uploadSuccess', function (file, data) {
            //console.log(data);
            console.log(data.src);
            if (data.error == 0) {
                $('#path').val(data.src);
                toastr.success('上传成功');
                //取消选中状态
                $('img').removeClass('img_selected');
            } else {
                img.attr('src', '');
                toastr.error('上传失败');
            }
        });

        // 文件上传失败，显示上传出错。
        uploader.on('uploadError', function (file) {
            toastr.error('上传失败');
        });

        // 完成上传完了，成功或者失败，先删除进度条。
        uploader.on('uploadComplete', function (file) {

        });
    </script>
@stop
