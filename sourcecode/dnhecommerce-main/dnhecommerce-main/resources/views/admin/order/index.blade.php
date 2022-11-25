@extends('layouts.admin')

@section('title', 'Order')

@section('active-order', 'active')

@section('sidebar')
    @parent
    @include('partials.admin.sidebar')
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb" style="background: white; margin-bottom: 0px; padding-top: 12px; padding-bottom: 12px;">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Trang Chủ</a></li>
                        <li class="active">Quản Lý Đơn Hàng</li>
                    </ol>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#order-toship" data-toggle="tab">Chờ Lấy Hàng</a></li>
                            <li><a href="#order-shipping" data-toggle="tab">Đang Giao</a></li>
                            <li><a href="#order-completed" data-toggle="tab">Đã Giao</a></li>
                            <li><a href="#order-return" data-toggle="tab">Trả Hàng và Hoàn Tiền</a></li>
                            <li><a href="#order-done" data-toggle="tab">Đơn Hàng Đã Hoàn Tất</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="order-toship">
                                <div class="box" style="border-top: none; box-shadow: none;">
                                    <div class="box-header" style="padding-bottom: 0;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p style="margin: 0;">{{ $countToship }}</b> Đơn Hàng</p>
                                                <p style="margin: 0;">Hiện tại đang có <b>{{ $countToship }}</b> Đơn Hàng trong hệ thống</p>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button type="button" class="btn btn-success btn-sm"><i class="fa fa-fw fa-print"></i> Tạo Pick List</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="table-order-toship" class="table table-bordered dataTable">
                                            <thead>
                                                <tr data-toggle="modal">
                                                    <th style="width: 20%;">Sản phẩm</th>
                                                    <th style="width: 5%;">Tổng đơn</th>
                                                    <th style="width: 10%;">Trạng thái</th>
                                                    <th style="width: 15%;">Vận Chuyển</th>
                                                    <th style="width: 5%;">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orders as $order)
                                                    @if ($order->active == 1)
                                                        <tr>
                                                            <td colspan="4" style="font-weight: bold; background-color: #f7f8fa;">
                                                                {{ $order->name_customer }}
                                                            </td>
                                                            <td style="background-color: #f7f8fa;">Mã Đơn Hàng: <span><b>{{ $order->id }}</b></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <ul style="padding-left: 18px;">
                                                                    @php
                                                                        $totalProduct = 0;
                                                                        $id_cart_products = explode(",", $order->id_cart_product);
                                                                        foreach ($id_cart_products as $id_cart_product) {
                                                                            foreach ($carts as $cart) {
                                                                                if($id_cart_product == $cart->id) {
                                                                                    $totalProduct += $cart->quantity_product;
                                                                                    foreach ($products as $product) {
                                                                                        if ($cart->id_product == $product->id) {
                                                                                            echo "<li>" . $product->name . "</li>";
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    @endphp
                                                                </ul>
                                                            </td>
                                                            <td>
                                                                {{ $totalProduct }}
                                                            </td>
                                                            <td>Chờ Lấy Hàng</td>
                                                            <td>
                                                                @foreach ($deliverys as $delivery)
                                                                    @if ($order->id_delivery == $delivery->id)
                                                                        {{ $delivery->name }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                <form action="{{ route('admin.order.handleCrudOrder') }}" method="post">
                                                                    {{ csrf_field() }}
                                                                    <input type="hidden" name="id" value="{{ $order->id }}">
                                                                    <div style="margin: 5px;">
                                                                        <button type="submit" name="button" value="shipping" style="width: 160px;" class="btn btn-primary btn-sm">Xác Nhận Giao Hàng</button>
                                                                    </div>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>

                            <div class="tab-pane" id="order-shipping">
                                <div class="box" style="border-top: none; box-shadow: none;">
                                    <div class="box-header" style="padding-bottom: 0;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p style="margin: 0;">{{ $countShipping }}</b> Đơn Hàng</p>
                                                <p style="margin: 0;">Hiện tại đang có <b>{{ $countShipping }}</b> Đơn Hàng trong hệ thống</p>
                                            </div>
                                            <div class="col-md-6 text-right">

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="table-order-shipping" class="table table-bordered dataTable">
                                            <thead>
                                                <tr data-toggle="modal">
                                                    <th style="width: 20%;">Sản phẩm</th>
                                                    <th style="width: 5%;">Tổng đơn</th>
                                                    <th style="width: 10%;">Trạng thái</th>
                                                    <th style="width: 15%;">Vận Chuyển</th>
                                                    <th style="width: 5%;">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orders as $order)
                                                    @if ($order->active == 2)
                                                        <tr>
                                                            <td colspan="4" style="font-weight: bold; background-color: #f7f8fa;">
                                                                {{ $order->name_customer }}
                                                            </td>
                                                            <td style="background-color: #f7f8fa;">Mã Đơn Hàng: <span><b>{{ $order->id }}</b></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <ul style="padding-left: 18px;">
                                                                    @php
                                                                        $totalProduct = 0;
                                                                        $id_cart_products = explode(",", $order->id_cart_product);
                                                                        foreach ($id_cart_products as $id_cart_product) {
                                                                            foreach ($carts as $cart) {
                                                                                if($id_cart_product == $cart->id) {
                                                                                    $totalProduct += $cart->quantity_product;
                                                                                    foreach ($products as $product) {
                                                                                        if ($cart->id_product == $product->id) {
                                                                                            echo "<li>" . $product->name . "</li>";
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    @endphp
                                                                </ul>
                                                            </td>
                                                            <td>
                                                                {{ $totalProduct }}
                                                            </td>
                                                            <td>Đang Giao Hàng</td>
                                                            <td>
                                                                @foreach ($deliverys as $delivery)
                                                                    @if ($order->id_delivery == $delivery->id)
                                                                        {{ $delivery->name }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                <form action="{{ route('admin.order.handleCrudOrder') }}" method="post">
                                                                    {{ csrf_field() }}
                                                                    <input type="hidden" name="id" value="{{ $order->id }}">
                                                                    <div style="margin: 5px;">
                                                                        <button type="submit" name="button" value="completed" style="width: 160px;" class="btn btn-primary btn-sm">Xác Nhận Đã Giao Hàng</button>
                                                                    </div>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>

                            <div class="tab-pane" id="order-completed">
                                <div class="box" style="border-top: none; box-shadow: none;">
                                    <div class="box-header" style="padding-bottom: 0;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p style="margin: 0;">{{ $countCompleted }}</b> Đơn Hàng</p>
                                                <p style="margin: 0;">Hiện tại đang có <b>{{ $countCompleted }}</b> Đơn Hàng trong hệ thống</p>
                                            </div>
                                            <div class="col-md-6 text-right">

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="table-order-completed" class="table table-bordered dataTable">
                                            <thead>
                                                <tr data-toggle="modal">
                                                    <th style="width: 20%;">Sản phẩm</th>
                                                    <th style="width: 5%;">Tổng đơn</th>
                                                    <th style="width: 10%;">Trạng thái</th>
                                                    <th style="width: 10%;">Vận Chuyển</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orders as $order)
                                                    @if ($order->active == 3)
                                                        <tr>
                                                            <td colspan="3" style="font-weight: bold; background-color: #f7f8fa;">
                                                                {{ $order->name_customer }}
                                                            </td>
                                                            <td style="background-color: #f7f8fa;">Mã Đơn Hàng: <span><b>{{ $order->id }}</b></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <ul style="padding-left: 18px;">
                                                                    @php
                                                                        $totalProduct = 0;
                                                                        $id_cart_products = explode(",", $order->id_cart_product);
                                                                        foreach ($id_cart_products as $id_cart_product) {
                                                                            foreach ($carts as $cart) {
                                                                                if($id_cart_product == $cart->id) {
                                                                                    $totalProduct += $cart->quantity_product;
                                                                                    foreach ($products as $product) {
                                                                                        if ($cart->id_product == $product->id) {
                                                                                            echo "<li>" . $product->name . "</li>";
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    @endphp
                                                                </ul>
                                                            </td>
                                                            <td>
                                                                {{ $totalProduct }}
                                                            </td>
                                                            <td>Đã Giao Hàng</td>
                                                            <td>
                                                                @foreach ($deliverys as $delivery)
                                                                    @if ($order->id_delivery == $delivery->id)
                                                                        {{ $delivery->name }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>

                            <div class="tab-pane" id="order-return">
                                <div class="box" style="border-top: none; box-shadow: none;">
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="table-order-toship" class="table table-bordered dataTable">
                                            <thead>
                                                <tr data-toggle="modal">
                                                    <th style="width: 20%;">Sản phẩm</th>
                                                    <th style="width: 5%;">Tổng đơn</th>
                                                    <th style="width: 10%;">Trạng thái</th>
                                                    <th style="width: 15%;">Vận Chuyển</th>
                                                    <th style="width: 15%;">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($returns as $return)
                                                <tr>
                                                    <td colspan="4" style="font-weight: bold; background-color: #f7f8fa;">
                                                        {{ $return->name_customer }}
                                                    </td>
                                                    <td style="background-color: #f7f8fa;">Mã Đơn Hàng: <span><b>{{ $return->id_order }}</b></span></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $return->name_product }}</td>
                                                    <td>{{ $return->quantity_product }}</td>
                                                    <td>
                                                        @if ($return->active == 1)
                                                            Chờ Xác Nhận Trả Hàng
                                                        @endif
                                                        @if ($return->active == 3)
                                                            Xác Nhận Đã Trả Hàng
                                                        @endif
                                                        @if ($return->active == 4)
                                                            Đã Trả Hàng và Hoàn Tiền
                                                        @endif
                                                    </td>
                                                    <td>{{ $return->name_delivery }}</td>
                                                    <td>
                                                        @if ($return->active == 1)
                                                            <form action="{{ route('admin.request.handleCrudRequest') }}" method="post">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="id" value="{{ $return->id }}">
                                                                <div style="margin: 5px;">
                                                                    <button type="submit" name="button" value="confirmReturnOrder" style="width: 160px;" class="btn btn-primary btn-sm">Xác Nhận Đã Trả Hàng</button>
                                                                </div>
                                                            </form>
                                                        @endif
                                                        @if ($return->active == 3)
                                                            <form action="{{ route('admin.request.handleCrudRequest') }}" method="post">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="id" value="{{ $return->id }}">
                                                                <div style="margin: 5px;">
                                                                    <button type="submit" name="button" value="confirmRefunded" style="width: 160px;" class="btn btn-primary btn-sm">Xác Nhận Đã Hoàn Tiền</button>
                                                                </div>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>

                            <div class="tab-pane" id="order-done">
                                <div class="box" style="border-top: none; box-shadow: none;">
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="table-order-toship" class="table table-bordered dataTable">
                                            <thead>
                                                <tr data-toggle="modal">
                                                    <th style="width: 20%;">Sản phẩm</th>
                                                    <th style="width: 5%;">Tổng đơn</th>
                                                    <th style="width: 10%;">Tiền</th>
                                                    <th style="width: 15%;">Vận Chuyển</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order_dones as $order_done)
                                                    <tr>
                                                        <td colspan="3" style="font-weight: bold; background-color: #f7f8fa;">
                                                            {{ $order_done->name_customer }}
                                                        </td>
                                                        <td style="background-color: #f7f8fa;">Mã Đơn Hàng: <span><b>{{ $order_done->id_order }}</b></span></td>
                                                    </tr>
                                                    <tr
                                                       @foreach ($return_orders as $return_order)
                                                            @if ($return_order->id_purchase == $order_done->id && $return_order->active == 4)
                                                                style="color: brown;"
                                                            @endif
                                                       @endforeach
                                                    >
                                                        <td>{{ $order_done->name_product }}</td>
                                                        <td>{{ $order_done->quantity_product }}</td>
                                                        <td>{{ number_format($order_done->total_price, 0) }} VND</td>
                                                        <td>{{ $order_done->name_delivery }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
