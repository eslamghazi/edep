<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Medad|Dashboard</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('assets/dashboard/plugins/fontawesome-free/all.min.css')}}">
    <!-- Theme style -->
    @vite(['public/assets/dashboard/css/adminlte-rtl.min.css'])
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Select2 -->
    <link href="{{asset('assets/dashboard/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />

    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{asset('assets/dashboard/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet"
        href="{{asset('assets/dashboard/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet"
        href="{{asset('assets/dashboard/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">


    <!--Toastr and Sweetalert -->
    <link rel="stylesheet" href="{{asset('assets/dashboard/plugins/sweetalert2/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/dashboard/plugins/toastr/toastr.min.css')}}">

    @yield('styles')

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                @hasanyrole('admin|super-admin')
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/dashboard" class="nav-link">الصفحة الرئيسية</a>
                </li>
                @endhasanyrole
                <li>
                    <form action="{{ route('dashboard.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link">
                            <i class="fa fa-sign-out"></i> تسجيل الخروج
                        </button>
                    </form>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

                <!-- Notifications Dropdown Menu -->
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">0</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">تصفح جميع الإشعارات</a>
                    </div>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="{{asset('assets/dashboard/img/icon-web.png')}}" alt="AdminLTE Logo"
                    class="brand-image elevation-3" style="opacity: .8; width:auto">
                <span style="font-size: 20px" class="brand-text font-weight-light">مـــداد</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 mb-3 d-flex">
                    <div class="image">
                        {{-- <img src="{{asset('assets/dashboard/img/Medad Logo final-06.png')}}"
                            class="img-circle elevation-2" alt="User Image"> --}}
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{auth()->user()->name ?? ''}}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                        @hasanyrole('admin|super-admin|contract-supervisor')
                        <li class="nav-item">
                            <a href="{{route('dashboard.home')}}" class="nav-link">
                                <i class="nav-icon fas fa-user-secret"></i>
                                <p>
                                    لوحة التحكم
                                </p>
                            </a>
                        </li>
                        @hasanyrole('admin|super-admin')
                        <li class="nav-item">
                            <a href="{{url('dashboard/users')}}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    المستخدمين
                                </p>
                            </a>
                        </li>
                        @endhasanyrole
                        <li class="nav-item">
                            <a href="{{url('dashboard/tickets')}}" class="nav-link">
                                <i class="nav-icon fas fa-ticket-alt"></i>
                                <p>
                                    طلبات الصيانة
                                </p>
                            </a>
                        </li>
                        @endhasanyrole
                        @role('user')
                        <li class="nav-item">
                            <a href="{{route('dashboard.tickets.support')}}" class="nav-link">
                                <i class="nav-icon fas fa-ticket-alt"></i>
                                <p>
                                    طلبات الصيانة
                                </p>
                            </a>
                        </li>
                        @endrole
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>


        @yield('main')

        <!-- Main Footer -->
        <footer class="main-footer d-flex justify-content-between">
            <div dir="ltr">
                <strong>&copy; {{ date('Y') }} <a target="_blank" href="https://medadalaamal.com/">Medad</a>.</strong> الحقوق محفوظة لمداد
            </div>
            <div>
                تم التنفيذ بواسطة <strong><a href="#">Qufa</a>.</strong>
            </div>
        </footer>


    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{asset('assets/dashboard/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('assets/dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('assets/dashboard/js/adminlte.js')}}"></script>

    <!-- Select2 -->
    <script src="{{asset('assets/dashboard/plugins/select2/js/select2.min.js')}}"></script>

    <!-- overlayScrollbars -->
    <script src="{{asset('assets/dashboard/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>

    <!-- jQuery Mapael -->
    <script src="{{asset('assets/dashboard/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
    <script src="{{asset('assets/dashboard/plugins/raphael/raphael.min.js')}}"></script>
    <script src="{{asset('assets/dashboard/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
    <script src="{{asset('assets/dashboard/plugins/jquery-mapael/usa_states.min.js')}}"></script>
    <!-- ChartJS -->
    <script src="{{asset('assets/dashboard/plugins/chart.js/Chart.min.js')}}"></script>

    <!-- DataTables  & Plugins -->
    <script src="{{asset('assets/dashboard/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/dashboard/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/dashboard/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/dashboard/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/dashboard/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/dashboard/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/dashboard/plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('assets/dashboard/plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/dashboard/js/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/dashboard/plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/dashboard/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/dashboard/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>

    <!--Toastr and Sweetalert -->
    <script src="{{asset('assets/dashboard/plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('assets/dashboard/plugins/toastr/toastr.min.js')}}"></script>

    <script src="{{asset('assets/dashboard/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

    <script>
        toastr.options.escapeHtml = true;
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "300",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        @if(Session::has('success'))
            toastr.success("{{Session::get('success')}}")
        @endif

        @if(Session::has('warning'))
            toastr.warning("{{Session::get('warning')}}")
        @endif

        @if(Session::has('info'))
            toastr.info("{{Session::get('info')}}")
        @endif

        @if(Session::has('error'))
            toastr.error("{{Session::get('error')}}")
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{$error}}")
            @endforeach
        @endif

    </script>

    <script src="{{asset('assets/dashboard/js/Chart.min.js')}}" charset="utf-8"></script>

    <script>
        function removeItem (url, e) {
        console.log(url);

            Swal.fire({
                title: 'هل تريد تأكيد الحذف  ',
                showCancelButton: true,
                confirmButtonText: 'تأكيد',
                cancelButtonText: 'إلغاء',
                confirmButtonColor:'#dc3545'
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $('#deleteItem').attr("action",url);
                    $('#deleteItem').submit();
                    Swal.fire('تم الحذف!', '', 'success')
                } else if (result.isDenied) {
                    Swal.fire('التغييرات لم تحفظ', '', 'info')
                }
            })
        };
    </script>

    @yield('scripts')

</body>

</html>
