@php
    $html_tag_data = [];
    $title = 'Provider Type List';
    $description= 'Provider Type List for Admin';
@endphp
@extends('layout.admin.layout',['html_tag_data'=>$html_tag_data, 'title'=>$title, 'description'=>$description])

@section('css')

@endsection

@section('js_vendor')

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
                <h4 id="title" >Provider Type List</h4>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb" >
                  <ul class="breadcrumb" style="background-color: #f8f9fc">
                    <li class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('admin.providerType')}}">Provider Type</a></li>
                  </ul>
                </nav>
              </div>
              <!-- Title End -->
              <!-- Top Buttons Start -->
              <div class="col-md-4 d-flex align-items-start justify-content-end">
                <!-- Add New Button Start -->
              <button data-bs-toggle="modal" data-bs-target="#createNewProviderType" type="button" class="createNewProvider btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto add-datatable">
                  <i class="fa fa-solid fa-plus"></i>
                  <span>Add New Provider</span>
                </button>
                <!-- Add New Button End -->
              </div>
              <!-- Top Buttons End -->
            </div>
          </div>
        <!-- Title and Top Buttons End -->

        <!-- Content Start -->
        <div class="data-table-rows slim">


          <!-- Table Start -->
          <div class="data-table-responsive-wrapper">
            <table id="providerType" class="data-table nowrap w-100">
              
            </table>
          </div>
          <!-- Table End -->
        </div>
        <!-- Content End -->

        <!-- Add Modal Start -->
        <div class="modal modal-right fade" id="createNewProviderType" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modelHeading">Create Provider Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="#" name="providerTypeForm" id="providerTypeForm">
                 
                  <div class="mb-3">
                    <label class="form-label">Provider Type</label>
                    <input name="provider_type" placeholder="Enter Provider Type Name" type="text" class="form-control" />
                    <small class="text-danger" id="provider_typeError"></small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Comission Rate</label>
                    <input name="comission_rate"  min="1" max="100" placeholder="Enter Comission Rate" type="number" class="form-control" />
                    <small class="text-danger" id="comission_rateError"></small>
                  </div>

                  <div>
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="createProviderTypeBtn">Create</button>
                  </div>
                </form>
              </div>
              
            </div>
          </div>
        </div>
        <!-- Add Modal End -->
         <!-- Add Modal Start -->
         <div class="modal modal-right fade" id="updateProviderType" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modelHeading">Edit Provider Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form name="updateProviderTypeForm" id="updateProviderTypeForm">
                  <input type="hidden" name="_method" value="PUT">
                  <input type="hidden" name="productType_id" id="productType_id" value="">
                  <div class="mb-3">
                    <label class="form-label">Provider Type</label>
                    <input name="provider_type" id="edit_provider_type" value="" placeholder="Enter Provider Type Name" type="text" class="form-control" />
                    <small class="text-danger" id="provider_typeError"></small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Comission Rate</label>
                    <input name="comission_rate" min="1" max="100" id="comission_rate" value="" placeholder="Enter Comission Rate" type="number" class="form-control" />
                    <small class="text-danger" id="comission_rateError"></small>
                  </div>

                  <div>
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="updateProviderTypeBtn">Update</button>
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

@endsection
@section('js_page')
<script src="{{asset('backend/admin/custom_js/providerType.js')}}"></script>
@endsection
