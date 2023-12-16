<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>System Setup</title>
		<meta name="keywords" content="{{ isset($page) ? $page->content[0]->seo_meta_keywords : 'school' }}"/>
		<meta name="description" content="{{ isset($page) ? $page->content[0]->seo_meta_description : 'school website' }}"/>

		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Lato:700%7CMontserrat:400,600" rel="stylesheet">

		<!-- Bootstrap -->
		<link type="text/css" rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}"/>
		<!-- Custom stlylesheet -->
		<link type="text/css" rel="stylesheet" href="{{ asset('assets/css/notification.css') }}"/>
		<link type="text/css" rel="stylesheet" href="{{ asset('assets/css/font-awosome.min.css') }}"/>
		<link type="text/css" rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}"/>
		<link type="text/css" rel="stylesheet" href="{{ asset('assets/css/parsley.css') }}"/>
		<link type="text/css" rel="stylesheet" href="{{ asset('install/css/style.css') }}"/>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

    </head>
	<body>

		<div class="container">
		    <div class="install-container col-md-12">
				@yield('content')
			</div>			
		</div>

		<!-- jQuery Plugins -->
		<script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('assets/js/popper.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('install/js/validate.js') }}"></script>
		<script type="text/javascript" src="{{ asset('install/js/growl.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('assets/js/parsley.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('assets/js/select2.min.js') }}"></script>

		<script>
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
		@yield('js-script')		
	</body>
</html>