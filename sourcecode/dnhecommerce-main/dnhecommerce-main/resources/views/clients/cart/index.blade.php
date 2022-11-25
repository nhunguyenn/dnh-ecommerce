@extends('layouts.client')

@section('title', 'Cart')

@section('content')
<div class="body-content outer-top-xs">
    <div class="container">
        <div class="row ">
            <div class="shopping-cart" style="padding: 15px; 20px;">
                <span style="font-weight: bold; font-size: 16px;">Trang Chủ / Giỏ Hàng</span>
            </div>
        </div>
    </div>
</div>

<div class="body-content outer-top-xs">
    <div class="container">
        <div class="row ">
            <div class="shopping-cart" style="margin-bottom: 20px;">
                <div class="shopping-cart-table" style="margin-bottom: 0px;">
                    <div class="table-responsive">
                        <table class="table">
                            @if ($countActive > 0)
                                <form action="{{ route('client.cart.handleCrudCart') }}" method="post">
                                    {{ csrf_field() }}
                                    <thead>
                                        <tr>
                                            <th style="width: 0%;"></th>
                                            <th style="width: 30%; text-align: left;">SẢN PHẨM</th>
                                            <th style="width: 10%;">ĐƠN GIÁ (VNĐ)</th>
                                            <th style="width: 10%;">SỐ LƯỢNG</th>
                                            <th style="width: 10%;">SỐ LƯỢNG (VNĐ)</th>
                                            <th style="width: 10%;">THAO TÁC</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                            $countID = 0;
                                        @endphp
                                        @foreach ($cart as $value)
                                            <tr>
                                                <td style="padding: 18px; text-align: center; padding-left: 0; padding-right: 0px;">
                                                    <input type="hidden" name="id[{{ $countID }}]" value="{{ $value->id }}">
                                                    <input type="checkbox" name="status[{{ $countID }}]" value="1" onchange="this.form.submit()" @if ($value->status == 1) checked="checked" @endif>
                                                </td>

                                                <td style="padding: 18px;" class="cart-product-name-info">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h4 class='cart-product-description'>
                                                                <input type="hidden" name="id_product[{{ $countID }}]" value="{{ $value->id_product }}">
                                                                <a href="{{ route('client.detail', [$value->id_product, Str::slug($value->name_product, '-')]) }}">{{ $value->name_product }}</a>
                                                            </h4>
                                                        </div>
                                                        <div class="col-md-6" style="width: auto;">
                                                            <div class="form-group" style="width: 130px; display: inline-block;">
                                                                <select class="form-control" name="id_size[{{ $countID }}]" onchange="this.form.submit()">
                                                                    @foreach ($sizes as $size)
                                                                        @if ($size->active == 1 && $size->id_product == $value->id_product)
                                                                            <option value="{{ $size->id }}" @if ($value->id_size == $size->id) selected="selected" @endif>{{ $size->name }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6" style="width: auto;">
                                                            <div class="form-group" style="width: 130px; display: inline-block;">
                                                                <select class="form-control" name="id_color[{{ $countID }}]" onchange="this.form.submit()">
                                                                    @foreach ($colors as $color)
                                                                        @if ($color->active == 1 && $color->id_product == $value->id_product)
                                                                            <option value="{{ $color->id }}" @if ($value->id_color == $color->id) selected="selected" @endif>{{ $color->name }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td style="padding: 18px; text-align: center;">
                                                    @foreach ($colors as $color)
                                                        @if ($color->active == 1 && $color->id_product == $value->id_product && $color->id == $value->id_color)
                                                            <input type="hidden" name="price[{{ $countID }}]" value="{{ $value->price + $color->price }}">
                                                            {{ number_format($value->price + $color->price, 0) }}
                                                        @endif
                                                    @endforeach
                                                </td>

                                                <td style="padding: 18px; text-align: center;">
                                                    <div class="quant-input">
                                                        <div class="arrows">
                                                            <div class="arrow plus gradient"><span class="ir"><i class="icon fa fa-sort-asc"></i></span></div>
                                                            <div class="arrow minus gradient"><span class="ir"><i class="icon fa fa-sort-desc"></i></span></div>
                                                        </div>
                                                        @foreach ($colors as $color)
                                                            @if ($color->active == 1 && $color->id_product == $value->id_product && $color->id == $value->id_color)
                                                                <input type="text" id="quantity_product[{{ $countID }}]" name="quantity_product[{{ $countID }}]" onchange="this.form.submit()" value="{{ $value->quantity_product }}" onchange="QuantityProduct('{{ $value->price + $color->price}}', '{{ $countID }}')">
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </td>

                                                <td style="padding: 18px; text-align: center;">
                                                    @foreach ($colors as $color)
                                                        @if ($color->active == 1 && $color->id_product == $value->id_product && $color->id == $value->id_color)
                                                            <span class="cart-grand-total-price" id="total_price[{{ $countID }}]">{{ number_format(($value->price + $color->price)* $value->quantity_product, 0) }}</span>
                                                        @endif
                                                    @endforeach
                                                </td>

                                                <td style="padding: 18px; text-align: center;">
                                                    <button style="submit" name="buttonDelete" value="deleteCart,{{ $value->id }}" class="btn btn-upper btn-danger" style="color: red; font-size: 15px; font-weight: bold;">Xóa</button>
                                                </td>
                                            </tr>
                                            @php
                                                $countID++;
                                            @endphp
                                        @endforeach
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <td colspan="6" style="padding-bottom: 0px; padding-top: 0px;">
                                                <div class="shopping-cart-btn">
                                                    <span class="">
                                                        <a href="{{ route('client.home') }}" class="btn btn-upper btn-primary outer-left-xs" style="padding: 6px 14px;">Tiếp Tục Mua Hàng</a>
                                                        <a href="{{ route('client.checkout') }}" class="btn btn-upper btn-warning pull-right outer-right-xs" style="padding: 6px 14px;">Thanh Toán</a>
                                                        <input type="hidden" name="button" value="updateCart">
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </form>
                            @else
                                <p style="text-align: center; font-size: 20px;">CHƯA CÓ SẢN PHẨM NÀO TRONG GIỎ HÀNG CỦA BẠN</p>
                                <hr>
                                <a href="{{ route('client.home') }}" class="btn btn-upper btn-primary outer-left-xs" style="padding: 6px 14px;">Tiếp Tục Mua Hàng</a>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
