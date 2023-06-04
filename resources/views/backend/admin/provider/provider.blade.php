@php
    $html_tag_data = [];
    $title = 'Provider List';
    $description= 'Provider List for Admin';
@endphp
@extends('layout.admin.layout',['html_tag_data'=>$html_tag_data, 'title'=>$title, 'description'=>$description])

@section('css')

@endsection

@section('js_vendor')
<script src="{{asset('backend/js/moment-with-locales.min.js')}}"></script>
{{-- ckEditor --}}
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.1/classic/ckeditor.js"></script> 
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
                <h4 id="title" >Provider List</h4>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb" >
                  <ul class="breadcrumb" style="background-color: #f8f9fc">
                    <li class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('admin.provider')}}">Provider</a></li>
                  </ul>
                </nav>
              </div>
              <!-- Title End -->
              <!-- Top Buttons Start -->
              <div class="col-md-4 d-flex align-items-start justify-content-end">
                <!-- Add New Button Start -->
              <button data-bs-toggle="modal" data-bs-target="#createNewProvider" type="button" class="createNewProvider btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto add-datatable">
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
          <!-- Controls Start -->
         
          <!-- Controls End -->

          <!-- Table Start -->
          <div class="data-table-responsive-wrapper">
            <table id="providers" class="data-table nowrap w-100">
              
            </table>
          </div>
          <!-- Table End -->
        </div>
        <!-- Content End -->

        <!-- Add Modal Start -->
        <div class="modal modal-right fade" id="createNewProvider" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modelHeading">Create New Provider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form name="providerForm" id="providerForm">
                  <div class="mb-3">
                    <label class="form-label">Provider Type</label>
                    <select name="providerType_id" id="providerType_id" class="form-control">
                      <option value="">Select Provider Type</option>
                    </select>
                    <small class="text-danger" id="providerType_idError"></small>
                </div>
                  <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input name="name" placeholder="Enter Name" type="text" class="form-control" />
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
                    <!-- <input name="city" placeholder="Enter City" type="text" class="form-control" /> -->
                    <small class="text-danger" id="cityError"></small>
                  </div>
                 
                  <div class="mb-3">
                    <label class="form-label">About</label>
                    <textarea name="about" cols="30" rows="5" class="form-control" placeholder="Write Your about ..."></textarea>
                    <small class="text-danger" id="aboutError"></small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input name="password" placeholder="Enter Password" type="password" class="form-control" />
                    <small class="text-danger" id="passwordError"></small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Photo</label>
                    <input name="photo" type="file" class="photo form-control" />
                    <small class="text-danger" id="photoError"></small>
                  </div>
                  <div class="imageShow float-end">
                      
                  </div>
                  <div >
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="ProviderBtn">Create</button>
                  </div>
                </form>
              </div>
              
            </div>
          </div>
        </div>
        <!-- Add Modal End -->
                <!-- Add Modal Start -->
          <div class="modal modal-right fade" id="updateProvider" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modelHeading">Edit Provider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form name="updateProviderForm" id="updateProviderForm">
                  <input type="hidden" name="provider_id" id="provider_id" value="">
                  <input type="hidden" name="_method" value="PUT">
                  <div class="mb-3">
                    <label class="form-label">Provider Type</label>
                    <select name="providerType_id" id="edit_providerType_id" class="form-control">
                      <option value="">Select Provider Type</option>
                      
                    </select>
                    <small class="text-danger" id="providerType_idError"></small>
                </div>
                  <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input name="name" id="name" value="" placeholder="Enter Name" type="text" class="form-control" />
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
                    <label class="form-label">About</label>
                    <textarea name="about" id="about" value="" cols="30" rows="5" class="form-control" placeholder="Write Your about ..."></textarea>
                    <small class="text-danger" id="aboutError"></small>
                  </div>
                  <!-- <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input name="password" id="password" value="" placeholder="Enter Password" type="password" class="form-control" />
                    <small class="text-danger" id="passwordError"></small>
                  </div> -->
                  <div class="mb-3">
                    <label class="form-label">Photo</label>
                    <input name="photo" type="file" class="photo form-control" />
                    <small class="text-danger" id="photoError"></small>
                  </div>
                  <div class="imageShow float-end">
                      
                  </div>
                  <div >
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="updateProviderBtn">Update</button>
                  </div>
                </form>
              </div>
              
            </div>
          </div>
        </div>
        <!-- Add Modal End -->
          <!--  Edit Modal Start -->
     
          <!--  Edit Modal End -->
      </div>
    </div>
  </div>
