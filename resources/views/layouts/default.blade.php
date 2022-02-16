<?php
/**
 * Created by PhpStorm.
 * User: mrqpro
 * Date: 26/01/2022
 * Time: 01:18
 */
?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>@yield('title')</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/plugins.css')}}">
    <!-- style css -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/style.css')}}">
    <!-- Responsive-->

    <!-- fevicon -->
    <link rel="icon" href="images/fevicon.png" type="image/gif"/>
    @yield('stylesheet')
    @yield('header-scripts')
</head>
<!-- body -->
<body>
@section('header')
    @include('sections.header')
@show
<!-- Blog Start -->
@yield('content')
<!--blog end -->
@section('footer')
    @include('sections.footer')
@show
</body>
</html>


<!-- Javascript files-->
<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('js/popper.min.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('js/scripts.js') }}"></script>
@yield('footer-scripts')
