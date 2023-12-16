<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fa fa-bars"></i></a>
        </li>
        {{--<li class="nav-item">
            <a class="nav-link" href="#" role="button"><span id="timestamp"></span>
        </a>--}}
    </li>
    {{-- <li class="nav-item d-none d-sm-inline-block">
        <a href="../../index3.html" class="nav-link">Home</a>
    </li> --}}
    {{-- <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
    </li> --}}
</ul>
<!-- SEARCH FORM -->
{{-- <form class="form-inline ml-3">
    <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search"
        aria-label="Search">
        <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</form> --}}
<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
    <!-- Messages Dropdown Menu -->
   <!--  <li class="nav-item dropdown">
       <a class="nav-link" data-toggle="dropdown" href="#">
           <i class="fa fa-comments"></i>
           <span class="badge badge-danger navbar-badge">3</span>
       </a>
       <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
           {{--
           <a href="#" class="dropdown-item">
               Message Start
               <div class="media">
                   <img src="../../dist/img/user3-128x128.jpg" alt="User Avatar"
                   class="img-size-50 img-circle mr-3">
                   <div class="media-body">
                       <h3 class="dropdown-item-title">
                       Nora Silvester
                       <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                       </h3>
                       <p class="text-sm">The subject goes here</p>
                       <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                   </div>
               </div>
               Message End
           </a>
           <div class="dropdown-divider"></div> --}}
           <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
       </div>
   </li>
   Notifications Dropdown Menu
   <li class="nav-item dropdown">
       <a class="nav-link" data-toggle="dropdown" href="#">
           <i class="fa fa-bell"></i>
           <span class="badge badge-warning navbar-badge">15</span>
       </a>
       <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
           <span class="dropdown-item dropdown-header">15 Notifications</span>
           <div class="dropdown-divider"></div>
           <a href="#" class="dropdown-item">
               <i class="fa fa-file mr-2"></i> 3 new reports
               <span class="float-right text-muted text-sm">2 days</span>
           </a>
           <div class="dropdown-divider"></div>
           <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
       </div>
   </li> -->
    <!-- User Account: style can be found in dropdown.less -->
    <li class="dropdown nav-item user user-menu">
        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
            <img src="{{ (Auth::user()->image != 'user.png' ? asset('storage/images/user'. '/'. Auth::user()->image) : asset('images/user.png')) }}" class="user-image" alt="User Image">
            <span class="hidden-xs">{{ substr(Auth::user()->name, 0 , 15) }}</span>
        </a>
        <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
                <img src="{{ (Auth::user()->image != 'user.png' ? asset('storage/images/user'. '/'. Auth::user()->image) : asset('images/user.png')) }}" class="img-circle" alt="User Image">
                <p>
                    @php
                    $user_id = Auth::user()->id;
                    $user = App\User::where('id', $user_id)->with('info')->first();
                    @endphp
                    {{ Auth::user()->name }} {{--- {{ $user->info->designation }}--}}
                    <small>Member since {{ formatDate(Auth::user()->created_at) }}</small>
                </p>
            </li>

            <!-- Menu Footer-->
            <li class="user-footer">
                <div class="pull-left">
                    <a href="{{ route('admin.me') }}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                    <a id="logout" data-url='{{ route('logout') }}' class="btn btn-default btn-flat">Sign out</a>
                </div>
            </li>
        </ul>
    </li>
{{--    <li class="nav-item">--}}
{{--        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">--}}
{{--            <i class="fa fa-th-large"></i>--}}
{{--        </a>--}}
{{--    </li>--}}
</ul>
</nav>
