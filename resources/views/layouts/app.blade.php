<!DOCTYPE html>
<html  lang="en">
<html dir="ltr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <!-- Other meta tags as needed -->

    <!-- Title -->
    <title>@yield('title')</title>
    <?php  

    $logoHeader = App\Models\GeneralSetting::where(['key' => 'logo'])->first();
    $fav_icon = App\Models\GeneralSetting::where(['key' => 'icon'])->first();
    $logoHeader = $logoHeader->value??'';
    $fav_icon = $fav_icon->value??'';

    ?>
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('storage/assets/images/admin/'.$fav_icon)}}">
    <!-- CSS -->
    <!-- Replace these with your asset paths -->
    <link href="{{ asset('assets/libs/flot/css/float-chart.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/custom-style.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/libs/quill/dist/quill.snow.css')}}">
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <!-- Scripts -->
    <!-- Include your scripts here -->
    <script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    @stack('css')
</head>
<body>

        {!! Toastr::message() !!}
    <div class="preloader">
    <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="loading" class="initial-hidden">
                <div class="loader--inner">
                    <!-- <img width="200" src="{{asset('assets/images/admin/loader.gif')}}" alt="image"> -->
                </div>
            </div>
        </div>
    </div>
</div>
    </div>

    <div id="main-wrapper">
 
        @include('partials.header')
        @include('partials.sidenav')
      
        <div class="page-wrapper">
            @yield('breadcrumb')
            <div class="container-fluid">
            @yield('content')
            </div>
            @include('partials.footer')
         
        </div>
     
    </div>
    @stack('script_2')
    <script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('assets/libs/popper.js/dist/umd/popper.min.js')}}"></script>
  <script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
  <script src="{{asset('assets/extra-libs/sparkline/sparkline.js')}}"></script>
  <script src="{{asset('dist/js/waves.js')}}"></script>
  <script src="{{asset('dist/js/sidebarmenu.js')}}"></script>
  <script src="{{asset('dist/js/custom.min.js')}}"></script>
  <script src="{{asset('assets/libs/flot/excanvas.js')}}"></script>
  <script src="{{asset('assets/libs/flot/jquery.flot.js')}}"></script>
  <script src="{{asset('assets/libs/flot/jquery.flot.pie.js')}}"></script>
  <script src="{{asset('assets/libs/flot/jquery.flot.time.js')}}"></script>
  <script src="{{asset('assets/libs/flot/jquery.flot.stack.js')}}"></script>
  <script src="{{asset('assets/libs/flot/jquery.flot.crosshair.js')}}"></script>
  <script src="{{asset('assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js')}}"></script>
  <script src="{{asset('dist/js/pages/chart/chart-page-init.js')}}"></script>
  @yield('scripts')
</body>
</html>
</body>
</html>



