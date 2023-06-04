@php
    $html_tag_data = [];
    $title = 'Booking List';
    $description= 'Booking List for Admin';
@endphp
@extends('layout.admin.layout',['html_tag_data'=>$html_tag_data, 'title'=>$title, 'description'=>$description])

@section('css')

@endsection

@section('js_vendor')
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
                <h4 id="title" >Bookings List</h4>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb" >
                  <ul class="breadcrumb" style="background-color: #f8f9fc">
                  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="{{route('admin.bookings')}}">Bookings</a></li>
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
            <table id="bookings" class="data-table nowrap w-100">
              
            </table>
          </div>
          <!-- Table End -->
        </div>
        <!-- Content End -->

        
      </div>
    </div>
  </div>
</main>
                <!-- Add Modal Start -->
  <div class="modal fade" id="viewBooking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelDefault" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title w-100 text-center" id="exampleModalLabelDefault">Booking Info</h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="bookingInfo">

        </div>
      </div>
    </div>
  </div>
  <!-- Add Modal End -->
{{-- details modal  --}}
    <!-- Add Modal Start -->
    <div class="modal fade" id="bookingInvoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelDefault" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          
          <div class="modal-header">
            <h3 class="modal-title w-100 text-center" id="exampleModalLabelDefault">Booking Invoice</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="col-12 col-md-5 mt-2 mx-5">
            <a onclick="printDivSection('invoiceInfo')" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto" href="#">
              <i data-acorn-icon="print"></i>
              <span>Print</span>
            </a>
          </div>
          <div class="modal-body" id="invoiceInfo">
            
          </div>

        </div>
      </div>
    </div>
    <!-- Add Modal End -->
{{-- details modal  --}}

@endsection

@section('js_page')
<script src="{{asset('backend/admin/custom_js/booking.js')}}"></script>
@endsection