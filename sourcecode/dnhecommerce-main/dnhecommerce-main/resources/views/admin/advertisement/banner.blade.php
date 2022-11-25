@extends('layouts.admin')

@section('title', 'Banner')

@section('active-advertisement', 'active')

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
                        <li class="active">Sản Phẩm Quảng Cáo</li>
                    </ol>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header" style="padding-bottom: 0px;">
                            <h3 class="box-title">DANH SÁCH SẢN PHẨM QUẢNG CÁO</h3>
                            <br>
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-6">
                                    <p style="margin: 0;"><b>{{ $countBanner }}</b> Sản Phẩm</p>
                                    <p style="margin: 0;">Hiện tại đang có <b>{{ $countBanner }}</b> sản phẩm trong hệ thống
                                    </p>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-add-new-banner"><i class="fa fa-fw fa-plus"></i> THÊM 1 BANNER MỚI</button>
                                </div>
                            </div>
                        </div>

                        <div class="box-body" style="padding-top: 0px;">
                            <table id="table-banner-list" class="table table-bordered table-hover dataTable">
                                <thead>
                                    <tr>
                                        <th style="width: 3%;">ID</th>
                                        <th style="width: 10%;">Sản phẩm</th>
                                        <th style="width: 10%;">Ghi chú</th>
                                        <th style="width: 5%;">Ngày tạo</th>
                                        <th style="width: 5%;">Ngày sửa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($banners as $banner)
                                        <tr onclick="BannerView('{{ $banner->id }}','{{ $banner->id_product }}','{{ $banner->note }}','{{ $banner->created_at }}','{{ $banner->updated_at }}')"
                                            data-toggle="modal" data-target="#modal-view-banner-list">
                                            <td>{{ $banner->id }}</td>
                                            <td>
                                                @foreach ($products as $product)
                                                    @if ($product->id == $banner->id_product)
                                                        {{ $product->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $banner->note }}</td>
                                            <td>{{ $banner->created_at }}</td>
                                            <td>{{ $banner->updated_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="modal fade" id="modal-add-new-banner">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <form action="{{ route('admin.advertisement.handleCrudBanner') }}" method="POST" id="check-validate-1" onsubmit='return(validate("check-validate-1"));'>
                                        {{ csrf_field() }}
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">THÊM QUẢNG CÁO MỚI</h4>
                                        </div>

                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Sản phẩm</label>
                                                        <select class="form-control" name="id_product">
                                                            @foreach ($products as $product)
                                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                            @endforeach
                                                        </select>
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
                                            <button type="submit" class="btn btn-success" name="button" value="create">Thêm Banner mới</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>

                        <div class="modal fade" id="modal-view-banner-list">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.advertisement.handleCrudBanner') }}" method="POST" id="check-validate-2" onsubmit='return(validate("check-validate-2"));'>
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
                                                        <input type="hidden" class="form-control" id="id_view" name="id">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Sản phẩm</label>
                                                        <select class="form-control" id="id_product_view" name="id_product">
                                                            @foreach ($products as $product)
                                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                            @endforeach
                                                        </select>
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
                                            <button type="button" class="btn btn-default pull-left"  data-dismiss="modal">Thoát</button>
                                            <button type="submit" class="btn btn-danger" name="button" value="delete">Xóa Banner</button>
                                            <button type="submit" class="btn btn-primary" name="button" value="update">Sửa Banner</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
