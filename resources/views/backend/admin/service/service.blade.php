@php
    $html_tag_data = [];
    $title = 'Service List';
    $description= 'Service List for Admin';
@endphp
@extends('layout.admin.layout',['html_tag_data'=>$html_tag_data, 'title'=>$title, 'description'=>$description])

@section('css')


@endsection

@section('js_vendor')
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.1/classic/ckeditor.js"></script>
<script src="{{asset('backend/js/moment-with-locales.min.js')}}"></script>
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
                <h4 id="title" >Services List</h4>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb" >
                  <ul class="breadcrumb" style="background-color: #f8f9fc">
                    <li class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('admin.services')}}">Services</a></li>
                  </ul>
                </nav>
              </div>
              <!-- Title End -->
              <!-- Top Buttons Start -->
              <div class="col-md-4 d-flex align-items-start justify-content-end">
                <!-- Add New Button Start -->
                <button data-bs-toggle="modal" data-bs-target="#createNewService" type="button" class="createNewService btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto add-datatable">
                  <i class="fa fa-solid fa-plus"></i>
                  <span>Add New Services</span>
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
            <table id="service" class="data-table nowrap w-100">
          
            </table>
          </div>
          <!-- Table End -->
        </div>
        <!-- Content End -->
        <!-- Add Modal Start -->
        <div class="modal modal-right fade" id="createNewService" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modelHeading">Create Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">
                <form name="adminServiceForm" id="adminServiceForm">
                  <div class="mb-3">
                    <label class="form-label">Category Name</label>
                    <select name="category_id" id="category_id" class="form-control">
                      <option value="">Select Category</option>
                    </select>
                    <small class="text-danger" id="category_idError"></small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Provider Name</label>
                    <select name="provider_id" id="provider_id" class="form-control">
                      <option value="">Select Provider</option>
                    </select>
                    <small class="text-danger" id="provider_idError"></small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Service Title</label>
                    <input name="name" placeholder="Enter Service Title" type="text" class="form-control" />
                    <small class="text-danger" id="nameError"></small>
                  </div>
                
                  <div class="mb-3">
                    <label class="form-label">Price Type</label>
                    <select name="price_type" class="form-control">
                      <option value="" disabled="">select</option>
                      <option value="$">$</option>
                      <option value="৳">৳</option>
                      <option value="€">€</option>
                    </select>
                    <small class="text-danger" id="price_TypeError"></small>
                </div>
                  <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input name="price" placeholder="Enter Price" type="number" class="form-control" />
                    <small class="text-danger" id="priceError"></small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Discount</label>
                    <input name="discount" placeholder="Enter Discount" type="number" class="form-control" />
                    <small class="text-danger" id="discountError"></small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Duration</label>
                    <input name="duration" placeholder="Duration" type="text" class="form-control" />
                    <small class="text-danger" id="durationError"></small>
                  </div>

                  <div class="mb-3"  >
                    <label class="form-label">Description</label>
                    <textarea name="description" id="description" cols="10" rows="20" class="description form-control" placeholder="Enter Coupon Description ..."></textarea>
                    <small class="text-danger" id="descriptionError"></small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input name="image" type="file" class="image form-control" />
                    <small class="text-danger" id="imageError"></small>
                  </div>
                  <div class="imageShow float-end">
                      
                  </div>
                 
                  <div>
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="adminServiceBtn">Create</button>
                  </div>
                </form>
              </div>
              
            </div>
          </div>
        </div>
        <!-- Add Modal End -->
         <!-- Add Modal Start -->
         <div class="modal modal-right fade" id="updateService" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modelHeading">Edit Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">
                <form name="updateAdminServiceForm" id="updateAdminServiceForm">
                  <input type="hidden" name="_method" value="PUT">
                  <input type="hidden" name="servic_id" id="servic_id" value="">
                  <div class="mb-3">
                    <label class="form-label">Category Name</label>
                    <select name="category_id" id="edit_category_id" class="form-control">
                      <option value="">Select Category</option>
                    </select>
                    <small class="text-danger" id="category_idError"></small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Provider Name</label>
                    <select name="provider_id" id="edit_provider_id" class="form-control">
                      <option value="">Select Provider</option>
                    </select>
                    <small class="text-danger" id="provider_idError"></small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Service Title</label>
                    <input name="name" id="name" value="" placeholder="Enter Service Title" type="text" class="form-control" />
                    <small class="text-danger" id="nameError"></small>
                  </div>
                
                  <div class="mb-3">
                    <label class="form-label">Price Type</label>
                    <select name="price_type" id="price_type" class="form-control">
                      <option value="" disabled="">select</option>
                      <option value="$">$</option>
                      <option value="৳">৳</option>
                      <option value="€">€</option>
                    </select>
                    <small class="text-danger" id="price_TypeError"></small>
                </div>
                  <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input name="price" value="" id="price" placeholder="Enter Price" type="number" class="form-control" />
                    <small class="text-danger" id="priceError"></small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Discount</label>
                    <input name="discount" id="discount" value="" placeholder="Enter Discount" type="number" class="form-control" />
                    <small class="text-danger" id="discountError"></small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Duration</label>
                    <input name="duration" id="duration" value="" placeholder="Duration" type="text" class="form-control" />
                    <small class="text-danger" id="durationError"></small>
                  </div>

                  <div class="mb-3"  >
                    <label class="form-label">Description</label>
                    <textarea name="description" id="edit_description" cols="10" rows="20" class="description form-control" placeholder="Enter Coupon Description ..."></textarea>
                    <small class="text-danger" id="descriptionError"></small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input name="image" type="file" class="image form-control" />
                    <small class="text-danger" id="imageError"></small>
                  </div>
                  <div class="imageShow float-end">
                      
                  </div>
                  <div>
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="updareAdminServiceBtn">Update</button>
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
<div class="modal fade" id="ServiceDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelDefault" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title w-100 text-center" id="exampleModalLabelDefault">Service Information</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
              <section class="scroll-section" id="responsiveTabs">
              <div class="card mb-3">
                <div class="card-header border-0 pb-0">
                  <ul class="nav nav-tabs nav-tabs-line card-header-tabs responsive-tabs" role="tablist">

                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#first" role="tab" type="button" aria-selected="true">
                        Service Sumarry</button>
                    </li>

                    <li class="nav-item" role="presentation">
                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#second" role="tab" type="button" aria-selected="false">Service Details</button>
                    </li>

                    <li class="nav-item" role="presentation">
                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#third" role="tab" type="button" aria-selected="false">Booking List</button>
                    </li>

                    <li class="nav-item" role="presentation">
                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#four" role="tab" type="button" aria-selected="false">Review List</button>
                    </li>
                    
                    <!-- An empty list to put overflowed links -->
                    <li class="nav-item dropdown ms-auto pe-0 d-none responsive-tab-dropdown">
                      <button
                        class="btn btn-icon btn-icon-only btn-foreground mt-2"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                      >
                        <i data-acorn-icon="more-horizontal"></i>
                      </button>
                      <ul class="dropdown-menu mt-2 dropdown-menu-end"></ul>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane fade active show" id="first" role="tabpanel">
                      
                    <div class="mb-5" id="serviceSummary">
                    
                  </div>
                    
                    </div>
                    <div class="tab-pane fade" id="second" role="tabpanel">
                    <div class="container" id="serviceInformation">
                      <div class="row">
                        <div class="col-md-8">
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th colspan="2" class="text-center">Service Details</th>
                              </tr>
                              
                            </thead>
                          </table>
                        </div>
                        <div class="col-md-4">
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th scope="col" class="text-center">Provider Information</th>
                            </tr>
                           
                          </thead>
                        </table>
                    </div>
                      
                    </div>
                  </div>
                    </div>
                    <div class="tab-pane fade" id="third" role="tabpanel">
                      <div class="container">
                        <div class="row">
                          <div class="col-md-12">
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th scope="col">Booking ID#</th>
                                  <th scope="col">Service</th>
                                  <th scope="col">Price</th>
                                  <th scope="col">Status</th>
                                </tr>
                              </thead>
                              <tbody id="BookingId">
                                
                              </tbody>
                          </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="four" role="tabpanel">
                      <div class="container">
                        <div class="row">
                          <div class="col-md-12">
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th scope="col">Rating</th>
                                  <th scope="col">Review</th>
                                  <th scope="col">Action</th>
                                </tr>
                              </thead>
                              <tbody id="reviews_id">
                               
                              </tbody>
                          </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </section>
      </div>
      
    </div>
  </div>
</div>

{{-- details modal  --}}

@endsection
@section('js_page')
<script src="{{asset('backend/admin/custom_js/service.js')}}"></script>
@endsection
