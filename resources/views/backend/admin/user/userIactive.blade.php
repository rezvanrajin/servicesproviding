@php
    $html_tag_data = [];
    $title = 'User Inactive List';
    $description= 'User List for Admin';
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
                <h4 id="title" >User Inactive List</h4>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb" >
                  <ul class="breadcrumb" style="background-color: #f8f9fc">
                  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="{{route('admin.Inactiveusers')}}">Users</a></li>
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
            <table id="user_inactive" class="data-table nowrap w-100">
              
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
<div class="modal fade" id="userDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelDefault" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title w-100 text-center" id="exampleModalLabelDefault">Buyer Information</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="userInfostatus">
        
      </div>
      
    </div>
  </div>
</div>
{{-- details modal  --}}

@endsection
@section('js_page')
<script src="{{asset('backend/admin/custom_js/user.js')}}"></script>
@endsection