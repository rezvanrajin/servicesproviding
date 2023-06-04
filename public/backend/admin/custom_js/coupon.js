var desEditor = null;
$(function () {
    // .......... cke editor ......... 
    ClassicEditor
    .create( document.querySelector( '#description' ) )
    .then(function(editor){
      desEditor = editor;
      // console.log(desEditor);
    })
    .catch( error => {
        console.error( error );
    } );
    ClassicEditor
    .create( document.querySelector( '#edit_description' ) )
    .then(function(editor){
      desEditEditor = editor;
      // console.log(desEditor);
    })
    .catch( error => {
        console.error( error );
    } );

    $('#service_id').select2();
    $('#edit_service_id').select2();

    // ......... date picker ........ 
    $( "#start_date" ).datepicker();
    $( "#end_date" ).datepicker();
    $( "#Editstart_date" ).datepicker();
    $( "#Editend_date" ).datepicker();

    // ............ token ......... 
    var token = document.querySelector('meta[name="api-token"]').content; 
    var editId = 0;

    // ...........create......... 

    $('.createNewCoupon').on('click',function () {
        $("#coupon_codeError").text('');
        $("#service_idError").text('');
        $("#discount_typeError").text('');
        $("#discount_amountError").text('');
        $("#start_dateError").text('');
        $("#end_dateError").text('');
        $("#descriptionError").text('');
   
    });
    // .......... coupon list ........... 
    var couponList = route('coupons.index');
    var table = $('#coupons').DataTable({
        processing: true,
        serverSide: true,
        "async": true,
        "crossDomain": true,
        ajax: {
          headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
          url : couponList,
        },
        'columns': [
          {
            'title': '#SL', data: 'id', class: "no-sort", width: '50px', render: function (data, row, type, col) {
              var pageInfo = table.page.info();
              return (col.row + 1) + pageInfo.start;
            }
          },
        {'title':'Coupon Code','name':'coupon_code','data':'coupon_code'},
        {
          'title': 'Amount', 'name': 'discount_amount', data: 'discount_amount', class: 'text-right w72', render: function (data, type, row, col) {
       
            let returnData = '';
            returnData += data +' '+ row.discount_type;
            return returnData;
          }
        },
        {
          'title': 'Status', 'name': 'status', data: 'status', class: 'text-right w72', render: function (data, type, row, col) {
       
            let returnData = '';
            returnData += (data == 1 ? '<a href="javascript:void(0)" class="updateCouponStatus text-success"  id="coupon-'+row.id+'" coupon_id="'+row.id+'"><i title="Active" class="fs-4 fa-solid fa-toggle-on" status="Active"></i></a> &nbsp;' : '<a href="javascript:void(0)" class="updateCouponStatus text-success" id="coupon-'+row.id+'" coupon_id="'+row.id+'"><i title="Inactive" class="fs-4 fa-solid fa-toggle-off" status="Inactive"></i></a>&nbsp;');
            return returnData;
          }
        },
        {
            'title': 'Action', data: 'id',class: 'text-right w72', render: function (data, type, row, col) {
                let returnData = '';
                  returnData += '<a title="Coupon Details" href="javascript:void(0);" data-id="'+data+'" class="viewCoupon text-info text-center"><i class="fs-4 fa-solid fa-eye"></i></a>&nbsp;';
                  returnData += '<a title="Edit"  href="javascript:void(0);" data-id="'+data+'" class="text-primary text-center editCoupon"><i class="fs-4 fa-solid fa-pen-to-square"></i></a> &nbsp;';
                  returnData += '<a title="Delete"  href="javascript:void(0);" data-id="'+data+'" class="text-danger deleteCoupon"><i class="fs-4 fa-solid fa-trash"></i></a>';
                
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

// //   ............ edit ............ 

    $('body').on('click', '.editCoupon', function () {
      $("#Editcoupon_codeError").text('');

      var coupon_id = $(this).data('id');
      console.log(coupon_id);
      var couponEdit = route('coupons.edit',{'coupon':coupon_id});
      $.ajax({
            headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
            type: "get",
            url: couponEdit,
            success: function (data) {
              $('#coupon_id').val(data.id);
              editId = data.id;
              $('#coupon_code').val(data.coupon_code);
              $('#edit_service_id').val(data.service_id);
              $('#Editdiscount_type').val(data.discount_type);
              $('#Editdiscount_amount').val(data.discount_amount);
              $('#Editstart_date').val(data.start_date);
              $('#Editend_date').val(data.end_date);
              $('#edit_description').html(data.description);
              
              $('#UpdateNewCoupon').modal('show');
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
      
    });


   // ........... create ........... 
   $('#couponSaveBtn').on('click',function(e) {
    e.preventDefault();

    var formData = new FormData($("#couponForm")[0]);
    // var data = $("#description").val(desEditor.getData());   
    console.log(data);
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
  

    // console.log(ck);
    $.ajax({
      headers: {"Authorization": token},
      type:'POST',
      url: route('coupons.store'),
      data: formData,
      cache:false,
      contentType: false,
      processData: false,
      success: (data) => {
            Toast.fire({
                icon: 'success',
                title: 'Coupons create successfully'
            })
         console.log(data);
            $('#couponForm').trigger("reset");
            $('#createNewCoupon').modal('hide');
            table.draw();
        },
        error: function(data){
            console.log(data);
            // $("#coupon_codeError").text(data.responseJSON.coupon_code);
            // $("#service_idError").text(data.responseJSON.service_id);
            // $("#discount_typeError").text(data.responseJSON.discount_type);
            // $("#discount_amountError").text(data.responseJSON.discount_amount);
            // $("#start_dateError").text(data.responseJSON.start_date);
            // $("#end_dateError").text(data.responseJSON.end_date);
            // $("#descriptionError").text(data.responseJSON.description);
        }
    });
});
   // ........... update ........... 
   $('#update_coupon_btn').on('click',function(e) {
    e.preventDefault();
    var storeCity = route('coupons.update', {'coupon':editId});
    var formData = new FormData($("#update_coupons_from")[0]);
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
    $('#edit_description').val(desEditEditor.getData());
    $.ajax({
      headers: {"Authorization": token},
      type:'POST',
      url: storeCity,
      data: formData,
      cache:false,
      contentType: false,
      processData: false,
      success: (data) => {
            Toast.fire({
                icon: 'success',
                title: 'Coupons Update in successfully'
            })
        //  console.log(data);
            $('#update_coupons_from').trigger("reset");
            $('#UpdateNewCoupon').modal('hide');
            table.draw();
        },
        error: function(data){
            console.log(data);
            // $("#coupon_codeError").text(data.responseJSON.coupon_code);
            // $("#service_idError").text(data.responseJSON.service_id);
            // $("#discount_typeError").text(data.responseJSON.discount_type);
            // $("#discount_amountError").text(data.responseJSON.discount_amount);
            // $("#start_dateError").text(data.responseJSON.start_date);
            // $("#end_dateError").text(data.responseJSON.end_date);
            // $("#descriptionError").text(data.responseJSON.description);
        }
    });
});



  // .............. destroy coupon .............. 
    $('body').on('click', '.deleteCoupon', function () {
     
     var coupon_id = $(this).data("id");
     var destroyCoupon = route('coupons.destroy', {'coupon':coupon_id});

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
                  url: destroyCoupon,
                  success: function (data) {
                    Swal.fire({
                      toast: true,
                      position: 'top-end',
                      icon: 'success',
                      title: 'Coupon Delete Successfull!',
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
    //  ........... coupon destails ............. 
     $('body').on('click', '.viewCoupon', function () {
      var coupon_id = $(this).data("id");
      // console.log(coupon_id);
      var viewCoupon = route('coupons.show',{'coupon':coupon_id});
      $.ajax({
            headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
            type: "get",
            url: viewCoupon,
            success: function (data) {
             
            $("#couponInfo").html(
              `<table class="table table-bordered">
              
            <tr>
              <th width="30%">Service ID</th>
              <td>#`+(data.service_id == null ? '--' : data.service_id) +`</td>
            </tr>
            <tr>
              <th width="30%">Coupon Code</th>
              <td>`+(data.coupon_code == null ? '--' : data.coupon_code)+`</td>
            </tr>
            <tr>
              <th width="30%">Amount</th>
              <td>`+(data.discount_amount == null ? '--' : data.discount_amount)+` `+(data.discount_type == null ? '--' : data.discount_type)+`</td>
            </tr>
            <tr>
              <th width="30%">Start Date</th>
              <td>`+moment(data.start_date).add(10, 'days').calendar()+`</td>
            </tr>
            
            <tr>
              <th width="30%">End Date</th>
              <td>`+moment(data.end_date).add(10, 'days').calendar()+`</td>
            </tr>
            <tr>
              <th width="30%">Description</th>
              <td>`+(data.description == null ? '--' : data.description)+`</td>
            </tr>
            <tr>
            <th width="30%">Status</th>
            <td>`+(data.status == 0 ? '<span class="text-danger">Inactive</span>' : '<span class="text-success">Active</span>')+`</td>
          </tr>
              </table>`
            ); 

              $('#couponDetails').modal('show'); 
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    // ............ get service ............ 
    getService();
    function getService(){
      $.ajax({
          headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
          type: "get",
          dataType: 'json',
          processing: true,
          serverSide: true,
          async: true,
          crossDomain: true,
          url: route('coupons.getService'),
          success: function(data) {
            $.each(data , function(index, val) { 
              // console.log(index, val)
              $("#service_id").append(`<option value="`+val.id+`">`+val.id+`(`+val.name+`)</option>`);
              $("#edit_service_id").append(`<option value="`+val.id+`">`+val.id+`(`+val.name+`)</option>`);
            });
        }
      });
    }






    $(document).on('click','.updateCouponStatus', function(){
      var status = $(this).children("i").attr("status");
			var coupon_id = $(this).attr("coupon_id");
      // console.log(status);
  
      $.ajax({
        headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token },
        type:"post",
        url: route('coupons.updateCouponStatus'),
        data:{status:status,coupon_id:coupon_id},
        success:function(resp){
          // console.log(resp);
          if(resp.status==0){
            $("#coupon-"+coupon_id).html('<i title="Inactive" class="fs-4 fa-solid fa-toggle-off" status="Inactive"></i>');
          }else if(resp.status==1){
            $("#coupon-"+coupon_id).html('<i title="Active" class="fs-4 fa-solid fa-toggle-on" status="Active"></i>');

          }
        },error:function(){
          console.log('Error');
        }
      });
    });



});
