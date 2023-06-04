@php
    $html_tag_data = [];
    $title = 'Support Mail List';
    $description= 'Support Mail List for Provider';
@endphp
@extends('layout.provider.layout',['html_tag_data'=>$html_tag_data, 'title'=>$title, 'description'=>$description])

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
                <h4 id="title" >Support</h4>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb" >
                  <ul class="breadcrumb" style="background-color: #f8f9fc">
                  <li class="breadcrumb-item"><a href="{{route('provider.dashboard')}}">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="{{route('provider.emailSupport')}}">Mail list</a></li>
                </ul>
              </nav>
            </div>
            <!-- Title End -->

            <!-- Top Buttons Start -->
              <div class="col-md-4 d-flex align-items-start justify-content-end">
                <!-- Add New Button Start -->
                <button data-bs-toggle="modal" data-bs-target="#Sendmail" type="button" class="Sendmail btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto add-datatable">
                  <i data-acorn-icon="plus"></i>
                  <span>Send Mail</span>
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
            <table id="Buyermail" class="data-table nowrap w-100">
             
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
<div class="modal fade" id="MailDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelDefault" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title  w-100 text-center" id="exampleModalLabelDefault">Mail Details.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="mailInfo">
        
      </div>
      
    </div>
  </div>
</div>
{{-- details modal  --}}
            <!-- Add Modal Start -->
            <div class="modal fade" id="Sendmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelDefault" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h3 class="modal-title w-100 text-center" id="exampleModalLabelDefault">Send Mail</h3>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="DashSendMail">
                        <div class="row">
                            <div class="col-md-12">
                              <form name="ReplayMailForm" id="ReplayMailForm">
                                <div class="row">
                                <div class="col-md-6">
                                  <select name="email" id="email" class="form-control">
                                    <option value="">Select Email</option>

                                  </select><br/>
                                </div>
                                <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Mail Subject" name="subject" id="subject"/><br/>
                                </div>
                              </div>
                                <div class="mb-3">
                                  <textarea class="form-control" placeholder="Write..."  cols="20" id="description" name="description" rows="5"></textarea>
                                </div>
                                  <button type="button" class="btn btn-primary" id="ReplayBtn">Reply</button>
                              </form>
                            </div>
                          </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Add Modal End -->
@endsection


@section('js_page')
<script src="{{asset('backend/provider/custom_js/support.js')}}"></script>
@endsection
