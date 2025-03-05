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
    <link rel="shortcut icon" href="{{asset('assets/images/fav.png')}}" type="image/x-icon">
    <!-- ==== css dependencies start ==== -->
    <link rel="stylesheet" href="{{asset('assets/css/style.min.css')}}">
</head>

<body>

   @include('user.partial.header')
    

    @include('user.partial.hero')

    
    @yield('user-content')
    
    
    @include('user.partial.footer')
   

    <!-- ==== js dependencies start ==== -->
    <script src="{{asset('assets/js/plugins/plugins.js')}}"></script>
    <script src="{{asset('assets/js/plugins/plugin-custom.js')}}"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>

</body>

</html>