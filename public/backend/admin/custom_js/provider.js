$(function () {
  // ......... date picker ........

  $('#service').DataTable();
  $('#example2').DataTable();
  var editId = 0;
  // ....... image preview ........ 
  $(".photo").change(function(){
      let reader = new FileReader();
      reader.onload = (e) =>{
      $(".photo_preview").attr('src', e.target.result);
      }
      reader.readAsDataURL(this.files[0]);
  });
  // .......... token ............. 
  var token = document.querySelector('meta[name="api-token"]').content; 

  // ...... provider list .......... 

  var table = $('#providers').DataTable({
      processing: true,
      serverSide: true,
      "async": true,
      "crossDomain": true,
      ajax: {
          headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
          url : route('providers.index'),
      },
      'columns': [
          {
              'title': '#SL', data: 'id', class: "no-sort", width: '50px', render: function (data, row, type, col) {
                  var pageInfo = table.page.info();
                  return (col.row + 1) + pageInfo.start;
              }
          },
          {
              'title': 'Provider Name','name' :'name', data: 'name',class: 'text-right w72', render: function (data, type, row, col) {
                  let returnData = '';
                    returnData += '<a href="" target="_blank">'+data+'</a>';
                  return returnData;
              }
          },
          {'title':'Email','name':'email','data':'email'},
          {'title':'Provider Type ','name':'provider_type','data':'provider_type.provider_type'},
          {'title':'Photo','name':'name',"data": "photo" ,
              "render": function ( data) {
              return '<img src="'+data+'" width="40px" height="40px">';}
          },
          {
              'title': 'Status', data: 'id',class: 'text-right w72', render: function (data, type, row, col) {
                  let returnData = '';
                  
                  returnData += (row.status == 1 ? '<a href="javascript:void(0)" class="updateProviderStatus text-success"  id="provider-'+row.id+'" provider_id="'+row.id+'"><i title="Active" class="fs-4 fa-solid fa-toggle-on" status="Active"></i></a> &nbsp;' : '<a href="javascript:void(0)" class="updateProviderStatus text-success" id="provider-'+row.id+'" provider_id="'+row.id+'"><i title="Inactive" class="fs-4 fa-solid fa-toggle-off" status="Inactive"></i></a>&nbsp;');                    
                  return returnData;
              }
          },
          {
              'title': 'Action', data: 'id',class: 'text-right w72', render: function (data, type, row, col) {
                  let returnData = '';
                  
                  returnData += '<a title="Edit" href="javascript:void(0);" data-id="'+data+'" class=" viewProvider fs-4 text-info text-center"><i class="fa-solid fa-eye"></i></a> &nbsp;';
                  returnData += '<a title="Edit" href="javascript:void(0);" data-id="'+data+'" class="editProvider fs-4 text-primary text-center"><i class="fa-solid fa-pen-to-square"></i></a> &nbsp;';
                  returnData += '<a title="Delete" href="javascript:void(0);" data-id="'+data+'" class="fs-4 text-danger deleteProvider"><i class="fa-solid fa-trash"></i></a>';
                  
                  return returnData;
              }
          },
          
      ],
      columnDefs: [{
          searchable: false,
          orderable: false,
          targets: [0,3,4,5,6]
        }],
        responsive: true,
        autoWidth: false,
        serverSide: true,
        processing: true,
      
  });

  // .......... create ........... 

  $('.createNewPage').on('click',function () {
     
      $('#provider_id').val('');
      $('#createNewProvider').modal('show');
      $(".imageShow").html(`<img class="photo_preview" src="/uploads/provider/no-image.png" width="70" height="70">`);
      $("#providerType_idError").text('');
      $("#nameError").text('');
      $("#emailError").text('');
      $("#passwordError").text('');
      $('#mobileError').val('');
      $('#addressError').val('');
      $('#cityError').val('');
      $('#aboutError').val('');
      $('#photoError').val('');

  });
  //   ........... edit ............. 
  $('body').on('click', '.editProvider', function () {
      $("#providerType_idError").text('');
      $("#nameError").text('');
      $("#emailError").text('');
      $("#passwordError").text('');
      $('#mobileError').val('');
      $('#addressError').val('');
      $('#cityError').val('');
      $('#aboutError').val('');
      $('#photoError').val('');

      var provider_id = $(this).data('id');
      var editProvider = route('providers.edit',{'provider':provider_id});
      $.ajax({
          headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
          type: "get",
          url: editProvider,
          success: function (data) {
              $('#updateProvider').modal('show');
              $(".imageShow").html(`<img class='photo_preview' src="`+data.photo+`" width='70' height='70'">`);
              $('#provider_id').val(data.id);
              $('#name').val(data.name);
              editId = data.id;
              $('#edit_providerType_id').val(data.providerType_id );
              $('#email').val(data.email);
              $('#password').val(data.password);
              $('#mobile').val(data.mobile);
              $('#address').val(data.address);
              $('#edit_city').val(data.city);
              $('#about').val(data.about);
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });
      
  });
  
  //  .......... add edit store ............ 
  $('#ProviderBtn').on('click',function(e) {
      e.preventDefault();
         
      var formData = new FormData($("#providerForm")[0]);
      const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
              didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
      })
      // console.log(formData);
      $.ajax({
          headers: {"Authorization": token},
          type:'POST',
          url:  route('providers.store'),
          data: formData,
          cache:false,
          contentType: false,
          processData: false,
          success: (data) => {
              Toast.fire({
                  icon: 'success',
                  title: 'Provider Create successfully'
              })
           console.log(data);
              $('#providerForm').trigger("reset");
              $('#createNewProvider').modal('hide');
          table.draw();
          },
          error: function(data){
          // console.log(data);
              $("#providerType_idError").text(data.responseJSON.providerType_id);
              $("#nameError").text(data.responseJSON.name);
              $("#emailError").text(data.responseJSON.email);
              $("#mobileError").text(data.responseJSON.mobile);
              $("#addressError").text(data.responseJSON.address);
              $("#cityError").text(data.responseJSON.city);
              $("#aboutError").text(data.responseJSON.about);
              $("#photoError").text(data.responseJSON.photo);
            
          }
      });
  });

  $('#updateProviderBtn').on('click',function(e) {
      e.preventDefault();
      var ProviderUrl = route('providers.update',{'provider':editId});

      var formData = new FormData($("#updateProviderForm")[0]);
      const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
              didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
      })
      // console.log(formData);
      $.ajax({
          headers: {"Authorization": token},
          type:'POST',
          url: ProviderUrl,
          data: formData,
          cache:false,
          contentType: false,
          processData: false,
          success: (data) => {
              Toast.fire({
                  icon: 'success',
                  title: 'Provider Update successfully'
              })
           console.log(data);
              $('#updateProviderForm').trigger("reset");
              $('#updateProvider').modal('hide');
          table.draw();
          },
          error: function(data){
          // console.log(data);
              $("#providerType_idError").text(data.responseJSON.providerType_id);
              $("#nameError").text(data.responseJSON.name);
              $("#emailError").text(data.responseJSON.email);
              $("#mobileError").text(data.responseJSON.mobile);
              $("#addressError").text(data.responseJSON.address);
              $("#cityError").text(data.responseJSON.city);
              $("#aboutError").text(data.responseJSON.about);
              $("#photoError").text(data.responseJSON.photo);
              $("#passwordError").text(data.responseJSON.password);
          }
      });
  });

  //   .......... destroy ............. 
  $('body').on('click', '.deleteProvider', function () {
  
  var provider_id = $(this).data("id");
  var destroyProvider = route('providers.destroy',{'provider':provider_id});

  Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
                  headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
                  type: "DELETE",
                  url: destroyProvider,
                  success: function (data) {
                  Swal.fire({
                      toast: true,
                      position: 'top-end',
                      icon: 'success',
                      title: 'Provider Delete has been Successfully!',
                      showConfirmButton: false,
                      timer: 1500
                  })
                  table.draw()
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
          }
      })

  });

  //    .......... get provider ..........
  getAllProvider();
  function getAllProvider(){
      var providerType = route('admin.provider.getProvider');
      $.ajax({
          headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
          type: "get",
          dataType: 'json',
          processing: true,
          serverSide: true,
          async: true,
          crossDomain: true,
          url: providerType,
          success: function(data) {
          $.each(data , function(index, val) { 
              // console.log(index, val)
              $("#providerType_id").append(`<option value="`+val.id+`">`+val.provider_type+`</option>`);
              $("#edit_providerType_id").append(`<option value="`+val.id+`">`+val.provider_type+`</option>`);
              
          });
          
      }
      });
  }
  getAllCity();
  function getAllCity(){
      var city = route('admin.provider.getCity');
      $.ajax({
          headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
          type: "get",
          dataType: 'json',
          processing: true,
          serverSide: true,
          async: true,
          crossDomain: true,
          url: city,
          success: function(data) {
          $.each(data , function(index, val) { 
              // console.log(index, val)
              $("#city").append(`<option value="`+val.name+`">`+val.name+`</option>`);
              $("#edit_city").append(`<option value="`+val.name+`">`+val.name+`</option>`);
          });
          
      }
      });
  }


  


  //   .......... view provider ............ 
  $('body').on('click', '.viewProvider', function () {
      var provider_id = $(this).data("id");
      var viewProvider = route('providers.show',{'provider':provider_id});
 
      $.ajax({
          headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
          type: "get",
          url: viewProvider,
          success: function (data) {
        
              var loopdata ='';
              $.each(data.service, function(k, val) {
              let serviceUrl = route('ServiceDetails','url').replace("url",val.id);
              loopdata += `<tr>`;
                  // loopdata += `<td>`+val.category.name+`</td>`;
                  loopdata += `<td> <a href="${serviceUrl}" target="_blanck"> `+val.name+`</a></td>`;
                  loopdata += `<td>`+val.price+` `+val.price_type+`</td>`;
                  loopdata += `<td>`+val.duration+` Days</td>`;
                  loopdata += `<td><buttin type="button" data-id="`+val.id+`" class="btn btn-sm btn-info viewService"><i class="fa-solid fa-eye"></i></button></td>`;
                  loopdata += `<td>`+(val.status ==1 ? '<a href="javascript:void(0)" class="UpdateProviderServiceStatus text-success" id="ServiceStatus-' + val.id +'" ServiceStatus_id="' + val.id + '"><i class="fs-4 fa-solid fa-toggle-on" status="Active"></i></a>&nbsp;' : '<a href="javascript:void(0)" class="UpdateProviderServiceStatus text-success" id="ServiceStatus-' + val.id +'" ServiceStatus_id="'+ val.id + '"><i class="fs-4 fa-solid fa-toggle-off" status="Inactive"></i></a>&nbsp;')+`</td>`;
              loopdata += `</tr>`;
              });
              $("#serviceID").html(loopdata);

              var handymandata ='';
              $.each(data.handyman, function(k, val) {
              handymandata += `<tr>`;
                 
                  handymandata += `<td>`+val.name+`</td>`;
                  handymandata += `<td>`+val.mobile+`</td>`;
                  handymandata += `<td>`+val.address+`</td>`;
                  handymandata += `<td>`+val.city+`</td>`;
                  handymandata += `<td><img src="`+val.photo+`" width="50" height="50"></td>`;
                  handymandata += `<td>`+(val.status ==1 ? '<a href="javascript:void(0)" class="updateHandymanStatusUnder text-success" id="handyman-' + val.id +'" handyman_id="' + val.id + '"><i class="fs-4 fa-solid fa-toggle-on" status="Active"></i></a>&nbsp;' : '<a href="javascript:void(0)" class="updateHandymanStatusUnder text-success" id="handyman-' + val.id +'" handyman_id="'+ val.id + '"><i class="fs-4 fa-solid fa-toggle-off" status="Inactive"></i></a>&nbsp;')+`</td>`;
              handymandata += `</tr>`;
              });

              $("#handymanid").html(handymandata);
              
              var review_data ='';
              $.each(data.reviews, function(k, val) {
                  review_data += `<tr>`;
                  review_data += `<td>`+val.rating+`</td>`;
                  review_data += `<td>`+val.review+`</td>`;
                  review_data += `<td>`+(val.status ==1 ? '<a href="javascript:void(0)" class="ProviderUpdateReviewStatus text-success" id="reviewstatus-' + val.id +'" StatusReview_id="' + val.id + '"><i class="fs-4 fa-solid fa-toggle-on" status="Active"></i></a>&nbsp;' : '<a href="javascript:void(0)" class="ProviderUpdateReviewStatus text-success" id="reviewstatus-' + val.id +'" StatusReview_id="'+ val.id + '"><i class="fs-4 fa-solid fa-toggle-off" status="Inactive"></i></a>&nbsp;')+`</td>`;
                  review_data += `</tr>`;
              });
              $("#providerReviewId").html(review_data);

              var SellerReview_data ='';
              $.each(data.provider_reviews, function(k, val) {
              // console.log(val.user.name);
                  SellerReview_data += `<tr>`;
                  SellerReview_data += `<td>${val.id}</td>`;
                  SellerReview_data += `<td>${val.user.name}</td>`;
                  SellerReview_data += `<td>${val.rating}</td>`;
                  SellerReview_data += `<td>${val.review}</td>`;
                  SellerReview_data += `</tr>`;
              });
              $("#sellerReviewId").html(SellerReview_data);

              

              $("#summeryInfo").html(`
                      <div class="row g-2">
                      <div class="col-12 col-sm-6 col-lg-6">
                      <div class="card hover-scale-up cursor-pointer sh-19">
                          <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
                          <div class="bg-gradient-light sh-5 sw-5 rounded-xl d-flex justify-content-center align-items-center mb-2">
                              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-radish text-white"><path d="M11.7852 15.4134C9.18166 18.0169 4.8614 17.9177 3.53558 16.5919C2.20976 15.2661 2.11059 10.9458 4.71409 8.34231C7.31758 5.73881 8.82906 4.91481 12.0209 8.10661C15.2127 11.2984 14.3887 12.8099 11.7852 15.4134Z"></path><path d="M6.36401 8.10657 8.13178 9.87433M9 14 10.7678 15.7678M3 12 4.76777 13.7678M12.1777 7.94978V7.94978C13.4445 6.68295 15.3799 6.36889 16.9823 7.1701L17.1274 7.24268M12.1777 7.94975V7.94975C13.4445 6.68292 13.7586 4.74757 12.9573 3.14515L12.8848 3M14.157 6.00006 15.5712 4.58585"></path></svg>
                          </div>
                          <div class="heading text-center mb-0 d-flex align-items-center lh-1">Total Earn</div>
                          <div class="text-small text-primary">14 PRODUCTS</div>
                          </div>
                      </div>
                      </div>
                      <div class="col-12 col-sm-6 col-lg-6">
                      <div class="card hover-scale-up cursor-pointer sh-19">
                          <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
                          <div class="bg-gradient-light sh-5 sw-5 rounded-xl d-flex justify-content-center align-items-center mb-2">
                              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-loaf text-white"><path d="M18 11C18 16 14.4183 16 10 16C5.58172 16 2 16 2 11C2 7.68629 4 4 10 4C16 4 18 7.68629 18 11Z"></path><path d="M6 10 6 5M14 10 14 5M10 9 10 4"></path></svg>
                          </div>
                          <div class="heading text-center mb-0 d-flex align-items-center lh-1">Total Service</div>
                          <div class="text-small text-primary">`+(data .total_service==null ? '--' : data.total_service)+` Services</div>
                        
                          </div>
                      </div>
                      </div>
                      <div class="col-12 col-sm-6 col-lg-6">
                      <div class="card hover-scale-up cursor-pointer sh-19">
                          <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
                          <div class="bg-gradient-light sh-5 sw-5 rounded-xl d-flex justify-content-center align-items-center mb-2">
                              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-pepper text-white"><path d="M13 11.3333C13 15.0152 11.125 18 10 18C8.875 18 7 15.0152 7 11.3333C7 7.65144 7.29167 6 10 6C12.7083 6 13 7.65144 13 11.3333Z"></path><path d="M11 17.5C12.4471 17.4093 16.1356 16.6825 16.7696 13.3675 17.4035 10.0525 18.6096 7.29223 14.9118 6.58509 13.5768 6.3298 13.119 6.7133 12.4304 7.00002M9 17.5C7.5529 17.4093 3.86436 16.6825 3.23041 13.3675 2.59647 10.0525 1.39044 7.29223 5.08821 6.58509 6.42318 6.3298 6.881 6.7133 7.56958 7.00002"></path><path d="M10 6L9.37873 3.51493C9.15615 2.62459 8.35618 2 7.43845 2H7"></path></svg>
                          </div>
                          <div class="heading text-center mb-0 d-flex align-items-center lh-1">Total Handyman</div>
                          <div class="text-small text-primary">`+(data.total_handyman ==null ? '--': data.total_handyman)+` Handymans</div>
                          
                          </div>
                      </div>
                      </div>
                      <div class="col-12 col-sm-6 col-lg-6">
                      <div class="card hover-scale-up cursor-pointer sh-19">
                          <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
                          <div class="bg-gradient-light sh-5 sw-5 rounded-xl d-flex justify-content-center align-items-center mb-2">
                              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-pepper text-white"><path d="M13 11.3333C13 15.0152 11.125 18 10 18C8.875 18 7 15.0152 7 11.3333C7 7.65144 7.29167 6 10 6C12.7083 6 13 7.65144 13 11.3333Z"></path><path d="M11 17.5C12.4471 17.4093 16.1356 16.6825 16.7696 13.3675 17.4035 10.0525 18.6096 7.29223 14.9118 6.58509 13.5768 6.3298 13.119 6.7133 12.4304 7.00002M9 17.5C7.5529 17.4093 3.86436 16.6825 3.23041 13.3675 2.59647 10.0525 1.39044 7.29223 5.08821 6.58509 6.42318 6.3298 6.881 6.7133 7.56958 7.00002"></path><path d="M10 6L9.37873 3.51493C9.15615 2.62459 8.35618 2 7.43845 2H7"></path></svg>
                          </div>
                          <div class="heading text-center mb-0 d-flex align-items-center lh-1">Wallet</div>
                          <div class="text-small text-primary">21 PRODUCTS</div>
                          </div>
                      </div>
                      </div>
                      
                  </div>
              `);

              $('#poviderInfo').html(
                  `<table class="table table-bordered table-hover">
                      <tr>
                      <th colspan="2" class="text-center text-info">Provider Information</th>
                      </tr>
                      <tr>
                      <th width="30%">Provider Type</th>
                      <td>`+(data.provider.provider_type.provider_type == null ? '--': data.provider.provider_type.provider_type)+`</td>
                      </tr>
                      <tr>
                      <th width="30%">Comission Rate</th>
                      <td>`+(data.provider.provider_type.comission_rate == null ? '--':data.provider.provider_type.comission_rate)+`%</td>
                     
                      </tr>
                      <tr>
                      <th width="30%">Full Name</th>
                      <td>`+(data.provider.name == null ? '--':data.provider.name)+`</td>
                     
                      </tr>
                      <tr>
                      <th width="30%">Email</th>
                      <td>`+(data.provider.email == null ? '--':data.provider.email)+`</td>
                     
                      </tr>
                      <tr>
                      <th width="30%">Mobile</th>
                      <td>`+(data.provider.mobile == null ? '--':data.provider.mobile)+`</td>
                    
                      </tr>
                      
                      <tr>
                      <th width="30%">Address</th>
                      <td>`+(data.provider.address ==null ? '--':data.provider.address)+`</td>
                      
                      </tr>
                      <tr>
                      <th width="30%">City</th>
                      <td>`+(data.provider.city == null ? '--': data.provider.city)+`</td>
                      
                      </tr>
                      <tr>
                      <th width="30%">About</th>
                      <td>`+(data.provider.about == null ? '--':data.provider.about)+`</td>
                    
                      </tr>
                      <tr>
                      <th width="30%">Created At</th>
                      <td>`+moment(data.created_at).add(10, 'days').calendar()+`</td>
                     
                      </tr>
                      <tr>
                      <th width="30%">Photo</th>
                      <td><img src="`+(data.provider.photo ==null ? '--':data.provider.photo)+`" width="70" height="70"></td>
                      </tr>
                     
                  </table>`
              
              ); 
              $('#providerDetails').modal('show'); 
        
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });
 
  });

  // ...... view service ............ 
  $('body').on('click', '.viewService', function () {
    var service_id = $(this).data("id");
    // console.log(service_id);
    var viewService = route('providers.providerServiceDetails','service_id').replace("service_id",service_id);
    $.ajax({
        headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
        type: "get",
        url: viewService,
        success: function (data) {
         
          // console.log(data);
          $('#serviceInfo').html(
          `<table class="table table-bordered">
              <tr>
                <td colspan="2" class="text-center"><img src="`+data.image+`" width="200" height="120"></td>
              </tr>
              
              <tr>
                <th width="30%">Category Name</th>
                <td>`+(data.category.name == null ? '--': data.category.name)+`</td>
              </tr>
              
              <tr>
                <th width="30%">Service Title</th>
                <td>`+(data.name == null ? '--':data.name)+`</td>
              </tr>
              <tr>
                <th width="30%">Price</th>
                <td>`+(data.price == null ? '--': data.price )+` `+(data.price_type == null ? '--':data.price_type)+`</td>
              </tr>
              <tr>
                <th width="30%">Discount</th>
                <td>`+(data.discount == null ? '--':data.discount)+` `+(data.price_type == null ? '--':data.price_type)+`</td>
              </tr>
              <tr>
                <th width="30%">Duration</th>
                <td>`+(data.duration ==null ? '--'  : data.duration)+` Day's</td>
              </tr>
              <tr>
                <th width="30%">Service Details</th>
                <td>`+(data.description == null ? '--': data.description)+`</td>
              </tr>
              
              <tr>
                <th width="30%">Created At</th>
                <td>`+moment(data.created_at).add(10, 'days').calendar()+`</td>
              </tr>
          </table>
          `
          
        ); 

          $('#ServiceDetails').modal('show'); 
       
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
  });

  $(document).on('click','.updateProviderStatus', function(){
      var status = $(this).children("i").attr("status");
      var provider_id = $(this).attr("provider_id");
      // console.log(status);
  
      $.ajax({
        headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token },
        type:"post",
        url: route('providers.updateProviderStatus'),
        data:{status:status,provider_id:provider_id},
        success:function(resp){
          // console.log(resp);
          if(resp.status==0){
            $("#provider-"+provider_id).html('<i title="Inactive" class="fs-4 fa-solid fa-toggle-off" status="Inactive"></i>');
          }else if(resp.status==1){
            $("#provider-"+provider_id).html('<i title="Active" class="fs-4 fa-solid fa-toggle-on" status="Active"></i>');

          }
        },error:function(){
          console.log('Error');
        }
      });
  
    });

    $(document).on('click','.ProviderUpdateReviewStatus', function(){
      var status = $(this).children("i").attr("status");
            var StatusReview_id = $(this).attr("StatusReview_id");
      // console.log(status);
  
      $.ajax({
        headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token },
        type:"post",
        url: route('providers.updatePrviderReviewStatus'),
        data:{status:status,StatusReview_id:StatusReview_id},
        success:function(resp){
          // console.log(resp);
          if(resp.status==0){
            $("#reviewstatus-"+StatusReview_id).html('<i class="fs-4 fa-solid fa-toggle-off" status="Inactive"></i>');
          }else if(resp.status==1){
            $("#reviewstatus-"+StatusReview_id).html('<i class="fs-4 fa-solid fa-toggle-on" status="Active"></i>');

          }
        

        },error:function(){
          console.log('Error');
        }
      });    
    });

    $(document).on('click','.UpdateProviderServiceStatus', function(){
      var status = $(this).children("i").attr("status");
            var ServiceStatus_id = $(this).attr("ServiceStatus_id");
      // console.log(status);
  
      $.ajax({
        headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token },
        type:"post",
        url: route('adminsservices.UpdateadminServiceStatus'),
        data:{status:status,ServiceStatus_id:ServiceStatus_id},
        success:function(resp){
          // console.log(resp);
          if(resp.status==0){
            $("#ServiceStatus-"+ServiceStatus_id).html('<i title="Inactive" class="fs-4 fa-solid fa-toggle-off" status="Inactive"></i>');
          }else if(resp.status==1){
            $("#ServiceStatus-"+ServiceStatus_id).html('<i title="Active" class="fs-4 fa-solid fa-toggle-on" status="Active"></i>');

          }
        },error:function(){
          console.log('Error');
        }
      });
  
    });

    $(document).on('click','.updateHandymanStatusUnder', function(){
      var status = $(this).children("i").attr("status");
            var handyman_id = $(this).attr("handyman_id");
      // console.log(status);
  
      $.ajax({
        headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token },
        type:"post",
        url: route('handymen.updateHandymanStatus'),
        data:{status:status,handyman_id:handyman_id},
        success:function(resp){
          // console.log(resp);
          if(resp.status==0){
            $("#handyman-"+handyman_id).html('<i class="fs-4 fa-solid fa-toggle-off" status="Inactive"></i>');
          }else if(resp.status==1){
            $("#handyman-"+handyman_id).html('<i class="fs-4 fa-solid fa-toggle-on" status="Active"></i>');

          }
        },error:function(){
          console.log('Error');
        }
      });
  
    });
});