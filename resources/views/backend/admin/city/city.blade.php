@php
    $html_tag_data = [];
    $title = 'City List';
    $description= 'City List for Admin';
@endphp
@extends('layout.admin.layout',['html_tag_data'=>$html_tag_data, 'title'=>$title, 'description'=>$description])

@section('css')

@endsection

@section('js_vendor')

@endsection
@section('content')
<section class="col-md-10 offset-1">
  <div class="container">
    <div class="row">
      <div class="col">
        <!-- Title and Top Buttons Start -->
        <div class="page-title-container">
            <div class="row">
              <!-- Title Start -->
              <div class="col-md-8">
                <h4 id="title" >City List</h4>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb" >
                  <ul class="breadcrumb" style="background-color: #f8f9fc">
                    <li class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('admin.city')}}">City</a></li>
                  </ul>
                </nav>
              </div>
              <!-- Title End -->
              <!-- Top Buttons Start -->
              <div class="col-md-4 d-flex align-items-start justify-content-end">
                <!-- Add New Button Start -->
                <button data-bs-toggle="modal" data-bs-target="#createNewCity" type="button" class="createNewCity btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto add-datatable">
                  <i class="fa fa-solid fa-plus"></i>
                  <span>Add New City</span>
                </button>
                <!-- Add New Button End -->
              </div>
              <!-- Top Buttons End -->
            </div>
          </div>
        <!-- Title and Top Buttons End -->

        <!-- Content Start -->
        <div class="data-table-rows slim">
          <!-- Controls Start -->
         
          <!-- Controls End -->

          <!-- Table Start -->
          <div class="data-table-responsive-wrapper">
            <table id="city" class="data-table nowrap w-100">
              
            </table>
          </div>
          <!-- Table End -->
        </div>
        <!-- Content End -->

        <!-- Add Modal Start -->
        <div class="modal modal-right fade" id="createNewCity" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form name="add_city_form" id="add_city_form" enctype="multipart/form-data">
                  <input type="hidden" name="city_id" id="city_id" value="">
                  <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input name="name" id="name" value="" placeholder="Enter City Name" type="text" class="form-control" />
                    <small class="text-danger" id="nameError"></small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">City Image</label>
                    <input type="file" name="image" id="image" class="form-control">
                    <small class="text-danger" id="imageError"></small>
                  </div>
                  <div id="imageShow" class="float-end">
                    
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Status</label>
                    <div class="form-check">
                      <input class="form-check-input" name="status" type="checkbox" id="status" value="1">
                      <label class="form-check-label check" for="status">Active</label>
                    </div>
                  </div>
                  <div>
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="add_city_btn">Create</button>
                  </div>
                </form>
              </div>
              
            </div>
          </div>
        </div>
        <!-- Add Modal End -->
        <!-- Add Modal Start -->
        <div class="modal modal-right fade" id="updateCity" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modelHeading">Edit City</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form id="update_city_form" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="city_id" id="city_id" value="">
                    <div class="mb-3">
                      <label class="form-label">Name</label>
                      <input name="name" id="edit_name" value="" placeholder="Enter City Name" type="text" class="form-control" />
                      <small class="text-danger" id="edit_nameError"></small>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">City Image</label>
                      <small class="form-label">(upload city image 300*300)</small>
                      <input type="file" name="image" class="image form-control">
                      <small class="text-danger imageError"></small>
                    </div>
                    <div class="imageShow float-end">
                      
                    </div>
                    <div>
                      <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                      <button type="button" class="btn btn-primary" id="update_city_btn">Update</button>
                    </div>
                  </form>
                </div>
                
              </div>
            </div>
          </div>
          <!-- Add Modal End -->
      </div>
    </div>
  </div>
</section>


@endsection
@section('js_page')
<script src="{{asset('backend/admin/custom_js/city.js')}}"></script>
@endsection
