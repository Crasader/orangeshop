@extends('admin.layouts.layout')

@section('head')
    <meta name="_token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/webuploader/css/webuploader.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/toastr/toastr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('AdminLTE/plugins/colorpicker/bootstrap-colorpicker.css')}}">
    <style>
        .btn_picker {
            width: 40px;
            height: 34px;
            float: right;
        }

        .webuploader-pick {
            padding: 5px !important;
        }

        img {
            width: 34px;
            height: 34px;
            border: 1px dashed transparent;
        }

        .img_selected {
            border: 1px dashed red;
        }

        .colorpicker {
            margin-top: 0;
            padding: 0;
        }
    </style>
@stop
@section('content')
    <section class="content">
        <div class="row">
            <div class="box with-border">
                <div class="box-header">
                    <h3 class="box-title">编辑属性</h3>
                    <a href="{{ route('attribute.index') }}" class="btn btn-default pull-right">
                        <i class="fa fa-list"></i> 列表
                    </a>
                </div>
                <div class="box-body">
                    @include('admin.layouts.message')
                    <form class="form-horizontal"
                          action="{{ route('attribute.update',['id'=>$attribute->attr_id]) }}"
                          method="post">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        <div class="form-group">
                            <label class="col-lg-2 control-label">ID</label>

                            <div class="col-lg-8">
                                <input type="text" class="form-control" disabled
                                       value="{{ $attribute->attr_id }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">属性名</label>

                            <div class="col-lg-8">
                                <input type="text" class="form-control" placeholder="品牌名"
                                       name="name" value="{{ $attribute->name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">显示方式</label>

                            <div class="col-lg-8">
                                <label class="control-label"><input class="form-control" type="radio"
                                                                    name="show_type"
                                                                    value="0"
                                                                    @if($attribute->show_type == 0)checked @endif>
                                    文本 </label>
                                <label><input class="form-control " type="radio" name="show_type"
                                              value="1" @if($attribute->show_type == 1)checked @endif> css块
                                </label>
                                <label><input class="form-control " type="radio" name="show_type"
                                              value="2" @if($attribute->show_type == 2)checked @endif> 图片
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">属性值</label>

                            <div class="col-lg-8" id="div_show_type">
                                <table class="table table-bordered" id="table">
                                    <tr>
                                        <th>排序</th>
                                        <th>文本值</th>
                                        <th style="width: 100px">css块值</th>
                                        <th>img值</th>
                                        <th style="width: 70px">操 作</th>
                                    </tr>
                                    <template>
                                        <tr v-for="(value, index) in values">
                                            <td>
                                                <input type="number" :value="value.order"
                                                       class="form-control" style="width: 80px">
                                            </td>
                                            <td>
                                                <input type="text" :value="value.attr_value_0" style="width: 100px"
                                                       class="form-control">
                                            </td>
                                            <td>
                                                <div class="input-group colorpicker">
                                                    <span class="input-group-addon">
                                                        <i></i>
                                                    </span>
                                                    <input type="text" :value="value.attr_value_1" class="form-control">
                                                </div>
                                            </td>
                                            <td style="width: 100px">
                                                <img :src="value.attr_value_2" style="width: 34px;height: 34px">

                                                <input type="hidden" :value="value.attr_value_2">

                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-xs">
                                                    <button type="button" class="btn btn-danger btn-xs"  @click="deleteValue(index,$event)"
                                                    :data-id="value.attr_value_id" >
                                                        <i class="fa  fa-close"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-primary btn-xs"  @click="updateValue(index,$event)"
                                                    :data-id="value.attr_value_id">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </div>

                                            </td>
                                        </tr>
                                        {{--新增--}}
                                        <tr id="new_value">
                                            <td>
                                                <input type="number" class="form-control" style="width: 80px">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control">
                                            </td>
                                            <td>
                                                <div class="input-group colorpicker">
                                                    <span class="input-group-addon">
                                                        <i></i>
                                                    </span>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </td>
                                            <td>
                                                <img src="">
                                                <input type="hidden">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm"><i
                                                            class="fa fa-plus" @click='addValue'></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <div id="btn_picker">选择图片</div>
                                                <div class="progress" style="height: 2px">
                                                    <div class="progress-bar" role="progressbar" aria-valuenow="60"
                                                         aria-valuemin="0" aria-valuemax="100" style="width: 0;">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                </table>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">筛选？</label>

                            <div class="col-lg-8">
                                <label class="control-label"><input class="form-control " type="radio"
                                                                    name="is_filter"
                                                                    value="1"
                                                                    @if($attribute->is_filter == 1)checked @endif>是</label>
                                <label><input class="form-control " type="radio" name="is_filter"
                                              value="0"
                                              @if($attribute->is_filter == 0)checked @endif>否</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">排序</label>

                            <div class="col-lg-8">
                                <input type="text" class="form-control" placeholder="排序"
                                       name="order" value="{{ $attribute->order }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">创建时间</label>

                            <div class="col-lg-8">
                                <input type="text" class="form-control" disabled placeholder="排序"
                                       name="order" value="{{ $attribute->created_at }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">更新时间</label>

                            <div class="col-lg-8">
                                <input type="text" class="form-control" disabled placeholder="排序"
                                       name="order" value="{{ $attribute->updated_at }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-4 col-lg-offset-2">
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
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <!-- Web Uploader -->
    <script src="{{ asset('plugins/webuploader/dist/webuploader.js') }}"></script>
    <!-- COLORPICKER -->
    <script src="{{ asset('AdminLTE/plugins/colorpicker/bootstrap-colorpicker.js')}}"></script>
    <script src="{{ asset('js/vue.js') }}"></script>
    <script>
        var vue;
        $(document).ready(function () {

            // webuploader添加全局站点信息
            var BASE_URL = 'plugins/webuploader/dist';
            var SERVER = "{{ route('upload_image') }}";

            vue = new Vue({
                el: '#table',
                data: {
                    values: {!! $attribute->attribute_values()->orderBy('order')->get(['attr_value_id','order','attr_value_0','attr_value_1','attr_value_2',])->toJson() !!},
                },
                methods: {
                    deleteValue: function (index, event) {
                        var _that = this;
                        var dom = $(event.currentTarget);

                        var attr_value_id = dom.data('id');

                        dom.find('li').removeClass('fa-close').addClass('fa-spinner');
                        $.ajax({
                            url: "/admin/attribute_value/" + attr_value_id,
                            type: 'delete',
                            dataType: 'json',
                            data: {
                                _token: $('meta[name="_token"]').attr('content')
                            },

                            success: function (data) {
                                if (data.error) {
                                    var error = '新增属性值失败!<br>';
                                    for (msg in data.message) {
                                        error += data.message[msg].join(',') + '<br>';
                                    }
                                    toastr.error(error);
                                    dom.find('li').removeClass('fa-spinner').addClass('fa-close');
                                } else {
                                    //删除数据中的指定元素
                                    _that.values.splice(index, 1);
                                    toastr.success(data.message);
                                }
                            },
                            error: function () {
                                dom.find('li').removeClass('fa-spinner').addClass('fa-close');
                                toastr.error('删除失败');
                            }
                        })
                    },
                    //更新
                    updateValue: function (index, event) {
                        var dom = $(event.currentTarget);
                        var dom_tr = dom.parents('tr').eq(0);
                        var order = $.trim(dom_tr.find('input').eq(0).val());
                        var attr_value_0 = $.trim(dom_tr.find('input').eq(1).val());
                        var attr_value_1 = $.trim(dom_tr.find('input').eq(2).val());
                        var attr_value_2 = $.trim(dom_tr.find('input').eq(3).val());
                        if (!$.isNumeric(order)) {
                            order = 0;
                        }
                        if (attr_value_0.length < 1 && attr_value_1.length < 1 && attr_value_2.length < 1) {
                            alert('属性值不能全是空');
                            return false;
                        }
                        $.ajax({
                            url: "/admin/attribute_value/" + dom.data('id'),
                            type: 'put',
                            dataType: 'json',
                            data: {
                                order: order,
                                attr_id:"{{ $attribute->attr_id }}",
                                attr_value_0: attr_value_0,
                                attr_value_1: attr_value_1,
                                attr_value_2: attr_value_2,
                                _token: $('meta[name="_token"]').attr('content')
                            },

                            success: function (data) {
                                if (data.error) {
                                    var error = '新增属性值失败!<br>';
                                    for (msg in data.message) {
                                        error += data.message[msg].join(',') + '<br>';
                                    }
                                    toastr.error(error);
                                } else {
                                    toastr.success(data.message);
                                }
                            },
                            error: function () {
                                toastr.error('更新失败');
                            }
                        })
                    },
                    //新增
                    addValue: function (event) {
                        var _that = this;
                        var doms = $('#new_value').find('input');
                        var btn_i = $('#new_value').find('i');
                        btn_i.removeClass('fa-plus').addClass('fa-spinner');
                        var order = $.isNumeric(doms.eq(0).val()) ? doms.eq(0).val() : 0;
                        var attr_value_0 = doms.eq(1).val().trim();
                        var attr_value_1 = doms.eq(2).val().trim();
                        var attr_value_2 = doms.eq(3).val().trim();
                        if (attr_value_0.length < 1 && attr_value_1.length < 1 && attr_value_2.length < 1) {
                            alert('属性值不能全是空');
                            return false;
                        }
                        $.ajax({
                            url: "/admin/attribute_value",
                            type: 'post',
                            dataType: 'json',
                            data: {
                                attr_id: "{{ $attribute->attr_id }}",
                                order: order,
                                attr_value_0: attr_value_0,
                                attr_value_1: attr_value_1,
                                attr_value_2: attr_value_2,
                                _token: $('meta[name="_token"]').attr('content')
                            },

                            success: function (data) {
                                if (data.error) {
                                    var error = '新增属性值失败!<br>';
                                    for (msg in data.message) {
                                        error += data.message[msg].join(',') + '<br>';
                                    }
                                    toastr.error(error);
                                } else {
                                    toastr.success(data.message);
                                    var value = {
                                        attr_value_id:data.data.attr_value_id,
                                        order: order,
                                        attr_value_0: attr_value_0,
                                        attr_value_1: attr_value_1,
                                        attr_value_2: attr_value_2
                                    };
                                    vue.values.push(value);
                                    //拾色器
                                    $('#new_value').find('input').val('');
                                }
                                btn_i.removeClass('fa-spinner').addClass('fa-plus');
                            },
                            error: function () {
                                toastr.error('新增失败');
                                btn_i.removeClass('fa-spinner').addClass('fa-plus');
                            }
                        })
                    }

                },
                mounted: function () {
                    //当挂在的时候初始化 颜色选择器
                    $(".colorpicker").colorpicker();
                },
                updated: function () {
                    //当更新时候初始化 颜色选择器
                    $(".colorpicker").colorpicker();
                }
            });

            //图片选择
            $('img').click(function () {
                $('img').removeClass('img_selected');
                $(this).addClass('img_selected');
            });

            $('#btn_picker').click(function (event) {
                if ($('.img_selected').length < 1) {
                    alert('请激活要修改的图片');
                    //event.preventDefault();
                    return false;
                }
            });
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
                var img_selected = $('.img_selected');
                if (img_selected.length < 1) {
                    alert('请激活要更改的图片');
                    uploader.removeFile(file);
                    return false;
                }
                $('.progress-bar').css('width', 0);
                // 创建缩略图
                // 如果为非图片文件，可以不用调用此方法。
                // thumbnailWidth x thumbnailHeight 为 100 x 100
                uploader.makeThumb(file, function (error, src) {
                    if (error) {
                        img_selected.replaceWith('<span>不能预览</span>');
                        return;
                    }

                    img_selected.attr('src', src);
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
                    var img_selected = $('.img_selected');
                    var img_input = img_selected.siblings('input');
                    img_input.val(data.src);
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

        });
    </script>
@stop
