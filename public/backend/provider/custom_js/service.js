var desEditor = null;
$(function () {
    ClassicEditor
    .create( document.querySelector('#description') )
    .then(function(editor){
      desEditor = editor;
      // console.log(desEditor);
    })
    .catch( error => {
        console.error( error );
    } );

    ClassicEditor
    .create( document.querySelector('#edit_description') )
    .then(function(editor){
      desEditor = editor;
      // console.log(desEditor);
    })
    .catch( error => {
        console.error( error );
    } );

    
    // .......... token .......... 
    var token = document.querySelector('meta[name="api-token"]').content; 
  var editid =0; 
    // .......... image preview .......
    $(".image").change(function(){
      let reader = new FileReader();
      reader.onload = (e) =>{
        $(".photo_preview").attr('src', e.target.result);
      }
      reader.readAsDataURL(this.files[0]);
    });

    // ........... get service ......... 
    var table = $('#service').DataTable({
        processing: true,
        serverSide: true,
        "async": true,
        "crossDomain": true,
        ajax: {
          headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token},
          url: route('services.index'),
        },
        'columns': [
          {
            'title': '#SL', data: 'id', class: "no-sort", width: '50px', render: function (data, row, type, col) {
              var pageInfo = table.page.info();
              return (col.row + 1) + pageInfo.start;
            }
        },
        {
          'title': 'Service Name','name':'name', data: 'name',class: 'text-right w72', render: function (data, type, row, col) {
              let url = route('ServiceDetails','url').replace("url",row.id);
              let returnData = '';
                returnData += '<a href="'+url+'" target="_blank">'+data+'</a>';
              return returnData;
          }
      },
      
        {'title':'Image','name':'name',"data": "image" ,
                "render": function ( data) {
                return '<img src="'+data+'" width="70px" height="50px">';}
        },
        {
          'title':'Status','name':'status',"data": "status", "width": "70px", "render": function (data, type, row, meta) {
            return  (data != 1 ? '<span class="text-danger">Inactive</span>' : '<span class="text-success">Active</span>') 
          }

        },
        {
          'title': 'Featured', data: 'id', class: 'text-right w72', render: function (data, type, row, col) {
            let returnData = '';
            returnData += (row.featured == 1 ? '<a href="javascript:void(0)" class="updateServiceFeaturedStatus text-success"  id="serviceFeatured-'+row.id+'" serviceFeatured_id="'+row.id+'"><i title="Featured" class="fs-4 fa-solid fa-bookmark" featured="Featured"></i></a>&nbsp;' : '<a href="javascript:void(0)" class="updateServiceFeaturedStatus text-success" id="serviceFeatured-'+row.id+'" serviceFeatured_id="'+row.id+'"><i title="Inactive" class="fs-4 fa-regular fa-bookmark" featured="NoFeatured"></i>&nbsp;');
            return returnData;
          }
        },
        {
            'title': 'Action', data: 'id',class: 'text-right w72', render: function (data, type, row, col) {
                let returnData = '';
                
                  returnData += '<a title="Service Details" href="javascript:void(0);" data-id="'+data+'" class="text-info text-center serviceDetails"><i class="fs-5 fa-solid fa-eye"></i></a> &nbsp;&nbsp;';
                  returnData += '<a title="Edit" href="javascript:void(0);" data-id="'+data+'" class="text-primary text-center editService"><i class="fs-5 fa-solid fa-pen-to-square"></i></a> &nbsp;&nbsp;';
                  returnData += '<a title="Delete" href="javascript:void(0);" data-id="'+data+'" class="text-danger text-center deleteService"><i class="fs-5 fa-solid fa-trash"></i></a>';
                
                return returnData;
            }
        },
      ],
      columnDefs: [{
        searchable: false,
        orderable: false,
        targets: [0, 2, 3,4]
      }],
      responsive: true,
      autoWidth: false,
      serverSide: true,
      processing: true,
    });

    // ............. create ........... 
    $('.createNewService').on('click',function () {
        $('#createNewService').modal('show');
        $(".imageShow").html(`<img class="photo_preview" src="/uploads/service/no-image.png" width="70" height="70">`);

        $("#nameError").text('');
        $("#category_idError").text('');
        $("#price_typeError").text('');
        $("#priceError").text('');
        $("#discountError").text('');
        $("#durationError").text('');
        $("#descriptionError").text('');
        $("#imageError").text('');
        $("#featuredError").text('');
        
    });    
    
    // .............. edit ............. 
    $('body').on('click', '.editService', function () {
      
        var service_id = $(this).data('id');
        var serviceEdit = route('services.edit',{'service':service_id});
        $.ajax({
            headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token},
            type: "get",
            url: serviceEdit,
            success: function (data) {
              $('#updateService').modal('show');
              $('#service_id').val(data.id);
              editid = data.id;
              $('#name').val(data.name);
              $('#edit_category_id').val(data.category_id);
              $('#price_type').val(data.price_type);
              $('#price').val(data.price);
              $('#discount').val(data.discount);
              $('#duration').val(data.duration);
              $('#edit_description').val(data.description);
              $(".imageShow").html(`<img class='photo_preview' src="`+data.image+`" width='70' height='70'">`);
              if(data.featured =='Yes'){
                $("#featured").attr('checked',true);
              }else{
                $("#featured").attr('checked', false);
              }
            },
            error: function (data) {
              
                console.log('Error:', data);
            }
        });
      
    });

    // ................ create or update store ........... 

    $('#serviceBtn').on('click',function(e) {
        e.preventDefault();

        var formData = new FormData($("#serviceForm")[0]);
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
        $('#description').val(desEditor.getData());
        $.ajax({
          headers: { "Authorization": token},
          type:'POST',
          url: route('services.store'),
          data: formData, 
          cache:false,
          contentType: false,
          processData: false,
          success: (data) => {
              Toast.fire({
                icon: 'success',
                title: 'Service Created successfully'
              })
           console.log(data);
              $('#serviceForm').trigger("reset");
              $('#createNewService').modal('hide');
            table.draw();
          },
          error: function(data){
            console.log(data);
             $("#nameError").text(data.responseJSON.name);
              $("#category_idError").text(data.responseJSON.category_id);
              $("#price_typeError").text(data.responseJSON.price_type);
              $("#priceError").text(data.responseJSON.price);
              $("#discountError").text(data.responseJSON.discount);
              $("#durationError").text(data.responseJSON.duration);
              $("#descriptionError").text(data.responseJSON.description);
              $("#imageError").text(data.responseJSON.image);
              $("#featuredError").text(data.responseJSON.featured);
          }
        });
    });



    $('#updateServiceBtn').on('click',function(e) {
      e.preventDefault();
      var updateUrl = route('services.update',{'service':editid});
      var formData = new FormData($("#UpdateServiceForm")[0]);
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
      $('#description').val(desEditor.getData());
      $.ajax({
        headers: { "Authorization": token},
        type:'POST',
        url: updateUrl,
        data: formData, 
        cache:false,
        contentType: false,
        processData: false,
        success: (data) => {
            Toast.fire({
              icon: 'success',
              title: 'Service Created successfully'
            })
         console.log(data);
            $('#UpdateServiceForm').trigger("reset");
            $('#updateService').modal('hide');
          table.draw();
        },
        error: function(data){
          console.log(data);
           $("#nameError").text(data.responseJSON.name);
            $("#category_idError").text(data.responseJSON.category_id);
            $("#price_typeError").text(data.responseJSON.price_type);
            $("#priceError").text(data.responseJSON.price);
            $("#discountError").text(data.responseJSON.discount);
            $("#durationError").text(data.responseJSON.duration);
            $("#descriptionError").text(data.responseJSON.description);
            $("#imageError").text(data.responseJSON.image);
            $("#featuredError").text(data.responseJSON.featured);
        }
      });
  });

