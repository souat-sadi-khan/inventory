<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ isset($title) ? $title : '' }} | {{get_option('site_titlee') && get_option('site_titlee') != '' ? get_option('site_titlee') : 'Sadik'}}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- StyleSheet -->
    @include('_partials.admin.stylesheet')
</head>

<body class="hold-transition sidebar-mini text-sm">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        @include('_partials.admin.navbar')

        <!-- Main Sidebar Container -->
        @include('_partials.admin.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <div style="position: absolute;top: 50%;left: 50%;z-index:100; display:none;" id="loader">
                <i class="fa fa-spinner fa-spin fa-5x fa-fw"></i><h3>Loading...</h3>
            </div>
            
            <!-- Content Header (Page header) -->
            @yield('header')

            <!-- Main content -->
            <section class="content">

                @yield('content')

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; {{ date('Y') }} <a href="http://www.sattit.com">Satt IT</a>.</strong> All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    @if(isset($modal))
        <!-- Remote source -->
        <div id="modal_remote" class="modal fade border-top-success rounded-top-0" data-backdrop="static"  role="dialog">
            <div class="modal-dialog modal-{{ $modal }} modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light border-grey-300">
                        <h5 class="modal-title">{{$title}}</h5>
                        <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
                    </div>
                    <div id="modal-loader" style="display: none; text-align: center;">
                        <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>
                    </div>
                    <div class="modal-body">
                    </div>
                </div>
            </div>
        </div>
        <!-- /remote source -->
    @endif

    @include('_partials.admin.scripts')
</body>

</html>
