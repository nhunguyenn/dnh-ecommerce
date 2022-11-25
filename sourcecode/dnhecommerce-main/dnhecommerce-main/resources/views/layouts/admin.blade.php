<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') | Admin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport') }}">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('assets/admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/admin/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('assets/admin/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet"
        href="{{ asset('assets/admin/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet"
        href="{{ asset('assets/admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/iCheck/all.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset('assets/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet"
        href="{{ asset('assets/admin/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/timepicker/bootstrap-timepicker.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/admin/bower_components/select2/dist/css/select2.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/skins/_all-skins.min.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

{{-- sidebar-collapse --}}

<body class="skin-blue sidebar-mini">
    <div class="wrapper">

        @section('header')
            @include('partials.admin.header')
        @show

        @section('sidebar')
            {{-- sidebar --}}
        @show

        @yield('content')

        @section('footer')
            @include('partials.admin.footer')
        @show

    </div>
    <!-- ./wrapper -->

    <!-- jQuery 3 -->
    <script src="{{ asset('assets/admin/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('assets/admin/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('assets/admin/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/admin/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('assets/admin/plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('assets/admin/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/admin/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{ asset('assets/admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">
    </script>
    <!-- bootstrap color picker -->
    <script src="{{ asset('assets/admin/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}">
    </script>
    <!-- bootstrap time picker -->
    <script src="{{ asset('assets/admin/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ asset('assets/admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- iCheck 1.0.1 -->
    <script src="{{ asset('assets/admin/plugins/iCheck/icheck.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('assets/admin/bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/admin/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('assets/admin/dist/js/demo.js') }}"></script>
    <!-- CK Editor -->
    <script src="{{ asset('assets/admin/bower_components/ckeditor/ckeditor.js') }}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <!-- Page script -->
    <script src="{{ asset('assets/admin/dist/js/main.js') }}"></script>
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()
            $('.my-colorpicker2').colorpicker()
        })
    </script>
</body>

</html>
