@php
    $html_tag_data = [];
    $title = 'Handyman List';
    $description= 'Handyman List for Provider';
@endphp
@extends('layout.provider.layout',['html_tag_data'=>$html_tag_data, 'title'=>$title, 'description'=>$description])
@section('css')
<style type="text/css">
  .select2.select2-container.select2-container--default{
    width:100% !important;  
  }
  </style>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet" />
@endsection

@section('js_vendor')
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.1/classic/ckeditor.js"></script>
<script src="{{asset('backend/provider/js/lib/moment-with-locales.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
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
                <h4 id="title" >Coupon List</h4>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb" >
                  <ul class="breadcrumb" style="background-color: #f8f9fc">
                  <li class="breadcrumb-item"><a href="{{route('provider.dashboard')}}">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="{{route('provider.coupons')}}">Coupons</a></li>
                </ul>
              </nav>
            </div>
            <!-- Title End -->

            <!-- Top Buttons Start -->
              <div class="col-md-4 d-flex align-items-start justify-content-end">
              <!-- Add New Button Start -->
              <button data-bs-toggle="modal" data-bs-target="#createNewCoupon" type="button" class="createNewCoupon btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto add-datatable">
                <i data-acorn-icon="plus"></i>
                <span>Add New Coupon</span>
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
            <table id="providerCoupons" class="data-table nowrap w-100">
             
            </table>
          </div>
          <!-- Table End -->
        </div>
        <!-- Content End -->

        <!-- Add Modal Start -->
        <div class="modal modal-right fade" id="createNewCoupon" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modelHeading">Create New Coupon</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form name="couponForm" id="couponForm">
                    
                    <div class="mb-3">
                      <label class="form-label">Coupon Code</label>
                      <input name="coupon_code" placeholder="Enter Coupon Code" type="text" class="form-control" />
                      <small class="text-danger" id="coupon_codeError"></small>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">User Email</label>
                      <select name="user_email[]" class="select2" multiple="multiple" id="user_id">
                        <option value="">Select Service</option>
                      </select>
                      <small class="text-danger" id="user_emailError"></small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Discount Type</label>
                        <select name="discount_type" class="form-control">
                          <option value="" disabled>select</option>
                          <option value="Fixed">Fixed</option>
                          <option value="Percentage">Percentage</option>
                        </select>
                        <small class="text-danger" id="discount_typeError"></small>
                    </div>
                    
                    <div class="mb-3">
                      <label class="form-label">Discount Amount</label>
                      <input name="discount_amount" placeholder="Enter Discount Amount" type="text" class="form-control" />
                      <small class="text-danger" id="discount_amountError"></small>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Start Date</label>
                      <input readonly type="text" class="form-control" placeholder="Start Date" name="start_date"  id="start_date">
                      <small class="text-danger" id="start_dateError"></small>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">End Date</label>
                      <input readonly name="end_date" id="end_date" placeholder="End Date" type="text" class="form-control" />
                      <small class="text-danger" id="end_dateError"></small>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Description</label>
                      <textarea name="description" id="description" cols="10" rows="10" class="form-control" placeholder="Enter Coupon Description ..."></textarea>
                      <small class="text-danger" id="descriptionError"></small>
                    </div>
                   
                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-primary" id="couponSaveBtn">Create</button>
                    </div>
                  </form>
                </div>
                
              </div>
            </div>
          </div>
          <!-- Add Modal End -->
           
          
          <!-- Add Modal Start -->
          <div class="modal modal-right fade" id="UpdateNewCoupon" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modelHeading">Edit Coupon</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form name="update_coupons_from" id="update_coupons_from">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="coupon_id" id="coupon_id" value="">
                    <div class="mb-3">
                      <label class="form-label">Coupon Code</label>
                      <input name="coupon_code" id="coupon_code" value="" placeholder="Enter Coupon Code" type="text" class="form-control" />
                      <small class="text-danger" id="Editcoupon_codeError"></small>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Service Name</label>
                      <select name="user_email[]" class="select2" multiple="multiple" id="edit_user_id">
                        <option value="">Select user</option>
                      </select>
                      <small class="text-danger" id="service_idError"></small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Discount Type</label>
                        <select name="discount_type" id="Editdiscount_type" class="form-control">
                          <option value="" disabled>select</option>
                          <option value="Fixed">Fixed</option>
                          <option value="Percentage">Percentage</option>
                        </select>
                        <small class="text-danger" id="Editdiscount_typeError"></small>
                    </div>
                    
                    <div class="mb-3">
                      <label class="form-label">Discount Amount</label>
                      <input name="discount_amount" id="Editdiscount_amount" value="" placeholder="Enter Discount Amount" type="text" class="form-control" />
                      <small class="text-danger" id="Editdiscount_amountError"></small>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Start Date</label>
                      <input readonly type="text" class="form-control" placeholder="Start Date" name="start_date" value=""  id="Editstart_date">
                      <small class="text-danger" id="start_dateError"></small>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">End Date</label>
                      <input readonly name="end_date" id="Editend_date" value="" placeholder="End Date" type="text" class="form-control" />
                      <small class="text-danger" id="end_dateError"></small>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Description</label>
                      <textarea name="description" id="edit_description" cols="10" rows="10" class="form-control" placeholder="Enter Coupon Description ..."></textarea>
                      <small class="text-danger" id="EditdescriptionError"></small>
                    </div>
                    
                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                      <button type="button" class="btn btn-primary" id="update_coupon_btn">Update</button>
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
<div class="modal fade" id="couponDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelDefault" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title  w-100 text-center" id="exampleModalLabelDefault">Coupon Information</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="couponInfo">
        
      </div>
      
    </div>
  </div>
</div>
{{-- details modal  --}}
@endsection
@section('js_page')
<script src="{{asset('backend/provider/custom_js/coupon.js')}}"></script>
@endsection
