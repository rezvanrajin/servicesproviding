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

<main class="col-md-10 offset-2">
    <div class="container">
      <div class="row">
        <div class="col">
    <!-- Title Start -->
    <section class="scroll-section" id="title">
      <div class="page-title-container">
        <div class="row">
            <div class="col-md-8">
                <h4 id="title" >Footer Setting</h4>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb" >
                  <ul class="breadcrumb" style="background-color: #f8f9fc">
                    <li class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('admin.footer')}}">Footer</a></li>
                  </ul>
                </nav>
      </div>
      </div>
      </div>
    </section>
    <!-- Title End -->

    <!-- Content Start -->
    <div>
      
      <!-- Form Row Start -->
      <section class="scroll-section" id="formRow">
        <div class="card mb-5 col-md-8">
          <div class="card-body">
            <form class="row g-3" name="footer_settingForm" id="footer_settingForm">
              
              <div class="col-md-6">
                <label for="logo" class="form-label">Logo</label>
                <input type="file" name="logo" class="form-control logo">
              </div>
             
              <div class="col-md-6">
              <label for="email" class="form-label">Email</label>
                    <input name="email" type="text" class="form-control" name="email" id="email" placeholder="Enter Email"/>
              </div>
              <div class="col-md-6">
                <label for="contact_detaile" class="form-label">Contact Details</label>
                <input type="text" class="form-control" placeholder="Contact number" name="contact_detaile" id="contact_detaile">
              </div>
              <div class="col-md-6">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" name="location" id="location" placeholder="Location">
              </div>

              <div class="col-md-12">
                <label for="des" class="form-label"> Description</label>
                <textarea class="form-control" name="description" id="description" placeholder="description"></textarea>
              </div>
              <div class="float-end imageShow"></div>
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
  </div>
</main>


@endsection
@section('js_page')
<script src="{{asset('backend/admin/custom_js/footer_setting.js')}}"></script>
@endsection
