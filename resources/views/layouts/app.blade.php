<!DOCTYPE html>
<html>


<?php

use Illuminate\Support\Facades\Auth;

$roleadmin = Auth::user()->role;

$userhalo = Auth::user()->email;



?>


<head>

    <meta charset="utf-8" />

    <title>Booking Ruang Rapat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">

    <!-- DataTables -->
    <link href="{{asset('plugins/datatables/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/datatables/responsive.bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/datatables/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('plugins/bootstrap-sweetalert/sweet-alert.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">






    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/icons.css')}}" rel="stylesheet" type="text/css">
    <!-- <link href="css/style.css" rel="stylesheet" type="text/css"> -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" /> -->


</head>


<body class="fixed-left">

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Top Bar Start -->
        <div class="topbar">
            <!-- LOGO -->
            <div class="topbar-left">
                <div class="text-center">
                    <a href="home" class="logo"><img src="images/logopt.png" height="28"></a>
                </div>
            </div>
            <!-- Button mobile view to collapse sidebar menu -->
            <div class="navbar navbar-default" role="navigation">
                <div class="container">
                    <div class="">
                        <div class="pull-left">
                            <button type="button" class="button-menu-mobile open-left waves-effect waves-light">
                                <i class="ion-navicon"></i>
                            </button>
                            <span class="clearfix"></span>
                        </div>


                        <!-- <ul class="nav navbar-nav navbar-right pull-right">
                            <li class="dropdown hidden-xs">
                                <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                                    <i class="fa fa-bell"></i> <span class="badge badge-xs badge-danger"></span>
                                </a>

                            </li>
                            <li class="hidden-xs">
                                <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="fa fa-crosshairs"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true"><img src="images/users/avatar.png" alt="user-img" class="img-circle"> </a>
                                <ul class="dropdown-menu">

                                    <li> <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                    <li><a href="{{ route('register') }}">Register</a></li>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                            </li>
                        </ul> -->
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <!-- Top Bar End -->


        <!-- ========== Left Sidebar Start ========== -->

        <div class="left side-menu">
            <div class="sidebar-inner slimscrollleft">
                <div class="user-details">
                    <div class="text-center">

                    </div>
                    <div class="user-info">
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Booking Ruang Rapat</a>
                        </div>

                        <p class="text-muted m-0"><i class="fa fa-dot-circle-o text-success"></i></p>
                    </div>
                    <center>
                        <h6 class="text-white"> Hai, {{$userhalo}}</h6>
                    </center>
                </div>
                <!--- Divider -->
                <div id="sidebar-menu">

                    <ul>
                        <li>
                            <a href="http://localhost:8000/home" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                        </li>

                        <?php
                        if ($roleadmin < 3) { ?> <li class="dropdown">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-agenda"></i> <span> Data Master </span> <span class="pull-right"><i class="mdi mdi-plus"></i></span></a>

                                <ul class="list-unstyled">

                                    <li>


                                        <a href="{{ route('ruangRapat') }}" class="waves-effect"><i class="ion-ios7-home"></i><span> Ruang Rapat <span class="badge badge-primary pull-right"></span></span></a>
                                    </li>
                                    <li>
                                        <a href="{{ route('pegawai')}}" class="waves-effect"><i class="ti-user"></i><span> Admin <span class="badge badge-primary pull-right"></span></span></a>
                                    </li>
                                    <li>
                                        <a href="{{ route('fasilitas_baru')}}" class="waves-effect"><i class="ti-desktop"></i><span> Fasilitas <span class="badge badge-primary pull-right"></span></span></a>
                                    </li>
                                    <li>
                                        <a href="{{ route('fasilitas')}}" class="waves-effect"><i class="ti-desktop"></i><span> Fasilitas Tambahan <span class="badge badge-primary pull-right"></span></span></a>
                                    </li>
                                    <li>
                                        <a href="{{ route('divisi')}}" class="waves-effect"><i class="fa fa-slideshare"></i><span> Divisi <span class="badge badge-primary pull-right"></span></span></a>
                                    </li>
                                    <li>
                                        <a href="{{ route('dataPegawai')}}" class="waves-effect"><i class="fa fa-users"></i><span> Pegawai <span class="badge badge-primary pull-right"></span></span></a>
                                    </li>



                                </ul>
                            </li>
                        <?php } else {
                        } ?>



                        <li>
                            <a href="{{ route('permohonan_rapat')}}" class="waves-effect"><i class="fa fa-calendar-plus-o"></i><span> Permohonan Rapat </span></a>
                        </li>
                        <li>
                            <a href="{{ route('agenda')}}" class="waves-effect"><i class="fa fa-calendar-check-o"></i><span> Jadwal </span></a>
                        </li>

                        <!-- <li>
                            <a href="{{ route('password.request') }}">Forgot Password</a>
                        </li> -->

                        <li class="dropdown">
                            <a href="javascript:void(0);" class="waves-effect"><i class="ti-user"></i> <span> Manajemen Profil </span> <span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                            <ul class="list-unstyled">
                                <li> <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                        <i class="mdi mdi-logout"></i><span></span></a>

                                    <?php if ($roleadmin < 3) {

                                    ?>
                                <li><a href="{{ route('register') }}">Register</a></li>
                            <?php } else {
                                    } ?>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> <i class="ion-log-out">
                                </i>
                                @csrf
                            </form>
                            </ul>
                        </li>

                        <!-- <li>
                            <a href="" class="waves-effect"><i class="fa fa-sticky-note"></i><span> Permohonan Rapat </span></a>
                        </li> -->

                        <!--<li class="has_sub">-->
                        <!--<a href="javascript:void(0);" class="waves-effect"><i class="ti-share"></i><span>Multi Menu </span><span class="pull-right"><i class="mdi mdi-plus"></i></span></a>-->
                        <!--<ul>-->
                        <!--<li class="has_sub">-->
                        <!--<a href="javascript:void(0);" class="waves-effect"><span>Menu Item 1.1</span> <span class="pull-right"><i class="mdi mdi-plus"></i></span></a>-->
                        <!--<ul style="">-->
                        <!--<li><a href="javascript:void(0);"><span>Menu Item 2.1</span></a></li>-->
                        <!--<li><a href="javascript:void(0);"><span>Menu Item 2.2</span></a></li>-->
                        <!--</ul>-->
                        <!--</li>-->
                        <!--<li>-->
                        <!--<a href="javascript:void(0);"><span>Menu Item 1.2</span></a>-->
                        <!--</li>-->
                        <!--</ul>-->
                        <!--</li>-->
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div> <!-- end sidebarinner -->
        </div>
        <!-- Left Sidebar End -->

        <!-- Start right Content here -->

        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <div class="container">
                    @yield('content')
                </div>
                <footer class="footer">
                    Haikal Ar-2023
                </footer>

            </div>
            <!-- End Right content here -->

        </div>
        <!-- END wrapper -->


        <!-- jQuery  -->
        <script src="{{asset('js/jquery.min.js')}}"></script>
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        <script src="{{asset('js/modernizr.min.js')}}"></script>
        <script src="{{asset('js/detect.js')}}"></script>
        <script src="{{asset('js/fastclick.js')}}"></script>
        <script src="{{asset('js/jquery.slimscroll.js')}}"></script>
        <script src="{{asset('js/jquery.blockUI.js')}}"></script>
        <script src="{{asset('js/waves.js')}}"></script>
        <script src="{{asset('js/wow.min.js')}}"></script>
        <script src="{{asset('js/jquery.nicescroll.js')}}"></script>
        <script src="{{asset('js/jquery.scrollTo.min.js')}}"></script>

        <script src="plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

        <!-- Datatables-->
        <script src="plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap.js"></script>
        <script src="plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="plugins/datatables/buttons.bootstrap.min.js"></script>
        <script src="plugins/datatables/jszip.min.js"></script>
        <script src="plugins/datatables/pdfmake.min.js"></script>
        <script src="plugins/datatables/vfs_fonts.js"></script>
        <script src="plugins/datatables/buttons.html5.min.js"></script>
        <script src="plugins/datatables/buttons.print.min.js"></script>
        <script src="plugins/datatables/dataTables.fixedHeader.min.js"></script>
        <script src="plugins/datatables/dataTables.keyTable.min.js"></script>
        <script src="plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="plugins/datatables/responsive.bootstrap.min.js"></script>
        <script src="plugins/datatables/dataTables.scroller.min.js"></script>

        <!-- chart -->
        <!-- <script src="assets/plugins/chart.js/chart.min.js"></script>
        <script src="assets/pages/chartjs.init.js"></script>

        <script src="assets/js/app.js"></script> -->


        <!-- Datatable init js -->
        <script src="pages/datatables.init.js"></script>

        <script src="{{asset('plugins/bootstrap-sweetalert/sweet-alert.min.js')}}"></script>
        <script src="{{asset('pages/sweet-alert.init.js')}}"></script>


        <script src="{{asset('pages/dashborad.js')}}"></script>

        <script src="{{asset('js/app.js')}}"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->

        <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script> -->
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/i18n/id.js" type="text/javascript"></script> -->
        <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">


</body>


</html>

<!-- <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    < CSRF Token -->
<!-- <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title> -->

<!-- Scripts -->
<!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

<!-- Fonts -->
<!-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> -->

<!-- Styles -->
<!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
<!-- Left Side Of Navbar -->
<!-- <ul class="navbar-nav mr-auto">

                    </ul>
 -->
<!-- Right Side Of Navbar -->
<!-- <ul class="navbar-nav ml-auto"> -->
<!-- Authentication Links -->
<!-- @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>