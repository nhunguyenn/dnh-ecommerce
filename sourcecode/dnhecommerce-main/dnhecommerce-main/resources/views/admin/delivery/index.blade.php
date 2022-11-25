@extends('layouts.admin')

@section('title', 'Delivery')

@section('active-delivery', 'active')

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
                        <li class="active">Quản Lý Đơn Vị Vận Chuyển</li>
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
                            <li class="active"><a href="#delivery-list" data-toggle="tab">Tất Cả</a></li>
                            <li><a href="#trash-delivery-list" data-toggle="tab">Thùng Rác</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="delivery-list">
                                <div class="box" style="border-top: none; box-shadow: none;">
                                    <div class="box-header" style="padding-bottom: 0;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p style="margin: 0;"><b>{{ $countActive }}</b> Đơn Vị Vận Chuyển</p>
                                                <p style="margin: 0;">Hiện tại đang có <b>{{ $countActive }}</b> Đơn Vị Vận Chuyển trong hệ thống</p>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-add-new-delivery"><i class="fa fa-fw fa-plus"></i> THÊM 1 ĐƠN VỊ VẬN CHUYỂN MỚI</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="table-delivery-list" class="table table-bordered table-hover dataTable">
                                            <thead>
                                                <tr data-toggle="modal">
                                                    <th style="width: 3%;">ID</th>
                                                    <th style="width: 10%;">Đợn vị</th>
                                                    <th style="width: 10%;">Số điện thoại</th>
                                                    <th style="width: 10%;">Giá vận chuyển</th>
                                                    <th style="width: 20%;">Ghi chú</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($deliverys as $delivery)
                                                    @if ($delivery->active == 1)
                                                        <tr onclick="DeliveryView('{{ $delivery->id }}','{{ $delivery->name }}','{{ $delivery->phone }}','{{ $delivery->price }}','{{ $delivery->note }}','{{ $delivery->created_at }}','{{ $delivery->updated_at }}')" data-toggle="modal" data-target="#modal-view-delivery-list">
                                                            <td>{{ $delivery->id }}</td>
                                                            <td>{{ $delivery->name }}</td>
                                                            <td>{{ $delivery->phone }}</td>
                                                            <td>{{ number_format($delivery->price, 0) }} VNĐ</td>
                                                            <td>{{ $delivery->note }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>

                            <div class="tab-pane" id="trash-delivery-list">
                                <div class="box" style="border-top: none; box-shadow: none;">
                                    <div class="box-header" style="padding-bottom: 0;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p style="margin: 0;"><b>{{ $countHidden }}</b> Đơn Vị Vận Chuyển</p>
                                                <p style="margin: 0;">Hiện tại đang có <b>{{ $countHidden }}</b> Đơn Vị Vận Chuyển bị xóa trong hệ thống</p>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <form action="{{ route('admin.delivery.handleCrudDelivery') }}" method="post">
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger btn-sm" name="button" value="deleteAll"><i class="fa fa-fw fa-trash"></i> XÓA TẤT CẢ VĨNH VIỄN</button>
                                                    <button type="submit" class="btn btn-primary btn-sm" name="button" value="restoreAll"><i class="fa fa-fw fa-refresh"></i> KHÔI PHỤC TẤT CẢ</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="table-trash-delivery-list" class="table table-bordered table-hover dataTable">
                                            <thead>
                                                <tr data-toggle="modal">
                                                    <th style="width: 3%;">ID</th>
                                                    <th style="width: 10%;">Đợn vị</th>
                                                    <th style="width: 10%;">Số điện thoại</th>
                                                    <th style="width: 10%;">Giá vận chuyển</th>
                                                    <th style="width: 20%;">Ghi chú</th>
                                                    <th style="width: 1%;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($deliverys as $delivery)
                                                    @if ($delivery->active == 0)
                                                        <tr>
                                                            <td>{{ $delivery->id }}</td>
                                                            <td>{{ $delivery->name }}</td>
                                                            <td>{{ $delivery->phone }}</td>
                                                            <td>{{ number_format($delivery->price, 0) }} VNĐ</td>
                                                            <td>{{ $delivery->note }}</td>
                                                            <td>
                                                                <form action="{{ route('admin.delivery.handleCrudDelivery') }}" method="post">
                                                                    {{ csrf_field() }}
                                                                    <input type="hidden" name="id" value="{{ $delivery->id }}">
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

            <div class="modal fade" id="modal-add-new-delivery">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <form action="{{ route('admin.delivery.handleCrudDelivery') }}" method="POST" id="check-validate-1" onsubmit='return(validate("check-validate-1"));'>
                            {{ csrf_field() }}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">THÊM ĐƠN VỊ VẬN CHUYỂN MỚI</h4>
                            </div>

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Đơn vị vận chuyển</label>
                                            <input type="text" class="form-control" name="name" placeholder="Nhập đơn vị vận chuyển">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Số điện thoại</label>
                                            <input type="text" class="form-control" name="phone" placeholder="Nhập số điện thoại">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Giá vận chuyển</label>
                                            <input type="text" class="form-control" name="price" placeholder="Nhập giá vận chuyển">
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
                                <button type="submit" class="btn btn-success" name="button" value="create">Thêm đơn vị vận chuyển mới</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            <div class="modal fade" id="modal-view-delivery-list">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('admin.delivery.handleCrudDelivery') }}" method="POST" id="check-validate-2" onsubmit='return(validate("check-validate-2"));'>
                            {{ csrf_field() }}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">THÔNG TIN CHI TIẾT</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="id_view" name="id">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Đơn vị vận chuển</label>
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
                                            <label for="">Giá vận chuyển</label>
                                            <input type="text" class="form-control" id="price_view" name="price">
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
