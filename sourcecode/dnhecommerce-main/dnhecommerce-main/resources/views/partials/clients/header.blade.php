<header class="header-style-1">
    <div class="top-bar animate-dropdown" style="padding-top: 10px;">
        <div class="container">
            <div class="header-top-inner">
                <div class="cnt-account">
                    <ul class="list-unstyled">
                        <li class="myaccount"><a href="#"><span>Tài Khoản</span></a></li>
                        <li class="wishlist"><a href="#"><span>Yêu Thích</span></a></li>
                        <li class="header_cart hidden-xs"><a href="{{ route('client.cart') }}"><span>Giỏ Hàng</span></a>
                        </li>
                        <li class="check"><a href="{{ route('client.checkout') }}"><span>Thanh Toán</span></a></li>
                        <li class="check"><a href="{{ route('client.purchase') }}"><span>Đơn Mua</span></a></li>
                        @if (Session::get('id_customer'))
                            <li class="logout"><a href="{{ route('client.auth.logout') }}"><span>Đăng Xuất</span></a>
                            </li>
                        @else
                            <li class="login"><a href="{{ route('client.auth.login') }}"><span>Đăng Nhập</span></a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="cnt-block">
                    <ul class="list-unstyled list-inline">
                        <li class="dropdown dropdown-small"> <a href="#" class="dropdown-toggle"
                                data-hover="dropdown" data-toggle="dropdown"><span class="value">USD </span><b
                                    class="caret"></b></a>
                            {{-- <ul class="dropdown-menu">
                                <li><a href="#">USD</a></li>
                                <li><a href="#">INR</a></li>
                                <li><a href="#">GBP</a></li>
                            </ul> --}}
                        </li>
                        <li class="dropdown dropdown-small lang"> <a href="#" class="dropdown-toggle"
                                data-hover="dropdown" data-toggle="dropdown"><span class="value">English </span><b
                                    class="caret"></b></a>
                            {{-- <ul class="dropdown-menu">
                                <li><a href="#">English</a></li>
                                <li><a href="#">French</a></li>
                                <li><a href="#">German</a></li>
                            </ul> --}}
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="main-header">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
                    <div class="logo"> <a href="/"> <img
                                src="{{ asset('assets/clients/assets/images/logo.png') }}" alt="logo"> </a></div>
                </div>
                <div class="col-lg-7 col-md-6 col-sm-8 col-xs-12 top-search-holder">
                    <div class="search-area">
                        <form>
                            <div class="control-group">
                                <ul class="categories-filter animate-dropdown">
                                    <li class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown"
                                            href="category.html">Tìm Kiếm<b class="caret"></b></a>
                                        {{-- <ul class="dropdown-menu" role="menu">
                                            <li class="menu-header">Computer</li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="category.html">- Clothing</a></li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="category.html">- Electronics</a></li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="category.html">- Shoes</a></li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="category.html">- Watches</a></li>
                                        </ul> --}}
                                    </li>
                                </ul>
                                <input class="search-field" placeholder="Nhập để tìm kiếm tại đây" />
                                <a class="search-button" href="#"></a>
                            </div>
                        </form>
                    </div>
                </div>

                @if (session()->get('id_customer') == null)
                    <div class="col-lg-1 col-md-3 col-sm-4 col-xs-12  top-cart-row">
                        <div class="dropdown dropdown-cart">
                            <a href="{{ route('client.cart') }}" class="lnk-cart">
                                <div class="items-cart-inner">
                                    <div class="basket">
                                        <div class="basket-item-count"><span class="count">0</span></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @else
                    @php
                        $cart = session()->get('cart');
                        $countActive = session()->get('countActive');
                    @endphp

                    <div class="col-lg-1 col-md-3 col-sm-4 col-xs-12 animate-dropdown top-cart-row">
                        <div class="dropdown dropdown-cart"> <a href="#" class="dropdown-toggle lnk-cart"
                                data-toggle="dropdown">
                                <div class="items-cart-inner">
                                    <div class="basket">
                                        <div class="basket-item-count"><span class="count">{{ $countActive }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <ul class="dropdown-menu" style="width: 400px">
                                <li>
                                    <div class="cart-item product-summary">
                                        @foreach ($cart as $value)
                                            @php
                                                $product = \App\Http\Controllers\clients\ProductController::findProductById($value->id_product);
                                                $iamgeList = \App\Http\Controllers\clients\Helper::loadImage($product);
                                            @endphp
                                            <div class="row" style="margin-bottom: 5px">
                                                <div class="col-xs-2">
                                                    <div class="image">
                                                        <a
                                                            href="/product/{{ $product->id }}-{{ Str::slug($product->name, '-') }}">
                                                            <img id="product-image{{ $value->id }}" src="">
                                                        </a>
                                                    </div>

                                                    <script>
                                                        var linkImage = window.location.protocol + "//" + window.location.hostname + "/images/product/" +
                                                            "{{ $iamgeList[0] }}";
                                                        document.getElementById("product-image" + {{ $value->id }}).src = linkImage;
                                                    </script>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-7">
                                                        <h3 class="name"><a
                                                            href="/product/{{ $product->id }}-{{ Str::slug($product->name, '-') }}">{{ $value->name_product }}</a>
                                                        </h3>
                                                    </div>
                                                    <div class="price">đ{{ number_format($product->price, 0) }}</div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                    <hr>
                                    <a href="{{ route('client.cart') }}"
                                        class="btn btn-upper btn-primary pull-right outer-right-xs"
                                        style="padding: 6px 14px; margin-right: 10px;">Xem Giỏ Hàng</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="header-nav animate-dropdown">
        <div class="container">
            <div class="yamm navbar navbar-default" role="navigation">
                <div class="navbar-header">
                    <button data-target="#mc-horizontal-menu-collapse" data-toggle="collapse"
                        class="navbar-toggle collapsed" type="button">
                        <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span
                            class="icon-bar"></span> <span class="icon-bar"></span> </button>
                </div>
                <div class="nav-bg-class">
                    <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse">
                        <div class="nav-outer">
                            <ul class="nav navbar-nav">
                                {{-- <li class="active dropdown"> <a href="/">Home</a> </li> --}}
                                <li class="dropdown"> <a href="/">Trang Chủ</a> </li>
                                <li class="dropdown yamm mega-menu">
                                    <a href="/" data-hover="dropdown" class="dropdown-toggle"
                                        data-toggle="dropdown">Sản Phẩm</a>
                                    <ul class="dropdown-menu container">
                                        <li>
                                            <div class="yamm-content ">
                                                <div class="row">
                                                    @foreach ($themes as $theme)
                                                        @if ($theme->active == 1)
                                                            <div class="col-xs-12 col-sm-6 col-md-2 col-menu">
                                                                <h2 class="title">{{ $theme->name }}</h2>
                                                                <ul class="links">
                                                                    @php
                                                                        $category = \App\Http\Controllers\clients\HomeController::findCategoryByThemeId($theme->id);
                                                                    @endphp
                                                                    @foreach ($category as $item)
                                                                        <li><a href="#">{{ $item->name }}</a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                            <!-- /.col -->
                                                        @endif
                                                    @endforeach
                                                    <div class="col-xs-12 col-sm-6 col-md-4 col-menu banner-image">
                                                        <img class="img-responsive"
                                                            src="{{ asset('assets/clients/assets/images/banners/top-menu-banner.jpg') }}"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown"> <a href="">Yêu Thích</a> </li>
                                <li class="dropdown  navbar-right special-menu"> <a href="#">Get 30% off on
                                        selected items</a> </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
