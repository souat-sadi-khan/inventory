<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/home') }}" class="brand-link">
        <img
            src="{{ get_option('logo') && get_option('logo') != '' ? asset('storage/images/logo'). '/'. get_option('logo') : asset('images/logo.png') }}"
            alt="Brand Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span
            class="brand-text font-weight-light">{{get_option('site_title') && get_option('site_title') != '' ? substr(get_option('site_title'), 0, 11) : 'SATT IT'}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img
                    src="{{ (Auth::user()->image != 'user.png' ? asset('storage/images/user'. '/'. Auth::user()->image) : asset('images/user.png')) }}"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('admin.me') }}" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{ url('/home') }}" class="nav-link {{Request::is('home') ? 'active':''}}">
                        <i class="nav-icon fa fa-tachometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @if(auth()->user()->can('customer.view') or auth()->user()->can('customer.create'))
                    {{-- Customer --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.customer.index') }}"
                           class="nav-link {{Request::is('admin/customer*') ? 'active':''}}">
                            <i class="nav-icon fa fa-user"></i>
                            <p>Customer</p>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->can('supplier.view') or auth()->user()->can('supplier.create'))
                    {{-- Supplier --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.supplier.index') }}"
                           class="nav-link {{Request::is('admin/supplier*') ? 'active':''}}">
                            <i class="nav-icon fa fa-truck"></i>
                            <p>Supplier</p>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->can('productInitialize.view') or auth()->user()->can('productInitialize.create'))
                    {{-- Product Initialize --}}
                    <li class="nav-item has-treeview {{ Request::is('admin/product-initiazile*') ? 'menu-open' : '' }} ">
                        <a href="#" class="nav-link {{ Request::is('admin/product-initiazile*') ? 'active' : '' }} ">
                            <i class="nav-icon fa fa-cog"></i>
                            <p>
                                Product Initialize
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                                {{-- Category --}}
                                <li class="nav-item">
                                    <a href="{{ route('admin.product-initiazile.category.index') }} "
                                       class="nav-link {{ Request::is('admin/product-initiazile/category') ? 'active' : '' }}">
                                        <i class="fa fa-stop-circle nav-icon"></i>
                                        <p>Category</p>
                                    </a>
                                </li>

                                {{-- Brand --}}
                                <li class="nav-item">
                                    <a href="{{ route('admin.product-initiazile.brand.index') }} "
                                       class="nav-link {{ Request::is('admin/product-initiazile/brand') ? 'active' : '' }}">
                                        <i class="fa fa-stop-circle nav-icon"></i>
                                        <p>Brand</p>
                                    </a>
                                </li>

                                {{-- Unit --}}
                                <li class="nav-item">
                                    <a href="{{ route('admin.product-initiazile.unit.index') }} "
                                       class="nav-link {{ Request::is('admin/product-initiazile/unit') ? 'active' : '' }}">
                                        <i class="fa fa-stop-circle nav-icon"></i>
                                        <p>Unit</p>
                                    </a>
                                </li>
                                {{-- Box --}}
                                <li class="nav-item">
                                    <a href="{{ route('admin.product-initiazile.box.index') }} "
                                       class="nav-link {{ Request::is('admin/product-initiazile/box') ? 'active' : '' }}">
                                        <i class="fa fa-stop-circle nav-icon"></i>
                                        <p>Box</p>
                                    </a>
                                </li>

                                {{-- TaxRate --}}
                                <li class="nav-item">
                                    <a href="{{ route('admin.product-initiazile.taxrate.index') }} "
                                       class="nav-link {{ Request::is('admin/product-initiazile/taxrate') ? 'active' : '' }}">
                                        <i class="fa fa-stop-circle nav-icon"></i>
                                        <p>TaxRate</p>
                                    </a>
                                </li>
                        </ul>
                    </li>
                @endif

                @if(auth()->user()->can('inventoryItem.view') or auth()->user()->can('inventoryItem.create'))
                    {{-- Product Section --}}
                    <li class="nav-item has-treeview {{ Request::is('admin/products*') ? 'menu-open' : '' }} ">
                        <a href="#" class="nav-link {{ Request::is('admin/products*') ? 'active' : '' }} ">
                            <i class="nav-icon fa fa-instagram"></i>
                            <p>
                                Inventory Items
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                                {{-- Product --}}
                                <li class="nav-item">
                                    <a href="{{ route('admin.products.products.index') }} "
                                       class="nav-link {{ Request::is('admin/products/products*') ? 'active' : '' }}">
                                        <i class="fa fa-stop-circle nav-icon"></i>
                                        <p>Products Manage</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.products.product_filter') }} "
                                       class="nav-link {{ Request::is('admin/products/product-filter') ? 'active' : '' }}">
                                        <i class="fa fa-stop-circle nav-icon"></i>
                                        <p>Product Filter</p>
                                    </a>
                                </li>


                        </ul>
                    </li>
                @endif

                @if(auth()->user()->can('purchase.view') or auth()->user()->can('purchase.create'))
                    {{-- Purchase Section --}}
                    <li class="nav-item has-treeview {{ Request::is('admin/purchase-voucher*') ? 'menu-open' : '' }} ">
                        <a href="#" class="nav-link {{ Request::is('admin/purchase-voucher*') ? 'active' : '' }} ">
                            <i class="nav-icon fa fa-shopping-cart"></i>
                            <p>
                                Purchase Voucher
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                                {{-- Product --}}
                                <li class="nav-item">
                                    <a href="{{ route('admin.pur_voucher.purchase.create') }} "
                                       class="nav-link {{ Request::is('admin/purchase-voucher/purchase/create') ? 'active' : '' }}">
                                        <i class="fa fa-stop-circle nav-icon"></i>
                                        <p>Purchase</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.pur_voucher.purchase.index') }} "
                                       class="nav-link {{ Request::is('admin/purchase-voucher/purchase') ? 'active' : '' }}">
                                        <i class="fa fa-stop-circle nav-icon"></i>
                                        <p>Purchase List</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.pur_voucher.return.create') }} "
                                       class="nav-link {{ Request::is('admin/purchase-voucher/return/create') ? 'active' : '' }}">
                                        <i class="fa fa-stop-circle nav-icon"></i>
                                        <p>Return</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.pur_voucher.return.index') }} "
                                       class="nav-link {{ Request::is('admin/purchase-voucher/return') ? 'active' : '' }}">
                                        <i class="fa fa-stop-circle nav-icon"></i>
                                        <p>Return List</p>
                                    </a>
                                </li>


                        </ul>
                    </li>
                @endif



                @if(auth()->user()->can('sale.view') or auth()->user()->can('sale.create'))
                    {{-- Sale Section --}}
                    <li class="nav-item has-treeview {{ Request::is('admin/sale-voucher*') ? 'menu-open' : '' }} ">
                        <a href="#" class="nav-link {{ Request::is('admin/sale-voucher*') ? 'active' : '' }} ">
                            <i class="nav-icon fa fa-star"></i>
                            <p>
                                Sale Voucher
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                                {{-- Sale --}}
                                <li class="nav-item">
                                    <a href="{{ route('admin.sale_voucher.sale.create',['sale_type'=>'retail']) }}"
                                       class="nav-link {{ (\Request::route()->getName() == 'this.route') ? 'active' : '' }}">
                                        <i class="fa fa-stop-circle nav-icon"></i>
                                        <p>Retail Sale</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.sale_voucher.sale.create',['sale_type'=>'wholesale']) }} "
                                       class="nav-link {{ Request::is('admin/sale-voucher/sale/create?sale_type=wholesale') ? 'active' : '' }}">
                                        <i class="fa fa-stop-circle nav-icon"></i>
                                        <p>Whole Sale</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.sale_voucher.sale.index') }} "
                                       class="nav-link {{ Request::is('admin/sale-voucher/sale') ? 'active' : '' }}">
                                        <i class="fa fa-stop-circle nav-icon"></i>
                                        <p>Sale List</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.sale_voucher.return.create') }} "
                                       class="nav-link {{ Request::is('admin/sale-voucher/return/create') ? 'active' : '' }}">
                                        <i class="fa fa-stop-circle nav-icon"></i>
                                        <p>Return</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.sale_voucher.return.index') }} "
                                       class="nav-link {{ Request::is('admin/sale-voucher/return') ? 'active' : '' }}">
                                        <i class="fa fa-stop-circle nav-icon"></i>
                                        <p>Return List</p>
                                    </a>
                                </li>


                        </ul>
                    </li>
                @endif
                {{-- @if(auth()->user()->can('paymentAccount.create'))
                <li class="nav-item">
                    <a href="{{ route('admin.Payment_account') }}"
                       class="nav-link {{Request::is('admin/payment/account*') ? 'active':''}}">
                        <i class="nav-icon fa fa-address-card"></i>
                        <p>Payment Account</p>
                    </a>
                </li>
                @endif --}}
                @if(auth()->user()->can('account.create') or auth()->user()->can('account.view'))
                    {{-- Account --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.account.index') }}"
                           class="nav-link {{Request::is('admin/account') ? 'active':''}}">
                            <i class="nav-icon fa fa-address-card"></i>
                            <p>Account</p>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->can('account-trans.create') or auth()->user()->can('account-trans.view'))
                    {{-- Account --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.account-trans.index') }}"
                           class="nav-link {{Request::is('admin/account-trans*') ? 'active':''}}">
                            <i class="nav-icon fa fa-credit-card-alt"></i>
                            <p>Transaction List</p>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->can('voucher.create') or auth()->user()->can('voucher.view'))
                    {{-- Account --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.vaucher.index') }}"
                           class="nav-link {{Request::is('admin/vaucher*') ? 'active':''}}">
                            <i class="nav-icon fa fa-calculator"></i>
                            <p>Create Voucher</p>
                        </a>
                    </li>
                @endif



                @if(auth()->user()->can('report.view'))
                    {{-- Report --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.report.index') }}"
                           class="nav-link {{Request::is('admin/report*') ? 'active':''}}">
                            <i class="nav-icon fa fa-file-archive-o"></i>
                            <p>Report</p>
                        </a>
                    </li>
                @endif



                {{-- Loan Manage --}}
                @if(auth()->user()->can('vehicle.create') or auth()->user()->can('vehicle.view') or auth()->user()->can('vehicleIncomeExpense.create') or auth()->user()->can('vehicleIncomeExpense.view'))
                <li class="nav-item has-treeview {{ Request::is('admin/vehicle*') ? 'menu-open' : '' }} ">
                    <a href="#" class="nav-link {{ Request::is('admin/vehicle*') ? 'active' : '' }} ">
                        <i class="nav-icon fa fa-truck"></i>
                        <p>
                            Vehicle
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        @if(auth()->user()->can('vehicle.create') or auth()->user()->can('vehicle.view'))
                        <li class="nav-item">
                            <a href="{{ route('admin.vehicle-type.index') }} "
                               class="nav-link {{ Request::is('admin/vehicle-type*') ? 'active' : '' }}">
                                <i class="fa fa-stop-circle nav-icon"></i>
                                <p>Vehicle Type</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.vehicle.index') }} "
                               class="nav-link {{ Request::is('admin/vehicle') ? 'active' : '' }}">
                                <i class="fa fa-stop-circle nav-icon"></i>
                                <p>Vehicle List</p>
                            </a>
                        </li>
                            @endif
                            @if(auth()->user()->can('vehicleIncomeExpense.create') or auth()->user()->can('vehicleIncomeExpense.view'))
                        <li class="nav-item">
                            <a href="{{ route('admin.vehicle-transaction.index') }} "
                               class="nav-link {{ Request::is('admin/vehicle-transaction') ? 'active' : '' }}">
                                <i class="fa fa-stop-circle nav-icon"></i>
                                <p>Income/Expence</p>
                            </a>
                        </li>
                                @endif
                    </ul>
                </li>
@endif

                {{-- Loan Manage --}}
             {{--   <li class="nav-item has-treeview {{ Request::is('admin/loan*') ? 'menu-open' : '' }} ">
                    <a href="#" class="nav-link {{ Request::is('admin/loan*') ? 'active' : '' }} ">
                        <i class="nav-icon fa fa-tasks"></i>
                        <p>
                            Loan Manage
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.loan.index') }} "
                               class="nav-link {{ Request::is('admin/loan') ? 'active' : '' }}">
                                <i class="fa fa-stop-circle nav-icon"></i>
                                <p>Loan List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.loan.summery') }} "
                               class="nav-link {{ Request::is('admin/loan/summery') ? 'active' : '' }}">
                                <i class="fa fa-stop-circle nav-icon"></i>
                                <p>Summary</p>
                            </a>
                        </li>
                    </ul>
                </li>
--}}
                {{-- Settings --}}
                @if(auth()->user()->can('settings.view'))
                <li class="nav-item has-treeview {{ Request::is('admin/settings*') ||Request::is('invoice-layout*') ? 'menu-open' : '' }} ">
                    <a href="#"
                       class="nav-link {{ Request::is('admin/settings*') ||Request::is('invoice-layout*') ? 'active' : '' }} ">
                        <i class="nav-icon fa fa-cog"></i>
                        <p>
                            Settings
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.general.settings') }} "
                               class="nav-link {{ Request::is('admin/settings/general') ? 'active' : '' }}">
                                <i class="fa fa-stop-circle nav-icon"></i>
                                <p>General Settings</p>
                            </a>
                        </li>

                        {{--               <li class="nav-item">
                                          <a href="{{ route('invoice_layout') }} " class="nav-link {{ Request::is('invoice-layout') ? 'active' : '' }}">
                                              <i class="fa fa-stop-circle nav-icon"></i>
                                              <p>Invoice Layout</p>
                                          </a>
                                      </li> --}}
                    </ul>
                </li>
                @endif
                @if(auth()->user()->can('role.create') or auth()->user()->can('role.view') or auth()->user()->can('user.create') or auth()->user()->can('user.view'))
                {{-- User Manage --}}
                <li class="nav-item has-treeview {{ Request::is('admin/user*') ? 'menu-open' : '' }} ">
                    <a href="#" class="nav-link {{ Request::is('admin/user*') ? 'active' : '' }} ">
                        <i class="nav-icon fa fa-user-times"></i>
                        <p>
                            User Manage
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>

                    @if(auth()->user()->can('role.create') or auth()->user()->can('role.view'))
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.user.role') }} "
                               class="nav-link {{ Request::is('admin/user/role') ? 'active' : '' }}">
                                <i class="fa fa-stop-circle nav-icon"></i>
                                <p>Role</p>
                            </a>
                        </li>
                    </ul>
                    @endif
                    @if(auth()->user()->can('user.create') or auth()->user()->can('user.view'))
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.user.index') }} "
                               class="nav-link {{ Request::is('admin/user') ? 'active' : '' }}">
                                <i class="fa fa-stop-circle nav-icon"></i>
                                <p>User</p>
                            </a>
                        </li>
                    </ul>
                        @endif
                </li>

                    @endif

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
