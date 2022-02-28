<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sky - Homepage</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts-->
    <link rel="stylesheet" href="/assets/customer/css/style.css">

    {{--<!-- Css Styles -->--}}
    <link rel="stylesheet" href="/assets/customer/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/customer/plugins/ps-icon/style.css">
    {{--<!-- CSS Library-->--}}
    <link rel="stylesheet" href="/assets/customer/plugins/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/customer/plugins/bootstrap-select/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="/assets/customer/fashi/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="/assets/customer/fashi/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="/assets/customer/fashi/css/themify-icons.css" type="text/css">
    <link rel="stylesheet" href="/assets/customer/fashi/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="/assets/customer/fashi/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="/assets/customer/fashi/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="/assets/customer/fashi/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="/assets/customer/fashi/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="/assets/customer/fashi/css/style.css" type="text/css">
    <link rel="stylesheet" href="/assets/customer/OwlCarousel2/dist/assets/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="/assets/customer/OwlCarousel2/dist/assets/owl.theme.default.min.css" type="text/css">
    <style type="text/css">
        *{
            margin: 0;
            padding: 0;
        }
        html,body{
            width: 100%;
            height: 100%;
            background: #f5f5f5;
        }
        ul.menu{
            width: 400px;
            margin: auto;
            margin-top:20px;
            display: flex;
            justify-content: space-between;
        }
        li {
            list-style: none;
            background: #fff;
            color: #212121;
            padding: 10px 12px;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 3px 5px 5px rgb(0,0,0,0.23);
            border-radius: 2px;
        }
        .title {
            padding: 10px 12px;
            text-align: center;
            font-size: 36px;
            color: #212121;
        }
        .content{
            width: 1170px;
            margin: auto;
        }
        img.hinh {
            width: 30%;
            margin: 10px;
        }
    </style>

</head>

<body>

<div id="app">
    <router-view></router-view>

</div>


<!-- Js Plugins -->
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="/assets/customer/fashi/js/jquery-3.3.1.min.js"></script>
{{--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>--}}
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>

<script src="/assets/customer/OwlCarousel2/docs/assets/owlcarousel/owl.carousel.js"></script>

{{--<script src="/assets/customer/js/mainjs.js" type="text/javascript"></script>--}}

</body>
</html>
