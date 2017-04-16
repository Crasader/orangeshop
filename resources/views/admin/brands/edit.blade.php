@extends('admin.layouts.layout')
@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/webuploader/dist/webuploader.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/toastr/toastr.min.css')}}">
@stop
@section('content')
    <section class="content">
        <div class="row">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">编辑品牌</h3>
                    <a href="{{ route('brand.index') }}" class="btn btn-default pull-right">
                        <i class="fa fa-list"></i> 列表
                    </a>
                </div>
                <div class="box-body">
                    @include('admin.layouts.message')
                    <form class="form-horizontal" action="{{ route('brand.update',['id'=>$brand->brand_id]) }}"
                          method="post">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        <div class="form-group">
                            <label class="col-sm-2 control-label">ID</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" disabled
                                       value="{{ $brand->brand_id }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">品牌名</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="品牌名"
                                       name="name" value="{{ $brand->name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">logo</label>

                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <img src="{{ $brand->logo_path }}" alt="" class="img-lg img-"
                                                 id="img_holder">
                                        </div>
                                        <div class="progress" style="height: 2px">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="60"
                                                 aria-valuemin="0" aria-valuemax="100" style="width: 0;">
                                            </div>
                                        </div>
                                        <div id="btn_picker">选择图片</div>
                                        <input type="hidden" name="logo_path" value="{{ $brand->logo_path  }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">分类</label>

                            <div class="col-sm-8">
                                @foreach($cates as $cate)
                                    <label class="col-sm-3">
                                        <input type="checkbox" class="form-control" placeholder="排序"
                                               name="cates[]" value="{{ $cate->cate_id }}"
                                        @if(in_array($cate->cate_id,$related_cates) ) checked @endif
                                        >{{ $cate->name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">排序</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="排序"
                                       name="order" value="{{ $brand->order }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">描述</label>

                            <div class="col-sm-8">
                                        <textarea name="description" rows="5"
                                                  class="form-control">{{ $brand->description }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">状态</label>
                            <div class="col-sm-8">
                                <label class="control-label">
                                    <input type="radio" name="state" value="1"
                                           @if($brand->state == 1) checked @endif> 开启
                                </label>
                                <label class="control-label">
                                    <input type="radio" name="state" value="0"
                                           @if($brand->state == 0) checked @endif> 关闭
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit">提交</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
@stop

@section('script')
    <!-- jQuery Validation plugin javascript-->
    <script src="{{ asset('admin/js/plugins/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/validate/messages_zh.min.js') }}"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <!-- Web Uploader -->
    <script src="{{ asset('plugins/webuploader/dist/webuploader.js') }}"></script>

    <script>
        // 添加全局站点信息
        var BASE_URL = 'plugins/webuploader/dist';
        var SERVER = "{{ route('upload_image') }}";


        //获取图片对象
        var $img = $('#img_holder');

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

        //监听添加文件到队列
        uploader.on('fileQueued', function (file) {
            $('.progress-bar').css('width', 0);
            // 创建缩略图
            // 如果为非图片文件，可以不用调用此方法。
            // thumbnailWidth x thumbnailHeight 为 100 x 100
            uploader.makeThumb(file, function (error, src) {
                if (error) {
                    $img.replaceWith('<span>不能预览</span>');
                    return;
                }

                $img.attr('src', src);
            }, 200, 100);
        });
        // 文件上传过程中创建进度条实时显示。
        uploader.on('uploadProgress', function (file, percentage) {
            $('.progress-bar').css('width', percentage * 100 + '%');
        });

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on('uploadSuccess', function (file, data) {
            console.log(data);
            console.log(data.src);
            if (data.error == 0) {
                $("input[name='logo_path']").val(data.src);
                toastr.success('上传成功');
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