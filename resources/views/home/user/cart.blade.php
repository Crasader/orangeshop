@extends('home.layouts.layout')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="/index/css/cartstyle.css" rel="stylesheet" type="text/css"/>
    <link href="/index/css/jsstyle.css" rel="stylesheet" type="text/css"/>

    <script src="/js/cal.js"></script>
    <script type="text/javascript" src="/index/js/address.js"></script>

    <style>
        .J_MakePoint img {
            width: 80px !important;
            height: 80px !important;
        }

        .to_buy {
            position: absolute;
            width: 14px;
            height: 14px;
            display: inline-block;
            border: 1px solid #0c79b1;
        }
    </style>
@stop


@section('banner')

@stop

@section('shop_nav')
@stop

@section('content')
    <div class="concent">
        <!--地址 -->
        <div class="paycont">
            <div class="address">
                <h3>确认收货地址 </h3>
                <div class="control">
                    <div class="tc-btn createAddr theme-login am-btn am-btn-danger">使用新地址</div>
                </div>
                <div class="clear"></div>
                <ul>
                    @foreach($addresses as $address)
                        <div class="per-border"></div>
                        @if($address->is_default == 1)
                            <li class="user-addresslist defaultAddr">

                                <div class="address-left">
                                    <div class="user DefaultAddr">

										<span class="buy-address-detail">
                   <span class="buy-user">{{ $address->consignee }} </span>
										<span class="buy-phone">{{ $address->mobile }}</span>
										</span>
                                    </div>
                                    <div class="default-address DefaultAddr">
                                        <span class="buy-line-title buy-line-title-type">收货地址：</span>
                                        <span class="buy--address-detail">
								   <span class="province">{{ $address->province }}</span>
										<span class="city">{{ $address->city }}</span>
										<span class="dist">{{ $address->district }}</span>
										<span class="street">{{ $address->address }}</span>
                                    </div>
                                    <ins class="deftip">默认地址</ins>
                                </div>
                                <div class="address-right">
                                    <a href="../person/address.html">
                                        <span class="am-icon-angle-right am-icon-lg"></span></a>
                                </div>
                                <div class="clear"></div>

                                <div class="new-addr-btn">
                                    <a href="#" class="hidden">设为默认</a>
                                    <span class="new-addr-bar hidden">|</span>
                                    <a href="#">编辑</a>
                                    <span class="new-addr-bar">|</span>
                                    <a href="javascript:void(0);" onclick="delClick(this);">删除</a>
                                </div>

                            </li>
                        @else
                            <li class="user-addresslist">
                                <div class="address-left">
                                    <div class="user DefaultAddr">

										<span class="buy-address-detail">
                   <span class="buy-user">{{ $address->consignee }} </span>
										<span class="buy-phone">{{ $address->mobile }}</span>
										</span>
                                    </div>
                                    <div class="default-address DefaultAddr">
                                        <span class="buy-line-title buy-line-title-type">收货地址：</span>
                                        <span class="buy--address-detail">
								   <span class="province">{{ $address->province }}</span>
										<span class="city">{{ $address->city }}</span>
										<span class="dist">{{ $address->district }}</span>
										<span class="street">{{ $address->address }}</span>
										</span>
                                    </div>
                                    <ins class="deftip hidden">默认地址</ins>
                                </div>
                                <div class="address-right">
                                    <span class="am-icon-angle-right am-icon-lg"></span>
                                </div>
                                <div class="clear"></div>

                                <div class="new-addr-btn">
                                    <a href="#">设为默认</a>
                                    <span class="new-addr-bar">|</span>
                                    <a href="#">编辑</a>
                                    <span class="new-addr-bar">|</span>
                                    <a href="javascript:void(0);" onclick="delClick(this);">删除</a>
                                </div>

                            </li>
                        @endif
                    @endforeach
                </ul>

                <div class="clear"></div>
            </div>
            <!--物流 -->
            <div class="logistics">
                <h3>选择物流方式</h3>
                <ul class="op_express_delivery_hot">
                    <li data-value="yuantong" class="OP_LOG_BTN  "><i class="c-gap-right"
                                                                      style="background-position:0px -468px"></i>圆通<span></span>
                    </li>
                    <li data-value="shentong" class="OP_LOG_BTN  "><i class="c-gap-right"
                                                                      style="background-position:0px -1008px"></i>申通<span></span>
                    </li>
                    <li data-value="yunda" class="OP_LOG_BTN  "><i class="c-gap-right"
                                                                   style="background-position:0px -576px"></i>韵达<span></span>
                    </li>
                    <li data-value="zhongtong" class="OP_LOG_BTN op_express_delivery_hot_last "><i class="c-gap-right"
                                                                                                   style="background-position:0px -324px"></i>中通<span></span>
                    </li>
                    <li data-value="shunfeng" class="OP_LOG_BTN  op_express_delivery_hot_bottom"><i class="c-gap-right"
                                                                                                    style="background-position:0px -180px"></i>顺丰<span></span>
                    </li>
                </ul>
            </div>
            <div class="clear"></div>

            <!--支付方式-->
            <div class="logistics">
                <h3>选择支付方式</h3>
                <ul class="pay-list">
                    <li class="pay card"><img src="/index/images/wangyin.jpg"/>银联<span></span></li>
                    <li class="pay qq"><img src="/index/images/weizhifu.jpg"/>微信<span></span></li>
                    <li class="pay taobao"><img src="/index/images/zhifubao.jpg"/>支付宝<span></span></li>
                </ul>
            </div>
            <div class="clear"></div>

            <!--订单 -->
            <div class="concent">
                <div id="payTable">
                    <h3>确认订单信息</h3>
                    <div class="cart-table-th">
                        <div class="wp">

                            <div class="th th-item">
                                <div class="td-inner">商品信息</div>
                            </div>
                            <div class="th th-price">
                                <div class="td-inner">单价</div>
                            </div>
                            <div class="th th-amount">
                                <div class="td-inner">数量</div>
                            </div>
                            <div class="th th-sum">
                                <div class="td-inner">金额</div>
                            </div>
                            <div class="th th-oplist">
                                <div class="td-inner">配送方式</div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    @foreach($order_products as $order_product)
                        <div class="item-list">
                            <div class="bundle  bundle-last">

                                <div class="bundle-main">
                                    <ul class="item-content clearfix">
                                        <div class="pay-phone">
                                            <li class="td td-item">
                                                <div class="item-pic">

                                                    <a href="#" class="J_MakePoint">
                                                        <input type="checkbox" class="to_buy"
                                                               data-orderid="{{$order_product->record_id}}"
                                                               data-price="{{ $order_product->discount_price }}"
                                                               data-count="{{ $order_product->buy_count }}">
                                                        <img src="{{ $order_product->img }}"
                                                             class="itempic J_ItemImg"></a>
                                                </div>
                                                <div class="item-info">
                                                    <div class="item-basic-info">

                                                        <a href="#" class="item-title J_MakePoint"
                                                           data-point="tbcart.8.11">{{ $order_product->name }}</a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="td td-info">
                                                <div class="item-props">
                                                    @foreach($order_product->attr_and_values as $attr_and_value)
                                                        <span class="sku-line">{{ $attr_and_value[0]->name }}
                                                            :@if($attr_and_value[0]->show_type == 2)<img
                                                                    src="{{ $attr_and_value[1]->attr_value_2 }}" alt=""
                                                                    style="display: inline-block;width: 14px;height: 14px;> @elseif($attr_and_value[0]->show_type==1)
                                                                            <i style=" display: inline-block;width:
                                                                    14px;height:
                                                                    14px;background-color:{{$attr_and_value[1]->attr_value_1}}
                                                            "></i>@else {{$attr_and_value[1]->attr_value_0}} @endif</span>
                                                    @endforeach
                                                </div>
                                            </li>
                                            <li class="td td-price">
                                                <div class="item-price price-promo-promo">
                                                    <div class="price-content">
                                                        <em class="J_Price price-now">{{ $order_product->discount_price }}</em>
                                                    </div>
                                                </div>
                                            </li>
                                        </div>
                                        <li class="td td-amount">
                                            <div class="amount-wrapper ">
                                                <div class="item-amount ">
                                                    <span class="phone-title">购买数量</span>
                                                    <div class="sl">
                                                        {{ $order_product->buy_count }}
                                                        @if($order_product->send_count > 0)
                                                            (赠送 × {{ $order_product->send_count }})
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="td td-sum">
                                            <div class="td-inner">
                                                <em tabindex="0"
                                                    class="J_ItemSum number">{{ $order_product->buy_count * $order_product->discount_price}}</em>
                                            </div>
                                        </li>
                                        <li class="td td-oplist">
                                            <div class="td-inner">
                                                <span class="phone-title">配送方式</span>
                                                <div class="pay-logis">
                                                    快递<b class="sys_item_freprice">{{ $order_product->product->is_free_shipping ==1?0:10  }}</b>元
                                                    <button class="am-btn am-btn-danger am-btn-xs remove"
                                                            data-recordid="{{ $order_product->record_id }}">移除
                                                    </button>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                    <div class="clear"></div>

                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    @endforeach
                    <div class="clear"></div>
                    <div class="pay-total">
                        <!--留言-->
                        <div class="order-extra">
                            <div class="order-user-info">
                                <div id="holyshit257" class="memo">
                                    <label>买家留言：</label>
                                    <input type="text" title="选填,对本次交易的说明（建议填写已经和卖家达成一致的说明）"
                                           placeholder="选填,建议填写和卖家达成一致的说明"
                                           class="memo-input J_MakePoint c2c-text-default memo-close">
                                    <div class="msg hidden J-msg">
                                        <p class="error">最多输入500个字符</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--优惠券 -->
                        {{--  <ul class="buy-agio">
                              <li class="td td-coupon">

                                  <span class="coupon-title">优惠券</span>
                                  <select data-am-selected>
                                      <option value="a">
                                          <div class="c-price">
                                              <strong>￥8</strong>
                                          </div>
                                          <div class="c-limit">
                                              【消费满95元可用】
                                          </div>
                                      </option>
                                      <option value="b" selected>
                                          <div class="c-price">
                                              <strong>￥3</strong>
                                          </div>
                                          <div class="c-limit">
                                              【无使用门槛】
                                          </div>
                                      </option>
                                  </select>
                              </li>

                              <li class="td td-bonus">

                                  <span class="bonus-title">红包</span>
                                  <select data-am-selected>
                                      <option value="a">
                                          <div class="item-info">
                                              ¥50.00<span>元</span>
                                          </div>
                                          <div class="item-remainderprice">
                                              <span>还剩</span>10.40<span>元</span>
                                          </div>
                                      </option>
                                      <option value="b" selected>
                                          <div class="item-info">
                                              ¥50.00<span>元</span>
                                          </div>
                                          <div class="item-remainderprice">
                                              <span>还剩</span>50.00<span>元</span>
                                          </div>
                                      </option>
                                  </select>

                              </li>

                          </ul>--}}
                        <div class="clear"></div>
                    </div>
                    <!--含运费小计 -->
                    <div class="buy-point-discharge ">
                        <p class="price g_price ">
                            合计（含运费） <span>¥</span><em class="pay-sum"></em>
                        </p>
                    </div>

                    <!--信息 -->
                    <div class="order-go clearfix">
                        <div class="pay-confirm clearfix">
                            <div class="box">
                                <div tabindex="0" id="holyshit267" class="realPay"><em class="t">实付款：</em>
                                    <span class="price g_price ">
                                    <span>¥</span> <em class="style-large-bold-red " id="J_ActualFee"></em>
											</span>
                                </div>

                                <div id="holyshit268" class="pay-address">

                                    <p class="buy-footer-address">
                                        <span class="buy-line-title buy-line-title-type">寄送至：</span>
                                        <span class="buy--address-detail">
								   <span class="province">湖北</span>省
												<span class="city">武汉</span>市
												<span class="dist">洪山</span>区
												<span class="street">雄楚大道666号(中南财经政法大学)</span>
												<span></span>
                            </span>
                                    </p>
                                    <p class="buy-footer-address">
                                        <span class="buy-line-title">收货人：</span>
                                        <span class="buy-address-detail">
                                         <span class="buy-user">艾迪 </span>
												<span class="buy-phone">15871145629</span>
												</span>
                                    </p>
                                </div>
                            </div>

                            <div id="holyshit269" class="submitOrder">
                                <div class="go-btn-wrap">
                                    <a id="J_Go" href="success.html" class="btn-go" tabindex="0"
                                       title="点击此按钮，提交订单">提交订单</a>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>

                <div class="clear"></div>
            </div>
        </div>

    </div>
    <div class="theme-popover-mask"></div>
    <div class="theme-popover">
        <!--标题 -->
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">新增地址</strong> /
                <small>Add address</small>
            </div>
        </div>
        <hr/>

        <div class="am-u-md-12">
            <form class="am-form am-form-horizontal">

                <div class="am-form-group">
                    <label for="user-name" class="am-form-label">收货人</label>
                    <div class="am-form-content">
                        <input type="text" id="user-name" placeholder="收货人">
                    </div>
                </div>

                <div class="am-form-group">
                    <label for="user-phone" class="am-form-label">手机号码</label>
                    <div class="am-form-content">
                        <input id="user-phone" placeholder="手机号必填" type="email">
                    </div>
                </div>

                <div class="am-form-group">
                    <label for="user-phone" class="am-form-label">所在地</label>
                    <div class="am-form-content address">
                        <select data-am-selected>
                            <option value="a">浙江省</option>
                            <option value="b">湖北省</option>
                        </select>
                        <select data-am-selected>
                            <option value="a">温州市</option>
                            <option value="b">武汉市</option>
                        </select>
                        <select data-am-selected>
                            <option value="a">瑞安区</option>
                            <option value="b">洪山区</option>
                        </select>
                    </div>
                </div>

                <div class="am-form-group">
                    <label for="user-intro" class="am-form-label">详细地址</label>
                    <div class="am-form-content">
                        <textarea class="" rows="3" id="user-intro" placeholder="输入详细地址"></textarea>
                        <small>100字以内写出你的详细地址...</small>
                    </div>
                </div>

                <div class="am-form-group theme-poptit">
                    <div class="am-u-sm-9 am-u-sm-push-3">
                        <div class="am-btn am-btn-danger">保存</div>
                        <div class="am-btn am-btn-danger close">取消</div>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <div class="clear"></div>
    @include('home.layouts._footer')
