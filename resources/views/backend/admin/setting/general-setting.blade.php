@php
    $html_tag_data = [];
    $title = 'General Setting';
    $description= 'General Setting for Admin';
@endphp
@extends('layout.admin.layout',['html_tag_data'=>$html_tag_data, 'title'=>$title, 'description'=>$description])

@section('css')

@endsection

@section('js_vendor')

@endsection



@section('content')
<main class="col-md-10 offset-1">

<div class="col">
    <!-- Title Start -->
    <section class="scroll-section" id="title">
      <div class="col-md-8">
        <h4 id="title" >General Setting</h4>
        <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb" >
          <ul class="breadcrumb" style="background-color: #f8f9fc">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.generalSetting')}}">General Setting</a></li>
          </ul>
        </nav>
      </div>
    </section>
    <!-- Title End -->

    <!-- Content Start -->
    <div>
      
      <!-- Form Row Start -->
      <section class="scroll-section" id="formRow">
        <div class="card mb-5">
          <div class="card-body">
            <form class="row g-3" name="generalSettingForm" id="generalSettingForm">
              <div class="row">
              <div class="col-md-6">
                <label for="website_name" class="form-label">Website Name</label>
                <input type="text" class="form-control" name="website_name" id="website_name" placeholder="Your Website Name">
              </div>
              <div class="col-md-6">
                <label for="service_location" class="form-label">Location</label>
                <input type="text" class="form-control" name="service_location" id="service_location" placeholder="Your Conatct Location">
              </div>
            </div>
            <div class="col-md-12">
              <label for="contact_details" class="form-label">Details</label>
              <textarea class="form-control" placeholder="Enter Contact Details..."  cols="20" id="contact_details" name="contact_details" rows="5"></textarea>
            </div> 
            <div class="col-md-12">
              <label for="web_description" class="form-label">Web Description</label>
              <textarea class="form-control" placeholder="Enter Website Description..."  cols="20" id="web_description" name="web_description" rows="5"></textarea>
            </div>
            <div class="col-md-12">
              <label for="copyright_info" class="form-label">Copyright Info</label>
              <input type="text" class="form-control" name="copyright_info" id="copyright_info" placeholder="Website Copyright Info">
            </div>
            <div class="col-6">
              <label for="mobile" class="form-label">Mobile</label>
              <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter Mobile Number">
            </div>
              <div class="col-md-5">
                <label for="icon" class="form-label">Icon</label>
                <input type="file" class="form-control" name="icon" id="icon">
              </div>
              <div class="col-md-1" id="icon_Show">
                <img id="icon_preview" src="{{asset('uploads/setting/no-image.png')}}" alt="" class="w-50 h-50" style="margin-top:28px">
              </div>
              
              <div class="col-md-5">
                <label for="logo" class="form-label">Logo</label>
                <input type="file" name="logo" class="form-control" id="logo">
              </div>
              <div class="col-md-1" id="logo_Show">
                <img id="logo_preview" src="{{asset('uploads/setting/no-image.png')}}" alt="" class="w-50 h-50" style="margin-top:28px">
              </div>
              <div class="col-md-5">
                <label for="favicon" class="form-label">Favicon</label>
                <input type="file" class="form-control" name="favicon" id="favicon">
              </div>
              <div class="col-md-1" id="favicon_Show">
                <img id="favicon_preview" src="{{asset('uploads/setting/no-image.png')}}" alt="" class="w-50 h-50" style="margin-top:28px">
              </div>
              
              <div class="col-12" style="text-align: center">
                <button type="button" class="btn btn-primary" id="btnUpdate">Update</button>
              </div>
            </form>
          </div>
        </div>
      </section>
      <!-- Form Row End -->

    </div>
    <!-- Content End -->
  </div>


</main>
@endsection
@section('js_page')
<script src="{{asset('backend/admin/custom_js/general_setting.js')}}"></script>
@endsection
