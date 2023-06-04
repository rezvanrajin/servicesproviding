@php
    $html_tag_data = [];
    $title = 'All Orders';
    $description= 'Order List for User';
@endphp
@extends('layout.user.layout',['html_tag_data'=>$html_tag_data, 'title'=>$title, 'description'=>$description])

@section('css')

@endsection
<script src="{{asset('backend/user/js/lib/moment-with-locales.min.js')}}"></script>
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
                <h4 id="title" >Favorite List</h4>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb" >
                  <ul class="breadcrumb" style="background-color: #f8f9fc">
                  <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="{{route('user.allOrder')}}">Order</a></li>
                </ul>
              </nav>
            </div>
            <!-- Title End -->

            <!-- Top Buttons Start -->
       
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
            <table id="allOrders" class="data-table nowrap w-100">
             
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
<div class="modal fade" id="OderDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelDefault" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title  w-100 text-center" id="exampleModalLabelDefault">Order Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="oderInfo">
        
      </div>
      
    </div>
  </div>
</div>
{{-- details modal  --}}
@endsection
@section('js_page')
<script src="{{asset('backend/user/custom_js/allOrder.js')}}"></script>
@endsection
