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
                <h4 id="title" >Assign Logs List</h4>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb" >
                  <ul class="breadcrumb" style="background-color: #f8f9fc">
                  <li class="breadcrumb-item"><a href="{{route('provider.dashboard')}}">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="{{route('provider.assignHandyman')}}">Assign Logs</a></li>
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
            <table id="assignHandyman" class="data-table nowrap w-100">
              
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
          <h3 class="modal-title m-auto" id="exampleModalLabelDefault">Assing Logs Information</h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="assignInfo">
          
        </div>
        
      </div>
    </div>
  </div>
  {{-- details modal  --}}
@endsection
@section('js_page')
<script src="{{asset('backend/provider/custom_js/assign_log.js')}}"></script>
@endsection
