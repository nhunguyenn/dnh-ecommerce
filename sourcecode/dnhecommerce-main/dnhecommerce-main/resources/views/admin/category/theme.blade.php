@extends('layouts.admin')

@section('title', 'Category Theme')

@section('active-category', 'active')

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
                        <li class="active">Danh Mục Thể Loại</li>
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
                            <li class="active"><a href="#theme-list" data-toggle="tab">Tất Cả</a></li>
                            <li><a href="#trash-theme-list" data-toggle="tab">Thùng Rác</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="theme-list">
                                <div class="box" style="border-top: none; box-shadow: none;">
                                    <div class="box-header" style="padding-bottom: 0;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p style="margin: 0;"><b>{{ $countActive }}</b> Danh Mục Thể Loại</p>
                                                <p style="margin: 0;">Hiện tại đang có <b>{{ $countActive }}</b> Danh Mục Thể Loại trong hệ thống</p>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-add-new-theme"><i class="fa fa-fw fa-plus"></i> THÊM 1 DANH MỤC MỚI</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="table-theme-list" class="table table-bordered table-striped dataTable">
                                            <thead>
                                                <tr>
                                                    <th style="width: 8%;">Hình ảnh</th>
                                                    <th style="width: 5%;">Mã danh mục</th>
                                                    <th style="width: 10%;">Tên danh mục</th>
                                                    <th style="width: 30%;">Mô tả</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($themes as $theme)
                                                    @if ($theme->active == 1)
                                                        <tr onclick="ThemeView('{{ $theme->id }}','{{ $theme->name }}','{{ $theme->image }}','{{ $theme->note }}','{{ $theme->created_at }}','{{ $theme->updated_at }}')" data-toggle="modal" data-target="#modal-view-theme-list">
                                                            <td><img class="img-responsive" style="width: 40%;" src="{{ asset('images/category/' . $theme->image) }}"></td>
                                                            <td>{{ $theme->id }}</td>
                                                            <td>{{ $theme->name }}</td>
                                                            <td>{{ $theme->note }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>

                            <div class="tab-pane" id="trash-theme-list">
                                <div class="box" style="border-top: none; box-shadow: none;">
                                    <div class="box-header" style="padding-bottom: 0;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p style="margin: 0;"><b>{{ $countHidden }}</b> Danh Mục Thể Loại</p>
                                                <p style="margin: 0;">Hiện tại đang có <b>{{ $countHidden }}</b> Danh Mục Thể Loại bị xóa trong hệ thống</p>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <form action="{{ route('admin.category.handleCrudTheme') }}" method="post">
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger btn-sm" name="button" value="deleteAll"><i class="fa fa-fw fa-trash"></i> XÓA TẤT CẢ VĨNH VIỄN</button>
                                                    <button type="submit" class="btn btn-primary btn-sm" name="button" value="restoreAll"><i class="fa fa-fw fa-refresh"></i> KHÔI PHỤC TẤT CẢ</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="table-trash-theme-list" class="table table-bordered table-hover dataTable">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10%;">Hình ảnh</th>
                                                    <th style="width: 5%;">Mã danh mục</th>
                                                    <th style="width: 10%;">Tên danh mục</th>
                                                    <th style="width: 30%;">Mô tả</th>
                                                    <th style="width: 1%;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($themes as $theme)
                                                    @if ($theme->active == 0)
                                                        <tr>
                                                            <td><img class="img-responsive" style="width: 35%;" src="{{ asset('images/category/' . $theme->image) }}"></td>
                                                            <td>{{ $theme->id }}</td>
                                                            <td>{{ $theme->name }}</td>
                                                            <td>{{ $theme->note }}</td>
                                                            <td>
                                                                <form action="{{ route('admin.category.handleCrudTheme') }}" method="post">
                                                                    {{ csrf_field() }}
                                                                    <input type="hidden" name="id" value="{{ $theme->id }}">
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

            <div class="modal fade" id="modal-add-new-theme">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('admin.category.handleCrudTheme') }}" method="POST" enctype="multipart/form-data" id="check-validate-1" onsubmit='return(validate("check-validate-1"));'>
                            {{ csrf_field() }}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">THÊM DANH MỤC THỂ LOẠI MỚI</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">Hình ảnh</label>
                                            <input type="file" name="image" onchange="loadImgThemeView(event)">
                                        </div>
                                        <div class="col-md-6">
                                            <img class="img-responsive" id="img_add" style="width: 35%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Tên danh mục</label>
                                    <input type="text" class="form-control" name="name" placeholder="Nhập danh mục thể loại">
                                </div>
                                <div class="form-group">
                                    <label for="">Ghi chú</label>
                                    <textarea class="form-control" name="note" rows="5" cols="80"></textarea></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Thoát</button>
                                <button type="submit" class="btn btn-success" name="button" value="create">Thêm Danh Mục Thể Loại Mới</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-view-theme-list">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('admin.category.handleCrudTheme') }}" method="POST" enctype="multipart/form-data" id="check-validate-2" onsubmit='return(validate("check-validate-2"));'>
                            {{ csrf_field() }}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">THÔNG TIN CHI TIẾT</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">Hình ảnh</label>
                                            <input type="file" id="img_view" name="image" onchange="loadImgThemeNew(event)">
                                        </div>
                                        <div class="col-md-6">
                                            <img class="img-responsive" id="img_show" style="width: 25%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Mã danh mục</label>
                                    <input type="hidden" class="form-control" id="id_view_1" name="id">
                                    <input type="text" class="form-control" id="id_view_2" name="id" disabled="disabled">
                                </div>
                                <div class="form-group">
                                    <label for="">Tên danh mục</label>
                                    <input type="text" class="form-control" id="name_view" name="name">
                                </div>
                                <div class="form-group">
                                    <label for="">Ghi chú</label>
                                    <textarea class="form-control" id="note_view" name="note" rows="5" cols="80"></textarea></textarea>
                                </div>
                                <div class="row">
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
