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
                        <li class="active">Yêu Cầu Trả Hàng</li>
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
                            <li class="active"><a href="#return-unpaid" data-toggle="tab">Chờ Xác Nhận</a></li>
                            <li><a href="#return-confirm" data-toggle="tab">Xác Nhận Trả Hàng</a></li>
                            <li><a href="#return-cancelled" data-toggle="tab">Từ Chối Trả Hàng</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="return-unpaid">
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
                                                @foreach ($returns as $return)
                                                    @if ($return->active == 0)
                                                        <tr>
                                                            <td colspan="4" style="font-weight: bold; background-color: #f7f8fa;">
                                                                {{ $return->name_customer }}
                                                            </td>
                                                            <td style="background-color: #f7f8fa;">Mã Đơn Hàng: <span><b>{{ $return->id_order }}</b></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{ $return->name_product }}</td>
                                                            <td>{{ $return->quantity_product }}</td>
                                                            <td>Chờ Xác Nhận</td>
                                                            <td>{{ $return->name_delivery }}</td>
                                                            <td>
                                                                <form action="{{ route('admin.request.handleCrudRequest') }}" method="post">
                                                                    {{ csrf_field() }}
                                                                    <input type="hidden" name="id" value="{{ $return->id }}">
                                                                    <div style="margin: 5px;">
                                                                        <button type="submit" name="button" value="confirmReturn" style="width: 160px;" class="btn btn-primary btn-sm">Xác Nhận Trả Hàng</button>
                                                                    </div>
                                                                    <div style="margin: 5px;">
                                                                        <button type="submit" name="button" value="cancelledReturn" style="width: 160px;" class="btn btn-danger btn-sm">Từ Chối Trả Hàng</button>
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

                            <div class="tab-pane" id="return-confirm">
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
                                        <table id="table-order-unpaid" class="table table-bordered dataTable">
                                            <thead>
                                                <tr data-toggle="modal">
                                                    <th style="width: 20%;">Sản phẩm</th>
                                                    <th style="width: 5%;">Tổng đơn</th>
                                                    <th style="width: 10%;">Trạng thái</th>
                                                    <th style="width: 15%;">Vận Chuyển</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($returns as $return)
                                                    @if ($return->active == 1)
                                                        <tr>
                                                            <td colspan="3" style="font-weight: bold; background-color: #f7f8fa;">
                                                                {{ $return->name_customer }}
                                                            </td>
                                                            <td style="background-color: #f7f8fa;">Mã Đơn Hàng: <span><b>{{ $return->id_order }}</b></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{ $return->name_product }}</td>
                                                            <td>{{ $return->quantity_product }}</td>
                                                            <td>Chờ Xác Nhận</td>
                                                            <td>{{ $return->name_delivery }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>

                            <div class="tab-pane" id="return-cancelled">
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
                                        <table id="table-order-unpaid" class="table table-bordered dataTable">
                                            <thead>
                                                <tr data-toggle="modal">
                                                    <th style="width: 20%;">Sản phẩm</th>
                                                    <th style="width: 5%;">Tổng đơn</th>
                                                    <th style="width: 10%;">Trạng thái</th>
                                                    <th style="width: 15%;">Vận Chuyển</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($returns as $return)
                                                    @if ($return->active == 2)
                                                        <tr>
                                                            <td colspan="3" style="font-weight: bold; background-color: #f7f8fa;">
                                                                {{ $return->name_customer }}
                                                            </td>
                                                            <td style="background-color: #f7f8fa;">Mã Đơn Hàng: <span><b>{{ $return->id_order }}</b></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{ $return->name_product }}</td>
                                                            <td>{{ $return->quantity_product }}</td>
                                                            <td>Chờ Xác Nhận</td>
                                                            <td>{{ $return->name_delivery }}</td>
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
