@php
    $html_tag_data = [];
    $title = 'Dashboard';
    $description= 'Dashboard';
@endphp
@extends('layout.user.layout',['html_tag_data'=>$html_tag_data, 'title'=>$title, 'description'=>$description])

@section('css')
@endsection

@section('js_vendor')
<script src="{{asset('backend/js/moment-with-locales.min.js')}}"></script>

@endsection


@section('content')
<div class="container">
    <!-- Title and Top Buttons Start -->
    <div class="page-title-container">
      <div class="row">
        <!-- Title Start -->
        <div class="col-12 col-md-7">
          <a class="muted-link pb-2 d-inline-block hidden" href="#">
            <span class="align-middle lh-1 text-small">&nbsp;</span>
          </a>
          <h1 class="mb-0 pb-0 display-4" id="title">Welcome, {{Auth::user()->name}} !</h1>
        </div>
        <!-- Title End -->
      </div>
    </div>
    <!-- Title and Top Buttons End -->

    <!-- Stats Start -->
    <div class="row">
      <div class="col-12">
        <div class="d-flex">
          <div class="dropdown-as-select me-3" data-setActive="false" data-childSelector="span">
            <a class="pe-0 pt-0 align-top lh-1 dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
              <span class="small-title"></span>
            </a>
            <div class="dropdown-menu font-standard">
              <div class="nav flex-column" role="tablist">
                <a class="active dropdown-item text-medium" href="#" aria-selected="true" role="tab">Today's</a>
                <a class="dropdown-item text-medium" href="#" aria-selected="false" role="tab">Weekly</a>
                <a class="dropdown-item text-medium" href="#" aria-selected="false" role="tab">Monthly</a>
                <a class="dropdown-item text-medium" href="#" aria-selected="false" role="tab">Yearly</a>
              </div>
            </div>
          </div>
          <h2 class="small-title">Stats</h2>
        </div>
        <div class="mb-5" id="dashboard_widget">
          
        </div>
      </div>
    </div>


    <div class="row">
      <!-- Recent Orders Start -->
      <div class="col-xl-6 mb-5">
        <h2 class="small-title">Recent Orders</h2>
        <div class="mb-n2 scroll-out">
          <div class="scroll-by-count" data-count="6">
            
            <div class="card mb-2 sh-15 sh-md-6">
              <div class="card-body pt-0 pb-0 h-100">
                <div class="row g-0 h-100 align-content-center" id="UserOrderDetails">
                  
                </div>
              </div>
            </div>
          
          </div>
        </div>
      </div>
      <!-- Recent Orders End -->

      <!-- Performance Start -->
      <div class="col-xl-6 mb-5">
        <div class="d-flex">
          <div class="dropdown-as-select me-3" data-setActive="false" data-childSelector="span">
            <a class="pe-0 pt-0 align-top lh-1 dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
              <span class="small-title"></span>
            </a>
            <div class="dropdown-menu font-standard">
              <div class="nav flex-column" role="tablist">
                <a class="active dropdown-item text-medium" href="#" aria-selected="true" role="tab">Today's</a>
                <a class="dropdown-item text-medium" href="#" aria-selected="false" role="tab">Weekly</a>
                <a class="dropdown-item text-medium" href="#" aria-selected="false" role="tab">Monthly</a>
                <a class="dropdown-item text-medium" href="#" aria-selected="false" role="tab">Yearly</a>
              </div>
            </div>
          </div>
          <h2 class="small-title">Performance</h2>
        </div>
        <div class="card sh-45 h-xl-100-card">
          <div class="card-body h-100">
            
            </div>
          </div>
        </div>
      </div>
      <!-- Performance End -->
    </div>
  </div>
@endsection

@section('js_page')
<script src="{{asset('backend/buyer/custom_js/dashboard.js')}}"></script>
@endsection
