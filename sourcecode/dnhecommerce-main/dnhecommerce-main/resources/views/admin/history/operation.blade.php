@extends('layouts.admin')

@section('title', 'Product')

@section('active-operation-history', 'active')

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
                        <li class="active">Lịch Sử Thao Tác</li>
                    </ol>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="border-top: none; box-shadow: none;">
                        <div class="box-header" style="padding-bottom: 0;">
                            <div class="row">
                                <div class="col-md-12">
                                    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
                                    <input class="form-control" id="myInput" type="text" placeholder="Tìm Kiếm Thao Tác">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="table-product-list" class="table table-bordered table-hover dataTable">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">ID</th>
                                        <th style="width: 5%;">ID Account</th>
                                        <th style="width: 10%;">Tên Account</th>
                                        <th style="width: 10%;">Bảng Thao Tác</th>
                                        <th style="width: 10%;">Hoạt Động</th>
                                        <th style="width: 10%;">Ngày Thực Hiện</th>
                                    </tr>
                                </thead>
                                <tbody id="myTable">
                                    @foreach ($operations as $operation)
                                        <tr>
                                            <td>{{ $operation->id }}</td>
                                            <td>{{ $operation->id_employee }}</td>
                                            <td>{{ $operation->name }}</td>
                                            <td>{{ $operation->table }}</td>
                                            <td>{{ $operation->operation }}</td>
                                            <td>{{ $operation->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <script>
                                    $(document).ready(function(){
                                        $("#myInput").on("keyup", function() {
                                            var value = $(this).val().toLowerCase();
                                            $("#myTable tr").filter(function() {
                                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                                            });
                                        });
                                    });
                                </script>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
