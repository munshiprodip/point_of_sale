<!DOCTYPE html>
<!-- beautify ignore:start -->

<html lang="en" class="dark-style layout-navbar-fixed layout-menu-fixed " dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('/assets') }}/" data-template="vertical-menu-template-dark">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title> @yield('title') | Point of Sale</title>
   
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core-dark.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default-dark.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.45.0/tabler-icons.min.css">
    
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />

    <!-- Page CSS -->
    @yield('style')

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar  ">
    <div class="layout-container">

    <!-- Menu -->
    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo ">
            <a href="{{ route('dashboard') }}" class="app-brand-link">
                <span class="app-brand-logo demo">
                    <img width="32" height="22" src="{{ asset('/images/logo/').'/'.'app-logo.png' }}" alt="">
                </span>
                <span class="app-brand-text demo menu-text fw-bold">OPTICS</span>
            </a>
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
                <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
            </a>
        </div>

        <div class="menu-inner-shadow"></div>

    
    
        <ul class="menu-inner py-1">
            <!-- Dashboards -->
            <li class="menu-item {{ Route::currentRouteNamed('dashboard') ?  'active' : '' }}">
                <a href="{{route('dashboard')}}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-dashboard"></i>
                    <div>Dashboard</div>
                </a>
            </li>
            @can('Shop Settings')
            <li class="menu-item {{ Route::currentRouteNamed('shops.settings') ?  'active' : '' }}">
                <a href="{{ route('shops.settings') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-building-bank"></i>
                    <div>Shop Settings</div>
                </a>
            </li>
            @endcan
            @canany(['Read User','Read Role','Read Permission'])
                <!-- Admins Area -->
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">ADMINS AREA</span>
                </li>
                @can('Read User')
                <li class="menu-item {{ Route::currentRouteNamed('users') ?  'active' : '' }}">
                    <a href="{{ route('users') }}" class="menu-link ">
                        <i class="menu-icon tf-icons ti ti-users"></i>
                        <div>Users</div>
                    </a>
                </li>
                @endcan
                @can('Read Role')
                <li class="menu-item {{ Route::currentRouteNamed('roles') ?  'active' : '' }}">
                    <a href="{{ route('roles') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-forms"></i>
                        <div>Roles</div>
                    </a>
                </li>
                @endcan
                @can('Read Permission')
                <li class="menu-item {{ Route::currentRouteNamed('permissions') ?  'active' : '' }}">
                    <a href="{{ route('permissions') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-lock"></i>
                        <div>Permissions</div>
                    </a>
                </li>
                @endcan
            @endcanany




            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">POS MENU</span>
            </li>
            @can('Create Invoices')
            <li class="menu-item {{ Route::currentRouteNamed('pos') ?  'active' : '' }}">
                <a href="{{ route('pos') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-device-desktop-analytics"></i>
                    <div>POS</div>
                </a>
            </li>
            @endcan
            @canany(['View Products', 'Create Products'])
            <li class="menu-item {{ Route::currentRouteNamed('products.*') ?  'active open' : '' }} ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons ti ti-brand-stackoverflow'></i>
                    <div>Products</div>
                </a>
                
                <ul class="menu-sub">
                    @can('View Products')
                    <li class="menu-item {{ Route::currentRouteNamed('products.list') ?  'active' : '' }}">
                        <a href="{{ route('products.list') }}" class="menu-link">
                            <div>Product List</div>
                        </a>
                    </li>
                    @endcan
                    @can('Create Products')
                    <li class="menu-item {{ Route::currentRouteNamed('products.create') ?  'active' : '' }}">
                        <a href="{{ route('products.create') }}" class="menu-link">
                            <div>Add New Product</div>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany
            @canany(['View Requisitions', 'Create Requisitions'])
            <li class="menu-item {{ Route::currentRouteNamed('requisitions.*') ?  'active open' : '' }} ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons ti ti-trolley'></i>
                    <div>Requisitions</div>
                </a>
                <ul class="menu-sub">
                    @can('View Requisitions')
                    <li class="menu-item {{ Route::currentRouteNamed('requisitions.list') ?  'active' : '' }}">
                        <a href="{{ route('requisitions.list') }}" class="menu-link">
                            <div>Requisitions List</div>
                        </a>
                    </li>
                    @endcan
                    @can('Create Requisitions')
                    <li class="menu-item {{ Route::currentRouteNamed('requisitions') ?  'active' : '' }}">
                        <a href="{{ route('requisitions.create') }}" class="menu-link">
                            <div>New Requisition</div>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany
            @canany(['View Purchases', 'Create Purchases'])
            <li class="menu-item {{ Route::currentRouteNamed('purchases.*') ?  'active open' : '' }} ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons ti ti-shopping-cart-plus'></i>
                    <div>Purchases</div>
                </a>
                <ul class="menu-sub">
                    @can('View Purchases')
                    <li class="menu-item {{ Route::currentRouteNamed('purchases.list') ?  'active' : '' }}">
                        <a href="{{ route('purchases.list') }}" class="menu-link">
                            <div>Purchases List</div>
                        </a>
                    </li>
                    @endcan
                    @can('Create Purchases')
                    <li class="menu-item {{ Route::currentRouteNamed('purchases.create') ?  'active' : '' }}">
                        <a href="{{ route('purchases.create') }}" class="menu-link">
                            <div>New Purchases</div>
                        </a>
                    </li>
                    @endcan

                </ul>
            </li>
            @endcanany
            @can('View Invoices')
            <li class="menu-item {{ Route::currentRouteNamed('invoices.*') ?  'active open' : '' }} ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons ti ti-receipt-2'></i>
                    <div>Invoices</div>
                </a>
                <ul class="menu-sub">
                    @can('View Invoices')
                    <li class="menu-item {{ Route::currentRouteNamed('invoices.list') ?  'active' : '' }}">
                        <a href="{{ route('invoices.list') }}" class="menu-link">
                            <div>Invoice List</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Route::currentRouteNamed('invoices.due_list') ?  'active' : '' }}">
                        <a href="{{ route('invoices.due_list') }}" class="menu-link">
                            <div>Due Invoice List</div>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('View Payments')
            <li class="menu-item {{ Route::currentRouteNamed('payments.*') ?  'active open' : '' }} ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons ti ti-currency-dollar'></i>
                    <div>Payments</div>
                </a>
                <ul class="menu-sub">
                    @can('View Payments')
                    <li class="menu-item {{ Route::currentRouteNamed('payments.list') ?  'active' : '' }}">
                        <a href="{{ route('payments.list') }}" class="menu-link">
                            <div>Payments</div>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @canany(['View Deposits History', 'Create Cash Deposite', 'Cash Receive'])
            <li class="menu-item {{ Route::currentRouteNamed('cash_deposites.*') ?  'active open' : '' }} ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons ti ti-chart-histogram'></i>
                    <div>Accounts</div>
                </a>
                <ul class="menu-sub">
                    @canany(['Create Cash Deposite', 'Cash Receive'])
                    <li class="menu-item {{ Route::currentRouteNamed('cash_deposites.list') ?  'active' : '' }}">
                        <a href="{{ route('cash_deposites.list') }}" class="menu-link">
                            <div>Cash Handover</div>
                        </a>
                    </li>
                    @endcanany
                    @can('View Deposits History')
                    <li class="menu-item {{ Route::currentRouteNamed('cash_deposites.verified') ?  'active' : '' }}">
                        <a href="{{ route('cash_deposites.verified') }}" class="menu-link">
                            <div>Handover History</div>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany

            @canany(['View Damages', 'Create Damages'])
            <li class="menu-item {{ Route::currentRouteNamed('damages.*') ?  'active open' : '' }} ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons ti ti-shopping-cart-off'></i>
                    <div>Damage</div>
                </a>
                <ul class="menu-sub">
                    @canany(['Create Damages', 'Verify Damages'])
                    <li class="menu-item {{ Route::currentRouteNamed('damages.list') ?  'active' : '' }}">
                        <a href="{{ route('damages.list') }}" class="menu-link">
                            <div>Damages</div>
                        </a>
                    </li>
                    @endcanany
                    @can('View Damages')
                    <li class="menu-item {{ Route::currentRouteNamed('damages.verified') ?  'active' : '' }}">
                        <a href="{{ route('damages.verified') }}" class="menu-link">
                            <div>Damaged List</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Route::currentRouteNamed('damages.canceled') ?  'active' : '' }}">
                        <a href="{{ route('damages.canceled') }}" class="menu-link">
                            <div>Canceled Request</div>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany





            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">REPORTS</span>
            </li>
            <li class="menu-item {{ Route::currentRouteNamed('reports.*') ?  'active open' : '' }} ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons ti ti-file-type-pdf'></i>
                    <div>Generate Report</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ Route::currentRouteNamed('reports.stock_form') ?  'active' : '' }}">
                        <a href="{{ route('reports.stock_form') }}" class="menu-link">
                            <div>Stock Report</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Route::currentRouteNamed('reports.purchase_form') ?  'active' : '' }}">
                        <a href="{{ route('reports.purchase_form') }}" class="menu-link">
                            <div>Purchases Report</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Route::currentRouteNamed('reports.sell_form') ?  'active' : '' }}">
                        <a href="{{ route('reports.sell_form') }}" class="menu-link">
                            <div>Sales Report</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Route::currentRouteNamed('reports.damage_form') ?  'active' : '' }}">
                        <a href="{{ route('reports.damage_form') }}" class="menu-link">
                            <div>Damages Report</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Route::currentRouteNamed('reports.cash_deposite_form') ?  'active' : '' }}">
                        <a href="{{ route('reports.cash_deposite_form') }}" class="menu-link">
                            <div>Cash Handover Report</div>
                        </a>
                    </li>
                </ul>
            </li>

         
            

            <!-- Profile setup Area -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">PRSONALIZATION</span>
            </li>

            <li class="menu-item {{ request()->is('settings/profiles/*') ?  'active open' : '' }} ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons ti ti-adjustments'></i>
                    <div>Profile Settings</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ Route::currentRouteNamed('profiles.account') ?  'active' : '' }}">
                        <a href="{{ route('profiles.account') }}" class="menu-link">
                            <div>Account</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Route::currentRouteNamed('profiles.security') ?  'active' : '' }}">
                        <a href="{{ route('profiles.security') }}" class="menu-link">
                            <div>Security</div>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
    <!-- / Menu -->

    

    <!-- Layout container -->
    <div class="layout-page">
      
        <!-- Navbar -->
        <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    

            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0   d-xl-none ">
                <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                    <i class="ti ti-menu-2 ti-sm"></i>
                </a>
            </div>
            
            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                @hasrole('Salesman')
                <div class="navbar-nav align-items-center">
                    <div class="nav-item navbar-search-wrapper mb-0">
                        <a class="nav-item nav-link search-toggler d-flex align-items-center px-0" href="#">Your balance 
                        <i class="ti ti-currency-taka ti-md me-2"></i>
                        <span class="d-none d-md-inline-block text-muted">{{ auth()->user()->cashinhand }}</span>
                        </a>
                    </div>
                </div>
                @endhasrole
                <ul class="navbar-nav flex-row align-items-center ms-auto">
                    <!-- User -->
                    <li class="nav-item navbar-dropdown dropdown-user dropdown">
                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                            <div class="avatar avatar-online">
                                <img src="{{ asset('avaters').'/'.auth()->user()->avater}}" alt class="h-auto rounded-circle">
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar avatar-online">
                                                <img src="{{ asset('avaters').'/'.auth()->user()->avater}}" alt class="h-auto rounded-circle">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <span class="fw-semibold d-block">{{ auth()->user()->name }}</span>
                                            <small class="text-muted">{{ auth()->user()->getRoleNames()[0] }}</small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profiles.account') }}">
                                    <i class="ti ti-settings me-2 ti-sm"></i>
                                    <span class="align-middle">Settings</span>
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <a class="dropdown-item" href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        <i class="ti ti-logout me-2 ti-sm"></i>
                                        <span class="align-middle">Log Out</span>
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </li>
                <!--/ User -->
                </ul>
            </div>
        </nav>
        <!-- / Navbar -->
        <!-- Content wrapper -->
        <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
                <h4 class="py-3 mb-4"> <a href="{{ route('dashboard') }}"><span class="text-muted fw-light">Home /</span></a> @yield('title')</h4>
                @yield('content')

            </div>
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
                <div class="container-xxl">
                    <div class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
                    <div>
                        Developed by  &copy; <a href="#" target="_blank" class="fw-semibold">KYAMCH IT</a>
                    </div>
                    <div>        
                        <a href="#" class="footer-link d-none d-sm-inline-block">Point of sale</a>
                    </div>
                    </div>
                </div>
            </footer>
            <!-- / Footer -->

          
            <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    
    
    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
    
    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
    

    
  </div>
  <!-- / Layout wrapper -->



    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    
    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/jquery.bangla.js') }}"></script>
    

    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <!-- Flat Picker -->
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        $(document).ready(function () {
            $(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                
                $(".select3").each(function () {
                    var e = $(this);
                    e.wrap('<div class="position-relative"></div>').select2({
                        placeholder: "Select value",
                        dropdownParent: e.parent(),
                    });
                });

                $('.text-bn').bangla({ enable: true });
            });

            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
            });

            let datePickr = $('.pick-date');
            datePickr && datePickr.flatpickr({
                defaultDate: "today",
                monthSelectorType: "static"
            });

            let timePickr = $('.pick-time');
            timePickr && timePickr.flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
            });

            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "2000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            
        });
    </script>

    <!-- Page JS -->
    @yield('script')
   
</body>

</html>

<!-- beautify ignore:end -->