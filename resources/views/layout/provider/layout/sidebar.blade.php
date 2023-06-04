     <!-- Sidebar -->
     <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('provider.dashboard')}}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="{{route('provider.dashboard')}}">
                <i class="fa fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Interface
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link" href="{{route('provider.booking')}}">
                <i class="fa fa-bar-chart" aria-hidden="true"></i>
                <span>Booking</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSix"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-trophy"></i>
                <span>Coupon</span>
            </a>
            <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Add</h6>
                    <a class="collapse-item" href="{{route('provider.coupons')}}">Add Coupon</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('provider.customer')}}">
                <i class="fa fa-bar-chart" aria-hidden="true"></i>
                <span>Customer List</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsefive"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-trophy"></i>
                <span>Handyman</span>
            </a>
            <div id="collapsefive" class="collapse" aria-labelledby="headingfive" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Add</h6>
                    <a class="collapse-item" href="{{route('provider.handyman')}}">Add Handyman</a>
                    <a class="collapse-item" href="{{route('provider.assignHandyman')}}">Assign Handyman</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsefour"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-trophy"></i>
                <span>Review</span>
            </a>
            <div id="collapsefour" class="collapse" aria-labelledby="headingfour" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Add</h6>
                    <a class="collapse-item" href="{{route('provider.UserReview')}}">User Review</a>
                    <a class="collapse-item" href="{{route('provider.SellerReview')}}">Seller Review</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('provider.service')}}">
                <i class="fas fa-toilet-paper"></i>
                <span>Service</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('provider.emailSupport')}}">
                <i class="fas fa-train"></i>
                <span>Support</span></a>
        </li>
        <!-- Nav Item - Utilities Collapse Menu -->

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Addons
        </div>

    
               <!-- Nav Item - Charts -->

            
                   <!-- Divider -->




        <!-- Nav Item - Pages Collapse Menu -->



        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

        <!-- Sidebar Message -->
        {{-- <div class="sidebar-card d-none d-lg-flex">
            <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
            <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
            <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
        </div> --}}

    </ul>
    <!-- End of Sidebar -->