</main>
{{-- details modal  --}}

{{-- start details modal  --}}
<div class="modal fade" id="providerDetails" tabindex="-1" aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title w-100 text-center" id="exampleModalFullscreenLabel">Provider Information Details</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="providerID">
        
        <ul class="nav nav-tabs nav-tabs-title nav-tabs-line-title responsive-tabs" id="lineTitleTabsContainer" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link active" data-bs-toggle="tab" href="#firstLineTitleTab" role="tab" aria-selected="true">Provider Information</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" href="#secondLineTitleTab" role="tab" aria-selected="false">Service List</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" href="#thirdLineTitleTab" role="tab" aria-selected="false">Handyman List</a>
          </li>

          <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" href="#forthLineTitleTab" role="tab" aria-selected="false">Review List</a>
          </li>
         
          <!-- An empty list to put overflowed links -->
          <li class="nav-item dropdown ms-auto pe-0 d-none responsive-tab-dropdown">
            <a
              class="btn btn-icon btn-icon-only btn-background pt-0 bg-transparent pe-0"
              href="#"
              data-bs-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <i data-acorn-icon="more-horizontal"></i>
            </a>
            <ul class="dropdown-menu mt-2 dropdown-menu-end"></ul>
          </li>
        </ul>
        
        <div class="card mb-5">
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane fade active show" id="firstLineTitleTab" role="tabpanel">

                <div class="mb-5" id="summeryInfo">
                 
                </div>
                <div id="poviderInfo">
                  
                </div>
              </div>
              <div class="tab-pane fade" id="secondLineTitleTab" role="tabpanel">
                <div class="col">
                  <!-- Content Start -->
                  <div class="data-table-rows slim">
                    <div class="data-table-responsive-wrapper">
                      <div class="col-12 col-md-7">
                        <h1 class="mb-0 pb-0 display-4" id="title">Service List</h1>
                        <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                          <ul class="breadcrumb pt-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.provider')}}">Providers</a></li>
                          </ul>
                        </nav>
                      </div>
                      <table class="table table-bordered table-hover" >
                        <thead>
                          <tr>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th>View</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody id="serviceID">
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
                  
                  <!-- Content End -->
                </div>
              </div>
              <div class="tab-pane fade" id="thirdLineTitleTab" role="tabpanel">
                <div class="col">
                  <!-- Content Start -->
                  <div class="data-table-rows slim">
                    <div class="data-table-responsive-wrapper">
                      <div class="col-12 col-md-7">
                        <h1 class="mb-0 pb-0 display-4" id="title">Handyman List</h1>
                        <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                          <ul class="breadcrumb pt-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.provider')}}">Providers</a></li>
                          </ul>
                        </nav>
                      </div>
                      <table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Image</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody id="handymanid">
                         
                        </tbody>
                      </table>
                    </div>
                  </div>
                  
                  <!-- Content End -->
                </div>
              </div>
              <div class="tab-pane fade" id="forthLineTitleTab" role="tabpanel">
                <div class="col">
                  <!-- Content Start -->
                  <div class="data-table-rows slim">
                    <div class="data-table-responsive-wrapper">
                      <div class="col-12 col-md-7">
                        <h1 class="mb-0 pb-0 display-4" id="title">Review List</h1>
                        <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                          <ul class="breadcrumb pt-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.provider')}}">Providers</a></li>
                          </ul>
                        </nav>
                      </div>
                      <table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Action</th>
                          </tr>
                          
                        </thead>
                        <tbody id="providerReviewId">
                         
                        </tbody>
                      </table>
                    </div>
                  </div>
                  
                  <!-- Content End -->
                </div>
              </div>
             
            </div>
          </div>
        </div>
      </div>
     
    </div>
  </div>
</div>
{{-- end details modal  --}}
{{-- details modal  --}}
<div class="modal fade" id="ServiceDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelDefault" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title w-100 text-center" id="exampleModalLabelDefault">Service Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="serviceInfo">
        
      </div>
      
    </div>
  </div>
</div>
{{-- details modal  --}}

@endsection
@section('js_page')
<script src="{{asset('backend/admin/custom_js/provider.js')}}"></script>
<script>
  // ClassicEditor
  //     .create( document.querySelector( '#about' ) )
  //     .catch( error => {
  //         console.error( error );
  //     } );
</script>
@endsection
