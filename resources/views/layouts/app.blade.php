<!doctype html>
<html class="fixed header-dark">
<head>
    <!-- Basic -->
    <meta charset="UTF-8">
    <title>Dark Header Layout | Porto Admin - Responsive HTML5 Template</title>
    <meta name="keywords" content="HTML5 Admin Template" />
    <meta name="description" content="Porto Admin - Responsive HTML5 Template">
    <meta name="author" content="okler.net">
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{asset('backend/assets/vendor/bootstrap/css/bootstrap.css')}}" />
    <link rel="stylesheet" href="{{asset('backend/assets/vendor/animate/animate.compat.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/vendor/font-awesome/css/all.min.css')}}" />
    <link rel="stylesheet" href="{{asset('backend/assets/vendor/boxicons/css/boxicons.min.css')}}" />
    <link rel="stylesheet" href="{{asset('backend/assets/vendor/magnific-popup/magnific-popup.css')}}" />
    <link rel="stylesheet" href="{{asset('backend/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css')}}" />
    <link rel="stylesheet" href="{{asset('backend/assets/vendor/jquery-ui/jquery-ui.css')}}" />
    <link rel="stylesheet" href="{{asset('backend/assets/vendor/jquery-ui/jquery-ui.theme.css')}}" />
    <link rel="stylesheet" href="{{asset('backend/assets/vendor/bootstrap-multiselect/css/bootstrap-multiselect.css')}}" />
    <link rel="stylesheet" href="{{asset('backend/assets/vendor/morris/morris.css')}}" />
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{asset('backend/assets/css/theme.css')}}" />
    <!-- Skin CSS -->
    <link rel="stylesheet" href="{{asset('backend/assets/css/skins/default.css')}}" />
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{asset('backend/assets/css/custom.css')}}">
    <!-- Head Libs -->
    <script src="{{asset('backend/assets/vendor/modernizr/modernizr.js')}}"></script>

    {{--this is for to make workable image choose box--}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>


    @stack('styles')

    @yield('styles')
</head>
<body>
<section class="body">
    <!-- start: header -->
    @include('partials.header')
    <!-- end: header -->
    <div class="inner-wrapper">
        <!-- start: sidebar -->
        @include('partials.sidebar')
        <!-- end: sidebar -->
        {{--start body--}}
        @yield('content')
       {{-- end body--}}
    </div>
</section>
<!-- Vendor -->
<script src="{{asset('backend/assets/vendor/jquery/jquery.js')}}"></script>
<script src="{{asset('backend/assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js')}}"></script>
<script src="{{asset('backend/assets/vendor/popper/umd/popper.min.js')}}"></script>
<script src="{{asset('backend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('backend/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('backend/assets/vendor/common/common.js')}}"></script>
<script src="{{asset('backend/assets/vendor/nanoscroller/nanoscroller.js')}}"></script>
<script src="{{asset('backend/assets/vendor/magnific-popup/jquery.magnific-popup.js')}}"></script>
<script src="{{asset('backend/assets/vendor/jquery-placeholder/jquery.placeholder.js')}}"></script>
<!-- Specific Page Vendor -->
<script src="{{asset('backend/assets/vendor/jquery-ui/jquery-ui.js')}}"></script>
<script src="{{asset('backend/assets/vendor/jqueryui-touch-punch/jquery.ui.touch-punch.js')}}"></script>
<script src="{{asset('backend/assets/vendor/jquery-appear/jquery.appear.js')}}"></script>
<script src="{{asset('backend/assets/vendor/bootstrap-multiselect/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('backend/assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.js')}}"></script>
<script src="{{asset('backend/assets/vendor/flot/jquery.flot.js')}}"></script>
<script src="{{asset('backend/assets/vendor/flot.tooltip/jquery.flot.tooltip.js')}}"></script>
<script src="{{asset('backend/assets/vendor/flot/jquery.flot.pie.js')}}"></script>
<script src="{{asset('backend/assets/vendor/flot/jquery.flot.categories.js')}}"></script>
<script src="{{asset('backend/assets/vendor/flot/jquery.flot.resize.js')}}"></script>
<script src="{{asset('backend/assets/vendor/jquery-sparkline/jquery.sparkline.js')}}"></script>
<script src="{{asset('backend/assets/vendor/raphael/raphael.js')}}"></script>
<script src="{{asset('backend/assets/vendor/morris/morris.js')}}"></script>
<script src="{{asset('backend/assets/vendor/gauge/gauge.js')}}"></script>
<script src="{{asset('backend/assets/vendor/snap.svg/snap.svg.js')}}"></script>
<script src="{{asset('backend/assets/vendor/liquid-meter/liquid.meter.js')}}"></script>
<script src="{{asset('backend/assets/vendor/jqvmap/jquery.vmap.js')}}"></script>
<script src="{{asset('backend/assets/vendor/jqvmap/data/jquery.vmap.sampledata.js')}}"></script>
<script src="{{asset('backend/assets/vendor/jqvmap/maps/jquery.vmap.world.js')}}"></script>
<script src="{{asset('backend/assets/vendor/jqvmap/maps/continents/jquery.vmap.africa.js')}}"></script>
<script src="{{asset('backend/assets/vendor/jqvmap/maps/continents/jquery.vmap.asia.js')}}"></script>
<script src="{{asset('backend/assets/vendor/jqvmap/maps/continents/jquery.vmap.australia.js')}}"></script>
<script src="{{asset('backend/assets/vendor/jqvmap/maps/continents/jquery.vmap.europe.js')}}"></script>
<script src="{{asset('backend/assets/vendor/jqvmap/maps/continents/jquery.vmap.north-america.js')}}"></script>
<script src="{{asset('backend/assets/vendor/jqvmap/maps/continents/jquery.vmap.south-america.js')}}"></script>

<!-- Theme Base, Components and Settings -->
<script src="{{asset('backend/assets/js/theme.js')}} "></script>
<!-- Theme Custom -->
<script src="{{asset('backend/assets/js/custom.js')}} "></script>
<!-- Theme Initialization Files -->
<script src="{{asset('backend/assets/js/theme.init.js')}} "></script>
<!-- Examples -->
<script src="{{asset('backend/assets/js/examples/examples.dashboard.js')}} "></script>


@stack('scripts')
</body>
</html>
