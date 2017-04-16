@extends('admin.layouts.layout')
@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('plugins/wangEditor/dist/css/wangEditor.min.css') }}">
    <style>
        .add-money {
            width: 50px;
            margin-right: 10px;
        }

        .attr_values {
            padding-left: 40px;
            margin-bottom: 10px;
            border-bottom: 1px dashed #c0c0c0
        }
    </style>
@stop
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            新增属性
                        </h3>
                        <a href="{{ route('product.index') }}" class="btn btn-default pull-right">
                            <i class="fa fa-list"></i> 列表
                        </a>
                    </div>
                    <div class="box-body no-padding">
                        @include('admin.layouts.message')

                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_1" data-toggle="tab">基本信息</a></li>
                                <li><a href="#tab_2" data-toggle="tab">属性信息</a></li>
                                <li><a href="#tab_3" data-toggle="tab">辅助信息</a></li>
                                <li><a href="#tab_4" data-toggle="tab">详细描述</a></li>
                            </ul>
                            <form action="{{ route('product.store') }}" class="form-horizontal" method="post"
                                  id="product_form">
                                <div class="tab-content">

                                    <div class="tab-pane active" id="tab_1">
                                        {{ csrf_field() }}
                                        <div class="form-group">

                                            <label class="col-sm-2 control-label">产品名</label>

                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" placeholder="产品名"
                                                       name="name" value="{{ old('name') }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">品牌</label>

                                            <div class="col-sm-8">
                                                <select class="form-control select2" style="width: 100%;"
                                                        name="brand_id" id="brand_id">
                                                    <option value="">请选择</option>
                                                    @foreach($brands as $brand)
                                                        <option value="{{ $brand->brand_id}}"
                                                                data-cates="{{ $brand->categories->pluck('cate_id')}}">{{ $brand->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">产品分类</label>

                                            <div class="col-sm-8">
                                                <select class="form-control select2" style="width: 100%;"
                                                        name="cate_id" id="cate_id">
                                                    {{--@foreach($cate_tree as $key=> $name)--}}
                                                    {{--<option value="{{ $key }}">{{ $name }}</option>--}}
                                                    {{--@endforeach--}}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">关键字</label>

                                            <div class="col-sm-8">
                                                <textarea name="keywords" id="" cols="30" rows="5"
                                                          style="width: 100%">{{ old('keywords','') }}</textarea>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">排序</label>

                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" placeholder="排序"
                                                       name="order" value="{{ old('order',0) }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">成本价</label>

                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" placeholder="成本价"
                                                       name="cost_price" value="{{ old('cost_price',0) }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">市场价</label>

                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" placeholder="市场价"
                                                       name="market_price" value="{{ old('market_price',0) }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">本店价</label>

                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" placeholder="本店价"
                                                       name="shop_price" value="{{ old('shop_price',0) }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">状态</label>

                                            <div class="col-sm-8">
                                                <label>
                                                    <input type="radio" class="form-control"
                                                           name="state" value="1">
                                                    开启
                                                </label>
                                                <label>
                                                    <input type="radio" class="form-control"
                                                           name="state" value="0">
                                                    关闭
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_2">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">属性值</label>

                                            <div class="col-sm-8">
                                                @foreach($attrs as $attr)
                                                    <label>
                                                        <input type="checkbox" value="{{$attr->attr_id}}" class="attr">
                                                        {{$attr->name}}
                                                    </label>
                                                    <div class="attr_values">
                                                        @if($attr->show_type == 2)
                                                            @foreach($attr->attribute_values as $value)
                                                                <label>
                                                                    <input type="checkbox" name="attr_values[]"
                                                                           data-id="{{$attr->attr_id.'_'.$value->attr_value_id}}"
                                                                           value="{{$attr->attr_id.'_'.$value->attr_value_id}}">
                                                                    <img src="{{ $value->attr_value_2 }}"
                                                                         alt="{{ $value->attr_value_0 }}"
                                                                         style="width: 22px;height: 22px">
                                                                </label>
                                                                <input type="text" class="add-money">
                                                            @endforeach
                                                        @elseif($attr->show_type == 1)
                                                            @foreach($attr->attribute_values as $value)
                                                                <label class="p-r-10">
                                                                    <input type="checkbox" name="attr_values[]"
                                                                           data-id="{{$attr->attr_id.'_'.$value->attr_value_id}}"
                                                                           value="{{$attr->attr_id.'_'.$value->attr_value_id}}">
                                                                    <sapn style="vertical-align:middle;display:inline-block;width: 22px;height: 22px;background-color: {{ $value->attr_value_1 }}"></sapn>
                                                                </label>
                                                                <input type="text" class="add-money">
                                                            @endforeach
                                                        @else
                                                            @foreach($attr->attribute_values as $value)
                                                                <label class="p-r-10">
                                                                    <input type="checkbox" name="attr_values[]"
                                                                           data-id="{{$attr->attr_id.'_'.$value->attr_value_id}}"
                                                                           value="{{$attr->attr_id.'_'.$value->attr_value_id}}">
                                                                    {{$value->attr_value_0}}
                                                                </label>
                                                                <input type="text" class="add-money">
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_3">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">重量</label>

                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" placeholder="重量"
                                                       name="weight" value="{{ old('weight',0) }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">库存</label>

                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" placeholder="库存"
                                                       name="stock" value="{{ old('stock',0) }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">预警</label>

                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" placeholder="预警"
                                                       name="stock_limit" value="{{ old('stock_limit',0) }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">标签</label>

                                            <div class="col-sm-8">
                                                <label>
                                                    <input type="checkbox" class="form-control"
                                                           name="is_hot" value="1">热销
                                                </label>
                                                <label>
                                                    <input type="checkbox" class="form-control"
                                                           name="is_best" value="1">精品
                                                </label>
                                                <label>
                                                    <input type="checkbox" class="form-control"
                                                           name="is_new" value="1">新品
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_4">
                                        <textarea name="description" id="description" cols="30" rows="10"
                                                  style="height: 400px;max-height: 600px"></textarea>
                                    </div>
                                    <!-- /.tab-pane -->

                                </div>
                                <!-- /.tab-content -->
                                <div class="col-sm-push-2 col-sm-8">
                                    <button type="button" id="btn_submit" class="btn btn-primary">提交</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('script')
    <script src="{{ asset('AdminLTE/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/wangEditor/dist/js/wangEditor.js') }}"></script>
    <script src="{{ asset('/js/vue.js') }}"></script>

    <script>
        $(document).ready(function () {

            //初始化下拉插件
            $('.select2').select2();
            //下拉联动
            var cates = {!! $cates !!}
            $('#brand_id').change(function () {
                $('#cate_id').children().remove();
                var related_cates = $(this).find('option:selected').data('cates');

                for (i = 0; i < related_cates.length; i++) {
                    //console.log(cates[related_cates[i]]);
                    $('#cate_id').append($('<option value="' + related_cates[i] + '">' + cates[related_cates[i]] + '</option>'));
                }
            });


            //处理添加额外钱事件
            $('.add-money').change(function () {
                var money = $(this).val();
                console.log(money);
                if (!$.isNumeric(money) || money < 0) {
                    alert('输入不合法');
                    $(this).val('');
                    return false;
                }
                var dom = $(this).prev();
                if (dom) {
                    var dom_checkbox = dom.find('input[type="checkbox"]').eq(0);
                    //console.log(dom_checkbox);
                    dom_checkbox.val(dom_checkbox.data('id') + "_" + money);
                    console.log(dom_checkbox.val());
                }
            });

            //处理全选事件
            $('.attr').on('ifChecked', function () {
                $(this).parents('label').eq(0).next('div.attr_values').find('input[type="checkbox"]').iCheck('check');
            });
            $('.attr').on('ifUnchecked', function () {
                $(this).parents('label').eq(0).next('div.attr_values').find('input[type="checkbox"]').iCheck('uncheck');
            });


            //初始化富文本编辑器
            var editor = new wangEditor('description');
            editor.config.height = '600';
            //editor.config.hideLinkImg = true;
            //想本地上传图片，必须配置下边的参数
            editor.config.uploadImgUrl = "{{ route('upload_image') }}";
            editor.config.uploadImgFileName = 'description_image';
            editor.create();

            //提交表单,，需要处理富文本
            $('#btn_submit').click(function () {
                console.log('开始上传');
                //获取数据
                var editor_content = editor.$txt.html();
                $('#description').val(editor_content);

                $('#product_form').submit();
                console.log('ok');
            })
        })
    </script>
@stop