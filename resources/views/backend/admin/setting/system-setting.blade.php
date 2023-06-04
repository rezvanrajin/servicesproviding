@php
    $html_tag_data = [];
    $title = 'System Setting';
    $description= 'System Setting for Admin';
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
      <div class="page-title-container">
        <div class="col-md-8">
            <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb" >
              <ul class="breadcrumb" style="background-color: #f8f9fc">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.systemSetting')}}">System Setting</a></li>
          </ul>
        </nav>
      </div>
      </div>
    </section>
    <!-- Title End -->

    <!-- Content Start -->
    <div>
      
      <!-- Form Row Start -->
      <section class="scroll-section" id="formRow">
        <h2 class="small-title">System Setting</h2>
        <div class="card mb-5">
          <div class="card-body">
            <form class="row g-3" name="systemSettingForm" id="systemSettingForm">
              <div class="col-md-6">
                <label for="website_name" class="form-label">Google Map API KEY</label>
                <input type="text" class="form-control" name="google_map_Api_Key" id="google_map_Api_Key" placeholder="Your Google Map Api Key">
              </div>
              <div class="col-md-6">
                <label for="contact_details" class="form-label">Server Key</label>
                <input type="text" class="form-control" name="server_key" id="server_key" placeholder="Enter Server Key">
              </div>
             
              <div class="col-12">
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



  @endsection
</main>
@section('js_page')
<script src="{{asset('backend/admin/custom_js/system_setting.js')}}"></script>
@endsection
