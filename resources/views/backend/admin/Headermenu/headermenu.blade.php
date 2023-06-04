@php
    $html_tag_data = [];
    $title = 'Frontend Menu List';
    $description = 'Frontend Menu List for Admin';
@endphp
@extends('layout.admin.layout',['html_tag_data'=>$html_tag_data, 'title'=>$title, 'description'=>$description])

@section('css')
@endsection

@section('js_vendor')
@endsection



@section('content')
    <div class="col-md-10 offset-1">
        <!-- Title Start -->
        <section class="scroll-section" id="title">
            <div class="page-title-container">
                <h4 id="title" >Menu List</h4>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb" >
                  <ul class="breadcrumb" style="background-color: #f8f9fc">
                    <li class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('admin.menu')}}">Menu</a></li>
                  </ul>
                </nav>
            </div>
        </section>
        <!-- Title End -->

        <!-- Content Start -->
        <div class="row">
            <div class="col-md-4">
                <div class="card col-md-12">
                    <div class="card-body" id="create">
                        <!-- Form Row Start -->
                        <form action="#" name="headerMenuForm" id="headerMenuForm">
                            <div class="col-md-12">
                                <label class="form-label">Menu Name</label>
                                <input name="name" placeholder="Enter Menu Name"
                                    type="text" class="form-control" />
                                <small class="text-danger" id="nameError"></small>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Parent Menu</label>
                                <select name="parent_id" id="parent_id" class="parent_id form-control">
                                  <option value="">Select Prent Menu</option>
                                  
                                </select>
                                <small class="text-danger" id="edit_parent_idError"></small>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Url</label>
                                <input name="url"  placeholder="Enter Menu Url"
                                    type="text" class="form-control" />
                                <small class="text-danger" id="urlError"></small>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Serial</label>
                                <input name="serial" placeholder="Enter your serial"
                                    type="text" class="form-control" />
                                <small class="text-danger" id="serialError"></small>
                            </div><br />
                            <div class="col-12">
                                <button type="button" class="btn btn-primary" id="savebtn">Create</button>
                            </div>
                        </form>
                        <!-- Form Row End -->
                      <!-- Form Row Start -->
                      <form action="#" name="UpdateMenuForm" id="UpdateMenuForm">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="col-auto pe-2" style="text-align: right">
                            <button class="btn btn-sm btn-danger" id="backList"><i class="fas fa-arrow-left" width="10" height="10"></i></button>
                          </div>
                        <input type="hidden" name="menu_id" id="menu_id" value="">
                          <div class="col-md-12">
                              <label class="form-label">Menu Name</label>
                              <input name="name" id="name" value="" placeholder="Enter Menu Name"
                                  type="text" class="form-control" />
                              <small class="text-danger" id="nameError"></small>
                          </div>
                          <div class="col-md-12">
                            <label class="form-label">Parent Menu</label>
                            <select name="parent_id" id="edit_parent_id" class="parent_id form-control">
                              <option value="">Select Prent Menu</option>
                              
                            </select>
                            <small class="text-danger" id="edit_parent_idError"></small>
                        </div>
                          <div class="col-md-12">
                              <label class="form-label">Url</label>
                              <input name="url" id="url" value="" placeholder="Enter Menu Url"
                                  type="text" class="form-control" />
                              <small class="text-danger" id="urlError"></small>
                          </div>
                          <div class="col-md-12">
                              <label class="form-label">Serial</label>
                              <input name="serial" id="serial" value="" placeholder="Enter your serial"
                                  type="text" class="form-control" />
                              <small class="text-danger" id="serialError"></small>
                          </div><br />
                          <div class="col-12">
                              <button type="button" class="btn btn-primary" id="updatebtn">Update</button>
                          </div>
                      </form>
                      <!-- Form Row End -->
                    </div>
                   
                </div>
            </div>
            <div class="card col-md-8">
                <div class="card-body">
                  <table class="table table-bordered">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Parent</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="Headermenu">
                  <tr>
              
            </tr>
          </tbody>
                  </table>
                </div>
            </div>
        </div>
        </div>
    @endsection
    @section('js_page')
        <script src="{{ asset('backend/admin/custom_js/headerMenu.js') }}"></script>
    @endsection
