@extends('layouts.admin')

@section('title', 'Product Discount')

@section('active-product', 'active')

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
                    <ol class="breadcrumb"
                        style="background: white; margin-bottom: 0px; padding-top: 12px; padding-bottom: 12px;">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Trang Chủ</a></li>
                        <li class="active">Sản Phẩm Giảm Giá</li>
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
                            <li class="active"><a href="#discount-list" data-toggle="tab">Tất Cả</a></li>
                            <li><a href="#active-discount-list" data-toggle="tab">Đang Hoạt Động</a></li>
                            <li><a href="#sold-out-discount-list" data-toggle="tab">Không Hoạt Động</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="discount-list">
                                <div class="box" style="border-top: none; box-shadow: none;">
                                    <div class="box-header" style="padding-bottom: 0;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p style="margin: 0;"><b>{{ $countPrductDiscount }}</b> Sản Phẩm Giảm Giá</p>
                                                <p style="margin: 0;">Hiện tại đang có <b>{{ $countPrductDiscount }}</b> Sản Phẩm Giảm Giá trong hệ thống</p>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <div class="add-new">
                                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-add-new-discount"><i class="fa fa-fw fa-plus"></i> THÊM 1 SẢN PHẨM GIẢM GIÁ MỚI</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="table-discount-list" class="table table-bordered table-hover dataTable">
                                            <thead>
                                                <tr data-toggle="modal">
                                                    <th style="width: 3%;">ID</th>
                                                    <th style="width: 10%;">Sản Phẩm</th>
                                                    <th style="width: 5%;">Phần trăm</th>
                                                    <th style="width: 5%;">Số lượng</th>
                                                    <th style="width: 10%;">Thời gian bắt đầu</th>
                                                    <th style="width: 10%;">THời gian kết thúc</th>
                                                    <th style="width: 1%;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($product_discounts as $product_discount)
                                                    <tr onclick="ProductDiscountView('{{ $product_discount->id }}','{{ $product_discount->id_product }}','{{ $product_discount->percent_discount }}','{{ $product_discount->quantity }}','{{ $product_discount->time_start }}','{{ $product_discount->time_end }}','{{ $product_discount->active }}','{{ $product_discount->note }}','{{ $product_discount->created_at }}','{{ $product_discount->updated_at }}')"
                                                        data-toggle="modal" data-target="#modal-view-discount-list">
                                                        <td>{{ $product_discount->id }}</td>
                                                        <td>
                                                            @foreach ($products as $product)
                                                                @if ($product->id == $product_discount->id_product)
                                                                    {{ $product->name }}
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td>{{ $product_discount->percent_discount }}</td>
                                                        <td>{{ $product_discount->quantity }}</td>
                                                        <td>{{ $product_discount->time_start }}</td>
                                                        <td>{{ $product_discount->time_end }}</td>
                                                        <td style="text-align: center">
                                                            <input disabled="disabled" type="checkbox"  @if ($product_discount->active == 1) checked="checked" @endif>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>

                            <div class="tab-pane" id="active-discount-list">
                                <div class="box" style="border-top: none; box-shadow: none;">
                                    <div class="box-header" style="padding-bottom: 0;">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p style="margin: 0;"><b>{{ $countProductActive }}</b> Sản Phẩm Giảm Giá</p>
                                                <p style="margin: 0;">Hiện tại đang có <b>{{ $countProductActive }}</b> Sản Phẩm Giảm Giá đang hoạt động trong hệ thống</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="table-active-discount-list" class="table table-bordered table-hover dataTable">
                                            <thead>
                                                <tr data-toggle="modal">
                                                    <th style="width: 3%;">ID</th>
                                                    <th style="width: 10%;">Sản Phẩm</th>
                                                    <th style="width: 5%;">Phần trăm</th>
                                                    <th style="width: 5%;">Số lượng</th>
                                                    <th style="width: 10%;">Thời gian bắt đầu</th>
                                                    <th style="width: 10%;">THời gian kết thúc</th>
                                                    <th style="width: 1%;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($product_discounts as $product_discount)
                                                    @if ($product_discount->active == 1)
                                                        <tr onclick="ProductDiscountView('{{ $product_discount->id }}','{{ $product_discount->id_product }}','{{ $product_discount->percent_discount }}','{{ $product_discount->quantity }}','{{ $product_discount->time_start }}','{{ $product_discount->time_end }}','{{ $product_discount->active }}','{{ $product_discount->note }}','{{ $product_discount->created_at }}','{{ $product_discount->updated_at }}')"
                                                            data-toggle="modal" data-target="#modal-view-discount-list">
                                                            <td>{{ $product_discount->id }}</td>
                                                            <td>
                                                                @foreach ($products as $product)
                                                                    @if ($product->id == $product_discount->id_product)
                                                                        {{ $product->name }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>{{ $product_discount->percent_discount }}</td>
                                                            <td>{{ $product_discount->quantity }}</td>
                                                            <td>{{ $product_discount->time_start }}</td>
                                                            <td>{{ $product_discount->time_end }}</td>
                                                            <td style="text-align: center">
                                                                <input disabled="disabled" type="checkbox"  @if ($product_discount->active == 1) checked="checked" @endif>
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

                            <div class="tab-pane" id="sold-out-discount-list">
                                <div class="box" style="border-top: none; box-shadow: none;">
                                    <div class="box-header" style="padding-bottom: 0;">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p style="margin: 0;"><b>{{ $countProductHidden }}</b> Sản Phẩm Giảm Giá</p>
                                                <p style="margin: 0;">Hiện tại đang có <b>{{ $countProductHidden }}</b> Sản Phẩm Giảm Giá không hoạt động trong hệ thống</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="table-sold-out-discount-list" class="table table-bordered table-hover dataTable">
                                            <thead>
                                                <tr data-toggle="modal">
                                                    <th style="width: 3%;">ID</th>
                                                    <th style="width: 10%;">Sản Phẩm</th>
                                                    <th style="width: 5%;">Phần trăm</th>
                                                    <th style="width: 5%;">Số lượng</th>
                                                    <th style="width: 10%;">Thời gian bắt đầu</th>
                                                    <th style="width: 10%;">THời gian kết thúc</th>
                                                    <th style="width: 1%;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($product_discounts as $product_discount)
                                                    @if ($product_discount->active == 0)
                                                        <tr onclick="ProductDiscountView('{{ $product_discount->id }}','{{ $product_discount->id_product }}','{{ $product_discount->percent_discount }}','{{ $product_discount->quantity }}','{{ $product_discount->time_start }}','{{ $product_discount->time_end }}','{{ $product_discount->active }}','{{ $product_discount->note }}','{{ $product_discount->created_at }}','{{ $product_discount->updated_at }}')"
                                                            data-toggle="modal" data-target="#modal-view-discount-list">
                                                            <td>{{ $product_discount->id }}</td>
                                                            <td>
                                                                @foreach ($products as $product)
                                                                    @if ($product->id == $product_discount->id_product)
                                                                        {{ $product->name }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>{{ $product_discount->percent_discount }}</td>
                                                            <td>{{ $product_discount->quantity }}</td>
                                                            <td>{{ $product_discount->time_start }}</td>
                                                            <td>{{ $product_discount->time_end }}</td>
                                                            <td style="text-align: center">
                                                                <input disabled="disabled" type="checkbox"  @if ($product_discount->active == 1) checked="checked" @endif>
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

        <div class="modal fade" id="modal-add-new-discount">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.product.handleCrudProductDiscount') }}" method="POST" id="check-validate-1" onsubmit='return(validate("check-validate-1"));'>
                        {{ csrf_field() }}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">THÊM SẢN PHẨM GIẢM GIÁ MỚI</h4>
                        </div>

                        <div class="modal-body" style="padding-top: 5px;">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="checkbox" style="display: inline-block; margin-right: 10px;">
                                        <label>
                                            <input type="checkbox" name="active" value="1"> <b>HIỆN THỊ GIẢM GIÁ</b>
                                        </label>
                                    </div>
                                    <hr style="margin: 0px; margin-bottom: 10px;">
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Sản phẩm giảm giá</label>
                                        <select class="form-control" name="id_product">
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Số lượng</label>
                                        <input type="text" class="form-control" name="quantity"
                                            placeholder="Nhập số lượng sản phẩm">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Phần trăm</label>
                                        <input type="text" class="form-control" name="percent_discount"
                                            placeholder="Nhập phần trăm giảm giá">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Thời gian bắt đầu</label>
                                        <input type="date" class="form-control" name="time_start">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Thời gian kết thúc</label>
                                        <input type="date" class="form-control" name="time_end">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Ghi chú</label>
                                        <textarea class="form-control" name="note" rows="5" cols="80"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Thoát</button>
                            <button type="submit" class="btn btn-success" name="button" value="create">Thêm sản phẩm giảm giá mới</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="modal-view-discount-list">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.product.handleCrudProductDiscount') }}" method="POST" id="check-validate-2" onsubmit='return(validate("check-validate-2"));'>
                        {{ csrf_field() }}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">THÔNG TIN CHI TIẾT</h4>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="checkbox" style="display: inline-block; margin-right: 10px;">
                                        <label>
                                            <input type="checkbox" id="active_view" name="active" value="1">
                                            <b>HIỆN THỊ GIẢM GIÁ</b>
                                        </label>
                                    </div>
                                    <hr style="margin: 0px; margin-bottom: 10px;">
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="id_view" name="id">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Sản phẩm giảm giá</label>
                                        <select class="form-control" id="id_product_view" name="id_product">
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Số lượng</label>
                                        <input type="text" class="form-control" id="quantity_view" name="quantity">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phần trăm</label>
                                        <input type="text" class="form-control" id="percent_discount_view" name="percent_discount">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Thời gian bắt đầu</label>
                                        <input type="date" class="form-control" id="time_start_view" name="time_start">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Thời gian kết thúc</label>
                                        <input type="date" class="form-control" id="time_end_view" name="time_end">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Ghi chú</label>
                                        <textarea class="form-control" id="note_view" name="note" rows="5" cols="80"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Thời gian cập nhật</label>
                                        <input type="text" class="form-control" id="created_at_view" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Thời gian cập nhật</label>
                                        <input type="text" class="form-control" id="updated_at_view" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Thoát</button>
                            <button type="submit" class="btn btn-primary" name="button" value="update">Chỉnh Sửa</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
@endsection
