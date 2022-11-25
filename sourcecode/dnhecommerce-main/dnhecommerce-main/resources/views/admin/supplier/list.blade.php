@extends('layouts.admin')

@section('title', 'Supplier')

@section('active-supplier', 'active')

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
                        <li class="active">Quản Lý Nhà Cung Cấp</li>
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
                            <li class="active"><a href="#supplier-list" data-toggle="tab">Tất Cả</a></li>
                            <li><a href="#trash-supplier-list" data-toggle="tab">Thùng Rác</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="supplier-list">
                                <div class="box" style="border-top: none; box-shadow: none;">
                                    <div class="box-header" style="padding-bottom: 0;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p style="margin: 0;"><b>{{ $countActive }}</b> Nhà Cung Cấp</p>
                                                <p style="margin: 0;">Hiện tại đang có <b>{{ $countActive }}</b> Nhà Cung Cấp trong hệ thống</p>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-add-new-supplier"><i class="fa fa-fw fa-plus"></i> THÊM 1 NHÀ CUNG CẤP MỚI</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="table-supplier-list" class="table table-bordered table-hover dataTable">
                                            <thead>
                                                <tr data-toggle="modal">
                                                    <th style="width: 3%;">ID</th>
                                                    <th style="width: 10%;">Nhà cung cấp</th>
                                                    <th style="width: 10%;">Số điện thoại</th>
                                                    <th style="width: 10%;">Email</th>
                                                    <th style="width: 20%;">Địa chỉ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($suppliers as $supplier)
                                                    @if ($supplier->active == 1)
                                                        <tr onclick="SupplierView('{{ $supplier->id }}','{{ $supplier->name }}','{{ $supplier->phone }}','{{ $supplier->email }}','{{ $supplier->address }}','{{ $supplier->bank_name }}','{{ $supplier->bank_number }}','{{ $supplier->note }}','{{ $supplier->created_at }}','{{ $supplier->updated_at }}')"
                                                            data-toggle="modal" data-target="#modal-view-supplier-list">
                                                            <td>{{ $supplier->id }}</td>
                                                            <td>{{ $supplier->name }}</td>
                                                            <td>{{ $supplier->phone }}</td>
                                                            <td>{{ $supplier->email }}</td>
                                                            <td>{{ $supplier->address }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>

                            <div class="tab-pane" id="trash-supplier-list">
                                <div class="box" style="border-top: none; box-shadow: none;">
                                    <div class="box-header" style="padding-bottom: 0;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p style="margin: 0;"><b>{{ $countHidden }}</b> Nhà Cung Cấp</p>
                                                <p style="margin: 0;">Hiện tại đang có <b>{{ $countHidden }}</b> Nhà Cung Cấp bị xóa trong hệ thống</p>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <form action="{{ route('admin.supplier.handleCrudSupplier') }}" method="post">
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger btn-sm" name="button" value="deleteAll"><i class="fa fa-fw fa-trash"></i> XÓA TẤT CẢ VĨNH VIỄN</button>
                                                    <button type="submit" class="btn btn-primary btn-sm" name="button" value="restoreAll"><i class="fa fa-fw fa-refresh"></i> KHÔI PHỤC TẤT CẢ</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="table-trash-supplier-list" class="table table-bordered table-hover dataTable">
                                            <thead>
                                                <tr>
                                                    <th style="width: 3%;">ID</th>
                                                    <th style="width: 10%;">Nhà cung cấp</th>
                                                    <th style="width: 10%;">Số điện thoại</th>
                                                    <th style="width: 10%;">Email</th>
                                                    <th style="width: 20%;">Địa chỉ</th>
                                                    <th style="width: 1%;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($suppliers as $supplier)
                                                    @if ($supplier->active == 0)
                                                        <tr>
                                                            <td>{{ $supplier->id }}</td>
                                                            <td>{{ $supplier->name }}</td>
                                                            <td>{{ $supplier->phone }}</td>
                                                            <td>{{ $supplier->email }}</td>
                                                            <td>{{ $supplier->address }}</td>
                                                            <td>
                                                                <form action="{{ route('admin.supplier.handleCrudSupplier') }}" method="post">
                                                                    {{ csrf_field() }}
                                                                    <input type="hidden" name="id" value="{{ $supplier->id }}">
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

            <div class="modal fade" id="modal-add-new-supplier">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('admin.supplier.handleCrudSupplier') }}" method="POST" id="check-validate-1" onsubmit='return(validate("check-validate-1"));'>
                            {{ csrf_field() }}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">THÊM NHÀ CUNG CẤP MỚI</h4>
                            </div>

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Nhà cung cấp</label>
                                            <input type="text" class="form-control" name="name" placeholder="Nhập tên nhà cung cấp">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Số điện thoại</label>
                                            <input type="text" class="form-control" name="phone" placeholder="Nhập số điện thoại">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="text" class="form-control" name="email" placeholder="Nhập địa chỉ email">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Địa chỉ</label>
                                            <input type="text" class="form-control" name="address" placeholder="Nhập địa chỉ nhà cung cấp">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Tên ngân hàng</label>
                                            <input type="text" class="form-control" name="bank_name" placeholder="Nhập tên ngân hàng">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Số tài khoản</label>
                                            <input type="text" class="form-control" name="bank_number" placeholder="Nhập số tài khoản">
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
                                <button type="submit" class="btn btn-success" name="button" value="create">Thêm nhà cung cấp mới</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            <div class="modal fade" id="modal-view-supplier-list">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('admin.supplier.handleCrudSupplier') }}" method="POST" id="check-validate-2" onsubmit='return(validate("check-validate-2"));'>
                            {{ csrf_field() }}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">THÔNG TIN CHI TIẾT</h4>
                            </div>

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">ID</label>
                                            <input type="text" class="form-control" id="id_view_1" name="id"
                                                disabled="disabled">
                                            <input type="hidden" class="form-control" id="id_view_2" name="id">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Nhà cung cấp</label>
                                            <input type="text" class="form-control" id="name_view" name="name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Số điện thoại</label>
                                            <input type="text" class="form-control" id="phone_view" name="phone">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="text" class="form-control" id="email_view" name="email">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Địa chỉ</label>
                                            <input type="text" class="form-control" id="address_view" name="address">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Tên ngân hàng</label>
                                            <input type="text" class="form-control" id="bank_name_view" name="bank_name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Số tài khoản</label>
                                            <input type="text" class="form-control" id="bank_number_view" name="bank_number">
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
                                            <input type="text" class="form-control" id="created_at_view" name="phone" disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Thời gian cập nhật</label>
                                            <input type="text" class="form-control" id="updated_at_view" name="email" disabled="disabled">
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
