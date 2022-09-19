<div id="preloader">
<div class="sk-three-bounce">
    <div class="sk-child sk-bounce1"></div>
    <div class="sk-child sk-bounce2"></div>
    <div class="sk-child sk-bounce3"></div>
</div>
</div>
<!-- Preloader end -->
<!-- Main wrapper start -->
<div id="main-wrapper">
<!-- Nav header start -->
<div class="nav-header bg-primary">
    <a href="{{env('APP_URL')}}/admin/" class="brand-logo">
        <img src="http://webeetest.com/s&t/admin/../images/logo-white.png" alt="Logo" width="150px">
    </a>
    <div class="nav-control">
        <div class="hamburger"> <span class="line"></span><span class="line"></span><span class="line"></span>
        </div>
    </div>
</div>
<!-- Nav header end -->
<!-- Header start -->
<div class="header bg-primary">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left"></div>
                <ul class="navbar-nav header-right">
                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown"> <i class="la la-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{env('APP_URL')}}/admin/logout" class="dropdown-item ai-icon">
                                <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg> <span class="ml-2">Logout </span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<!-- Header end -->
<!-- Sidebar start -->
<div class="deznav bg-primary">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">Main Menu</li>
            <li class="active"><a href="{{env('APP_URL')}}/admin" aria-expanded="false"><i class="la la-home"></i><span class="nav-text">Dashboard</span></a></li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="la la-book"></i><span class="nav-text">Users</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{env('APP_URL')}}/admin/user/">All User</a></li>
                    <li><a href="{{env('APP_URL')}}/admin/user/add">Add User</a></li>
                </ul>
            </li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="la la-book"></i><span class="nav-text">Role</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{env('APP_URL')}}/admin/role/">All Role</a></li>
                    <li><a href="{{env('APP_URL')}}/admin/role/add">Add Role</a></li>
                </ul>
            </li>
            <li class="active"><a href="{{env('APP_URL')}}/admin/contact" aria-expanded="false"><i class="la la-book"></i><span class="nav-text">Contact</span></a></li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="la la-book"></i><span class="nav-text">Pages</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{env('APP_URL')}}/admin/homepage">Home Page</a></li>
                </ul>
            </li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="la la-book"></i><span class="nav-text">Template Part</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{env('APP_URL')}}/admin/footer">Footer</a></li>
                </ul>
            </li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="la la-book"></i><span class="nav-text">Startup</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{env('APP_URL')}}/admin/startup/">All Startup</a></li>
                    <!-- <li><a href="{{env('APP_URL')}}/admin/startup/add">Add Startup</a></li> -->
                </ul>
            </li>
             <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="la la-book"></i><span class="nav-text">Startup</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{env('APP_URL')}}/admin/startup/">All Startup</a></li>
                    <!-- <li><a href="{{env('APP_URL')}}/admin/startup/add">Add Startup</a></li> -->
                </ul>
            </li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="la la-book"></i><span class="nav-text">Case Studies</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{env('APP_URL')}}/admin/case_studies/">All Case Studies</a></li>
                    <li><a href="{{env('APP_URL')}}/admin/case_studies/add">Add Case Studies</a></li>
                </ul>
            </li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="la la-book"></i><span class="nav-text">Event</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{env('APP_URL')}}/admin/event">All Event</a></li>
                    <li><a href="{{env('APP_URL')}}/admin/event/add">Add Event</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
</div>