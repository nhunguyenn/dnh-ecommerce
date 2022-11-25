@extends('layouts.client')

@section('title', 'Home')

@section('content')
    <div class="body-content outer-top-xs">
        <div class='container'>
            <div class='row'>
                <div class="col-xs-12 col-sm-12 col-md-9 rht-col">
                    <div id="hero">
                        <div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">
                            <div class="item"
                                style="background-image: url({{ asset('assets/clients/assets/images/sliders/01.jpg') }});">
                                <div class="container-fluid">
                                    <div class="caption bg-color vertical-center text-left">
                                        <div class="slider-header fadeInDown-1">Top Brands</div>
                                        <div class="big-text fadeInDown-1"> New Collections </div>
                                        <div class="excerpt fadeInDown-2 hidden-xs"><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span> </div>
                                        <div class="button-holder fadeInDown-3"><a href="index6c11.html?page=single-product" class="btn-lg btn btn-uppercase btn-primary shop-now-button">Shop Now</a></div>
                                    </div>
                                </div>
                            </div>

                            <div class="item"
                                style="background-image: url({{ asset('assets/clients/assets/images/sliders/02.jpg') }});">
                                <div class="container-fluid">
                                    <div class="caption bg-color vertical-center text-left">
                                        <div class="slider-header fadeInDown-1">Spring 2018</div>
                                        <div class="big-text fadeInDown-1"> Women Fashion </div>
                                        <div class="excerpt fadeInDown-2 hidden-xs"> <span>Nemo enim ipsam voluptatem quia
                                                voluptas sit aspernatur aut odit aut fugit</span> </div>
                                        <div class="button-holder fadeInDown-3"> <a
                                                href="index6c11.html?page=single-product"
                                                class="btn-lg btn btn-uppercase btn-primary shop-now-button">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="product-tabs-slider" class="scroll-tabs outer-top-vs">
                        <div class="more-info-tab clearfix ">
                            <h3 class="new-product-title pull-left">SẢN PHẨM MỚI NHẤT</h3>
                            <ul class="nav nav-tabs nav-tab-line pull-right" id="new-products-1">
                                <li><a class="themeSelect selected" onclick="filterSelection('theme--')" data-transition-type="backSlide" data-toggle="tab">All</a></li>
                                <?php for($x = 0; $x < sizeOf($themes); $x++){ ?>
                                    <li><a class="themeSelect" onclick="filterSelection('theme-{{ $themes[$x]->id }}')" data-transition-type="backSlide" data-toggle="tab">{{ $themes[$x]->name }}</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="search-result-container ">
                            <div id="myTabContent" class="tab-content category-list">
                                <div class="tab-pane active " id="grid-container">
                                    <div class="category-product">
                                        <div class="row">
                                            @foreach ($products as $product)
                                                @if ($product->active == 1)
                                                    @php
                                                        $iamgeList = \App\Http\Controllers\clients\Helper::loadImage($product);
                                                        $themeId = \App\Http\Controllers\clients\ProductController::findThemeById($product->id_category);
                                                    @endphp

                                                    <div
                                                        class="filterDiv theme-{{ $themeId }} col-sm-6 col-md-4 col-lg-3">
                                                        <div class="item">
                                                            <div class="products">
                                                                <div class="product">
                                                                    <div class="product-image">
                                                                        <div class="image">
                                                                            <a href="/product/{{ $product->id }}-{{ Str::slug($product->name, '-') }}">
                                                                                <img id="product-image{{ $product->id }}" src="" alt="{{ $product->name }}">
                                                                                <img id="product-image-hover{{ $product->id }}" src="" alt="" class="hover-image">
                                                                            </a>
                                                                        </div>
                                                                        <script>
                                                                            var linkImage = window.location.protocol + "//" + window.location.hostname + "/images/product/" +  "{{ $iamgeList[0] }}";
                                                                            var linkImageHover = window.location.protocol + "//" + window.location.hostname + "/images/product/" + "{{ $iamgeList[1] }}";
                                                                            document.getElementById("product-image" + {{ $product->id }}).src = linkImage;
                                                                            document.getElementById("product-image-hover" + {{ $product->id }}).src = linkImageHover;
                                                                        </script>
                                                                        <div class="tag new"><span>Mới</span></div>
                                                                    </div>

                                                                    <div class="product-info text-left">
                                                                        <h3 class="name"><a href="detail.html">{{ $product->name }}</a></h3>
                                                                        <div class="rating rateit-small"></div>
                                                                        <div class="description"></div>
                                                                        <div class="product-price"> <span class="price">{{ $product->price }} </span> <span class="price-before-discount">{{ $product->price }}</span></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix filters-container bottom-row">
                                <div class="text-right">
                                    <div class="pagination-container">
                                        <ul class="list-inline list-unstyled">
                                            <li class="prev"><a href="#"><i class="fa fa-angle-left"></i></a></li>
                                            <li><a href="#">1</a></li>
                                            <li class="active"><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">4</a></li>
                                            <li class="next"><a href="#"><i class="fa fa-angle-right"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.onload = function() {
            filterSelection('theme--');
        };
    </script>
@endsection
