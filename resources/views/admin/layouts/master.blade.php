<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title>Purbachol | Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
    <link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="/assets/css/animate.min.css" rel="stylesheet" />
    <link href="/assets/css/style.min.css" rel="stylesheet" />
    <link href="/assets/css/style-responsive.min.css" rel="stylesheet" />
    <link href="/assets/css/theme/default.css" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
    <link href="/assets/plugins/jquery-jvectormap/jquery-jvectormap.css" rel="stylesheet" />
    <link href="/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
    {{-- <link href="/assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" /> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet">
    <!-- ================== END PAGE LEVEL STYLE ================== -->

    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
    <link href="/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
    <!-- ================== end PAGE LEVEL STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="/assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->



    @stack('css')
</head>
<body>
<!-- begin #page-loader -->
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<!-- end #page-loader -->

<!-- begin #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
    @include('admin.layouts.header')

    @include('admin.layouts.sidebar')

    <!-- begin #content -->
    <div id="content" class="content">
        <!-- begin breadcrumb -->
        <ol class="breadcrumb pull-right">
            <li><a href="javascript:;">Home</a></li>
            <li class="active">@yield('page')</li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">@yield('page') <small>Purbachol</small></h1>
        <!-- end page-header -->

        <!-- begin row -->
        <div class="row">
            @yield('content')
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->


    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    <!-- end scroll to top btn -->
</div>
<!-- end page container -->

<!-- ================== BEGIN BASE JS ================== -->
<script src="/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
<script src="/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
<script src="/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
    <script src="/assets/crossbrowserjs/html5shiv.js"></script>
    <script src="/assets/crossbrowserjs/respond.min.js"></script>
    <script src="/assets/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
<script src="/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
{{-- <script src="/assets/plugins/gritter/js/jquery.gritter.js"></script> --}}
<script src="/assets/plugins/flot/jquery.flot.min.js"></script>
<script src="/assets/plugins/flot/jquery.flot.time.min.js"></script>
<script src="/assets/plugins/flot/jquery.flot.resize.min.js"></script>
<script src="/assets/plugins/flot/jquery.flot.pie.min.js"></script>
<script src="/assets/plugins/sparkline/jquery.sparkline.js"></script>
<script src="/assets/plugins/jquery-jvectormap/jquery-jvectormap.min.js"></script>
<script src="/assets/plugins/jquery-jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="/assets/js/dashboard.min.js"></script>
<script src="/assets/js/apps.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->


<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="/assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
<script src="/assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="/assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="/assets/plugins/DataTables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
<script src="/assets/plugins/DataTables/extensions/Buttons/js/buttons.bootstrap.min.js"></script>
<script src="/assets/plugins/DataTables/extensions/Buttons/js/buttons.flash.min.js"></script>
<script src="/assets/plugins/DataTables/extensions/Buttons/js/jszip.min.js"></script>
<script src="/assets/plugins/DataTables/extensions/Buttons/js/pdfmake.min.js"></script>
<script src="/assets/plugins/DataTables/extensions/Buttons/js/vfs_fonts.min.js"></script>
<script src="/assets/plugins/DataTables/extensions/Buttons/js/buttons.html5.min.js"></script>
<script src="/assets/plugins/DataTables/extensions/Buttons/js/buttons.print.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->


<script>
    $(document).ready(function() {
        App.init();
        Dashboard.init();
    });
</script>

@stack('js')
</body>
</html>
