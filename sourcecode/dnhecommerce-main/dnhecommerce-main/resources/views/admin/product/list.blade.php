@extends('layouts.admin')

@section('title', 'Product')

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
                        <li class="active">Danh Sách Sản Phẩm</li>
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
                            <li class="active"><a href="#product-list" data-toggle="tab">Tất Cả</a></li>
                            <li><a href="#product-list-sold-out" data-toggle="tab">Hết Hàng</a></li>
                            <li><a href="#trash-product-list" data-toggle="tab">Thùng Rác (Bị Ẩn)</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="product-list">
                                <div class="box" style="border-top: none; box-shadow: none;">
                                    <div class="box-header" style="padding-bottom: 0;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p style="margin: 0;"><b>{{ $countProduct }}</b> Sản Phẩm</p>
                                                <p style="margin: 0;">Hiện tại đang có <b>{{ $countProduct }}</b> sản phẩm trong hệ thống</p>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <a href="{{ route('admin.product.createProduct') }}" class="btn btn-success btn-sm"><i class="fa fa-fw fa-plus"></i> THÊM 1 SẢN PHẨM MỚI</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="table-product-list" class="table table-bordered table-hover dataTable">
                                            <thead>
                                                <tr>
                                                    <th style="width: 3%;">ID</th>
                                                    <th style="width: 20%;">Tên sản phẩm</th>
                                                    <th style="width: 10%;">Nhóm thể loại</th>
                                                    <th style="width: 5%;">Giá nhập</th>
                                                    <th style="width: 5%;">Giá bán</th>
                                                    <th style="width: 5%;">Số lượng thực</th>
                                                    <th style="width: 5%;">Lượt xem</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($products as $product)
                                                    @if ($product->active == 1)
                                                        <tr onclick="ProductView('{{ $product->id }}','{{ $product->id_supplier }}','{{ $product->id_tax }}','{{ $product->id_category }}','{{ $product->id_related }}','{{ $product->name }}','{{ $product->image }}','{{ $product->quantity }}','{{ $product->cost }}','{{ $product->price }}','{{ $product->viewed }}','{{ $product->active_sale }}','{{ $product->active_purchase }}','{{ $product->note }}','{{ $product->created_at }}','{{ $product->updated_at }}');"
                                                        data-toggle="modal" data-target="#modal-view-product-list">
                                                            <td>{{ $product->id }}</td>
                                                            <td>{{ $product->name }}</td>
                                                            <td>
                                                                @foreach ($categorys as $category)
                                                                    @if ($category->id == $product->id_category)
                                                                        {{ $category->name }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>{{ number_format($product->cost, 0) }} VND</td>
                                                            <td>{{ number_format($product->price, 0) }} VND</td>
                                                            <td>{{ $product->quantity }}</td>
                                                            <td>{{ $product->viewed }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>

                            <div class="tab-pane" id="product-list-sold-out">
                                <div class="box" style="border-top: none; box-shadow: none;">
                                    <div class="box-header" style="padding-bottom: 0;">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p style="margin: 0;"><b>{{ $countProductSoldOut }}</b> Sản Phẩm</p>
                                                <p style="margin: 0;">Hiện tại đang có <b>{{ $countProductSoldOut }}</b> sản phẩm đang hết hàng trong hệ thống</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="table-product-list-sold-out" class="table table-bordered table-hover dataTable">
                                            <thead>
                                                <tr>
                                                    <th style="width: 3%;">ID</th>
                                                    <th style="width: 20%;">Tên sản phẩm</th>
                                                    <th style="width: 10%;">Nhóm thể loại</th>
                                                    <th style="width: 5%;">Giá nhập</th>
                                                    <th style="width: 5%;">Giá bán</th>
                                                    <th style="width: 5%;">Số lượng thực</th>
                                                    <th style="width: 5%;">Lượt xem</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($products as $product)
                                                    @if ($product->quantity == 0 && $product->active == 1)
                                                        <tr onclick="ProductView('{{ $product->id }}','{{ $product->id_supplier }}','{{ $product->id_tax }}','{{ $product->id_category }}','{{ $product->id_related }}','{{ $product->name }}','{{ $product->image }}','{{ $product->quantity }}','{{ $product->cost }}','{{ $product->price }}','{{ $product->viewed }}','{{ $product->active_sale }}','{{ $product->active_purchase }}','{{ $product->note }}','{{ $product->created_at }}','{{ $product->updated_at }}');"
                                                        data-toggle="modal" data-target="#modal-view-product-list">
                                                            <td>{{ $product->id }}</td>
                                                            <td>{{ $product->name }}</td>
                                                            <td>
                                                                @foreach ($categorys as $category)
                                                                    @if ($category->id == $product->id_category)
                                                                        {{ $category->name }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>{{ number_format($product->cost, 0) }} VND</td>
                                                            <td>{{ number_format($product->price, 0) }} VND</td>
                                                            <td>{{ $product->quantity }}</td>
                                                            <td>{{ $product->viewed }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>

                            <div class="tab-pane" id="trash-product-list">
                                <div class="box" style="border-top: none; box-shadow: none;">
                                    <div class="box-header" style="padding-bottom: 0;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p style="margin: 0;"><b>{{ $countProductHidden }}</b> Sản Phẩm </p>
                                                <p style="margin: 0;">Hiện tại đang có <b>{{ $countProductHidden }}</b> Sản Phẩm bị xóa (Bị Ẩn) trong hệ thống</p>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <form action="{{ route('admin.product.handleCrudProduct') }}" method="post">
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger btn-sm" name="button" value="deleteAll"><i class="fa fa-fw fa-trash"></i> XÓA TẤT CẢ VĨNH VIỄN</button>
                                                    <button type="submit" class="btn btn-primary btn-sm" name="button" value="restoreAll"><i class="fa fa-fw fa-refresh"></i> KHÔI PHỤC TẤT CẢ</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="table-trash-product-list" class="table table-bordered table-hover dataTable">
                                            <thead>
                                                <tr>
                                                    <th style="width: 3%;">ID</th>
                                                    <th style="width: 15%;">Tên sản phẩm</th>
                                                    <th style="width: 10%;">Nhóm thể loại</th>
                                                    <th style="width: 5%;">Giá nhập</th>
                                                    <th style="width: 5%;">Giá bán</th>
                                                    <th style="width: 5%;">Số lượng thực</th>
                                                    <th style="width: 5%;">Lượt xem</th>
                                                    <th style="width: 1%;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($products as $product)
                                                    @if ($product->active == 0)
                                                        <tr>
                                                            <td>{{ $product->id }}</td>
                                                            <td>{{ $product->name }}</td>
                                                            <td>
                                                                @foreach ($categorys as $category)
                                                                    @if ($category->id == $product->id_category)
                                                                        {{ $category->name }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>{{ number_format($product->cost, 0) }} VND</td>
                                                            <td>{{ number_format($product->price, 0) }} VND</td>
                                                            <td>{{ $product->quantity }}</td>
                                                            <td>{{ $product->viewed }}</td>
                                                            <td>
                                                                <form action="{{ route('admin.product.handleCrudProduct') }}" method="post">
                                                                    {{ csrf_field() }}
                                                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                                                    <button type="submit" name="button" value="delete" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-trash"></i></button>
                                                                    <button type="submit" name="button" value="restore" class="btn btn-block btn-primary btn-xs"><i class="fa fa-fw fa-refresh"></i></button>
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
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-view-product-list">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('admin.product.handleCrudProduct') }}" enctype="multipart/form-data" method="POST" id="check-validate-1" onsubmit='return(validate("check-validate-1"));'>
                            {{ csrf_field() }}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">THÔNG TIN CHI TIẾT</h4>
                            </div>

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Mã sản phẩm</label>
                                            <input type="text" class="form-control" id="id_view_1" name="id" disabled="disabled">
                                            <input type="hidden" class="form-control" id="id_view_2" name="id">
                                        </div>
                                    </div>

                                    <div class="col-md-12" style="margin-bottom: 10px;">
                                        <div class="checkbox" style="display: inline-block; margin-right: 10px;">
                                            <label><input type="checkbox" id="active_sale_view" name="active_sale" value="1"> Sản phẩm bán được</label>
                                        </div>
                                        <div class="checkbox" style="display: inline-block; margin-right: 10px;">
                                            <label><input type="checkbox" id="active_purchase_view" name="active_purchase" value="1"> Sản phẩm mua được</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="nav-tabs-custom">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a href="#info-item" data-toggle="tab">Thông Tin Chung</a></li>
                                                <li><a href="#accounting" data-toggle="tab">Kế Toán</a></li>
                                            </ul>

                                            <div class="tab-content">
                                                <div class="tab-pane active" id="info-item">
                                                    <div class="box-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="">Tên sản phẩm</label>
                                                                            <input type="text" class="form-control" id="name_view" name="name" placeholder="Nhập tên sản phẩm">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="">Hình ảnh</label>
                                                                            <input type="file" name="image[]" id="images_view" multiple>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12" id="divImgProducShow">
                                                                        <div class="form-group" id="imgProducShow"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>Nhà cung cấp sản phẩm</label>
                                                                            <select class="form-control" id="id_supplier_view" name="id_supplier">
                                                                                @foreach ($suppliers as $supplier)
                                                                                    <option
                                                                                        value="{{ $supplier->id }}">
                                                                                        {{ $supplier->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>Thể loại sản phẩm</label>
                                                                            <select class="form-control" id="id_category_view" name="id_category">
                                                                                @foreach ($categorys as $category)
                                                                                    <option value="{{ $category->id }}">
                                                                                        {{ $category->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>Danh mục sản phẩm liên quan</label>
                                                                            <select class="form-control" id="id_related_view" name="id_related">
                                                                                @foreach ($relateds as $related)
                                                                                    <option value="{{ $related->id }}">
                                                                                        {{ $related->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane" id="accounting">
                                                    <div class="box-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Số lượng sản phẩm</label>
                                                                    <input type="text" class="form-control" id="quantity_view" name="quantity" placeholder="Nhập số lượng sản phẩm">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">Giá sản phẩm nhập vào</label>
                                                                    <input type="text" class="form-control" id="cost_view" name="cost" placeholder="Nhập giá sản phẩm nhập vào">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">Giá sản phẩm bán ra</label>
                                                                    <input type="text" class="form-control" id="price_view" name="price" placeholder="Nhập giá sản phẩm bán ra">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Thuế sản phẩm</label>
                                                                    <select class="form-control" id="id_tax_view" name="id_tax">
                                                                        @foreach ($taxs as $tax)
                                                                            <option value="{{ $tax->id }}">
                                                                                {{ $tax->name }} - {{ $tax->value }}%
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Ghi chú nội bộ</label>
                                            <textarea class="form-control" id="note_view" name="note" rows="2" cols="80"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Thời gian tạo</label>
                                            <input type="text" class="form-control" id="created_at_view" name="created_at" disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Thời gian cập nhật</label>
                                            <input type="text" class="form-control" id="updated_at_view" name="updated_at" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Thoát</button>
                                <button type="submit" class="btn btn-danger" name="button" value="trash">Thùng Rác</button>
                                <button type="submit" class="btn btn-primary" name="button" value="update">Chỉnh Sửa</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </section>
    </div>
@endsection