//    ........... get category ............. 

    getAllCategory();
    function getAllCategory(){
        var getCategory = route('provider.service.getCategory');
      $.ajax({
          headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token},
          type: "get",
          dataType: 'json',
          processing: true,
          serverSide: true,
          async: true,
          crossDomain: true,
          url: getCategory,
          success: function(data) {
            $.each(data , function(index, val) { 
              // console.log(index, val)
              $("#category_id").append(`<option value="`+val.id+`">`+val.name+`</option>`);
              $("#edit_category_id").append(`<option value="`+val.id+`">`+val.name+`</option>`);
            });
            
        }
      });
    }
     
    // ........... destroy .............. 

    $('body').on('click', '.deleteService', function () {
     
     var service_id = $(this).data("id");
     var deleteUrl = route('services.destroy',{'service' : service_id});

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
                  headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token},
                  type: "DELETE",
                  url: deleteUrl,
                  success: function (data) {
                    Swal.fire({
                      toast: true,
                      position: 'top-end',
                      icon: 'success',
                      title: 'Category has been Deleted Successfully!',
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



    // ............. service details ...........
    $('body').on('click', '.serviceDetails', function () {
      var service_id = $(this).data("id");
      var serviceDetails = route('services.show',{'service':service_id});
      $.ajax({
            headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token},
            type: "get",
            url: serviceDetails,
            success: function (data) {
                // console.log(data.service.name);
                var loopdata ='';
                $.each(data.bookings, function(k, val) {
                  let serviceUrl = route('ServiceDetails','url').replace("url",val.id);
                  let categoryUrl = route('service.listing','url').replace("url",val.id);
                // console.log(val.status);
                loopdata += `<tr>`;
                  loopdata += `<td>`+val.id+`</td>`;
                      loopdata += `<td><a href="${categoryUrl}" target="_blanck"> `+val.category.name+`</td>`;
                      loopdata += `<td><a href="${serviceUrl}" target="_blanck"> `+val.service.name+` </a></td>`;
                      loopdata += `<td>`+val.price+` `+val.service.price_type+`</td>`;
                      loopdata += `<td><button type="button" class="btn btn-secondary btn-sm mb-1">`+val.status+`</button></td>`;
                    loopdata += `</tr>`;
                    });
                    $("#BookingId").html(loopdata);
                       //review
              var reviewdata ='';
              $.each(data.reviews, function(k, val) {
                // console.log(val.status);
              reviewdata += `<tr>`;
                  reviewdata += `<td>`+val.id+`</td>`;
                  reviewdata += `<td>`+val.user.name+`</td>`;
                  reviewdata += `<td>`+val.ratting+`</td>`;
                  reviewdata += `<td>`+val.review+`</td>`;
              reviewdata += `</tr>`;
              });
              $("#reviews").html(reviewdata);
                   
             
            $('#serviceInformation').html(
              `<table class="table table-bordered">
                  <tr>
                    <th colspan="2" class="text-center">Service Details</th>
                  </tr>
                  <tr>
                    <td colspan="2" class="text-center"><img src="`+data.service.image+`" width="300px" height="150px"></td>
                  </tr>
                  <tr>
                    <th width="30%">Category Name</th>
                    <td>`+data.service.category.name+`</td>
                  </tr>
                  <tr>
                    <th width="30%">Service Title</th>
                    <td>`+data.service.name+`</td>
                  </tr>
                  <tr>
                    <th width="30%">Price</th>
                    <td>`+data.service.price+` `+data.service.price_type+`</td>
                  </tr>
                  <tr>
                    <th width="30%">Discount</th>
                    <td>`+data.service.discount+` `+data.service.price_type+`</td>
                  </tr>
                  <tr>
                    <th width="30%">Duration</th>
                    <td>`+data.service.duration+` days</td>
                  </tr>
                  <tr>
                    <th width="30%">Description</th>
                    <td>`+(data.service.description==null ? '' : data.service.description)+`</td>
                  </tr>
                  <tr>
                    <th width="30%">Status</th>
                    <td>`+(data.service.status ==1 ? '<spna class="text-success">Active</span>' : '<span class="text-danger">Inctive</span>')+`</td>
                  </tr>
                  <tr>
                    <th width="30%">Featured</th>
                    <td>`+(data.service.featured ==1 ? '<span class="text-success">Yes</span>' : '<span class="text-info">No</span>')+`</td>
                  </tr>
                  <tr>
                    <th width="30%">Created At</th>
                    <td>`+moment(data.service.created_at).format("MMM d YYYY")+`</td>
                  </tr>
              </table>
              `
            ); 

            $("#serviceSummary").html(`
            <div class="row g-2">
              <div class="col-12 col-sm-6 col-lg-6">
                <div class="card sh-11 hover-scale-up cursor-pointer">
                  <div class="h-100 row g-0 card-body align-items-center py-3">
                    <div class="col-auto pe-3">
                      <div class="bg-gradient-light sh-5 sw-5 rounded-xl d-flex justify-content-center align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-navigate-diagonal text-white"><path d="M3.04983 7.55492L16.2848 2.46454C17.0935 2.15349 17.8882 2.94813 17.5771 3.75687L12.4868 16.9918C12.1327 17.9124 10.8008 17.8188 10.579 16.8577L9.89512 13.8942C9.4652 12.0312 8.01048 10.5765 6.14747 10.1465L3.18395 9.46265C2.22288 9.24087 2.12925 7.90899 3.04983 7.55492Z"></path></svg>
                      </div>
                    </div>
                    <div class="col">
                      <div class="row gx-2 d-flex align-content-center">
                        <div class="col-12 col-xl d-flex">
                          <div class="d-flex align-items-center lh-1-25">Total Booking</div>
                        </div>
                        <div class="col-12 col-xl-auto">
                          <div class="cta-2 text-primary">`+data.total_booking
                          +`</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12 col-sm-6 col-lg-6">
                <div class="card sh-11 hover-scale-up cursor-pointer">
                  <div class="h-100 row g-0 card-body align-items-center py-3">
                    <div class="col-auto pe-3">
                      <div class="bg-gradient-light sh-5 sw-5 rounded-xl d-flex justify-content-center align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-check text-white"><path d="M16 5L7.7051 14.2166C7.32183 14.6424 6.65982 14.6598 6.2547 14.2547L3 11"></path></svg>
                      </div>
                    </div>
                    <div class="col">
                      <div class="row gx-2 d-flex align-content-center">
                        <div class="col-12 col-xl d-flex">
                          <div class="d-flex align-items-center lh-1-25">Total Completed</div>
                        </div>
                        <div class="col-12 col-xl-auto">
                          <div class="cta-2 text-primary">35</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12 col-sm-6 col-lg-6">
                <div class="card sh-11 hover-scale-up cursor-pointer">
                  <div class="h-100 row g-0 card-body align-items-center py-3">
                    <div class="col-auto pe-3">
                      <div class="bg-gradient-light sh-5 sw-5 rounded-xl d-flex justify-content-center align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-alarm text-white"><circle cx="10" cy="10" r="7"></circle><path d="M16 2 18 4M4 2 2 4M7 17 6 18M13 17 14 18M8 12 9.70711 10.2929C9.89464 10.1054 10 9.851 10 9.58579V6"></path></svg>
                      </div>
                    </div>
                    <div class="col">
                      <div class="row gx-2 d-flex align-content-center">
                        <div class="col-12 col-xl d-flex">
                          <div class="d-flex align-items-center lh-1-25">Pending</div>
                        </div>
                        <div class="col-12 col-xl-auto">
                          <div class="cta-2 text-primary">14</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12 col-sm-6 col-lg-6">
                <div class="card sh-11 hover-scale-up cursor-pointer">
                  <div class="h-100 row g-0 card-body align-items-center py-3">
                    <div class="col-auto pe-3">
                      <div class="bg-gradient-light sh-5 sw-5 rounded-xl d-flex justify-content-center align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-sync-horizontal text-white"><path d="M3 5 16 5.00001C17.1046 5.00001 18 5.89544 18 7.00001V8M17 15 4.00001 15C2.89544 15 2.00001 14.1046 2.00001 13V12"></path><path d="M5 8 2 5 5 2M15 12 18 15 15 18"></path></svg>
                      </div>
                    </div>
                    <div class="col">
                      <div class="row gx-2 d-flex align-content-center">
                        <div class="col-12 col-xl d-flex">
                          <div class="d-flex align-items-center lh-1-25">Cancled</div>
                        </div>
                        <div class="col-12 col-xl-auto">
                          <div class="cta-2 text-primary">3</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12 col-sm-6 col-lg-6">
                <div class="card sh-11 hover-scale-up cursor-pointer">
                  <div class="h-100 row g-0 card-body align-items-center py-3">
                    <div class="col-auto pe-3">
                    
                      <div class="bg-gradient-light sh-5 sw-5 rounded-xl d-flex justify-content-center align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-sync-horizontal text-white"><path d="M3 5 16 5.00001C17.1046 5.00001 18 5.89544 18 7.00001V8M17 15 4.00001 15C2.89544 15 2.00001 14.1046 2.00001 13V12"></path><path d="M5 8 2 5 5 2M15 12 18 15 15 18"></path></svg>
                      </div>
                    </div>
                    <div class="col">
                      <div class="row gx-2 d-flex align-content-center">
                        <div class="col-12 col-xl d-flex">
                          <div class="d-flex align-items-center lh-1-25">Total Earning</div>
                        </div>
                        <div class="col-12 col-xl-auto">
                          <div class="cta-2 text-primary">3</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12 col-sm-6 col-lg-6">
                <div class="card sh-11 hover-scale-up cursor-pointer">
                  <div class="h-100 row g-0 card-body align-items-center py-3">
                    <div class="col-auto pe-3">
                    
                      <div class="bg-gradient-light sh-5 sw-5 rounded-xl d-flex justify-content-center align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-sync-horizontal text-white"><path d="M3 5 16 5.00001C17.1046 5.00001 18 5.89544 18 7.00001V8M17 15 4.00001 15C2.89544 15 2.00001 14.1046 2.00001 13V12"></path><path d="M5 8 2 5 5 2M15 12 18 15 15 18"></path></svg>
                      </div>
                    </div>
                    <div class="col">
                      <div class="row gx-2 d-flex align-content-center">
                        <div class="col-12 col-xl d-flex">
                          <div class="d-flex align-items-center lh-1-25">Total Earning</div>
                        </div>
                        <div class="col-12 col-xl-auto">
                          <div class="cta-2 text-primary">3</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

          </div>
            `);

              $('#serviceDetailsModal').modal('show'); 
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
        
    });

    $(document).on('click','.updateServiceFeaturedStatus', function(){
      var featured = $(this).children("i").attr("featured");
			var serviceFeatured_id = $(this).attr("serviceFeatured_id");
      // console.log(status);
  
      $.ajax({
        headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token },
        type:"post",
        url: route('services.updateServiceFeaturedStatus'),
        data:{featured:featured,serviceFeatured_id:serviceFeatured_id},
        success:function(resp){
          // console.log(resp);
          if(resp.featured==0){
            $("#serviceFeatured-"+serviceFeatured_id).html('<i title="NoFeatured" class="fs-4 fa-regular fa-bookmark" featured="NoFeatured"></i>&nbsp;');
          }else if(resp.featured==1){
            $("#serviceFeatured-"+serviceFeatured_id).html('<i title="Featured" class="fs-4 fa-solid fa-bookmark" featured="Featured"></i>&nbsp;');
          }
        },error:function(){
          console.log('Error');
        }
      });
  
    });

  });