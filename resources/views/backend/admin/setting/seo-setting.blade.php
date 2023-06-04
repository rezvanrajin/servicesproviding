@php
    $html_tag_data = [];
    $title = 'SEO Setting';
    $description= 'SEO Setting for Admin';
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
        <h4 id="title" >SEO Estting</h4>
        <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb" >
          <ul class="breadcrumb" style="background-color: #f8f9fc">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.SEOSetting')}}">SEO Setting</a></li>
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
            <form class="row g-3" name="SEOForm" id="SEOForm">
              <div class="col-md-12">
                <label for="meta_title" class="form-label">Meta Title</label>
                <input type="text" class="form-control" name="meta_title" id="meta_title" placeholder="Enter Meta Title">
              </div>
              <div class="col-md-12">
                <label for="meta_keyword" class="form-label">Meta Keyword</label>
                <textarea name="meta_keyword" id="meta_keyword" placeholder="Meta Keyword" class="form-control" cols="30" rows="5"></textarea>
              </div>
              <div class="col-12">
                <label for="meta_description" class="form-label">Meta Description</label>
                <textarea name="meta_description" id="meta_description" placeholder="Meta Description" class="form-control" cols="30" rows="5"></textarea>
              </div>
              
              <div class="col-12">
                <button type="submit" class="btn btn-primary" id="saveBtn">Update</button>
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
<script src="{{asset('backend/admin/custom_js/seo.js')}}"></script>
@endsection
