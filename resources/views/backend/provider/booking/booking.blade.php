@php
    $html_tag_data = [];
    $title = 'Booking List';
    $description= 'Booking List for Admin';
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
                <h4 id="title" >Bookings List</h4>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb" >
                  <ul class="breadcrumb" style="background-color: #f8f9fc">
                  <li class="breadcrumb-item"><a href="{{route('provider.dashboard')}}">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="{{route('provider.booking')}}">Bookings</a></li>
                </ul>
              </nav>
            </div>
            <!-- Title End -->
            
          </div>
        </div>
        <!-- Title and Top Buttons End -->

        <!-- Content Start -->
        <div class="data-table-rows slim">
          <!-- Controls Start -->
         
          <!-- Controls End -->

          <!-- Table Start -->
          <div class="data-table-responsive-wrapper">
            <table id="booking" class="data-table nowrap w-100">
              
            </table>
          </div>
          <!-- Table End -->
        </div>
        <!-- Content End -->

        
      </div>
    </div>
  </div>

</main>
  {{-- details modal  --}}

  <div class="modal fade" id="bookingDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelDefault" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="bookingInfo">
        
      </div>
      
    </div>
  </div>
</div>
{{-- details modal  --}}
{{-- details modal  --}}
<div class="modal fade" id="bookingAssign" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelDefault" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabelDefault">Assign Handyman</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="bookingInfo">
        <form name="assignHandymanForm" id="assignHandymanForm">
          <div class="row g-3">
            <input type="hidden" name="user_id" id="user_id" value="">
            <input type="hidden" name="booking_id" id="booking_id" value="">
            <input type="hidden" name="service_id" id="service_id" value="">
            <input type="hidden" name="provider_id" id="provider_id" value="">
            <div class="col-md-10">
              <select name="handyman_id" id="handyman_id" class="form-control">
                <option value="">Select Handyman</option>
              </select>
            </div>
            <div class="col-md-2">
              <button type="submit" id="saveBtn" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto">
                <span>Assign</span></button>
            </div>
            
          </div>
        </form>
      </div>
      
    </div>
  </div>
</div>
{{-- details modal  --}}
{{-- details modal  --}}
<div class="modal fade" id="bookingStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelDefault" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabelDefault">Booking Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="bookingInfo">
        <form name="bookingStatusForm" id="bookingStatusForm">
          <div class="row g-3">
            <div class="col-md-10">
              <select name="status" id="status" class="form-control">
                <option value="">Select Status</option>
                <option value="Pandding">Pandding</option>
                <option value="Paid">Paid</option>
                <option value="Assign">Assign</option>
                <option value="Working">Working</option>
                <option value="Complete">Complete</option>
              </select>
            </div>
            <div class="col-md-2">
              <button type="submit" id="statusBtn" class="btn btn-outline-info btn-icon btn-icon-start btn-md">
                <span>Update</span></button>
            </div>
            
          </div>
        </form>
      </div>
      
    </div>
  </div>
</div>
{{-- details modal  --}}


@endsection

@section('js_page')
<script src="{{asset('backend/provider/custom_js/booking.js')}}"></script>
@endsection