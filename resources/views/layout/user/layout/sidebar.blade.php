     <!-- Sidebar -->
     <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="{{route('dashboard')}}">
                <i class="fa fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Interface
        </div>

        
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fa fa-cog"></i>
                <span>Favorites</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Custom Components:</h6>
                    <a class="collapse-item" href="{{route('user.favorites')}}">Favorites</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseone"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fa fa-cog"></i>
                <span>Order</span>
            </a>
            <div id="collapseone" class="collapse" aria-labelledby="headingone" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Custom Components:</h6>
                    <a class="collapse-item" href="{{route('user.allOrder')}}">Order</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsethree"
                aria-expanded="true" aria-controls="collapsethree">
                <i class="fa fa-cog"></i>
                <span>Reviews</span>
            </a>
            <div id="collapsethree" class="collapse" aria-labelledby="headingone" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Custom Components:</h6>
                    <a class="collapse-item" href="{{route('user.reviews')}}">Reviews</a>
                </div>
            </div>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Addons
        </div>

        <li class="nav-item">
            <a class="nav-link" href="{{route('user.support')}}">
                <i class="fas fa-volleyball-ball"></i>
                <span>Support</span></a>
        </li>
            
                   <!-- Divider -->
        <hr class="sidebar-divider"> 

        <!-- Heading -->
        <div class="sidebar-heading">
            Site Tools
        </div> 

        {{-- <li class="nav-item">
            <a class="nav-link" href="{{route('admin.menu')}}">
              <i class="fas fa-umbrella-beach"></i>
                <span>Menus</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.page')}}">
              <i class="fas fa-video"></i>
                <span>Pages</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.footer')}}">
              <i class="fa-solid fa fa-rocket"></i>
                <span>Footer Setting</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.social')}}">
              <i class="fa-solid fa-address-book"></i>
                <span>Social Icon</span></a>
        </li> --}}


        <!-- Nav Item - Pages Collapse Menu -->


        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
                  <!-- Heading -->
                 {{-- <div class="sidebar-heading">
                       User And Provider Sector
                   </div> 

                   <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.users')}}">
                      <i class="fa-solid fa-truck-fast"></i>
                        <span>User</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.Inactiveusers')}}">
                      <i class="fa-solid fa-truck-fast"></i>
                        <span>Inactive User</span></a>
                </li> --}}
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