@extends('layouts.client')

@section('title', 'Checkout')

@section('content')
<div class="body-content outer-top-xs">
    <div class="container">
        <div class="row ">
            <div class="shopping-cart" style="padding: 15px; 20px;">
                <span style="font-weight: bold; font-size: 16px;">Trang Chủ / Thanh Toán</span>
            </div>
        </div>
    </div>
</div>

<div class="body-content outer-top-xs">
    <div class="container">
        <div class="row ">
            <form action="{{ route('client.checkout.handleCrudCheckout') }}" method="post" onsubmit="return inputCheckout();">
                {{ csrf_field() }}
                <div class="shopping-cart" style="margin-bottom: 20px;">
                    <div class="row">
                        <div class="col-md-12 estimate-ship-tax">
                            <span style="font-size: 18px; font-weight: bold;">ĐỊA CHỈ NHẬN HÀNG</span>
                        </div>
                        <div class="col-md-12 estimate-ship-tax">
                            @foreach ($addresses as $address)
                                @if ($address->active == 1)
                                    <div class="row" style="padding-top: 20px; font-size: 15px;">
                                        <input type="hidden" name="id_address" value="{{ $address->id }}">
                                        <div class="col-md-3">
                                            <p>{{ $address->name_customer }} - {{ $address->phone }}</p>
                                        </div>
                                        <div class="col-md-8">
                                            <span>{{ $address->specific_address }}</span>
                                        </div>
                                        <div class="col-md-1" style="text-align: right;">
                                            <a href="#" data-toggle="modal" data-target="#list_address" style="color: blue; font-size: 15px;">Thay Đổi</a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="shopping-cart" style="margin-bottom: 20px;">
                    <div class="shopping-cart-table" style="margin-bottom: 0px;">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="padding: 18px 0px; width: 30%; text-align: left;">SẢN PHẨM</th>
                                        <th style="padding: 18px 0px; width: 10%;">ĐƠN GIÁ (VNĐ)</th>
                                        <th style="padding: 18px 0px; width: 10%;">SỐ LƯỢNG</th>
                                        <th style="padding: 18px 0px; width: 10%;">TỔNG TIỂN (VNĐ)</th>
                                        <th style="padding: 18px 0px; width: 10%;">GIẢM CÒN (VNĐ)</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                        $totalPriceProduct = 0;
                                    @endphp
                                    @foreach ($products as $index => $product)
                                        <tr>
                                            <input type="hidden" name="id_cart_product[]" value="{{ $product->id }}">

                                            <td style="padding: 18px 0px;" class="cart-product-name-info">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h4 class='cart-product-description'><a href="">{{ $product->name_product }}</a></h4>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" style="width: auto; padding-left: 0px;">
                                                    <div class="cart-product-info">
                                                        <span class="product-color">Kích thước:<span style="text-transform: uppercase">{{ $product->name_size }}</span></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" style="width: auto; padding-left: 0px;">
                                                    <div class="cart-product-info">
                                                        <span class="product-color">Màu sắc:<span style="text-transform: uppercase">{{ $product->name_color }}</span></span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td style="text-align: center; padding: 18px 0px;">{{ number_format($product->price, 0) }}</td>

                                            <td style="text-align: center; padding: 18px 0px;">
                                                <div class="quant-input">
                                                    <input type="text" value="{{ $product->quantity_product }}" disabled="disabled">
                                                </div>
                                            </td>

                                            <td style="text-align: center; padding: 18px 0px;"><span class="cart-grand-total-price">{{ number_format($product->price * $product->quantity_product, 0) }}</span></td>

                                            @if (isset($discounts[$index]->id_product) && $discounts[$index]->id_product == $product->id_product)
                                                @php
                                                    $totalPriceProduct += (($product->price - ($product->price * ($discounts[$index]->percent_discount / 100))) * $product->quantity_product);
                                                @endphp
                                                <input type="hidden" name="id_product_discount[]" value="{{ $discounts[$index]->id_product }}">
                                                <td style="text-align: center; padding: 18px 0px;">
                                                    <span class="cart-discount-total-price">{{ number_format(($product->price - ($product->price * ($discounts[$index]->percent_discount / 100))) * $product->quantity_product, 0) }}</span>
                                                </td>
                                            @else
                                                @php
                                                    $totalPriceProduct += (($product->price - ($product->price * (0 / 100))) * $product->quantity_product);
                                                @endphp
                                                <td style="text-align: center; padding: 18px 0px;">
                                                    <span class="cart-discount-total-price">{{ number_format(($product->price - ($product->price * (0 / 100))) * $product->quantity_product, 0) }}</span>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th style="padding: 18px 0px; width: 10%;"></th>
                                        <th style="padding: 18px 0px; width: 10%;"></th>
                                        <th style="padding: 18px 0px; width: 10%;"></th>
                                        <th style="font-size: 15px; padding: 18px 0px; width: 10%; text-align: center;">TỔNG TIỀN SẢN PHẨM</th>
                                        <th style="font-size: 15px; padding: 18px 0px; width: 10%; text-align: center;">{{ number_format($totalPriceProduct, 0) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="shopping-cart" style="margin-bottom: 20px; padding-bottom: 10px;">
                    <div class="col-md-7 col-sm-12 estimate-ship-tax">
                        <div class="row">
                            <div style="padding-left: 0px;" class="col-md-12 estimate-ship-tax">
                                <span style="font-size: 18px; font-weight: bold;">PHIẾU GIẢM GIÁ -
                                    <a href="#" data-toggle="modal" data-target="#list_voucher" style="color: red; font-size: 15px;">
                                        CHỌN VOUCHER
                                    </a>
                                </span>
                            </div>
                            <div style="padding-left: 0px;" class="col-md-12 estimate-ship-tax">
                                <input type="hidden" id="id_voucher" name="id_voucher">
                                <div class="row" style="padding-top: 20px; font-size: 15px;">
                                    <div class="col-md-6">
                                        <p id="name_voucher"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <p id="price_voucher"></p>
                                    </div>
                                    <div class="col-md-3" style="text-align: right;">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div style="padding-left: 0px;" class="col-md-12 estimate-ship-tax">
                                <span style="font-size: 18px; font-weight: bold;">ĐƠN VỊ VẬN CHUYỂN -
                                    <a href="#" data-toggle="modal" data-target="#list_delivery" style="color: red; font-size: 15px;">
                                        CHỌN ĐỢN VỊ VẬN CHUYỂN
                                    </a>
                                </span>
                            </div>
                            <div style="padding-left: 0px;" class="col-md-12 estimate-ship-tax">
                                <input type="hidden" id="id_delivery" name="id_delivery">
                                <div class="row" style="padding-top: 20px; font-size: 15px;">
                                    <div class="col-md-6">
                                        <p id="name_delivery"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <p id="price_delivery"></p>
                                    </div>
                                    <div class="col-md-3" style="text-align: right;">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 col-sm-12 cart-shopping-total">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="cart-sub-total"> Tổng Tiền
                                            <span class="inner-left-md">
                                                <input type="text" readonly="readonly" style="text-align: right; border: none; background-color: #f8f8f8;" value="{{ number_format($totalPriceProduct, 0) }}">	VNĐ
                                            </span>
                                        </div>
                                        <div class="cart-grand-total"> Tổng Cộng
                                            <span class="inner-left-md">
                                                <input type="text" readonly="readonly" style="text-align: right; border: none; background-color: #f8f8f8;" value="{{ number_format($totalPriceProduct, 0) }}">  VNĐ
                                            </span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 10px 20px;">
                                        <div class="cart-checkout-btn pull-right">
                                            <button type="submit" name="button" value="checkout" class="btn btn-primary checkout-btn">Thanh toán</button>
                                            <span class="">Thanh toán sau khi nhận hàng!</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>

            <div class="modal" id="list_address">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('client.checkout.handleCrudCheckout') }}" method="post">
                            {{ csrf_field() }}
                            <div class="modal-header">
                                <h4 class="modal-title" style="font-weight: bold;">ĐỊA CHỈ CỦA TÔI</h4>
                            </div>
                            <div class="modal-body">
                                @foreach ($addresses as $address)
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="" style="padding: 10px 0px;">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <label class="custom-control-label" for="id_address[{{ $address->id }}]" style="font-size: 15px;">
                                                        <span style="font-weight: bold;">{{ $address->name_customer }}</span> | <span>{{ $address->phone }}</span>
                                                        @if ($address->active == 1)
                                                            <span style="color: red;"> Mặc Định</span>
                                                        @endif
                                                    </label>
                                                </div>
                                                <p>{{ $address->specific_address }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-right">
                                            <div class="" style="padding: 10px 0px;">
                                                <button type="submit" name="button" value="changeAddress,{{ $address->id }}" class="btn btn-danger">Xác Nhận</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            {{-- <div class="modal-footer">
                                <button type="submit" name="button" value="changeAddress" class="btn btn-danger">Xác Nhận</button>
                            </div> --}}
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal" id="list_voucher">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" style="font-weight: bold;">PHIẾU GIẢM GIÁ</h4>
                        </div>

                        <div class="modal-body">
                            @foreach ($vouchers as $voucher)
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="" style="padding: 10px 0px;">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <label class="custom-control-label" for="id_voucher[{{ $voucher->id }}]" style="font-size: 15px;">
                                                    <input type="hidden" id="totalVoucher_view" value="{{ $voucher->price }}" readonly="readonly">
                                                    <span style="font-weight: bold;">{{ $voucher->name }}</span> || <span style="color: red">{{ number_format($voucher->price, 0) }} VND</span>
                                                </label>
                                            </div>
                                            <p>Điều kiện: Phải mua từ <b>{{ $voucher->total_product }}</b> sản phẩm</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <div class="" style="padding: 10px 0px;">
                                            @if (sizeof($products) >= $voucher->total_product)
                                                <button type="button" class="btn btn-danger" onclick="Voucher('{{ $voucher->id }}', '{{ $voucher->name }}', '{{ $voucher->price }}', '{{ $totalPriceProduct }}');">Chọn</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="list_delivery">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" style="font-weight: bold;">ĐƠN VỊ VẬN CHUYỂN</h4>
                        </div>

                        <div class="modal-body">
                            @foreach ($deliverys as $delivery)
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="" style="padding: 10px 0px;">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <label class="custom-control-label" for="id_delivery[{{ $delivery->id }}]" style="font-size: 15px;">
                                                    <p style="font-weight: bold;">{{ $delivery->name }}</p>
                                                    <input type="hidden" id="totalDelivery_view" value="{{ $delivery->price }}" readonly="readonly">
                                                    <p style="font-size: 13px; font-weight: normal;">Giá vận chuyển <span style="color: red; font-weight: bold;">{{ number_format($delivery->price, 0) }} VND</span></p>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <div class="" style="padding: 10px 0px;">
                                            <button type="button" class="btn btn-danger" onclick="Delivery('{{ $delivery->id }}', '{{ $delivery->name }}', '{{ $delivery->price }}','{{ $totalPriceProduct }}');">Chọn</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
