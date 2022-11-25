<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('assets/admin/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                @if (Session::get('id_admin'))
                    <p>{{ Session::get('name_admin') }}</p>
                    <a href="#">Quản Trị Viên</a>
                @endif
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">TÁC VỤ CHÍNH</li>
            <li class="@yield('active-home')">
                <a href="{{ route('admin.home') }}">
                    <i class="fa fa-dashboard"></i> <span>Tổng Quan</span>
                </a>
            </li>
            <li class="@yield('active-operation-history')">
                <a href="{{ route('admin.history.operation') }}">
                    <i class="fa fa-book"></i> <span>Lịch Sử Thao Tác</span>
                </a>
            </li>
            <li class="@yield('active-supplier')">
                <a href="{{ route('admin.supplier.list') }}">
                    <i class="fa fa-home"></i> <span>Quản Lý Nhà Cung Cấp</span>
                </a>
            </li>
            <li class="@yield('active-tax')">
                <a href="{{ route('admin.tax') }}">
                    <i class="fa fa-bar-chart-o"></i> <span>Quản Lý Thuế</span>
                </a>
            </li>
            <li class="@yield('active-delivery')">
                <a href="{{ route('admin.delivery') }}">
                    <i class="fa fa-truck"></i> <span>Quản Lý Vận Chuyện</span>
                </a>
            </li>
            <li class="@yield('active-voucher')">
                <a href="{{ route('admin.voucher') }}">
                    <i class="fa fa-ticket"></i> <span>Quản Lý Voucher</span>
                </a>
            </li>
            <li class="@yield('active-order')">
                <a href="{{ route('admin.order') }}">
                    <i class="fa fa-file-text-o"></i> <span>Quản Lý Đơn Hàng</span>
                </a>
            </li>
            <li class="treeview @yield('active-request')">
                <a href="#">
                    <i class="fa fa-file-text-o"></i> <span>Quản Lý Yêu Cầu</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.request.unpaid') }}"><i class="fa fa-caret-right"></i> Xác Nhận Đơn Hàng</a></li>
                    <li><a href="{{ route('admin.request.return') }}"><i class="fa fa-caret-right"></i> Xác Nhận Trả Hàng</a></li>
                </ul>
            </li>
            <li class="treeview @yield('active-category')">
                <a href="#">
                    <i class="fa fa-list-alt"></i> <span>Quản Lý Thể Loại</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.category.theme') }}"><i class="fa fa-caret-right"></i> Danh Mục Thể Loại</a></li>
                    <li><a href="{{ route('admin.category.group') }}"><i class="fa fa-caret-right"></i> Nhóm Thể Loại</a></li>
                </ul>
            </li>
            <li class="treeview @yield('active-attributes')">
                <a href="#">
                    <i class="fa fa-chain-broken"></i> <span>Quản Lý Thuộc Tính</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.attributes.size') }}"><i class="fa fa-caret-right"></i> Kích Thước Sản Phẩm</a></li>
                    <li><a href="{{ route('admin.attributes.color') }}"><i class="fa fa-caret-right"></i> Màu Sắc Sản Phẩm</a></li>
                </ul>
            </li>
            <li class="treeview @yield('active-product')">
                <a href="#">
                    <i class="fa fa-shopping-cart"></i> <span>Quản Lý Sản Phẩm</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.product') }}"><i class="fa fa-caret-right"></i> Danh Sách Sản Phẩm</a></li>
                    <li><a href="{{ route('admin.product.discount') }}"><i class="fa fa-caret-right"></i> Sản Phẩm Giảm Giá</a></li>
                </ul>
            </li>
            <li class="treeview @yield('active-advertisement')">
                <a href="#">
                    <i class="fa fa-camera-retro"></i> <span>Quản Lý Quảng Cáo</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.advertisement.related') }}"><i class="fa fa-caret-right"></i> Sản Phẩm Liên Quan</a></li>
                    <li><a href="{{ route('admin.advertisement.banner') }}"><i class="fa fa-caret-right"></i> Sản Phẩm Quảng Cáo</a></li>
                </ul>
            </li>
            @if (Session::get('id_admin'))
                <li>
                    <a href="{{ route('admin.auth.logout') }}">
                        <i class="fa fa-sign-out"></i> <span>Đăng Xuất</span>
                    </a>
                </li>
            @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
