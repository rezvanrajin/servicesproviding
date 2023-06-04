@php
    $html_tag_data = [];
    $title = 'Index';
    $description= 'Index Page';
@endphp
@extends('layout.front_layouts.layout',['html_tag_data'=>$html_tag_data, 'title'=>$title, 'description'=>$description])
@section("content")

<header class="menu_wrapper">
</header>

                <!-- Login Area Starts -->
                <section class="login-area pt-100 pb-100">
                  <div class="container">
                      <div class="login-wrapper">
                          <h3 class="login-title">Sign In</h3>
                          <div class="error-message tex-danger" id="MassageError"></div>
                          <form action="#" id="handleAjax" method="post" class="login-form">
                            @csrf 
                              <div class="input-single mt-30">
                                  <label class="login-label"> Email * </label>
                                  <span class="login-icon">
                                      <i class="fa fa-envelope"></i>
                                  </span>
                                  <input
                                      class="form--control"
                                      type="email"
                                      name="email"
                                      id="email"
                                      placeholder="Email"
                                      required
                                  />
                              </div>
                              <span class="text-danger" id="emailLoginError"></span>
                              <div class="input-single mt-30">
                                  <label class="login-label"> Password* </label>
                                  <span class="login-icon">
                                      <i class="fa fa-lock"></i>
                                  </span>
                                  <input
                                      class="form--control"
                                      type="password"
                                      name="password"
                                      id="password"
                                      placeholder="Password"
                                      required
                                  />
                              </div>
                              <span class="text-danger" id="passwordLoginError"></span>
                              <div class="login-checkbox">
                                  <div class="checkbox-inlines">
                                      <input
                                          class="check-input"
                                          name="remember"
                                          id="remember"
                                          type="checkbox"
                                      />
                                      <label class="checkbox-label" for="remember">
                                          Remember me</label
                                      >
                                      
                                  </div>
                                  <div class="forgot-btn">
                                      <a href="{{route('buyer.forgotPassword')}}"
                                          >Forgot Password?</a
                                      >
                                  </div>
                              </div>
                              
                              <input
                                  type="submit" id="login_btn"
                                
                                  class="submit common-btn"
                                  value="Submit Now"
                              />
                              <span class="bottom-register">
                                  Do not have Account?
                                  <a class="resgister-link" href="{{route('buyer.register')}}"> Register </a>
                              </span>
                          </form>
                          <div class="social-login-wrapper">
                              <div class="bar-wrap">
                                  <span class="bar"></span>
                                  <p class="or">or</p>
                                  <span class="bar"></span>
                              </div>
                              <div class="login-with">
                                <div class="test" id="googleSingIn">
                                  <a href="{{route('buyer.redirectToGoogle')}}" class="login-btn">
                                      <img
                                          src="{{asset('frontend/images/google.png')}}"
                                          alt="Google Icon"
                                      />
                                      Sign in with Google
                                  </a>
                                </div>
                                  <a href="#" class="login-btn">
                                      <img
                                          src="{{asset('frontend/images/facebook.png')}}"
                                          alt="Facebook Icon"
                                      />
                                      Sign in with Facebook
                                  </a>
                              </div>
                          </div>
                      </div>
                  </div>
              </section>
              <!-- Login Area Ends -->

@endsection

@section('js_page')

@endsection 