@stop

@section('script')
    <script>

        $('.pay-phone img').click(function () {
            $(this).toggleClass('selected');
        })

        //计算价格
        function total() {
            var total = 0;
            var dom_buy = $('.to_buy:checked');
            for (var i = 0; i < dom_buy.length; i++) {
                var ship_fee = dom_buy.eq(i).closest('ul').find('.sys_item_freprice').text();
                console.log(ship_fee);
                var item_cost = add(ship_fee, dom_buy.eq(i).data('price') * dom_buy.eq(i).data('count'));
                total = add(total, item_cost);
            }
            $('.pay-sum').text(total);
            $('#J_ActualFee').text(total);

        }
        total();
        $('.to_buy').click(function () {
            total();
        });

        //移除订单
        $('.remove').click(function () {
            var self = this;
            $.ajax({
                url: 'cart/remove',
                type: 'delete',
                dataType: 'json',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    record_id: $(this).data('recordid')
                },
                success: function (data) {
                    if (data.error == 0) {
                        //删除成功，移除项目，并重新计算总额
                        $(self).closest('div.item-list').remove();
                        total();
                        swal({
                            title: '',
                            text: '删除成功',
                            type: "success",
                        })
                    }
                },
                error: function () {
                    swal({
                        title: '',
                        text: '请求出错啦...',
                        type: "warning",
                    })
                }
            })
        });
    </script>
@stop

