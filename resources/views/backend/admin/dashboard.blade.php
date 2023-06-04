@php
    $html_tag_data = [];
    $title = 'Dashboard';
    $description= 'Dashboard for Admin';
@endphp
@extends('layout.admin.layout',['html_tag_data'=>$html_tag_data, 'title'=>$title, 'description'=>$description])

@section('css')
@endsection

@section('js_vendor')
<script src="{{asset('backend/provider/js/lib/moment-with-locales.min.js')}}"></script>
@endsection


@section('content')

   <!-- Performance Start -->

  <div class="col-md-9">

    <div class="mb-5" id="dashborad_id">
      
    </div>
    
    <div class="row">
      <!-- Recent Orders Start -->
      <div class="col-xl-6 mb-5">
        <h2 class="small-title">Recent Bookings</h2>
        <div class="mb-n2 scroll-out">
          <div class="scroll-by-count" data-count="6" id="recentBookingShow">


           

           
          </div>
        </div>
      </div>
      <!-- Recent Orders End -->

      <!-- Performance Start -->
      <div class="col-xl-6 mb-5">
        <h2 class="small-title">Recent Mail</h2>
        <div class="mb-n2 scroll-out" >
          <div class="scroll-by-count" data-count="6" id="EmailList">
              
          </div>
        </div>
      </div>
      <!-- Performance End -->
           <!-- Add Modal Start -->
           <div class="modal fade" id="DashboardMailDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelDefault" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title w-100 text-center" id="exampleModalLabelDefault">Mail Information</h3>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="Mailtable">
  
                </div>
                
              </div>
            </div>
          </div>
          <!-- Add Modal End -->
            <!-- Add Modal Start -->
        <div class="modal fade" id="DashReplayModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelDefault" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title w-100 text-center" id="exampleModalLabelDefault">Replay Mail</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body" id="DashSendMail">

              </div>
            </div>
          </div>
        </div>
        <!-- Add Modal End -->
    </div>
  </div>
   

@endsection

@section('js_page')
<script src="{{asset('backend/admin/custom_js/dashboard.js')}}"></script>
@endsection


