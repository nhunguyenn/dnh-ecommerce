@extends('layouts.client')

@section('title', 'detail')

@section('content')
    @php
        $iamgeList = \App\Http\Controllers\clients\Helper::loadImage($product);
    @endphp

    <div class="body-content outer-top-xs" style="margin-bottom: 50px;">
        <div class='container'>
            <div class='row single-product'>
                <div class="col-xs-12 col-sm-12 col-md-3 sidebar">
                    <div class="sidebar-module-container">
                        <div class="home-banner outer-top-n outer-bottom-xs">
                            <img src="{{ asset('assets/clients/assets/images/banners/LHS-banner.jpg') }}" alt="Image">
                          </div>
                    </div>
                    <div class="sidebar-widget  outer-top-vs ">
                        <div id="advertisement" class="advertisement owl-carousel owl-theme" style="opacity: 1; display: block;">
                            <div class="owl-wrapper-outer">
                                <div class="owl-wrapper"
                                    style="width: 1320px; left: 0px; display: block; transition: all 400ms ease 0s; transform: translate3d(0px, 0px, 0px);">
                                    <div class="owl-item" style="width: 220px;">
                                        <div class="item">
                                            <div class="avatar"><img src="{{ asset('assets/clients/assets/images/testimonials/member1.png') }}" alt="Image"></div>
                                            <div class="clients_author">John Doe <span>Abc Company</span> </div>
                                        </div>
                                    </div>
                                    <div class="owl-item" style="width: 220px;">
                                        <div class="item">
                                            <div class="avatar"><img src="{{ asset('assets/clients/assets/images/testimonials/member3.png') }}" alt="Image"></div>
                                            <div class="clients_author">Stephen Doe <span>Xperia Designs</span> </div>
                                        </div>
                                    </div>
                                    <div class="owl-item" style="width: 220px;">
                                        <div class="item">
                                            <div class="avatar"><img src="{{ asset('assets/clients/assets/images/testimonials/member2.png') }}" alt="Image"></div>
                                            <div class="clients_author">Saraha Smith <span>Datsun &amp; Co</span> </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.item -->
                            <div class="owl-controls clickable">
                                <div class="owl-pagination">
                                    <div class="owl-page active"><span class=""></span></div>
                                    <div class="owl-page"><span class=""></span></div>
                                    <div class="owl-page"><span class=""></span></div>
                                </div>
                                <div class="owl-buttons">
                                    <div class="owl-prev"></div>
                                    <div class="owl-next"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class='col-xs-12 col-sm-12 col-md-9'>
                    <div class="detail-block" style="margin-bottom: 50px;">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 gallery-holder">
                                <div class="product-item-holder size-big single-product-gallery small-gallery">
                                    <div id="owl-single-product">
                                        <?php for($x = 0; $x< sizeof($iamgeList);$x++){ ?>
                                        <div class="single-product-gallery-item" id="slide{{ $x + 1 }}">
                                            <a id="product-image-link" data-lightbox="image-1" data-title="Gallery" href="">
                                                <div id="imgProducShowClient-{{ $x }}"> </div>
                                            </a>
                                        </div>
                                        <?php } ?>
                                    </div>

                                    <div class="single-product-gallery-thumbs gallery-thumbs">
                                        <div id="owl-single-product-thumbnails">
                                            <?php for($x = 0; $x< sizeof($iamgeList);$x++) { ?>
                                            <div class="item">
                                                <a class="horizontal-thumb active" data-target="#owl-single-product" data-slide="{{ $x + 1 }}" href="#slide{{ $x + 1 }}">
                                                    <div id="imgProducShowClientThumbs-{{ $x }}"></div>
                                                </a>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='col-sm-12 col-md-8 col-lg-8 product-info-block'>
                                <form action="/product/{{ $product->id }}-{{ Str::slug($product->name, '-') }}/handleAddToCart" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id_product" value="{{ $product->id }}" />
                                    <input type="hidden" name="slug_product" value="{{ Str::slug($product->name, '-') }}" />

                                    <div class="product-info">
                                        <h1 class="name" style="font-size: 20px;">{{ $product->name }}</h1>
                                        <div class="stock-container info-container m-t-10">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="pull-left">
                                                        <div class="stock-box">
                                                            <span class="label">Lượt xem: </span>
                                                        </div>
                                                    </div>
                                                    <div class="pull-left">
                                                        <div class="stock-box">
                                                            <span class="value">{{ $product->viewed }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="stock-container info-container m-t-10">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="pull-left">
                                                        <div class="stock-box">
                                                            <span class="label">Số lượng còn: </span>
                                                        </div>
                                                    </div>
                                                    <div class="pull-left">
                                                        <div class="stock-box">
                                                            <span class="value">{{ $product->quantity }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="description-container m-t-20"><p>{{ $product->note }}</p></div>

                                        <div class="price-container info-container m-t-10">
                                            <div class="row">
                                                <div class="col-md-6" style="width: auto;">
                                                    <div class="form-group" style="width: 200px; display: inline-block;">
                                                        <select id="id_size" class="form-control" name="id_size">
                                                            <option value="0">Kích thước</option>
                                                            @foreach ($sizes as $size)
                                                                @if ($size->active == 1 && $size->id_product == $product->id)
                                                                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" style="width: auto;">
                                                    <div class="form-group" style="width: 200px; display: inline-block;">
                                                        <select id="id_color" class="form-control" name="id_color">
                                                            <option value="0">Màu sắc</option>
                                                            @foreach ($colors as $color)
                                                                @if ($color->active == 1 && $color->id_product == $product->id)
                                                                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="price-box">
                                                        <span class="price">Giá: </span>
                                                        <span class="price">{{ $product->price }}<span style="font-size: 17px;">đ</span></span>
                                                        {{-- <span class="price-strike">300000<span style="font-size: 17px;">đ</span></span> --}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="cart-warning" style="margin-bottom: -40px;" class="alert alert-warning">Vui Lòng chọn phân loại sản phẩm!</div>
                                        </div>

                                        <div class="quantity-container info-container">
                                            <div class="row">
                                                <div class="qty">
                                                    <span class="label">Số lượng:</span>
                                                </div>
                                                <div class="qty-count">
                                                    <div class="cart-quantity">
                                                        <div class="quant-input">
                                                            <div class="arrows">
                                                                <div class="arrow plus gradient" style="height: 10px;"><span class="ir"><i class="icon fa fa-sort-asc"></i></span></div>
                                                                <div class="arrow minus gradient"><span class="ir"><i class="icon fa fa-sort-desc"></i></span></div>
                                                            </div>
                                                            <input type="text" name="quantity_product" value="1" style="height: 36px;">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="add-btn">
                                                    <button onclick="btnAddToCart()" id="btn_add_to_cart" type="button" class="btn btn-warning" style="margin-left: 10px">
                                                        <i class="fa fa-shopping-cart inner-right-vs"></i> Thêm vào giỏ hàng
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script> window.onload = function() { ProductView(<?php echo json_encode($iamgeList); ?>); }; </script>
@endsection
