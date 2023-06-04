

$(function () {
  // .......... token ...........
  var token = document.querySelector('meta[name="api-token"]').content; 
   
  // ............ booking list............. 
  var bookingList = route('providersbookings.index');
  var table = $('#booking').DataTable({
      processing: true,
      serverSide: true,
      "async": true,
      "crossDomain": true,
      ajax: {
        headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token},
        url : bookingList,
      },
      'columns': [
      {'title':'ID','name':'id','data':'id'},
      {
        'title': 'Service Name', data: 'service.name',class: 'text-right w72', render: function (data, type, row, col) {
          let url = route('ServiceDetails','url').replace("url",row.id);
            let returnData = '';
              returnData += '<a href="'+url+'" target="_blank">'+data+'</a>';
            return returnData;
        }
      },
      {'title':'Price','name':'price','data':'price'},
      {
        'title':'Assign','name':'handyman',"data": "handyman", "width": "50px", "render": function (data, type, row, meta) {
          return ((data == null) ? '--' : data.name)
      }

      },
      {'title':'Status','name':'status','data':'status', "render" : function(data, type, row, col){
        $Status = '';
          $Status = '<button type="button" class="btn btn-secondary btn-sm mb-1">'+data+'</button>'; 
        return $Status;
      }},
    
      {
          'title': 'Action', data: 'id',class: 'text-right w72', "render": function (data, type, row, col) {
              let returnData = '';
                
                returnData += '<a title="Booking Status" href="javascript:void(0);" data-id="'+data+'" class="bookingStatus btn btn-sm btn-success text-white text-center"><i class="fa-solid fa-circle-check"></i></a> ';

              
                returnData += (row.status == "Assign" || "Working" || "Complete" ? '<a title="PDF Download" href="'+route('provider.printPDFInvoice',data)+'" class="btn btn-sm btn-success text-white text-center"><i class="fas fa-file-download"></i></a> ' : ' ');
                

                returnData += '<a title="Assign" href="javascript:void(0);" data-id="'+data+'" id="AssignHandyman" class="AssignHandyman btn btn-sm btn-warning text-white text-center"><i class="fa-solid fa-circle-check"></i></a> ';
                returnData +=  '<a title="Booking Details" href="javascript:void(0);" data-id="'+data+'" class="viewBooking btn btn-sm btn-info text-white text-center"><i class="fa-solid fa-eye"></i></a> ';

                returnData += '<a title="Delete" data-id="'+data+'" class="btn btn-sm btn-danger text-white deleteBooking"><i class="fa-solid fa-trash"></i></a>';
              
              return returnData;
          }
      },
        
    ],
    columnDefs: [{
      searchable: false,
      orderable: false,
      targets: [0,1,2,3,4,5]
    }],
    responsive: true,
    autoWidth: false,
    serverSide: true,
    processing: true,
  });
 /*------------------------------------------
  Delete booking 
  --------------------------------------------*/
  $('body').on('click', '.deleteBooking', function () {
   
   var booking_id = $(this).data("id");
   var destroyBooking = route('providersbookings.destroy',{'providersbooking':booking_id});

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
                url: destroyBooking,
                success: function (data) {
                  Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )
                table.draw()
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
        }
      })

  });

