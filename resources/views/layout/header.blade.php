<header class="header py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-6 col-lg-3">
                <a class="navbar-brand" href="{{env('APP_URL')}}/"><img src="{{env('APP_URL')}}/assets/images/logo.jpg" alt="Logo"></a>
            </div>
            <div class="col-6 col-lg-9">
                
                <div class="main-menu">
                    <div class="main-menu-inner">
                        
                        <ul class="menu-top list-none ms-auto d-lg-none">
                            <!--<li><a href="#"><img src="/assets/images/search.png"></a></li>-->
                            <li class="d-inline-block d-lg-none">
                                <div class="login-mob">
                                    <a href="{{env('APP_URL')}}/login-signup.php"><i class="bi bi-person-circle"></i></a>
                                </div>
                            </li>
                        </ul>
                        <nav class="navbar navbar-expand-lg navbar-light">
                            <button class="navbar-toggler bg-primary ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation">
                                <div class="hamburger-icon d-block d-lg-none">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </button>
                            <div class="collapse navbar-collapse" id="main-nav">
                                <ul class="navbar-nav ms-auto list-none">
                                    @if(session()->has('pilot'))
                                        <small class="text-primary"><span class="fw-bold">Welcome</span> {{session('pilot') -> name}}</small>
                                    @endif
                                    @if(session()->has('startup'))
                                        <small class="text-primary"><span class="fw-bold">Welcome</span> {{session('startup') -> fullname}}</small>
                                    @endif
                                    <li class="nav-item"> <a class="nav-link" href="{{env('APP_URL')}}/">Home</a></li>
                                    <!--<li class="nav-item"> <a class="nav-link" href="{{env('APP_URL')}}/#">Challenge</a></li>-->
                                    <li class="nav-item"> <a class="nav-link" href="{{env('APP_URL')}}/case-studies">Case Studies</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="{{env('APP_URL')}}/event">Event</a></li>
                                    <!--<li class="nav-item"> <a class="nav-link" href="{{env('APP_URL')}}/#">Connect</a></li>-->
                                    <!--<li class="nav-item"> <a class="nav-link" href="{{env('APP_URL')}}/#">About</a></li>-->
                                    @if(session()->has('pilot'))
                                        
                                        <li class="nav-item"> <a class="nav-link" href="{{env('APP_URL')}}/startups">My Dashboard</a></li>
                                    @endif
                                    @if(session()->has('startup'))
                                        <li><a class="nav-link" href="{{env('APP_URL')}}/myaccount">My Account</a></li>
                                    @endif
                                    
                                    
                                </ul>
                            </div>
                        </nav>
                    </div>
                    
                    <div class="login d-none d-xl-block list-none">
                        <a class="nav-link season_text">Season {{ env('CURRENT_SEASON') }}</a>
                        <div class="login-dropdown">
                            <ul class="list-none">
                                <li><a class="dropdown-item " href="{{ env('SEASON_ONE_URL') }}">Season 1</a></li>
                                <li><a class="dropdown-item" href="{{ env('SEASON_TWO_URL') }}">Season 2</a></li>
                            </ul>
                        </div>
                    </div>

                   
                        <div class="login d-none d-xl-block">
                            <div class="login-item">
                                <i class="bi bi-person-circle"></i>
                            </div>
                            <div class="login-dropdown">
                                <ul class="list-none">
                                     @if(!session()->has('startup') && !session()->has('pilot'))
                                        <li><a href="{{env('APP_URL')}}/auth">Login/Register as Startup</a></li>
                                        <li><a href="{{env('APP_URL')}}/pilot_companies">Login as Pilot Companies</a></li>
                                    @endif
                                    @if(session()->has('startup'))
                                        <li><a class="nav-link" href="{{env('APP_URL')}}/startup/changepassword">Change Password</a></li>
                                        <li><a class="nav-link" href="{{env('APP_URL')}}/myaccount/signout">Logout</a></li>
                                    @endif
                                    @if(session()->has('pilot'))
                                        
                                        <li><a class="nav-link" href="{{env('APP_URL')}}/pilot_companies/changepassword">Change Password</a></li>
                                        <li><a class="nav-link" href="{{env('APP_URL')}}/pilot_companies/signout">Logout</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    
                        <!-- <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                Login
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <li><a class="dropdown-item" href="#">Login/Register as Startup</a></li>
                                <li><a class="dropdown-item" href="#">Login as Pilot Cos</a></li>
                                <li><a class="dropdown-item" href="#">Login as Project Committee</a></li>
                            </ul>
                        </div> -->
                </div>
            </div>
        </div>
    </div>
</header>