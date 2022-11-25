@extends('layouts.admin')

@section('title', 'Color')

@section('active-attributes', 'active')

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
                        <li class="active">Màu Sắc Sản Phẩm</li>
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
                            <li class="active"><a href="#color-list" data-toggle="tab">Tất Cả</a></li>
                            <li><a href="#trash-color-list" data-toggle="tab">Bị Ẩn (Thùng Rác)</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="color-list">
                                <div class="box" style="border-top: none; box-shadow: none;">
                                    <div class="box-header" style="padding-bottom: 0;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p style="margin: 0;"><b>{{ $countActive }}</b> Màu Sắc</p>
                                                <p style="margin: 0;">Hiện tại đang có <b>{{ $countActive }}</b> Màu Sắc trong hệ thống
                                                </p>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-add-new-color"><i class="fa fa-fw fa-plus"></i> THÊM 1 MÀU SẮC MỚI</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="table-color-list" class="table table-bordered table-hover dataTable">
                                            <thead>
                                                <tr data-toggle="modal">
                                                    <th style="width: 3%;">ID</th>
                                                    <th style="width: 20%;">Sản phẩm</th>
                                                    <th style="width: 10%;">Tên màu</th>
                                                    <th style="width: 10%;">Giá cộng thêm</th>
                                                    <th style="width: 5%;">Mã màu</th>
                                                    <th style="width: 5%;">Số lượng</th>
                                                    <th style="width: 10%;">Ghi chú</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($colors as $color)
                                                    @if ($color->active == 1)
                                                        <tr onclick="ColorView('{{ $color->id }}','{{ $color->id_product }}','{{ $color->name }}','{{ $color->color_code }}','{{ $color->quantity }}','{{ $color->price }}','{{ $color->note }}','{{ $color->active }}','{{ $color->created_at }}','{{ $color->updated_at }}')"
                                                            data-toggle="modal" data-target="#modal-view-color-list">
                                                            <td>{{ $color->id }}</td>
                                                            <td>
                                                                @foreach ($products as $product)
                                                                    @if ($product->id == $color->id_product)
                                                                        {{ $product->name }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>{{ $color->name }}</td>
                                                            <td>{{ $color->price }}</td>
                                                            <td><small class="label" style="background-color: {{ $color->color_code }}">{{ $color->color_code }}</small></td>
                                                            <td>{{ $color->quantity }}</td>
                                                            <td>{{ $color->note }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>

                            <div class="tab-pane" id="trash-color-list">
                                <div class="box" style="border-top: none; box-shadow: none;">
                                    <div class="box-header" style="padding-bottom: 0;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p style="margin: 0;"><b>{{ $countHidden }}</b> Màu Sắc</p>
                                                <p style="margin: 0;">Hiện tại đang có <b>{{ $countHidden }}</b> Màu Sắc bị ẩn (xóa) trong hệ thống
                                                </p>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <form action="{{ route('admin.attributes.handleCrudColorAttribute') }}" method="post">
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger btn-sm" name="button" value="deleteAll"><i class="fa fa-fw fa-trash"></i> XÓA TẤT CẢ VĨNH VIỄN</button>
                                                    <button type="submit" class="btn btn-primary btn-sm" name="button" value="restoreAll"><i class="fa fa-fw fa-refresh"></i> KHÔI PHỤC TẤT CẢ</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="table-trash-size-list" class="table table-bordered table-hover dataTable">
                                            <thead>
                                                <tr data-toggle="modal">
                                                    <th style="width: 3%;">ID</th>
                                                    <th style="width: 20%;">Sản phẩm</th>
                                                    <th style="width: 10%;">Tên màu</th>
                                                    <th style="width: 10%;">Giá cộng thêm</th>
                                                    <th style="width: 5%;">Mã màu</th>
                                                    <th style="width: 5%;">Số lượng</th>
                                                    <th style="width: 10%;">Ghi chú</th>
                                                    <th style="width: 1%;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($colors as $color)
                                                    @if ($color->active == 0)
                                                        <tr>
                                                            <td>{{ $color->id }}</td>
                                                            <td>
                                                                @foreach ($products as $product)
                                                                    @if ($product->id == $color->id_product)
                                                                        {{ $product->name }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>{{ $color->name }}</td>
                                                            <td>{{ $color->price }}</td>
                                                            <td><small class="label" style="background-color: {{ $color->color_code }}">{{ $color->color_code }}</small></td>
                                                            <td>{{ $color->quantity }}</td>
                                                            <td>{{ $color->note }}</td>
                                                            <td>
                                                                <form action="{{ route('admin.attributes.handleCrudColorAttribute') }}" method="post">
                                                                    {{ csrf_field() }}
                                                                    <input type="hidden" name="id" value="{{ $color->id }}">
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

            <div class="modal fade" id="modal-add-new-color">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <form action="{{ route('admin.attributes.handleCrudColorAttribute') }}" method="POST" id="check-validate-1" onsubmit='return(validate("check-validate-1"));'>
                            {{ csrf_field() }}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">THÊM MÀU SẮC MỚI</h4>
                            </div>

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Sản phẩm</label>
                                            <select class="form-control" name="id_product">
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Tên màu</label>
                                            <input type="text" class="form-control" name="name" placeholder="Nhập tên màu">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Mã màu</label>
                                            <div class="input-group my-colorpicker2">
                                              <input type="text" class="form-control" name="color_code" placeholder="Nhập mã màu">
                                              <div class="input-group-addon">
                                                <i></i>
                                              </div>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Giá cộng thêm</label>
                                            <input type="text" class="form-control" name="price" value="0" placeholder="Nhập số tiền cộng thêm">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Số lượng</label>
                                            <input type="text" class="form-control" name="quantity" placeholder="Nhập số lượng sản phẩm">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Ghi chú</label>
                                            <textarea class="form-control" name="note" rows="5" cols="80"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-right">
                                        <hr style="margin: 0px; margin-top: 10px;">
                                        <div class="checkbox" style="display: inline-block; margin-right: 5px;">
                                            <label>
                                                <input type="checkbox" name="active" value="1"> <b> HIỆN THỊ MÀU SẮC</b>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Thoát</button>
                                <button type="submit" class="btn btn-success" name="button" value="create">Thêm màu sắc mới</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            <div class="modal fade" id="modal-view-color-list">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('admin.attributes.handleCrudColorAttribute') }}" method="POST" id="check-validate-2" onsubmit='return(validate("check-validate-2"));'>
                            {{ csrf_field() }}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">THÔNG TIN CHI TIẾT</h4>
                            </div>
                            <div class="modal-body" style="padding-bottom: 0px;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="id_view" name="id">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Sản phẩm</label>
                                            <select class="form-control" id="id_product_view" name="id_product">
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Tên màu</label>
                                            <input type="text" class="form-control" id="name_view" name="name" placeholder="Nhập tên màu">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Mã màu</label>
                                            <div class="input-group my-colorpicker2">
                                                <input type="text" class="form-control" id="color_code_view" name="color_code" placeholder="Nhập mã màu">
                                                <div class="input-group-addon">
                                                    <i id="color_view"></i>
                                                </div>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Giá cộng thêm</label>
                                            <input type="text" class="form-control" id="price_view" name="price">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Số lượng</label>
                                            <input type="text" class="form-control" id="quantity_view" name="quantity">
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
                                            <label for="">Thời gian tạo</label>
                                            <input type="text" class="form-control" id="created_at_view"
                                                name="created_at" disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Thời gian cập nhật</label>
                                            <input type="text" class="form-control" id="updated_at_view" name="updated_at" disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-right">
                                        <hr style="margin: 0px; margin-top: 10px;">
                                        <div class="checkbox" style="display: inline-block; margin-right: 0px;">
                                            <label>
                                                <input type="checkbox" id="active_view" name="active" value="1" disabled="disabled"> <b> HIỆN THỊ MÀU SẮC</b>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Thoát</button>
                                <button type="submit" class="btn btn-danger" name="button" value="trash">Ẩn Color</button>
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
