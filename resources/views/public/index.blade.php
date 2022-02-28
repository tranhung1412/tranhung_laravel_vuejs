<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sky - Homepage</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts-->
    <link
        href="https://fonts.googleapis.com/css?family=Archivo+Narrow:300,400,700%7CMontserrat:300,400,500,600,700,800,900"
        rel="stylesheet">
    <link rel="stylesheet" href="/assets/customer/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/customer/plugins/ps-icon/style.css">
    <link rel="stylesheet" href="/assets/customer/plugins/bootstrap-select/dist/css/bootstrap-select.min.css">

    <link rel="stylesheet" href="/assets/customer/css/style.css">

    {{--<!-- Css Styles -->--}}
    <link rel="stylesheet" href="/assets/customer/fashi/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="/assets/customer/fashi/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="/assets/customer/fashi/css/themify-icons.css" type="text/css">
    <link rel="stylesheet" href="/assets/customer/fashi/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="/assets/customer/fashi/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="/assets/customer/fashi/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="/assets/customer/fashi/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="/assets/customer/fashi/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="/assets/customer/fashi/css/style.css" type="text/css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" type="text/css">
</head>

<body>

<div id="app">
    <router-view></router-view>

</div>

{{--<script type="text/javascript" src="/assets/customer/plugins/jquery/dist/jquery.min.js"></script>--}}
{{--<script type="text/javascript"--}}
        {{--src="/assets/customer/plugins/bootstrap/dist/js/bootstrap.min.js"></script>--}}
{{--<script type="text/javascript" src="/assets/customer/plugins/jquery-ui/jquery-ui.min.js"></script>--}}
{{--<script type="text/javascript"--}}
        {{--src="/assets/customer/plugins/bootstrap-select/dist/js/bootstrap-select.min.js"></script>--}}
<!-- Js Plugins -->
<script src="/assets/customer/fashi/js/jquery-3.3.1.min.js"></script>
<script src="/assets/customer/fashi/js/bootstrap.min.js"></script>
<script src="/assets/customer/fashi/js/jquery-ui.min.js"></script>
<script src="/assets/customer/fashi/js/jquery.countdown.min.js"></script>
<script src="/assets/customer/fashi/js/jquery.nice-select.min.js"></script>
<script src="/assets/customer/fashi/js/jquery.zoom.min.js"></script>
<script src="/assets/customer/fashi/js/jquery.dd.min.js"></script>
<script src="/assets/customer/fashi/js/jquery.slicknav.js"></script>
<script src="/assets/customer/fashi/js/owl.carousel.min.js"></script>
<script src="/assets/customer/fashi/js/main.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="{{ asset('js/app.js') }}" defer></script>
<script type="text/javascript">
$(document).ready(function() {
  $('.commentBtn').click(function() {
    $(this).next('.comment').toggle();
  });
});
</script>
</body>
</html>
