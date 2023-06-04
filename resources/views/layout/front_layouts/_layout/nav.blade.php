<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a href="{{route('index')}}" class="navbar-brand"
            ><img src="@if($generalsetting){{$generalsetting->logo}} @endif" alt="Logo"
        /></a>
        <button
            class="navbar-toggler"
            data-bs-toggle="collapse"
            data-bs-target="#menu"
            area-controls="menu"
            area-expanded="false"
            area-label="Toggle navigation"
        >
            <i class="fas fa-stream text-black"></i>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0" id="menuBar">
                @foreach($menus as $menu)
                 <li class="nav-item">
                    <a href="{{$menu->url}}" class="nav-link">{{$menu->name}}</a>
                </li> 
                @endforeach
              
            </ul>
            <div class="acount-info">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link" data-bs-toggle="dropdown" data-bs-auto-close="outside"><span>@if(Auth::check()) {{Auth::user()->name}} <img src="{{asset(Auth::user()->photo)}}" width="35" class="rounded-circle" alt=""> @else Account <i class="fa-solid fa-user-plus"></i> @endif</span>
                            
                        </a>
                        <ul class="dropdown-menu shadow">
                            @if(Auth::check())
                            <li>
                                <a href="{{route('buyer.logout')}}" class="dropdown-item">Logout <i class="fa-solid fa-right-from-bracket"></i></a
                                >
                            </li>
                            <li>
                                <a href="{{route('buyer.dashboard')}}" class="dropdown-item">{{Auth::user()->name}} <img src="{{asset(Auth::user()->photo)}}" width="30" alt=""></a>
                            </li>

                            @else 
                            <li>
                                <a href="{{route('buyer.register')}}" class="dropdown-item">Sign Up <i class="float-end fa-solid fa-user-plus"></i></a>
                            </li>
                            <li>
                                <a href="{{route('buyer.login')}}" class="dropdown-item">Sign In <i class="float-end fa-solid fa-right-to-bracket"></i></a
                                >
                            </li>
                            @endif 
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

