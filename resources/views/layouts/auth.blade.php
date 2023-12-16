<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> {{get_option('site_titlee') && get_option('site_titlee') != '' ? get_option('site_titlee') : 'Sadik'}} | Log in</title>
    <link rel="icon" href="{{ asset('images/sfavicon.png') }}" type="image/gif" sizes="64x64">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/css/font-awosome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('auth/css/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('auth/css/theme.min.css') }}">
    <!-- Parslay.min.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/parsley.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('landing/images/logo.png') }}" width="200" height="160" alt="InTime" />
            <!-- <a href="{{ route('index') }}"><b>{{get_option('site_title') && get_option('site_title') != '' ? get_option('site_title') : 'Sadik'}}</b></a> -->
        </div>
  
        @yield('content')

    </div>

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <!-- Popper js -->
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/js/bootstrap.min.js')}} "></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('auth/js/theme.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/parsley.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('install/js/growl.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function notify(message, type){
            $.growl({
                message: message
            },{
                type: type,
                allow_dismiss: true,
                label: 'Cancel',
                className: 'btn-xs btn-inverse',
                placement: {
                    from: "top",
                    align: "right"
                },
                delay: 5000,
                animate: {
                        enter: 'animated fadeInRight',
                        exit: 'animated fadeOutRight'
                },
                offset: {
                    x: 30,
                    y: 30
                }
            });
        };
    </script>
    @yield('scripts')
    </body>
</html>
