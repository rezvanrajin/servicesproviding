@php
    $html_tag_data = [];
    $title = 'Handyman List';
    $description= 'Handyman List for Provider';
@endphp
@extends('layout.provider.layout',['html_tag_data'=>$html_tag_data, 'title'=>$title, 'description'=>$description])

@section('css')

@endsection

@section('js_vendor')
<script src="{{asset('backend/provider/js/lib/moment-with-locales.min.js')}}"></script>
@endsection



@section('content')
<main class="col-md-10 offset-1">

  <div class="container">
    <div class="row">
      <div class="col">
        <!-- Title and Top Buttons Start -->
        <div class="page-title-container">
          <div class="row">
            <!-- Title Start -->
            <div class="col-md-8">
                <h4 id="title" >Handyman List</h4>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb" >
                  <ul class="breadcrumb" style="background-color: #f8f9fc">
                  <li class="breadcrumb-item"><a href="{{route('provider.dashboard')}}">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="{{route('provider.handyman')}}">Handyman</a></li>
                </ul>
              </nav>
            </div>
            <!-- Title End -->

            <!-- Top Buttons Start -->
              <div class="col-md-4 d-flex align-items-start justify-content-end">
              <!-- Add New Button Start -->
              <button data-bs-toggle="modal" data-bs-target="#createNewHandyman" type="button" class="createNewHandyman btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto add-datatable">
                <i data-acorn-icon="plus"></i>
                <span>Add New Handyman</span>
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
            <table id="handyman" class="data-table nowrap w-100">
             
            </table>
          </div>
          <!-- Table End -->
        </div>
        <!-- Content End -->

        <!-- Add Modal Start -->
        <div class="modal modal-right fade" id="createNewHandyman" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modelHeading">Create New Handyman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form name="handymanForm" id="handymanForm">
                  <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input name="name" placeholder="Enter Your Handyman Name" type="text" class="form-control" />
                    <small class="text-danger" id="nameError"></small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input name="email" placeholder="Enter Email" type="text" class="form-control" />
                    <small class="text-danger" id="emailError"></small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Mobile</label>
                    <input name="mobile" placeholder="Enter Mobile" type="text" class="form-control" />
                    <small class="text-danger" id="mobileError"></small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input name="address" placeholder="Enter Address" type="text" class="form-control" />
                    <small class="text-danger" id="addressError"></small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">City</label>
                    <select name="city" id="city" class="form-control">
                      <option value="">Select City</option>
                    </select>
                    <small class="text-danger" id="cityError"></small>
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Photo</label>
                      <input type="file" name="photo" class="form-control photo">
                      <small class="text-danger" id="photoError"></small>
                  </div>
                  <div class="imageShow float-end">
                      
                  </div>
                  <div>
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="handymanBtn">Create</button>
                  </div>
                </form>
              </div>
              
            </div>
          </div>
        </div>
        <!-- Add Modal End -->
        <!-- Add Modal Start -->
        <div class="modal modal-right fade" id="updateHandyman" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modelHeading">Edit Handyman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form name="updateHandymanForm" id="updateHandymanForm">
                  <input type="hidden" name="_method" value="PUT">
                  <input type="hidden" name="handyman_id" id="handyman_id" value="">
                  <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input name="name" id="name" value="" placeholder="Enter Your Handyman Name" type="text" class="form-control" />
                    <small class="text-danger" id="nameError"></small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input name="email" id="email" value="" placeholder="Enter Email" type="text" class="form-control" />
                    <small class="text-danger" id="emailError"></small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Mobile</label>
                    <input name="mobile" id="mobile" value="" placeholder="Enter Mobile" type="text" class="form-control" />
                    <small class="text-danger" id="mobileError"></small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input name="address" id="address" value="" placeholder="Enter Address" type="text" class="form-control" />
                    <small class="text-danger" id="addressError"></small>
                  </div>
                  
                  <div class="mb-3">
                    <label class="form-label">City</label>
                    <select name="city" id="edit_city" class="form-control">
                      <option value="">Select City</option>
                      
                    </select>
                    <small class="text-danger" id="cityError"></small>
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Photo</label>
                      <input type="file" name="photo" class="form-control photo">
                      <small class="text-danger" id="photoError"></small>
                  </div>
                  <div class="imageShow float-end">
                      
                  </div>
                  <div>
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="updateHandymanBtn">Update</button>
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
</main>
{{-- details modal  --}}
<div class="modal fade" id="handymanDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelDefault" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title  w-100 text-center" id="exampleModalLabelDefault">Handyman Information</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="providerInfo">
        
      </div>
      
    </div>
  </div>
</div>
{{-- details modal  --}}
@endsection
@section('js_page')
<script src="{{asset('backend/provider/custom_js/handyman.js')}}"></script>
@endsection
