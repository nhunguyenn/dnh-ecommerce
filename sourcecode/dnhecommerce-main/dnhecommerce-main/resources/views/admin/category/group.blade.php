@extends('layouts.admin')

@section('title', 'Category Group')

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
                    <ol class="breadcrumb" style="background: white; margin-bottom: 0px; padding-top: 12px; padding-bottom: 12px;">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Trang Chủ</a></li>
                        <li class="active">Nhóm Thể Loại</li>
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
                            <li class="active"><a href="#group-list" data-toggle="tab">Tất Cả</a></li>
                            <li><a href="#trash-group-list" data-toggle="tab">Thùng Rác</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="group-list">
                                <div class="box" style="border-top: none; box-shadow: none;">
                                    <div class="box-header" style="padding-bottom: 0;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p style="margin: 0;"><b>{{ $countActive }}</b> Nhóm Thể Loại</p>
                                                <p style="margin: 0;">Hiện tại đang có <b>{{ $countActive }}</b> Nhóm Thể Loại trong hệ thống</p>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-add-new-group"><i class="fa fa-fw fa-plus"></i> THÊM 1 NHÓM THỂ LOẠi MỚI</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="table-group-list" class="table table-bordered table-hover dataTable">
                                            <thead>
                                                <tr data-toggle="modal">
                                                    <th style="width: 3%;">ID</th>
                                                    <th style="width: 3%;">ID Danh mục</th>
                                                    <th style="width: 10%;">Nhóm thể loại</th>
                                                    <th style="width: 20%;">Mô tả</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($categorys as $category)
                                                    @if ($category->active == 1)
                                                        <tr onclick="CategoryView('{{ $category->id }}','{{ $category->id_theme_list }}','{{ $category->name }}','{{ $category->note }}','{{ $category->created_at }}','{{ $category->updated_at }}')"
                                                            data-toggle="modal" data-target="#modal-view-group-list">
                                                            <td>{{ $category->id }}</td>
                                                            <td>{{ $category->id_theme_list }}</td>
                                                            <td>{{ $category->name }}</td>
                                                            <td>{{ $category->note }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>

                            <div class="tab-pane" id="trash-group-list">
                                <div class="box" style="border-top: none; box-shadow: none;">
                                    <div class="box-header" style="padding-bottom: 0;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p style="margin: 0;"><b>{{ $countHidden }}</b> Nhóm Thể Loại</p>
                                                <p style="margin: 0;">Hiện tại đang có <b>{{ $countHidden }}</b> Nhóm Thể Loại bị xóa trong hệ thống</p>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <form action="{{ route('admin.category.handleCrudGroup') }}" method="post">
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger btn-sm" name="button" value="deleteAll"><i class="fa fa-fw fa-trash"></i> XÓA TẤT CẢ VĨNH VIỄN</button>
                                                    <button type="submit" class="btn btn-primary btn-sm" name="button" value="restoreAll"><i class="fa fa-fw fa-refresh"></i> KHÔI PHỤC TẤT CẢ</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="table-trash-group-list"
                                            class="table table-bordered table-hover dataTable">
                                            <thead>
                                                <tr>
                                                    <th style="width: 3%;">ID</th>
                                                    <th style="width: 3%;">ID Danh mục</th>
                                                    <th style="width: 10%;">Nhóm thể loại</th>
                                                    <th style="width: 20%;">Mô tả</th>
                                                    <th style="width: 1%;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($categorys as $category)
                                                    @if ($category->active == 0)
                                                        <tr>
                                                            <td>{{ $category->id }}</td>
                                                            <td>{{ $category->id_theme_list }}</td>
                                                            <td>{{ $category->name }}</td>
                                                            <td>{{ $category->note }}</td>
                                                            <td>
                                                                <form action="{{ route('admin.category.handleCrudGroup') }}" method="post">
                                                                    {{ csrf_field() }}
                                                                    <input type="hidden" name="id" value="{{ $category->id }}">
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

            <div class="modal fade" id="modal-add-new-group">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <form action="{{ route('admin.category.handleCrudGroup') }}" method="POST" id="check-validate-1" onsubmit='return(validate("check-validate-1"));'>
                            {{ csrf_field() }}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">THÊM NHÓM THỂ LOẠI MỚI</h4>
                            </div>

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Danh mục thể loại</label>
                                            <select class="form-control" name="id_theme_list">
                                                @foreach ($themes as $theme)
                                                    <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Nhóm thể loại</label>
                                            <input type="text" class="form-control" name="name" placeholder="Nhập nhóm thể loại">
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
                                <button type="button" class="btn btn-default pull-left"
                                    data-dismiss="modal">Thoát</button>
                                <button type="submit" class="btn btn-success" name="button" value="create">Thêm nhóm thể loại mới</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            <div class="modal fade" id="modal-view-group-list">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <form action="{{ route('admin.category.handleCrudGroup') }}" method="POST" id="check-validate-2" onsubmit='return(validate("check-validate-2"));'>
                            {{ csrf_field() }}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">THÔNG TIN CHI TIẾT</h4>
                            </div>

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">ID</label>
                                            <input type="text" class="form-control" id="id_view_1" name="id" disabled="disabled">
                                            <input type="hidden" class="form-control" id="id_view_2" name="id">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Danh mục thể loại</label>
                                            <select class="form-control" id="id_theme_list_view" name="id_theme_list">
                                                @foreach ($themes as $theme)
                                                    <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Nhóm thể loại</label>
                                            <input type="text" class="form-control" id="name_view" name="name">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Ghi chú</label>
                                            <textarea class="form-control" id="note_view" name="note" rows="5" cols="80"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Thời gian tạo</label>
                                            <input type="text" class="form-control" id="created_at_view" name="phone" disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
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