/*------------------------------------------
  booking details
  --------------------------------------------*/
  $('body').on('click', '.viewBooking', function () {
    var booking_id = $(this).data("id");
    var viewBooking = route('providersbookings.show',{'providersbooking':booking_id});
    $.ajax({
          headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token},
          type: "get",
          url: viewBooking,
          success: function (data) {
           
          $('#bookingInfo').html(
            `<table class="table table-bordered">
                <tr>
                  <th width="30%" colspan="2" class="text-center">Booking Information</th>
                </tr>
                <tr>
                  <th width="30%" colspan="2" class="text-center"><img src="`+data.service.image+`" width="200px" height="120px"/></th>
                </tr>
                
                <tr>
                  <th width="30%">Category Name</th>
                  <td>`+data.category.name+`</td>
                </tr>
                <tr>
                  <th width="30%">Service Name</th>
                  <td>`+data.service.name+`</td>
                </tr>
                <tr>
                  <th width="30%">Service Details</th>
                  <td>`+data.service.description+`</td>
                </tr>
                <tr>
                  <th width="30%">Price</th>
                  <td>`+data.price+` `+data.service.price_type+`</td>
                </tr>
                <tr>
                  <th width="30%">Discount</th>
                  <td>`+data.service.discount+` `+data.service.price_type+`</td>
                </tr>
                <tr>
                  <th width="30%">Featured</th>
                  <td><span class="text-success">`+(data.service.featured ==1 ? 'Yes' : 'No')+`</span></td>
                </tr>
                <tr>
                  <th width="30%">Status</th>
                  <td><span class="text-success">`+data.status+`</span></td>
                </tr>
                <tr>
                  <th width="30%">Booking Date</th>
                  <td>`+moment(data.date_time).format("MMM d YYYY")+`</td>
                </tr>
                
            </table>
           
            <table class="table table-bordered">
                <tr>
                  <th width="30%" colspan="2" class="text-center">Buyer Information</th>
                </tr>
                <tr>
                  <th width="30%">Full Name</th>
                  <td>`+data.user.name+`</td>
                </tr>
                <tr>
                  <th width="30%">Email</th>
                  <td>`+data.user.email+`</td>
                </tr>
                
                <tr>
                  <th width="30%">Mobile</th>
                  <td>`+(data.user.mobile == null ? '--' : data.user.mobile)+`</td>
                </tr>
                <tr>
                  <th width="30%">Address</th>
                  <td>`+(data.user.address == null ? '--' : data.user.address)+`</td>
                </tr>
                <tr>
                  <th width="30%">State</th>
                  <td>`+(data.user.state == null ? '--' : data.user.state)+`</td>
                </tr>
                <tr>
                  <th width="30%">Post Code</th>
                  <td>`+(data.user.post_code ==null ? '--' : data.user.post_code)+`</td>
                </tr>
                <tr>
                  <th width="30%">City</th>
                  <td>`+(data.user.city == null ? '--' : data.user.city)+`</td>
                </tr>
                <tr>
                  <th width="30%">Country</th>
                  <td>`+(data.user.country ==null ? '--' : data.user.country)+`</td>
                </tr>
                
            </table>
            `+(data.handyman==null ? '' : ' <table class="table table-bordered"><tr><th width="30%" colspan="2" class="text-center">Handyman Information</th></tr><tr><th width="30%">Handyman Name</th><td>'+data.handyman.name+'</td></tr><tr><th width="30%">Email</th><td>'+data.handyman.email+'</td></tr><tr><th width="30%">Mobile</th><td>'+data.handyman.mobile+'</td></tr><tr><th width="30%">Address</th><td>'+data.handyman.address+'</td></tr><tr><th width="30%">City</th><td>'+data.handyman.city+'</td></tr></table>')+`
          
            `
            
          ); 

            $('#bookingDetails').modal('show'); 
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });
  });


  $(document).on('click', '.bookingStatus', function (e) {
    e.preventDefault();
    var status_id = $(this).data('id');
    var bookingStatus = route('providersbookings.bookingStatus',{'providersbooking':status_id});
    var bookingStatusSave = route('providersbookings.status',{'providersbooking':status_id});

    // console.log(handyman_id);
    $.ajax({
        headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token},
        type: "get",
        url: bookingStatus,
        success: function (data) {
          $('#bookingStatus').modal('show');
 
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });

    $(document).on('click','#statusBtn',function (e) {
      e.preventDefault();
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
        $.ajax({
          headers: {"Authorization": token},
          data: $('#bookingStatusForm').serialize(),
          url: bookingStatusSave,
          type: "POST",
          success: function (data) {
            // console.log(data);
            Toast.fire({
              icon: 'success',
              title: 'Status Update successfully!'
            })
            $('#bookingStatus').modal('hide');
            table.draw();
            
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });
    });

  });


   /*------------------------------------------
   patch handyman
   --------------------------------------------*/ 
  getHandymanAll();
  function getHandymanAll(){
    $.ajax({
      headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token},
      type: "get",
      dataType: 'json',
      processing: true,
      serverSide: true,
      async: true,
      crossDomain: true,
      url: route('providersbookings.getHandymanAll'),
      success: function(data) {
        $.each(data , function(index, val) { 
          // console.log(index, val)
          $("#handyman_id").append(`<option value="`+val.id+`">`+val.id+`-`+val.name+`</option>`);
         
        });
      }
    });
  }


    /*------------------------------------------
   edit assign handyman
   --------------------------------------------*/ 
  $('body').on('click', '.AssignHandyman', function () {
      var assign_id = $(this).data('id');
      var AssignHandyman = route('providersbookings.bookingAssignHandyman',{'providersbooking':assign_id});
      // console.log(handyman_id);
      $.ajax({
          headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token},
          type: "get",
          url: AssignHandyman,
          success: function (data) {
            $('#bookingAssign').modal('show');
            
            // console.log(data)
            
            $('#handyman_id').val(data.handyman_id);
            $('#booking_id').val(data.id);
            $('#service_id').val(data.service_id);
            $('#provider_id').val(data.provider_id);
            $('#user_id').val(data.user_id);
           
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });
    
  });


  $('#saveBtn').on('click',function (e) {
    e.preventDefault();
    $(this).html('Send..');
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
    var Store = route('providersbookings.handymanAssign');
    $.ajax({
      headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token},
      data: $('#assignHandymanForm').serialize(),
      url: Store,
      type: "POST",
      dataType: 'json',
      success: function (data) {
        Toast.fire({
            icon: 'success',
            title: 'Handyman Assign successfull!'
          })
        $('#bookingAssign').modal('hide');
       table.draw();
      },
      error: function (data) {
          console.log('Error:', data);
          // $('#saveBtn').html('Save Changes');
      }
  });
 });

 
});