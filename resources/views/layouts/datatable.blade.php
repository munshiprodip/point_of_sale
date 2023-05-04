<!DOCTYPE html>
<!-- beautify ignore:start -->

<html lang="en" class="dark-style layout-navbar-fixed layout-menu-fixed " dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('/assets') }}/" data-template="vertical-menu-template-dark">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title> @yield('title') | Laravel admin</title>
   
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="https://demos.pixinvent.com/vuexy-html-admin-template/assets/img/favicon/favicon.ico" />

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
                    <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z" fill="#7367F0" />
                        <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
                        <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z" fill="#7367F0" />
                    </svg>
                </span>
                <span class="app-brand-text demo menu-text fw-bold">Vuexy</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
                <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
            </a>
        </div>

        <div class="menu-inner-shadow"></div>

    
    
        <ul class="menu-inner py-1">
            <!-- Dashboards -->
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-mail"></i>
                    <div>Dashboard</div>
                </a>
            </li>

            <!-- Admins Area -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">ADMINS AREA</span>
            </li>

            <li class="menu-item {{ Route::currentRouteNamed('users') ?  'active' : '' }}">
                <a href="{{ route('users') }}" class="menu-link ">
                    <i class="menu-icon tf-icons ti ti-mail"></i>
                    <div>Users</div>
                </a>
            </li>
            <li class="menu-item {{ Route::currentRouteNamed('roles') ?  'active' : '' }}">
                <a href="{{ route('roles') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-mail"></i>
                    <div>Roles</div>
                </a>
            </li>
            <li class="menu-item {{ Route::currentRouteNamed('permissions') ?  'active' : '' }}">
                <a href="{{ route('permissions') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-mail"></i>
                    <div>Permissions</div>
                </a>
            </li>



            <!-- Doctors Area -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">DOCTOR ADMIN</span>
            </li>


            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-mail"></i>
                    <div>View Patient</div>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('appointments.create') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-mail"></i>
                    <div>Create Appointment</div>
                </a>
            </li>

            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-mail"></i>
                    <div>Today's Appointments</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-mail"></i>
                    <div>Appointments List</div>
                </a>
            </li>


            <!-- Settings Area -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">SETTINGS & OTHERS</span>
            </li>

            <li class="menu-item {{ request()->is('settings/medications/*') ?  'active open' : '' }} ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons ti ti-settings'></i>
                    <div>Medication Setup</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ Route::currentRouteNamed('generics') ?  'active' : '' }}">
                        <a href="{{ route('generics') }}" class="menu-link">
                            <div>Generic</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Route::currentRouteNamed('companies') ?  'active' : '' }}">
                        <a href="{{ route('companies') }}" class="menu-link">
                            <div>Company</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Route::currentRouteNamed('brands') ?  'active' : '' }}">
                        <a href="{{ route('brands') }}" class="menu-link">
                            <div>Brands</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Route::currentRouteNamed('doses') ?  'active' : '' }}">
                        <a href="{{ route('doses') }}" class="menu-link">
                            <div>Doses</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Route::currentRouteNamed('instructions') ?  'active' : '' }}">
                        <a href="{{ route('instructions') }}" class="menu-link">
                            <div>Instructions</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Route::currentRouteNamed('durations') ?  'active' : '' }}">
                        <a href="{{ route('durations') }}" class="menu-link">
                            <div>Durations</div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item {{ request()->is('settings/clinical/*') ?  'active open' : '' }} ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons ti ti-settings'></i>
                    <div>Clinical Setup</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->is('*/case_summary') ?  'active' : '' }}">
                        <a href="{{ route('clinical_components', 'case_summary') }}" class="menu-link">
                            <div>Case Summary</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('*/chief_complaints') ?  'active' : '' }}">
                        <a href="{{ route('clinical_components', 'chief_complaints') }}" class="menu-link">
                            <div>Chief Complaints</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('*/on_examination') ?  'active' : '' }}">
                        <a href="{{ route('clinical_components', 'on_examination') }}" class="menu-link">
                            <div>On Examinations</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('*/diagnosis') ?  'active' : '' }}">
                        <a href="{{ route('clinical_components', 'diagnosis') }}" class="menu-link">
                            <div>Diagnosis</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('*/investigations') ?  'active' : '' }}">
                        <a href="{{ route('clinical_components', 'investigations') }}" class="menu-link">
                            <div>Investigations</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('*/procedure') ?  'active' : '' }}">
                        <a href="{{ route('clinical_components', 'procedure') }}" class="menu-link">
                            <div>Procedures</div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item {{ request()->is('settings/profiles/*') ?  'active open' : '' }} ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons ti ti-settings'></i>
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
                    <li class="menu-item {{ Route::currentRouteNamed('brands') ?  'active' : '' }}">
                        <a href="{{ route('brands') }}" class="menu-link">
                            <div>App UI</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Route::currentRouteNamed('doses') ?  'active' : '' }}">
                        <a href="{{ route('doses') }}" class="menu-link">
                            <div>Shortcuts</div>
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
                <ul class="navbar-nav flex-row align-items-center ms-auto">

                    <!-- Quick links  -->
                    <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0">
                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            <i class='ti ti-layout-grid-add ti-md'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end py-0">
                            <div class="dropdown-menu-header border-bottom">
                                <div class="dropdown-header d-flex align-items-center py-3">
                                    <h5 class="text-body mb-0 me-auto">Shortcuts</h5>
                                    <a href="javascript:void(0)" class="dropdown-shortcuts-add text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Add shortcuts"><i class="ti ti-sm ti-apps"></i></a>
                                </div>
                            </div>
                        <div class="dropdown-shortcuts-list scrollable-container">
                            <div class="row row-bordered overflow-visible g-0">
                                <div class="dropdown-shortcuts-item col">
                                    <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                        <i class="ti ti-calendar fs-4"></i>
                                    </span>
                                    <a href="app-calendar.html" class="stretched-link">Calendar</a>
                                    <small class="text-muted mb-0">Appointments</small>
                                </div>
                                <div class="dropdown-shortcuts-item col">
                                    <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                        <i class="ti ti-file-invoice fs-4"></i>
                                    </span>
                                    <a href="app-invoice-list.html" class="stretched-link">Invoice App</a>
                                    <small class="text-muted mb-0">Manage Accounts</small>
                                </div>
                            </div>
                            <div class="row row-bordered overflow-visible g-0">
                                <div class="dropdown-shortcuts-item col">
                                    <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                        <i class="ti ti-users fs-4"></i>
                                    </span>
                                    <a href="app-user-list.html" class="stretched-link">User App</a>
                                    <small class="text-muted mb-0">Manage Users</small>
                                </div>
                                <div class="dropdown-shortcuts-item col">
                                    <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                        <i class="ti ti-lock fs-4"></i>
                                    </span>
                                    <a href="app-access-roles.html" class="stretched-link">Role Management</a>
                                    <small class="text-muted mb-0">Permission</small>
                                </div>
                            </div>
                            <div class="row row-bordered overflow-visible g-0">
                                <div class="dropdown-shortcuts-item col">
                                    <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                        <i class="ti ti-chart-bar fs-4"></i>
                                    </span>
                                    <a href="index.html" class="stretched-link">Dashboard</a>
                                    <small class="text-muted mb-0">User Profile</small>
                                </div>
                                <div class="dropdown-shortcuts-item col">
                                    <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                        <i class="ti ti-settings fs-4"></i>
                                    </span>
                                    <a href="pages-account-settings-account.html" class="stretched-link">Setting</a>
                                    <small class="text-muted mb-0">Account Settings</small>
                                </div>
                            </div>
                            <div class="row row-bordered overflow-visible g-0">
                                <div class="dropdown-shortcuts-item col">
                                    <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                        <i class="ti ti-help fs-4"></i>
                                    </span>
                                    <a href="pages-help-center-landing.html" class="stretched-link">Help Center</a>
                                    <small class="text-muted mb-0">FAQs & Articles</small>
                                </div>
                                <div class="dropdown-shortcuts-item col">
                                    <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                        <i class="ti ti-square fs-4"></i>
                                    </span>
                                    <a href="modal-examples.html" class="stretched-link">Modals</a>
                                    <small class="text-muted mb-0">Useful Popups</small>
                                </div>
                            </div>
                        </div>
                        </div>
                    </li>
                    <!-- Quick links -->


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
                                <a class="dropdown-item" href="#">
                                    <i class="ti ti-user-check me-2 ti-sm"></i>
                                    <span class="align-middle">My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
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

                @yield('content')

            </div>
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
                <div class="container-xxl">
                    <div class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
                    <div>
                        © 2023, made with ❤️ by <a href="https://facebook.com/munshiprodip/" target="_blank" class="fw-semibold">Prodip M</a>
                    </div>
                    <div>        
                        <a href="#" target="_blank" class="footer-link me-4">Documentation</a>
                        <a href="#" target="_blank" class="footer-link d-none d-sm-inline-block">Support</a>
                        
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
                        tags: true,
                        placeholder: "Select value",
                        dropdownParent: e.parent(),
                    });
                });

                $('.text-bn').bangla({ enable: true });
            });

            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
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
    <!-- <script src="{{ asset('assets/js/tables-datatables-advancedd.js"></script> -->
    
</body>

</html>

<!-- beautify ignore:end -->
