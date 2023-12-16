<!DOCTYPE html>
<html lang="en-US" class="no-js">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <title>Home | {{ isset($title) ? $title : '' }} | {{get_option('site_titlee') && get_option('site_titlee') != '' ? get_option('site_titlee') : 'Inventory'}} </title>
        
        <!-- Seo Tags -->
        <meta name="description" content="A Collective Participation for Sustainable Development" />
        <meta name="keywords" content="{{ config('app.name') }}"/>
        <meta name="robots" content="index, follow">
        <!-- Favicon -->
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <!-- Included CSS Files -->
        <link href="https://fonts.googleapis.com/css?family=Sansita:400,400i,700,700i,800,800i,900,900i" rel="stylesheet">
        <link href='http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" media="all" href="{{ asset('landing/css/style.css') }}" />
        <script type="text/javascript" src="{{ asset('landing/js/modernizr.js') }}"></script>
        <!--[if lt IE 9]>
        <link rel="stylesheet" type="text/css" media="all" href="css/ie.css" />
        <![endif]-->
    </head>
    <body class="text-sm">
        
        <!-- Slideshow Ken Burns -->
        <div class="slideshow">
            <div class="slideshow-image" style="background-image: url('{{ asset('landing/images/bg-1.jpg') }}')"></div>
            <div class="slideshow-image" style="background-image: url('{{ asset('landing/images/bg-2.jpg') }}')"></div>
            <!-- <div class="slideshow-image" style="background-image: url('images/bg-3.jpg')"></div> -->
        </div>
        
        <div class="wrap flex">
            
            <!-- Firefly -->
            <canvas id="pixie"></canvas>
            
            <!-- Main -->
            <div id="main">
                <div class="login">
                     @auth
                          <a href="{{ route('admin.home') }}" style="text-decoration: none; font-size: 20px; text-align: center; position: fixed; top: 10px; right: 20px; font-weight: bold; background: purple; padding: 10px; width: 150px; border-radius: 10px;">Dashboard</a>
                           
                      @else
                           <a href="{{ route('login') }}" style="text-decoration: none; font-size: 20px; text-align: center; position: fixed; top: 10px; right: 20px; font-weight: bold; background: purple; padding: 10px; width: 150px; border-radius: 10px;">Login</a>
                     @endauth           
                            
        </div>
                <div class="inner fade-in">
                    <!-- Header -->
                    <header class="site-header">
                        <h1 class="site-title"><img src="{{ asset('landing/images/logo.png') }}" width="125" height="160" alt="InTime" /></h1>
                    </header>
                    <!-- Content -->
                    <section class="content">
                        <div class="row">
                            
                        </div>
                        
                    </div>
                    
                    <!-- Columns -->
                    <div class="row">
                        
                        <div class="one">
                            <p style="font-size: 20px; letter-spacing: 2.8px; text-align: center;     margin: 0px;">Janata Auto Rice Mill</p>
                            <p style="font-size: 20px; letter-spacing: 2.8px; text-align: center;">(All kinds of quality Rice saller and supplier)</p>
                            <p style="text-align: center">
                                <!--<span style="font-size: 20px; font-weight: bold; background: purple; padding: 10px; border-radius: 10px;">Contact Person </span>--><br>
                            <span style="font-weight: bold; display:block; font-size: 32px; color: black;">Nurul Akter
                            </span>
                            <span style="font-weight: bold; display:block;">
                            Founder and Chairperson</span></p>
                            
                            
                        </div>
                        
                        <div class="one-half tariq " style="    width: 25%;
    left: 20%;
    margin-left: 20%;
    text-align: left !important;
">
                            <h2 class=""><i class="fa fa-map-marker"></i> Corporate Office</h2>
                            <p style="margin: 0px;"> <i class="fa fa-location-arrow" aria-hidden="true"></i> &nbsp;
 Link Road, Cox's Bazar.</p>
                            
                             <p> <i class="fa fa-phone" aria-hidden="true"></i> &nbsp; (+88) 01711-171116 (Chairperson)<br />
                             <i class="fa fa-phone" aria-hidden="true"></i> &nbsp; (+88) 01313-401800-09 (Office) <br>
                             <i class="fa fa-envelope" aria-hidden="true"></i> &nbsp;   Email: tradlink71@gmail.com <br>
                              <i class="fa fa-globe" aria-hidden="true"></i>  &nbsp; Website: www.aksongroup.com
                            </p>
                        </div>
                        
                       
                        <div class="one-hal " style="width: 35%;
    margin-right: auto;
    float: right;
    text-align: left !important;">
                            <h2 class="">
<svg aria-hidden="true" focusable="false" data-prefix="fas" width="20" data-icon="archway" class="svg-inline--fa fa-archway fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M560 448h-16V96H32v352H16.02c-8.84 0-16 7.16-16 16v32c0 8.84 7.16 16 16 16H176c8.84 0 16-7.16 16-16V320c0-53.02 42.98-96 96-96s96 42.98 96 96l.02 160v16c0 8.84 7.16 16 16 16H560c8.84 0 16-7.16 16-16v-32c0-8.84-7.16-16-16-16zm0-448H16C7.16 0 0 7.16 0 16v32c0 8.84 7.16 16 16 16h544c8.84 0 16-7.16 16-16V16c0-8.84-7.16-16-16-16z"></path></svg> Subsidiaries</h2>
                            <p class="">
                               <i class="fa fa-arrow-right" aria-hidden="true"></i>
&nbsp; Janata Auto Rice Mill
                                <br>
                               <i class="fa fa-arrow-right" aria-hidden="true"></i>
&nbsp; Basundhara Agro Food Industry <br>
                               <i class="fa fa-arrow-right" aria-hidden="true"></i>
&nbsp; Trade Link <br>
                               <i class="fa fa-arrow-right" aria-hidden="true"></i>
&nbsp; Promaxo Properties <br>
                               <i class="fa fa-arrow-right" aria-hidden="true"></i>
&nbsp; Asif Poultry Farm <br>
                              <i class="fa fa-arrow-right" aria-hidden="true"></i>
&nbsp;  Asif Transport Service
                            </p>
                        </div>
                        
                    </div>
                </section>
                
                
            </section>
        </div>
    </div>
    <!-- Modal page: About Us -->
    <div id="modal">
        <div class="inner">
            <!-- Modal toggle -->
            <div class="social">
                <a href="#" id="modal-close"><span class="fa fa-times" title="Close"></span></a>
            </div>
            <!-- Content -->
            <section class="content">
                
            </div>
            <!-- Background overlay -->
            <div class="body-bg" ></div>
            <!-- Loading -->
            <div id="preload">
                <div id="preload-content">
                    <div class="preload-spinner">
                        <div class="loading-logo-wraper">
                            <img src="{{ asset('landing/images/logo.png') }}" alt="">
                        </div>
                        <div class="tp-loader spinner"></div>
                    </div>
                </div>
            </div>
            <!-- Included JS Files -->
            <script type="text/javascript" src="{{ asset('landing/js/jquery-1.11.3.min.js') }}"></script>
            <script type="text/javascript" src="{{ asset('landing/js/plugins.js') }}"></script>
            <script type="text/javascript" src="{{ asset('landing/js/scripts.js') }}"></script>
            <script type="text/javascript" src="{{ asset('landing/js/firefly.js') }}"></script>
        </body>
    </html>