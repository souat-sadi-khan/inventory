<!-- Favicon -->
<link rel="icon" type="image/png" sizes="16x16" href="{{get_option('favicon') && get_option('favicon') != '' ? asset('storage/images/logo' . '/'. get_option('favicon')) : asset('images/sfavicon.png') }}">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Font Awosome -->
<link rel="stylesheet" href="{{ asset('assets/css/font-awosome.min.css') }}">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}">
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<!-- Date Dropper -->
<link rel="stylesheet" href="{{ asset('assets/css/datedropper.min.css') }}">
<!-- Select 2 -->
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
<!-- Parslay.min.css -->
<link rel="stylesheet" href="{{ asset('assets/css/parsley.css') }}">
<!-- Drophify -->
<link rel="stylesheet" href="{{ asset('assets/css/drophify.min.css') }}">
<!-- Sweet Alert -->
<link type="text/css" rel="stylesheet" href="{{ asset('assets/css/sweetalert.min.css') }}"/>
<!-- toastr -->
<link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.9/datepicker.min.css" integrity="sha256-ZvEtNAd4i8k2hUczGFP3tFDwBRjw3WUTUagRUP7WcEw=" crossorigin="anonymous" />
<!-- Page Css -->
@stack('admin.css')