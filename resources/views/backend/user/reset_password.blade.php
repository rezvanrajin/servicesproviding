@php
    $html_tag_data = [];
    $title = 'Index';
    $description= 'Index Page';
@endphp
@extends('layout.front_layouts.layout',['html_tag_data'=>$html_tag_data, 'title'=>$title, 'description'=>$description])
@section("content")

<header class="menu_wrapper">
  @include('layouts.front_layouts._layout.nav')
</header>

                <!-- Login Area Starts -->
                <section class="login-area pt-100 pb-100">
                  <div class="container">
                      <div class="login-wrapper">
                          <h3 class="login-title">Reset Password.</h3>
                          <h6 class="text-center mt-10">Enter Your new password.</h6>
                          <div class="error-message"></div>
                          <form id="resetForm" action="" method="Post" 
                          class="login-form">
                          <input type="hidden" name="token" value="{{ $token }}">
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
                              <div class="input-single mt-30">
                                  <label class="login-label"> New Password* </label>
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
                              <div class="input-single mt-30">
                                  <label class="login-label">
                                      Confirm Password*
                                  </label>
                                  <span class="login-icon">
                                      <i class="fa fa-lock"></i>
                                  </span>
                                  <input
                                      class="form--control"
                                      type="password"
                                      name="password_confirmation"
                                      id="password_confirmation"
                                      placeholder="Password"
                                      required
                                  />
                              </div>
                              <input
                                  type="button"
                                  id="generate_pass_submit"
                                  class="submit common-btn"
                                  value="Set New Password"
                              />
                          </form>
                      </div>
                  </div>
              </section>
              <!-- Login Area Ends -->
    
@endsection

@section('js_page')
<script src="{{asset('backend/Buyer/custom_js/reset.js')}}"></script> 
@endsection 