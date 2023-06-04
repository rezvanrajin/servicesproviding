$(function () {

  // ............. token ............... 
  var token = document.querySelector('meta[name="api-token"]').content; 
var editid =0;
  // ............ image preview ........... 

  $(".photo").change(function(){
    let reader = new FileReader();
    reader.onload = (e) =>{
      $(".photo_preview").attr('src', e.target.result);
    }
    reader.readAsDataURL(this.files[0]);
  });

 
    
  // ............ get handyman .......... 
  var table = $('#handyman').DataTable({
      processing: true,
      serverSide: true,
      "async": true,
      "crossDomain": true,
      ajax: {
        headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token},
        url : route('handymen.index'),
      } ,
      'columns': [
        {
          'title': '#SL', data: 'id', class: "no-sort", width: '50px', render: function (data, row, type, col) {
            var pageInfo = table.page.info();
            return (col.row + 1) + pageInfo.start;
          }
      },
      {'title':'Name','name':'name','data':'name'},
      {'title':'Mobile','name':'mobile','data':'mobile'},
      {'title':'Email','name':'email','data':'email'},
      
      {
        'title':'Status','name':'status',"data": "status", "width": "70px", "render": function (data, type, row, meta) {
          return  (data != 1 ? '<span class="text-danger">Inactive</span>' : '<span class="text-success">Active</span>') 
        }

      },
      {
          'title': 'Action', data: 'id',class: 'text-right w72', render: function (data, type, row, col) {
              let returnData = '';
              returnData += '<a title="Handyman Details" href="javascript:void(0);" data-id="'+data+'" class="viewhandyman text-info text-center"><i class="fs-5 fa-solid fa-eye"></i></a> &nbsp;&nbsp;';
                returnData += '<a title="Edit" href="javascript:void(0);" data-id="'+data+'" class="text-primary text-center editHandyman"><i class="fs-5 fa-solid fa-pen-to-square"></i></a> &nbsp;&nbsp;';
                returnData += '<a title="Delete" href="javascript:void(0);" data-id="'+data+'" class="text-danger text-center deleteHandyman"><i class="fs-5 fa-solid fa-trash"></i></a>';
              
              return returnData;
          }
      },
          
    ],
    columnDefs: [{
      searchable: false,
      orderable: false,
      targets: [0,4,5]
    }],
    responsive: true,
    autoWidth: false,
    serverSide: true,
    processing: true,
  });
    
  /*------------------------------------------
  Click to create handyman
  --------------------------------------------*/
  $('.createNewHandyman').on('click',function () {
      $('#handyman_id').val('');
      $('#createNewHandyman').modal('show');
      $(".imageShow").html(`<img class="photo_preview" src="/uploads/handyman/no-image.png" width="70" height="70">`);
      $("#nameError").text('');
      $("#emailError").text('');
      $("#mobileError").text('');
      $("#addressError").text('');
      $("#cityError").text('');
      $('#handymanForm').trigger("reset");      
      $("#status").attr('checked', false);
      $(".imageShow").html(`<img class="photo_preview" src="/uploads/handyman/no-image.png" width="70" height="70">`);

     
  });
  /*------------------------------------------
  Click to Edit handyman
  --------------------------------------------*/
  $('body').on('click', '.editHandyman', function () {
    $("#nameError").text('');
    $("#emailError").text('');
    $("#mobileError").text('');
    $("#addressError").text('');
    $("#cityError").text('');

      var handyman_id = $(this).data('id');
      var editHandyman = route('handymen.edit',{'handyman':handyman_id});
      // console.log(handyman_id);
      $.ajax({
          headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token},
          type: "get",
          url: editHandyman,
          success: function (data) {
            $('#updateHandyman').modal('show');
            $('#handyman_id').val(data.id);
            editid = data.id;
            $('#name').val(data.name);
            $('#email').val(data.email);
            $('#address').val(data.address);
            $('#mobile').val(data.mobile);
            $('#edit_city').val(data.city);
            $(".imageShow").html(`<img class='photo_preview' src="`+data.photo+`" width='70' height='70'">`);

          },
          error: function (data) {
              console.log('Error:', data);
              $("#edit_nameError").text(responseJSON.name);
              $("#emailError").text(data.responseJSON.email);
              $("#mobileError").text(data.responseJSON.mobile);
              $("#addressError").text(data.responseJSON.address);
              $("#cityError").text(data.responseJSON.city);
              $("#photoError").text(data.responseJSON.photo);
          }
      });
    
  });
    
  /*------------------------------------------
  Create or update
  --------------------------------------------*/


  $('#handymanBtn').on('click',function(e) {
      e.preventDefault();
      $("#nameError").text('');
      $("#emailError").text('');
      $("#mobileError").text('');
      $("#addressError").text('');
      $("#cityError").text('');
      $("#photoError").text('');

      var formData = new FormData($("#handymanForm")[0]);
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
        url: route('handymen.store'),
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: (data) => {
            Toast.fire({
              icon: 'success',
              title: 'Handyman Create successfully'
            })
        //  console.log(data);
            $('#handymanForm').trigger("reset");
            $('#createNewHandyman').modal('hide');
          table.draw();
        },
        error: function(data){
          //console.log(data);
            $("#edit_nameError").text(data.responseJSON.name);
            $("#emailError").text(data.responseJSON.email);
            $("#mobileError").text(data.responseJSON.mobile);
            $("#addressError").text(data.responseJSON.address);
            $("#cityError").text(data.responseJSON.city);
            $("#photoError").text(data.responseJSON.photo);
        }
      });
  });

  $('#updateHandymanBtn').on('click',function(e) {
    e.preventDefault();
    $("#nameError").text('');
    $("#emailError").text('');
    $("#mobileError").text('');
    $("#addressError").text('');
    $("#cityError").text('');
    $("#photoError").text('');
    var updateUrl = route('handymen.update',{'handyman':editid});

    var formData = new FormData($("#updateHandymanForm")[0]);
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
      url: updateUrl,
      data: formData,
      cache:false,
      contentType: false,
      processData: false,
      success: (data) => {
          Toast.fire({
            icon: 'success',
            title: 'Handyman Updated successfully'
          })
      //  console.log(data);
          $('#updateHandymanForm').trigger("reset");
          $('#updateHandyman').modal('hide');
        table.draw();
      },
      error: function(data){
        console.log(data);
          $("#nameError").text(data.responseJSON.name);
          $("#emailError").text(data.responseJSON.email);
          $("#mobileError").text(data.responseJSON.mobile);
          $("#addressError").text(data.responseJSON.address);
          $("#cityError").text(data.responseJSON.city);
          $("#photoError").text(data.responseJSON.photo);
      }
    });
});    /*------------------------------------------
  Delete handyman
  --------------------------------------------*/
  $('body').on('click', '.deleteHandyman', function () {
   
    var handyman_id = $(this).data("id");
    var destroyHandyman = route('handymen.destroy',{'handyman':handyman_id});

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
                headers: { "Authorization": token},
                type: "DELETE",
                url: destroyHandyman,
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
  getAllCity();
  function getAllCity(){
      var city = route('handyman.getAllCity');
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
  /*------------------------------------------
  Delete details
  --------------------------------------------*/
  $('body').on('click', '.viewhandyman', function () {
      var handyman_id = $(this).data("id");
      var viewhandyman = route('handymen.show',{'handyman':handyman_id});
      $.ajax({
          headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token},
          type: "get",
          url: viewhandyman,
          success: function (data) {
           
          $('#providerInfo').html(
            `<table class="table table-bordered">
                <tr>
                  <th width="30%">Full Name</th>
                  <td>`+data.name+`</td>
                </tr>
                <tr>
                  <th width="30%">Email</th>
                  <td>`+data.email+`</td>
                </tr>
                <tr>
                  <th width="30%">Mobile</th>
                  <td>(+)`+data.mobile+`</td>
                </tr>
                <tr>
                  <th width="30%">Address</th>
                  <td>`+data.address+`</td>
                </tr>
                <tr>
                  <th width="30%">City</th>
                  <td>`+data.city+`</td>
                </tr>
               
                <tr>
                  <th width="30%">Created At</th>
                  <td>`+moment(data.created_at).format("MMM d YYYY")+`</td>
                </tr>
                <tr>
                  <th width="30%">Photo</th>
                  <td><img src="`+data.photo+`" height="70" width="70"></td>
                </tr>
                
            </table>`
          ); 

            $('#handymanDetails').modal('show'); 
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });
  });

});