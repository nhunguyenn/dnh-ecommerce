@extends('layouts.admin')

@section('title', 'Related Product')

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
                        <li><a href="{{ route('admin.product') }}">Danh Sách Sản Phẩm</a></li>
                        <li class="active">Thêm Sản Phẩm Mới</li>
                    </ol>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Thêm Sản Phẩm Mới</h3>
                        </div>
                        <div class="box-body pad table-responsive">
                            <form action="{{ route('admin.product.handleCrudProduct') }}" method="POST" enctype="multipart/form-data" id="check-validate-1" onsubmit='return(validate("check-validate-1"));'>
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-12" style="margin-bottom: 10px;">
                                        <div class="checkbox" style="display: inline-block; margin-right: 10px;">
                                            <label>
                                                <input type="checkbox" name="active_sale" value="1"> Sản phẩm bán được
                                            </label>
                                        </div>
                                        <div class="checkbox" style="display: inline-block; margin-right: 10px;">
                                            <label>
                                                <input type="checkbox" name="active_purchase" value="1"> Sản phẩm mua được
                                            </label>
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
                                                                            <input type="text" class="form-control" name="name" placeholder="Nhập tên sản phẩm">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="">Hình ảnh</label>
                                                                            <input type="file" name="image[]" id="images" multiple>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12" id="divImgProducNew">
                                                                        <div class="form-group" id="imgProducNew"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>Nhà cung cấp sản phẩm</label>
                                                                            <select class="form-control" name="id_supplier">
                                                                                @foreach ($suppliers as $supplier)
                                                                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>Thể loại sản phẩm</label>
                                                                            <select class="form-control" name="id_category">
                                                                                @foreach ($categorys as $category)
                                                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>Danh mục sản phẩm liên quan</label>
                                                                            <select class="form-control" name="id_related">
                                                                                @foreach ($relateds as $related)
                                                                                    <option value="{{ $related->id }}">{{ $related->name }}</option>
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
                                                                    <input type="text" class="form-control" name="quantity" placeholder="Nhập số lượng sản phẩm">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">Giá sản phẩm nhập vào</label>
                                                                    <input type="text" class="form-control" name="cost" placeholder="Nhập giá sản phẩm nhập vào">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">Giá sản phẩm bán ra</label>
                                                                    <input type="text" class="form-control" name="price" placeholder="Nhập giá sản phẩm bán ra">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Thuế sản phẩm</label>
                                                                    <select class="form-control" name="id_tax">
                                                                        @foreach ($taxs as $tax)
                                                                            <option value="{{ $tax->id }}">{{ $tax->name }} - {{ $tax->value }}%</option>
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
                                            <textarea class="form-control" name="note" rows="2" cols="80"></textarea>
                                            </textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <a href="{{ route('admin.product') }}" class="btn btn-default">Thoát</a>
                                    </div>

                                    <div class="col-md-6 text-right">
                                        <button type="submit" class="btn btn-success" name="button" value="create">Thêm Sản Phẩm Mới</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
