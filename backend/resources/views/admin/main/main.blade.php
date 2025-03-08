<!doctype html>
<html lang="en">

<head>
    <!-- required meta -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- #keywords -->
    <meta name="keywords" content="boot, Bootstrap, Oddsx Sports Betting Website HTML Template">
    <!-- #description -->
    <meta name="description" content="Oddsx Sports Betting Website HTML Template">
    <!-- #title -->
    <title>Oddsx - Sports Betting Website HTML Template</title>
    <!-- #favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/white_logoff_new.png')}}" type="image/x-icon">
    <!-- ==== css dependencies start ==== -->
    <link rel="stylesheet" href="{{asset('assets/css/style.min.css')}}">
</head>

<body>

   @include('admin.partial.header')
    

    @include('admin.partial.hero')

    <section class="top_matches  pb-8 pb-md-10">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 gx-0 gx-lg-4">
                    <div class="top_matches__main">
                      
    @yield('admin-content')
    
    
    @include('admin.partial.footer')
   

    <!-- ==== js dependencies start ==== -->
    <script src="{{asset('assets/js/plugins/plugins.js')}}"></script>
    <script src="{{asset('assets/js/plugins/plugin-custom.js')}}"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>

</body>

</html>