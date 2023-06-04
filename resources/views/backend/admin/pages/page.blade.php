@php
    $html_tag_data = [];
    $title = 'Page List';
    $description= 'Page List for Admin';
@endphp
@extends('layout.admin.layout',['html_tag_data'=>$html_tag_data, 'title'=>$title, 'description'=>$description])

@section('css')

@endsection

@section('js_vendor')
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.1/classic/ckeditor.js"></script>
@endsection
@section('content')
<main class="col-md-10 offset-1">
  <div class="container">
    <div class="row">
        <!-- Title and Top Buttons Start -->
        <div class="page-title-container">
            <div class="row">
              <!-- Title Start -->
              <div class="col-md-8">
                <h4 id="title" >Page List</h4>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb" >
                  <ul class="breadcrumb" style="background-color: #f8f9fc">
                    <li class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('admin.page')}}">Page</a></li>
                  </ul>
                </nav>
              </div>
              <!-- Title End -->
              <!-- Top Buttons Start -->
              <div class="col-md-4 d-flex align-items-start justify-content-end">
                <!-- Add New Button Start -->
                <button data-bs-toggle="modal" data-bs-target="#createNewpages" type="button" class="createNewpages btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto add-datatable">
                  <i class="fa fa-solid fa-plus"></i>
                  <span>Add New Page</span>
                </button>
                <!-- Add New Button End -->
              </div>
              <!-- Top Buttons End -->
            </div>
          </div>

        <!-- Title and Top Buttons End -->

        <!-- Content Start -->
        <div class="data-table-rows slim">


          <!-- Table Start -->
          <div class="data-table-responsive-wrapper">
            <table id="pages" class="data-table nowrap w-100">
            
            </table>
          </div>
          <!-- Table End -->
        </div>
        <!-- Content End -->

        <!-- Add Modal Start -->
        <div class="modal modal-right large fade" id="createNewpages" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form name="pagesForm" id="pagesForm">           
                  <div class="mb-3">
                    <label class="form-label">Page Title</label>
                    <input name="title"  placeholder="Enter Page Title" type="text" class="form-control" />
                    <small class="text-danger" id="titleError"></small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" cols="10" rows="20" class="form-control" placeholder="Enter Page Description ..."></textarea>
                    <small class="text-danger" id="descriptionError"></small>
                  </div>

                  <div>
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveBtn">Create</button>
                  </div>
                </form>
              </div>
              
            </div>
          </div>
        </div>
        <!-- Add Modal End -->

        <!-- Add Modal Start -->
        <div class="modal modal-right large fade" id="UpdateNewpages" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modelHeading">Edit Pages</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form name="updatePagesForm" id="updatePagesForm">
                  <input type="hidden" name="_method" value="PUT">
                  <input type="hidden" name="page_id" id="page_id" value="">
                  <div class="mb-3">
                    <label class="form-label">Page Title</label>
                    <input name="title" id="titlePage" value="" placeholder="Enter Page Title" type="text" class="form-control" />
                    <small class="text-danger" id="editTitleError"></small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" id="editDescriptionPage" value="" cols="10" rows="20" class="form-control" placeholder="Enter Page Description ..."></textarea>
                    <small class="text-danger" id="editDescriptionError"></small>
                  </div>

                  <div>
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="UpdateBtn">Update</button>
                  </div>
                </form>
              </div>
              
            </div>
          </div>
        </div>
        <!-- Add Modal End -->
        


    </div>
  </div>
  
</main>
{{-- details modal  --}}
<div class="modal fade" id="pageDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelDefault" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title  w-100 text-center" id="exampleModalLabelDefault">Page Information</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="pageInfo">
        
      </div>
      
    </div>
  </div>
</div>
{{-- details modal  --}}

@endsection
@section('js_page')
<script src="{{asset('backend/admin/custom_js/page.js')}}"></script>
{{-- <script>
  ClassicEditor
      .create( document.querySelector( '#description' ) )
      .catch( error => {
          console.error( error );
      } );
</script> --}}
@endsection
