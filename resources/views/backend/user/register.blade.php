@php
    $html_tag_data = [];
    $title = 'Index';
    $description = 'Index Page';
@endphp
@extends('layout.front_layouts.layout', ['html_tag_data' => $html_tag_data, 'title' => $title, 'description' => $description])
@section('content')
    <header class="menu_wrapper">
        @include('layout.front_layouts._layout.nav')
    </header>

    <!-- Login Area Starts -->
    {{-- <section class="login-area pt-100 pb-100">
        <div class="container">
            <div class="login-wrapper">
                <h3 class="login-title">Sign Up</h3>
                <div class="error-message"></div>
                <form method="post" id="UserRegisterFrom" class="login-form">
                    <div class="input-single mt-30">
                        <label class="login-label"> User Name * </label>
                        <span class="login-icon">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input class="form--control" type="name" name="name" id="name" placeholder="User Name" />
                    </div>
                    <span class="text-danger" id="nameError"></span>
                    <div class="input-single mt-30">
                        <label class="login-label"> Email * </label>
                        <span class="login-icon">
                            <i class="fa fa-envelope"></i>
                        </span>
                        <input class="form--control" type="email" name="email" id="email" placeholder="Email" />

                    </div>
                    <span class="text-danger" id="emailError"></span>
                    <div class="input-single mt-30">
                        <label class="login-label"> Password* </label>
                        <span class="login-icon">
                            <i class="fa fa-lock"></i>
                        </span>
                        <input class="form--control" type="password" name="password" id="password"
                            placeholder="Password" />
                    </div>
                    <span class="text-danger" id="passwordError"></span>
                    <input type="button" id="RegisterSubmit" class="submit common-btn" value="Submit Now" />
                    <span class="bottom-register">
                        Do not have Account?
                        <a class="resgister-link" href="{{ route('buyer.login') }}"> Login </a>
                    </span>
                </form>

            </div>
        </div>
    </section> --}}
    <!-- Login Area Ends -->
    <!-- Registration Area Starts -->
    <section class="banner-inner-area pt-70 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="banner-inner-contents text-center">
                        <h2 class="banner-inner-title">
                            Register For Join With Us
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="registration-area pt-40 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tab-content active" id="tab_one">
                        <div class="registration-form mt-50">
                            <form id="UserRegisterFrom" name="UserRegisterFrom" class="msform user-register-form login-form" data-multi-step>
                                <ul class="registration-list step-list-two">
                                    <li class="active">
                                        <a href="javascript:void(0)"> 1 </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)"> 2 </a>
                                    </li>
                                </ul>
                                <fieldset class="fieldset-info active" data-step>
                                    <div class="information-all mt-50">
                                        <div class="info-forms">
                                            <div class="single-forms">
                                                <div class="input-single mt-30">
                                                    <label class="login-label">Full Name *</label>
                                                    <span class="login-icon"><i class="fa fa-user"></i></span>
                                                    <input class="form--control" type="text" name="name" id="name" placeholder="Full name"/ required>
                                                    <small class="text-danger" id="nameError"></small>
                                                </div>
                                                <div class="input-single mt-30">
                                                    <label class="login-label">Email *</label>
                                                    <span class="login-icon"><i class="fa fa-envelope"></i></span>
                                                    <input class="form--control" type="email" name="email" id="email" placeholder="Email" required/>
                                                    <small class="text-danger" id="emailError"></small>
                                                </div>
                                            </div>
                                            <div class="single-forms">
                                                <div class="input-single mt-30">
                                                    <label class="login-label">Adress *</label>
                                                    <span class="login-icon"><i class="fa-solid fa-location-dot"></i></span>
                                                    <input class="form--control" type="text" name="address" id="address" placeholder="Adress" required/>
                                                    <small class="text-danger" id="addressError"></small>
                                                </div>
                                                <div class="input-single mt-30">
                                                    <label class="login-label">State *</label>
                                                    <span class="login-icon"><i class="fa-solid fa-home"></i></span>
                                                    <input class="form--control" type="text" name="state" id="state" placeholder="State" required/>
                                                    <span class="text-danger" id="stateError"></span>
                                                </div>
                                            </div>
                                            <div class="single-forms">
                                                <div class="input-single mt-30">
                                                    <label class="login-label">Phone Number *</label>
                                                    <span class="login-icon"> <i class="fa fa-phone"></i></span>
                                                    <input class="form--control" type="text" name="mobile" id="mobile" placeholder="Type Number" required/>
                                                    <small class="text-danger" id="mobileError"></small>
                                                </div>
                                                <div class="input-single mt-30">
                                                    <label class="login-label">Password*</label>
                                                    <span class="login-icon"><i class="fa fa-lock"></i></span>
                                                    <input class="form--control" type="password" name="password" id="password" placeholder="Type Password" required/>
                                                    <small class="text-danger" id="passwordError"></small>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                  
                                    <input type="button" name="name" class="common-btn same-border" value="Next" data-next />
                                </fieldset>
                                
                                <fieldset class="fieldset-service" data-step>
                                    <div class="information-all mt-50">
                                        <div class="info-service category-service-area">
                                            <div class="single-category-service mt-30">
                                            
                                                <div class="input-single mt-30">
                                                    <label class="">Post Code *</label>
                                                    <span class="login-icon"><i class="fa fa-envelope-circle-check"></i></span>
                                                    <input class="form--control" type="text" name="post_code" id="post_code" placeholder="Post Code" required/>
                                                    <small class="text-danger" id="post_codeError"></small>
                                                </div>
                                                <div class="input-single mt-30">
                                                    <label class="login-label">City *</label>
                                                    <<select name="city" id="city" required>
                                                        <option value="">select city</option>
                                                        <option value="Dhaka">Dhaka</option>
                                                    </select>
                                                    <small class="text-danger" id="cityError"></small>
                                                </div>
                                                
                                            </div>
                                                
                                            <div class="single-select mt-30">
                                                    <label for="">Country*</label>
                                                    <span class="login-icon"><i class="fa-solid fa-flag"></i></span>
                                                    <select name="country" id="country" required>
                                                        <option value="">select country</option>
                                                        <option value="Bangladesh">Bangladesh</option>
                                                    </select>
                                                </div>
                                                <smaill class="text-danger" id="countryError"></smaill>
                                            </div>
                                    
                                        </div>
                                    </div>
                                    <input type="button" id="RegisterSubmit" class="common-btn same-border"
                                    value="Submit" />
                                <input type="button" name="name" class="float-start common-btn-outline common-btn"value="Previous" data-previous />
                                </fieldset>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Registration Area Ends -->
@endsection

@section('js_page')
    <script src="{{ asset('backend/Buyer/custom_js/login_register.js') }}"></script>
@endsection
