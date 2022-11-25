@extends('layouts.admin')

@section('title', 'Request')

@section('active-request', 'active')

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
                        <li class="active">Yêu Cầu Đơn Hàng</li>
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
                            <li class="active"><a href="#order-unpaid" data-toggle="tab">Chờ Xác Nhận</a></li>
                            <li><a href="#order-confirm" data-toggle="tab">Đơn Đã Xác Nhận</a></li>
                            <li><a href="#order-cancelled" data-toggle="tab">Đơn Bị Hủy</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="order-unpaid">
                                <div class="box" style="border-top: none; box-shadow: none;">
                                    <div class="box-header" style="padding-bottom: 0;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p style="margin: 0;">{{ $countUnpaid }}</b> Đơn Hàng</p>
                                                <p style="margin: 0;">Hiện tại đang có <b>{{ $countUnpaid }}</b> Đơn Hàng trong hệ thống</p>
                                            </div>
                                            <div class="col-md-6 text-right">

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="table-order-unpaid" class="table table-bordered dataTable">
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
                                                    @if ($order->active == 0)
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
                                                            <td>Chờ Xác Nhận</td>
                                                            <td>
                                                                @foreach ($deliverys as $delivery)
                                                                    @if ($order->id_delivery == $delivery->id)
                                                                        {{ $delivery->name }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                <form action="{{ route('admin.request.handleCrudRequest') }}" method="post">
                                                                    {{ csrf_field() }}
                                                                    <input type="hidden" name="id" value="{{ $order->id }}">
                                                                    <div style="margin: 5px;">
                                                                        <button type="submit" name="button" value="confirmOrder" style="width: 160px;" class="btn btn-primary btn-sm">Xác Nhận Đơn Hàng</button>
                                                                    </div>
                                                                    <div style="margin: 5px;">
                                                                        <button type="submit" name="button" value="cancelledOrder" style="width: 160px;" class="btn btn-danger btn-sm">Hủy Đơn Hàng</button>
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

                            <div class="tab-pane" id="order-confirm">
                                <div class="box" style="border-top: none; box-shadow: none;">
                                    <div class="box-header" style="padding-bottom: 0;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p style="margin: 0;">{{ $countConfirm }}</b> Đơn Hàng</p>
                                                <p style="margin: 0;">Hiện tại đang có <b>{{ $countConfirm }}</b> Đơn Hàng trong hệ thống</p>
                                            </div>
                                            <div class="col-md-6 text-right">

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="table-order-cancelled" class="table table-bordered dataTable">
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
                                                    @if ($order->active != 4 && $order->active != 0)
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
                                                        <td>Đơn Hàng Đã Xác Nhận</td>
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

                            <div class="tab-pane" id="order-cancelled">
                                <div class="box" style="border-top: none; box-shadow: none;">
                                    <div class="box-header" style="padding-bottom: 0;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p style="margin: 0;">{{ $countCancelled }}</b> Đơn Hàng</p>
                                                <p style="margin: 0;">Hiện tại đang có <b>{{ $countCancelled }}</b> Đơn Hàng trong hệ thống</p>
                                            </div>
                                            <div class="col-md-6 text-right">

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="table-order-cancelled" class="table table-bordered dataTable">
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
                                                    @if ($order->active == 4)
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
                                                        <td>Đơn Hàng Đã Hủy</td>
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
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
