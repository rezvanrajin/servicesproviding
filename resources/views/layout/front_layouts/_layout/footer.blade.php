<footer class="footer pt-100">
    <div class="footer-top pb-100">
        <div class="container">
            <div class="row footer-contents">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    {{-- <div class="footer-single">
                        <img src="@if($generalsetting) {{$generalsetting->logo}} @endif" alt="Footer Logo" class="footer-logo"/>
                        <p class="footer-text">
                            @if($generalsetting){{$generalsetting->web_description}}@endif
                        </p>
                    </div> --}}
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer-single">
                        <h4 class="footer-title">Community</h4>
                        <ul class="navbar-nav footer-menu">
                            <li class="nav-item">
                                <a href="#" class="nav-link"
                                    ><span>Become A Seller</span></a
                                >
                                <a href="#" class="nav-link"
                                    ><span>Become A Buyer</span></a
                                >
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer-single">
                        <h4 class="footer-title">Category</h4>
                        <ul class="navbar-nav footer-menu">
                            {{-- <li class="nav-item">
                                @if(count($linkswidgets) > 0)
                                @foreach($linkswidgets as $link)
                                <a href="{{$link->links_name}}" class="nav-link"
                                    ><span>{{$link->title_name}}</span></a
                                >
                               @endforeach
                               @endif 
                            </li> --}}
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="footer-single">
                        <h4 class="footer-title">Contact Info</h4>
                        <ul class="footer-address">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i
                                        class="fas fa-map-marker-alt"
                                    ></i>
                                    {{-- <span>
                                        @if($generalsetting){{$generalsetting->contact_details}}@endif 
                                    </span> --}}
                                </a>
                            </li>
                            <li class="nav-item">
                                {{-- <a href="#" class="nav-link">
                                    <i class="fas fa-mobile"></i>
                                    <span>@if($generalsetting){{$generalsetting->mobile}} @endif</span>
                                </a> --}}
                            </li>
                            <li class="nav-item">
                                {{-- <a href="#" class="nav-link">
                                    <i class="fas fa-envelope"></i>
                                    <span>@if($generalsetting){{$generalsetting->website_name}}@endif</span>
                                </a> --}}
                            </li>
                        </ul>
                        {{-- <div class="footer-social">
                            @if(count($sociallinks) >0)
                            @foreach($sociallinks as $social)
                            <a href="{{$social->link}}"><i class="{{$social->icon}}"></i></a>
                            @endforeach
                            @endif 
                           
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-area pt-30 pb-30">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="copyright-list">
                        <a href="#">Privacy Policy</a>
                        <a href="#">Terms & Conditions</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    {{-- <div class="copyright-contents">
                        <span>@if($generalsetting){{$generalsetting->copyright_info}}@endif</span>
                    </div> --}}
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="copyright-payment">
                        <a href="#"
                            ><img
                                src="{{asset('frontend/images/paypal.png')}}"
                                alt="Paypal"
                        /></a>
                        <a href="#"
                            ><img
                                src="{{asset('frontend/images/discover.png')}}"
                                alt="Discover"
                        /></a>
                        <a href="#"
                            ><img
                                src="{{asset('frontend/images/american-express.png')}}"
                                alt="American Express"
                        /></a>
                        <a href="#"
                            ><img
                                src="{{asset('frontend/images/visa.png')}}"
                                alt="Visa"
                        /></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>