@php
    $html_tag_data = [];
    $title = 'Category List';
    $description= 'Category List for Admin';
@endphp
@extends('layout.admin.layout',['html_tag_data'=>$html_tag_data, 'title'=>$title, 'description'=>$description])

@section('css')

@endsection
@section('js_vendor')

@endsection

@section('content')
    
<section class="col-md-10 offset-1">
<div class="container">
<div class="row">
    <div class="col">
            
        <!-- Title and Top Buttons Start -->
        <div class="page-title-container">
            <div class="row">
              <!-- Title Start -->
              <div class="col-md-8">
                <h4 id="title" >Category List</h4>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb" >
                  <ul class="breadcrumb" style="background-color: #f8f9fc">
                    <li class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('admin.category')}}">Categoroy</a></li>
                  </ul>
                </nav>
              </div>
              <!-- Title End -->
              <!-- Top Buttons Start -->
              <div class="col-md-4 d-flex align-items-start justify-content-end">
                <!-- Add New Button Start -->
                <button data-bs-toggle="modal" data-bs-target="#createNewCategory" type="button" class="createNewCategory btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto add-datatable">
                  <i class="fa fa-solid fa-plus"></i>
                  <span>Add New Category</span>
                </button>
                <!-- Add New Button End -->
              </div>
              <!-- Top Buttons End -->
            </div>
          </div>
          <!-- Title and Top Buttons End -->
  
          <!-- Content Start -->
<div class="card-body">
                            <div class="table-responsive">
                              <table id="category" class="data-table nowrap w-100">
              
                              </table>
                            </div>
                        </div>
          <!-- Content End -->

    </div>
</div>
</div>
</section>  
          <!-- Add Modal Start -->
        <div class="modal modal-right fade" id="createNewCategory" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modelHeading">Create Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form id="categoryForm" enctype="multipart/form-data">
                  <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input name="name" placeholder="Enter Category Name" type="text" class="form-control" />
                    <small class="text-danger" id="nameError"></small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Parent Category</label>
                    <select name="parent_id" class="parent_id form-control">
                      <option value="">Select Prent Category</option>
                      
                    </select>
                    <small class="text-danger" id="parent_idError"></small>
                </div>
                  <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input name="image" type="file" class="image form-control" />
                    <small class="text-danger" id="imageError"></small>
                  </div>
                  <div class="float-end imageShow">
                    
                  </div>
                  <div>
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary add_edit_city_btn" id="add_category_btn">Create</button>
                  </div>
                </form>
              </div>
              
            </div>
          </div>
        </div>
        <!-- Add Modal End -->
          <!-- Add Modal Start -->
          <div class="modal modal-right fade" id="updateCategory" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modelHeading">Edit Category</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form id="updateCategoryForm" name="updateCategoryForm" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="category_id" id="category_id" value="">
                    <div class="mb-3">
                      <label class="form-label">Name</label>
                      <input name="name" id="name" value="" placeholder="Enter Category Name" type="text" class="form-control" />
                      <small class="text-danger" id="edit_nameError"></small>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Parent Category</label>
                      <select name="parent_id" id="edit_parent_id" class="parent_id form-control">
                        <option value="">Select Prent Category</option>
                        
                      </select>
                      <small class="text-danger" id="edit_parent_idError"></small>
                  </div>
                    <div class="mb-3">
                      <label class="form-label">Image</label>
                      <input name="image" type="file" class="image form-control" />
                      <small class="text-danger" id="imageError"></small>
                    </div>
                    <div class="float-end imageShow">
                      
                    </div>
                    
                    <div>
                      <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-primary" id="update_category_btn">Update</button>
                    </div>
                  </form>
                </div>
                
              </div>
            </div>
          </div>
          <!-- Add Modal End -->


@endsection

@section('js_page')
<script src="{{asset('backend/admin/custom_js/category.js')}}"></script>
@endsection