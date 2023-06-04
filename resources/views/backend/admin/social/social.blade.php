@php
    $html_tag_data = [];
    $title = 'Social Icon';
    $description = 'Social Icon List for Admin';
@endphp
@extends('layout.admin.layout',['html_tag_data'=>$html_tag_data, 'title'=>$title, 'description'=>$description])

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
<link href="{{asset('backend/admin/css/lib/bootstrapicons-iconpicker.css')}}" rel="stylesheet">
@endsection

@section('js_vendor')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection



@section('content')
    <div class="col-md-10 offset-1">
        <!-- Title Start -->
        <section class="scroll-section" id="title">
            <div class="page-title-container">
                <h4 id="title" >Social Icon List</h4>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb" >
                  <ul class="breadcrumb" style="background-color: #f8f9fc">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.social') }}">Social Link</a></li>
                    </ul>
                </nav>
            </div>
        </section>
        <!-- Title End -->
        <!-- admin.sociallink -->
        <!-- Content Start -->
        <div class="row">
            <div class="col-md-4">
                <div class="card col-md-12">
                    <div class="card-body" id="create">
                        <!-- Form Row Start -->
                        <form  id="add_sociallink_form">
                          <div class="mb-3">
                            <label class="form-label">icon</label>
                            <input type="text" name="icon" class="form-control iconpicker"  placeholder="Icon Picker" aria-label="Icone Picker"
                                    aria-describedby="basic-addon1">
                                    <small class="text-danger" id="icon_Error"></small>
                          </div>
                           
                          <div class="mb-3">
                            <label class="form-label">Link</label>
                            <input name="link" placeholder="Enter link" type="text" class="form-control" />
                            <small class="text-danger" id="link_Error"></small>
                          </div>
                         
                          <div style="text-align: center">
                            <button type="button" class="btn btn-primary" id="add_sociallink_btn">Create</button>
                          </div>
                        </form>
                        <!-- Form Row End -->
 
                        <form action="#" name="UpdateSocialLinkForm" id="UpdateSocialLinkForm">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="col-auto pe-2" style="text-align: right">
                            <button class="btn btn-sm btn-danger" id="backList"><i class="fas fa-arrow-left" width="10" height="10"></i></button>
                          </div>
                        <input type="hidden" name="sociallink_id" id="sociallink_id" value="">
                          <div class="col-md-12">
                          <label class="form-label">icon</label>
                            <input type="text" name="icon" id="icon" value="" class="form-control iconpicker"  placeholder="Icon Picker" aria-label="Icone Picker"
                                    aria-describedby="basic-addon1">
                                    <small class="text-danger" id="icon_Error"></small>
                          </div>
                          <div class="col-md-12">
                          <label class="form-label">Link</label>
                            <input name="link" value="" id="link" placeholder="Enter link" type="text" class="form-control" />
                            <small class="text-danger" id="link_Error"></small>
                          </div>
                          <div style="text-align: center; margin:10px">
                              <button type="button" class="btn btn-primary" id="update_socaillink_btn">Update</button>
                          </div>
                      </form> 
                        
                    </div>
                   
                </div>
            </div>
            <div class="card col-md-8">
                <div class="card-body">
                  <div class="data-table-rows slim">
                    <!-- Controls Start -->
                   
                    <!-- Controls End -->
          
                    <!-- Table Start -->
                    <div class="data-table-responsive-wrapper">
                      <table id="sociallink" class="data-table nowrap w-100">
                        
                      </table>
                    </div>
                    <!-- Table End -->
                  </div>
                </div>
            </div>
        </div>
        </div>
<!-- .......... icon picker .....  -->

<!-- <div id="iconPicker" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Icon Picker</h4>
			</div>
			<div class="modal-body">
				<div>
					<ul class="icon-picker-list">
						<li>
							
						</li>
					</ul>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="change-icon" class="btn btn-success">
					<span class="fa fa-check-circle-o"></span>
					Use Selected Icon
				</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div> -->
<!-- ..............end icon picker ..........  -->
    @endsection
    @section('js_page')
    <script src="{{asset('backend/admin/js/lib/bootstrapicon-iconpicker.js')}}"></script>
<script>
  // initialize the icon picker and done
  $('.iconpicker').iconpicker({
      // customize the icon picker with the following options
      // THANKS FOR WATCHING!
      title: 'My Icon Picker',
      selected: false,
      defaultValue: false,
      placement: "bottom",
      collision: "none",
      animation: true,
      hideOnSelect: true,
      showFooter: true,
      searchInFooter: false,
      mustAccept: false,
      selectedCustomClass: "bg-primary",
      fullClassFormatter: function (e) {
          return e;
      },
      input: "input,.iconpicker-input",
      inputSearch: false,
      container: false,
      component: ".input-group-addon,.iconpicker-component",
      templates: {
          popover: '<div class="iconpicker-popover popover" role="tooltip"><div class="arrow"></div>' + '<div class="popover-title"></div><div class="popover-content"></div></div>',
          footer: '<div class="popover-footer"></div>',
          buttons: '<button class="iconpicker-btn iconpicker-btn-cancel btn btn-default btn-sm">Cancel</button>' + ' <button class="iconpicker-btn iconpicker-btn-accept btn btn-primary btn-sm">Accept</button>',
          search: '<input type="search" class="form-control iconpicker-search" placeholder="Type to filter" />',
          iconpicker: '<div class="iconpicker"><div class="iconpicker-items"></div></div>',
          iconpickerItem: '<a role="button" href="javascript:;" class="iconpicker-item"><i></i></a>'
      }
  });
</script>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-1VDDWMRSTH"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', 'G-1VDDWMRSTH');
</script>
<script>
try {
fetch(new Request("https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js", { method: 'HEAD', mode: 'no-cors' })).then(function(response) {
  return true;
}).catch(function(e) {
  var carbonScript = document.createElement("script");
  carbonScript.src = "//cdn.carbonads.com/carbon.js?serve=CK7DKKQU&placement=wwwjqueryscriptnet";
  carbonScript.id = "_carbonads_js";
  document.getElementById("carbon-block").appendChild(carbonScript);
});
} catch (error) {
console.log(error);
}
</script>
    <script src="{{asset('backend/admin/custom_js/social-link.js') }}"></script>
    @endsection