<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>اسأل استشير</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="stylesheet" href="{{url('public/css/bootstrap.minn.css')}}">
    <link rel="stylesheet" href="{{url('public/css/bootstrap-rtl.min.css')}}">
    <link rel="stylesheet" href="{{url('public/css/font-awesome.min.css')}}">
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">--}}
    <link rel="stylesheet" href="{{url('public/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{url('public/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{url('public/css/_all-skins.min.css')}}">
    <link rel="stylesheet" href="{{url('public/css/_all.css')}}">
    <link rel="stylesheet" href="{{url('public/css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{url('public/css/icons.css')}}">

    <!-- Ionicons -->
    <style>
        .box-body {
            background-color: #F4F3F2 !important;
        }

        @font-face {
            font-family: 'Droid Arabic Kufi';
            src: url('{{url('public/DroidKufi-Regular.ttf')}}') format('truetype');
            font-weight: bold;
            font-style: normal;
        }

        .table-responsive {
            display: block !important;
        }

        h1, h2, h3, h4, h5, h6, p, li, input, label, th, tr, option {
            direction: rtl !important;
            font-family: 'Droid Arabic Kufi', serif !important;
        }

        .main-sidebar {
            right: 0 !important;
        }

        .main-header .navbar {
            margin-left: 0px !important;
        }

        .content-wrapper, .main-footer {
            margin-left: 0px !important;
            margin-right: 230px !important;

        }

        .neso_right {
            text-align: right !important;
        }

        .create_user {
            visibility: hidden;
        }

        .update_user {
            visibility: hidden;
        }

        .delete_user {
            visibility: hidden;
        }

        .print_user {
            visibility: hidden;
        }

        .super_admin {
            visibility: hidden;
        }

        .password_requests {
            visibility: hidden;
        }

        .pushmenu {
            background: #3c3933;
            width: 240px;
            height: 100%;
            top: 0;
            z-index: 1000;
            position: fixed;
        }

        .pushmenu a {
            display: block;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            border-top: 1px solid #56544e;
            border-bottom: 1px solid #312e2a;
            padding: 10px;
        }

        .pushmenu a:hover {
            background: #367fa9;
        }

        .pushmenu a:active {
            background: #367fa9;
            color: #fff;
        }

        .pushmenu-left {
            left: -240px;
        }

        .pushmenu-left.pushmenu-open {
            left: 0;
        }

        .pushmenu-push {
            overflow-x: hidden;
            position: relative;
            left: 0;
        }

        .pushmenu-push-toright {
            left: 240px;
        }

        .pushmenu, .pushmenu-push {
            -webkit-transition: all 0.3s ease;
            -moz-transition: all 0.3s ease;
            transition: all 0.3s ease;
        }

        #nav_list {
            background: url({{ asset('public/img/icon_nav.png') }}) no-repeat left top;
            cursor: pointer;
            height: 27px;
            width: 33px;
            text-indent: -99999em;
        }

        nav-list.active {
            background-position: -33px top;
        }

        .buttonset {
            height: 16px;
            padding: 10px 20px 20px;
        }

        section.content {
            padding: 10px 20px;
        }

        .pushmenu li {
            list-style: none;
        }

        .style_title {
            background-color: #367fa9;
            text-align: center;
        }

        .style_title span {
            font-weight: bold;
            font-size: 20px;
        }

        .skin-blue .main-header .logo {
            background-color: transparent
        }

        nav-list.active {
            background-position: -33px top;
        }

        .buttonset {
            height: 16px;
            padding: 10px 20px 20px;
        }

        section.content {
            padding: 10px 20px;
        }

        .pushmenu li {
            list-style: none;
        }

        .style_title {
            background-color: #367fa9;
            text-align: center;
        }

        .style_title span {
            font-weight: bold;
            font-size: 20px;
        }

        .skin-blue .main-header .logo, .skin-blue .main-header .logo:hover {
            cursor: default;
            background-color: transparent
        }

        .logo b {
            font-family: 'Droid Arabic Kufi', serif !important;
            font-weight: bold;
            font-size: 20px;
        }
    </style>
    @yield('css')
</head>

<body class="skin-blue sidebar-mini pushmenu-push">
@if (!Auth::guest())
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">


                <!-- Sidebar toggle button-->
                <span class="logo col-xs-6 col-lg-2 pull-right" style="text-align:right">
                    <b>تسجيل الحضور</b>
                </span>

                <form action="{{ url('logout') }}" method="post" style="text-align: right;"
                      class="col-xs-6 col-lg-8 logo pull-right">
                    {{ csrf_field() }}

                    <button type="submit" class="btn btn-default btn-sm"
                            style="background-color: #367fa9; color: white; margin-right: 7px; font-family: 'Droid Arabic Kufi', serif; text-decoration: none; ">
                        تسجيل خروج
                    </button>
                    <!--slide push menu-->

                </form>


            </nav>

        </header>

        <!-- Left side column. contains the logo and sidebar -->
    @include('layouts.sidebar')
    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Main Footer -->
        <footer class="main-footer" style="max-height: 100px;text-align: center"></a>.</strong> All rights
            reserved.
        </footer>

    </div>
@else
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <button id="user_id" style="display: none;">{{ Auth::user()->id }}</button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{!! url('/') !!}">
                    InfyOm Generator
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{!! url('/home') !!}">Home</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <li><a href="{!! url('/login') !!}">Login</a></li>
                    <li><a href="{!! url('/register') !!}">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
@endif

<!-- jQuery 3.1.1 -->
<script src="{{url('public/js/jquery.min.js')}}"></script>
<script src="{{url('public/js/jquery-ui.js')}}"></script>
<script src="{{url('public/js/bootstrap.min.js')}}"></script>
<script src="{{url('public/js/select2.min.js')}}"></script>
<script src="{{url('public/js/icheck.min.js')}}"></script>
<script src="{{url('public/js/app.min.js')}}"></script>

<!-- AdminLTE App -->
<script src="{{url('public/js/jquery.printpage.js')}}"></script>

<script src="{{url('public/js/sweetalert.min.js')}}"></script>


@yield('scripts')
@stack('scripts')
</body>
</html>
