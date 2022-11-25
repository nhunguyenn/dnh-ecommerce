@extends('layouts.client')

@section('title', 'Purchase')

@section('content')
    <div class="body-content outer-top-xs">
        <div class="container">
            <div class="row ">
                <div class="shopping-cart" style="padding: 15px; 20px;">
                    <span style="font-weight: bold; font-size: 16px;">Trang Chủ / Đơn Mua</span>
                </div>
            </div>
        </div>
    </div>

    <div class="body-content outer-top-xs">
        <div class="container">
            @if ($order)
                @foreach ($order as $value)
                    @php $status = true; @endphp
                    <div class="row">
                        <div class="shopping-cart" style="margin-bottom: 20px;">
                            <div class="shopping-cart-table" style="margin-bottom: 0px;">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            @php $id_cart_product_list = explode(',', $value->id_cart_product); @endphp
                                            @foreach ($id_cart_product_list as $id_cart_product)
                                                <form action="{{ route('client.purchase.handlePurchase') }}" method="post">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="id_order" value="{{ $value->id }}">
                                                    <input type="hidden" name="id_cart_product" value="{{ $id_cart_product }}">
                                                    @php $cart = \App\Http\Controllers\clients\CartController::getCartProductInforById($id_cart_product)[0]; @endphp
                                                    <thead>
                                                        <tr>
                                                            <th style="order-bottom: 0.5px solid #ffff; padding: 0; width: 30%;"></th>
                                                            <th style="order-bottom: 0.5px solid #ffff; padding: 0; width: 8%;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="padding: 18px;" class="cart-product-name-info">
                                                                @php $price = \App\Http\Controllers\clients\PurchaseController::findPriceByCartProductId($id_cart_product); @endphp
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <h4 class='cart-product-description'>
                                                                            <a href="{{ route('client.detail', [$cart->id_product, Str::slug($cart->name_product, '-')]) }}">{{ $cart->name_product }}</a>
                                                                        </h4>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <p>
                                                                            <span><span style="font-weight: bold;">Phân loại: </span>{{ $cart->size }}/{{ $cart->color }}</span> &ensp; &ensp;
                                                                            <span><span style="font-weight: bold;">Số lượng: </span>{{ $cart->quantity_product }}</span> &ensp; &ensp;
                                                                            <span><span style="font-weight: bold;">Tổng tiền: </span>{{ number_format($price[0]->price_product * $cart->quantity_product - $price[0]->price_discount * $cart->quantity_product - $value->price_voucher + $value->price_delivery, 0) }} VNĐ</span>
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <table style="text-align: center;">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="padding-right: 30px; color: red;">Giá Sản phẩm (VNĐ/SP)</th>
                                                                                    <th style="padding-right: 30px; color: red;">Số tiền giảm giả (VNĐ/SP)</th>
                                                                                    <th style="padding-right: 30px; color: red;">Phiếu giảm giá (VNĐ)</th>
                                                                                    <th style="padding-right: 30px; color: red;">Tiền vận chuyển (VNĐ)</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="padding-right: 30px;">{{ number_format($price[0]->price_product, 0) }}</td>
                                                                                    <td style="padding-right: 30px;">{{ number_format($price[0]->price_discount, 0) }}</td>
                                                                                    <td style="padding-right: 30px;">{{ number_format($value->price_voucher, 0) }}</td>
                                                                                    <td style="padding-right: 30px;">{{ number_format($value->price_delivery, 0) }}</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td style="padding: 18px; text-align: center;">
                                                                @if ($value->active == 3)
                                                                    @php
                                                                        $active_confirm = \App\Http\Controllers\clients\PurchaseController::findActiveConfirmByOrderIdAndCartProductId($value->id, $id_cart_product);
                                                                        $active_return = \App\Http\Controllers\clients\PurchaseController::findActiveReturnByOrderIdAndCartProductId($value->id, $id_cart_product);
                                                                        $active_return_order = \App\Http\Controllers\clients\PurchaseController::findActiveReturnByOrderIdAndCartProductIdInTableReturnOrder($value->id, $id_cart_product);
                                                                    @endphp
                                                                    @if ($active_confirm == 0 and $active_return == 0)
                                                                        <button name="button" id="btn-return-order" value="return" type="submit" class="btn btn-danger" style="height: 38px; margin-left: 10px;">Trả hàng</button>
                                                                        <button name="button" id="btn-confirm-order" value="confirm" type="submit" class="btn btn-primary">Đã nhận hàng</button>
                                                                    @endif
                                                                    @if ($active_confirm == 1 and $active_return == 0)
                                                                        @if ($active_return_order == 2)
                                                                            <h4 class="order-status" style="font-size: 15px; color: red;">ĐƠN HÀNG <br> ĐÃ BỊ TỪ CHỐI TRẢ HÀNG</h4>
                                                                        @else
                                                                            <h4 class="order-status" style="font-size: 15px; color: green;">ĐƠN HÀNG <br> ĐÃ ĐƯỢC HOÀN TẤT</h4>
                                                                        @endif
                                                                    @endif
                                                                    @if ($active_confirm == 0 and $active_return == 1)
                                                                        @if ($active_return_order == 1)
                                                                            <h4 class="order-status" style="font-size: 15px;">ĐƠN HÀNG <br> ĐÃ XÁC NHẬN TRẢ HÀNG</h4>
                                                                        @elseif ($active_return_order == 3)
                                                                            <h4 class="order-status" style="font-size: 15px;">ĐƠN HÀNG <br> ĐANG CHỜ HOÀN TIỀN</h4>
                                                                        @elseif ($active_return_order == 4)
                                                                            <h4 class="order-status" style="font-size: 15px; color: green;">ĐƠN HÀNG <br> ĐÃ ĐƯỢC ĐỔI TRẢ/HOÀN TIỀN</h4>
                                                                        @else
                                                                            <h4 class="order-status" style="font-size: 15px;">ĐƠN HÀNG <br> ĐANG CHỜ XÁC NHẬN TRẢ HÀNG</h4>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                    @if ($value->active == 1)
                                                                        <h4 class="order-status" style="font-size: 15px;">CHỜ LẤY HÀNG</h4>
                                                                    @elseif ($value->active == 2)
                                                                        <h4 class="order-status" style="font-size: 15px;">ĐANG GIAO HÀNG</h4>
                                                                    @elseif ($value->active == 4)
                                                                        <h4 class="order-status" style="font-size: 15px; color: red;">ĐƠN HÀNG ĐÃ BỊ HỦY</h4>
                                                                    @else
                                                                        <h4 class="order-status" style="font-size: 15px;">CHỜ XÁC NHẬN</h4>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th style="order-bottom: 0.5px solid #ffff; padding: 0; width: 30%;"></th>
                                                            <th style="order-bottom: 0.5px solid #ffff; padding: 0; width: 8%;"></th>
                                                        </tr>
                                                    </thead>
                                                </form>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
