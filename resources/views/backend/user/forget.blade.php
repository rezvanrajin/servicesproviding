@php
    $html_tag_data = [];
    $title = 'Forget';
    $description= 'Forget Page';
@endphp
@extends('layout.front_layouts.layout',['html_tag_data'=>$html_tag_data, 'title'=>$title, 'description'=>$description])
@section("content")

<header class="menu_wrapper">
    @include('layout.front_layouts._layout.nav')
</header>

        <!-- Login Area Starts -->
        <section class="login-area pt-100 pb-100">
          <div class="container">
              <div class="login-wrapper">
                  <h3 class="login-title">Forget Password.</h3>
                  <h6 class="text-center mt-10">
                      Enter Your Email to set new password.
                  </h6>
                  <div class="error-message"></div>
                  <form class="login-form" id="BuyerForgotForm">
                    <h5 class="text-success" id="message"></h5>
                      <div class="input-single mt-30">
                          <label class="login-label"> Email * </label>
                          <small class="text-danger" id="emailError"></small>
                          <span class="login-icon">
                              <i class="fa fa-envelope"></i>
                          </span>
                          <input
                              class="form--control" type="email" name="email" id="email"placeholder="Email" required />
                      </div>
                      <input
                          type="button"
                          id="SendBtn"
                          class="submit common-btn"
                          value="Generate New Password"
                      />
                  </form>
              </div>
          </div>
      </section>
      <!-- Login Area Ends -->
@endsection

@section("js_page")
<script src="{{asset('backend/Buyer/custom_js/forget-password.js')}}"></script>
@endsection
