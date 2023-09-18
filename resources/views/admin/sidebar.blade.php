<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="/template/admin/dist/img/logo-01.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">HP Store</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <i style="color: white; margin-left: 20px" class="fa fa-user-friends"><a href="#" style="margin-left: 10px">Phúc</a></i>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Nhà Cung Cấp Giống
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo route('admin.seedsuppliers.add')?>" class="nav-link">
                                <p>Thêm nhà cung cấp </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/seedsuppliers/list" class="nav-link">
                                <p>Danh sách nhà cung cấp </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tree"></i>
                        <p>
                            Cây Và Hạt Giống
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo route('admin.seedsandseedlings.add')?>" class="nav-link">
                                <p>Thêm Hạt - Cây Giống </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/seedsandseedlings/list" class="nav-link">
                                <p>Danh sách Hạt - Cây Giống </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Nhà Vườn
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo route('admin.farmers.add')?>" class="nav-link">
                                <p>Thêm nhà vườn </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/farmers/list" class="nav-link">
                                <p>Danh sách nhà vườn </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tree"></i>
                        <p>
                            Cây Trồng
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo route('admin.crops.add')?>" class="nav-link">
                                <p>Thêm cây trồng </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/crops/list" class="nav-link">
                                <p>Danh sách cây trồng </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-ellipsis-v"></i>
                        <p>
                            Danh Mục
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/menus/add" class="nav-link">
                                <p>Thêm danh Mục</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/menus/list" class="nav-link">
                                <p>Danh sách mục</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tree"></i>
                        <p>
                            Sản Phẩm
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo route('admin.products.add')?>" class="nav-link">
                                <p>Thêm sản phẩm </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/products/list" class="nav-link">
                                <p>Danh sách sản phẩm </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-money-check"></i>
                        <p>
                            Salesroom
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo route('admin.salerooms.add')?>" class="nav-link">
                                <p>Thêm salesroom </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/salerooms/list" class="nav-link">
                                <p>Danh sách salesroom </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-money-bill"></i>
                        <p>
                            Hoá Đơn Nhập Hàng
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo route('admin.billreceiveds.add')?>" class="nav-link">
                                <p>Thêm hóa đơn nhập hàng </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/billreceiveds/list" class="nav-link">
                                <p>Danh sách hóa đơn nhập hàng </p>
                            </a>
                        </li>
{{--                        <li class="nav-item">--}}
{{--                            <a href="/admin/billreceiveds/backupDBFunc" class="nav-link">--}}
{{--                                <p>Backup DB</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}
                    </ul>

                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-lock"></i>
                        <p>
                            Xác Thực Dữ Liệu
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/accuracys/checkview" class="nav-link">
                                <p>Xác thực dữ liệu hệ thống</p>
                            </a>
                        </li>
                        {{--                        <li class="nav-item">--}}
                        {{--                            <a href="/admin/billreceiveds/backupDBFunc" class="nav-link">--}}
                        {{--                                <p>Backup DB</p>--}}
                        {{--                            </a>--}}
                        {{--                        </li>--}}
                    </ul>

                </li>


                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-money-check"></i>
                        <p>
                            Slider
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo route('admin.sliders.add')?>" class="nav-link">
                                <p>Thêm Slider </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/sliders/list" class="nav-link">
                                <p>Danh sách slider</p>
                            </a>
                        </li>
                    </ul>
                </li>



                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-pager"></i>
                        <p>
                            Page
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo route('home')?>" class="nav-link">
                                <p>Home</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo route('dangxuat')?>" class="nav-link">
                                <p>Đăng xuất</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    @if(session()->has('perr'))
                        @if(session()->get('perr') == 1)
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-universal-access"></i>
                                <p>
                                    User
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo route('admin.users.add')?>" class="nav-link">
                                        <p>Thêm user </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/admin/users/list" class="nav-link">
                                        <p>Danh sách user </p>
                                    </a>
                                </li>
                            </ul>
                        @endif
                    @endif
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
