
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Trang Quản Lý</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script type="text/javascript" src="../../templateEditor/ckeditor/ckeditor.js"></script>
    {{--<!-- CSRF Token -->--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Ckfinder and Ckeditor -->


</head>
<body class="hold-transition sidebar-mini" >
<!-- Site wrapper -->
<div class="wrapper" id="app">
    <router-view></router-view>
    {{--<admin></admin>--}}
    {{--<textarea class="ckeditor" id="editor1"></textarea>--}}
    {{--<router-view :user="{{auth()->user()}}"></router-view>--}}

    <footer class="main-footer">

        <strong>Copyright &copy; 2020 <a href="http://adminlte.io"></a></strong> 
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- Scripts -->
<script type="text/javascript">
    CKEDITOR.replace( 'editor1');
</script>
<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>

<script>
</script>
