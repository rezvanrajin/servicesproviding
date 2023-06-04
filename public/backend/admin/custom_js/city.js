$(function (){
  // ........ token .......... 
      var token = document.querySelector('meta[name="api-token"]').content; 
      var editId = 0;
  // .......... image preview ......... 
  $(".image").change(function () {
      let reader = new FileReader();
      reader.onload = (e) => {
        $(".photo_preview").attr('src', e.target.result);
      }
      reader.readAsDataURL(this.files[0]);
    });
  
  //   .......... city list ..........
      var cityList =  route('cities.index');
      var table = $('#city').DataTable({
          processing: true,
          serverSide: true,
          async: true,
          crossDomain: true,
          ajax: {
          url :cityList,
          headers: {"Authorization": token},
          },
          'columns': [
          {
          'title': '#SL', data: 'id', class: "no-sort", width: '50px', render: function (data, row, type, col) {
              var pageInfo = table.page.info();
              return (col.row + 1) + pageInfo.start;
          }
          },
          {'title':'City Name','name':'name','data':'name'},
          {'title':'City Map','name':'name',"data": "image" ,
              "render": function ( data) {
              return '<img src="'+data+'" width="40" height="40">';}
          },
          
          {
              'title': 'Status', data: 'id',class: 'text-right w72', render: function (data, type, row, col) {
                  let returnData = '';
                  returnData += (row.status == 1 ? '<a href="javascript:void(0)" class="updateCityStatus text-success"  id="city-'+row.id+'" city_id="'+row.id+'"><i title="Active" class="fs-4 fa-solid fa-toggle-on" status="Active"></i></a> &nbsp;' : '<a href="javascript:void(0)" class="updateCityStatus text-success" id="city-'+row.id+'" city_id="'+row.id+'"><i title="Inactive" class="fs-4 fa-solid fa-toggle-off" status="Inactive"></i></a>&nbsp;');
                  return returnData;
              }
          },
          {
            'title': 'Action', data: 'id',class: 'text-right w72', render: function (data, type, row, col) {
                let returnData = '';
                returnData += '<a title="Edit" href="javascript:void(0);" data-id="'+data+'" class="text-primary text-center editCity"><i class="fs-4 fa-solid fa-pen-to-square"></i></a> &nbsp;';
                returnData += '<a title="Delete" href="javascript:void(0);" data-id="'+data+'" class="text-danger deleteCity"><i class="fs-4 fa-solid fa-trash"></i></a>';
                
                return returnData;
            }
        },  
      ],
      columnDefs: [{
          searchable: false,
          orderable: false,
          targets: [0, 2, 3]
        }],
        responsive: true,
        autoWidth: false,
        serverSide: true,
        processing: true,
      });
  
      // ......... create .........
      $('.createNewCity').on('click',function () {
          $('#cityForm').trigger("reset");
          $('#createNewCity').modal('show');
          $("#nameError").text('');
          $(".imageShow").html(`<img class="photo_preview" src="/uploads/city/no-image.png" width="70" height="70">`);
          $("#status").attr('checked',false);
          $('#add_city_form').trigger("reset");
      });
  
      // .......... edit ...........
      $('body').on('click', '.editCity', function () {
          $("#edit_nameError").text('');
          var city_id = $(this).data('id');
          var editCity = route('cities.edit',{'city':city_id});
          $.ajax({
                headers: {"Authorization": token},
                type: "get",
                url: editCity,
                success: function (data) {
                  $('#modelHeading').html("Edit City");
                  $('#updateCity').modal('show');
                  $('#city_id').val(data.id);
                  editId = data.id;
                  $('#edit_name').val(data.name);
                  $(".imageShow").html(`<img class='photo_preview' src="`+data.image+`" width='70' height='70'">`);
                  
                  // console.log(data.status);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
          
       });
  
      //  ......... create or update store ..........
      $('#add_city_btn').on('click',function(e) {
          e.preventDefault();
  
          var storeCity = route('cities.store');
          var formData = new FormData($("#add_city_form")[0]);
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
            url: storeCity,
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: (data) => {
                  Toast.fire({
                      icon: 'success',
                      title: 'City Create in successfully'
                  })
              //  console.log(data);
                  $('#add_city_form').trigger("reset");
                  $('#createNewCity').modal('hide');
                  table.draw();
              },
              error: function(data){
                  console.log(data);
                  $("#nameError").text(data.responseJSON.errors.name);
                  $(".imageError").text(data.responseJSON.errors.image);
              }
          });
      });
  
      // ........... update ........... 
      $('#update_city_btn').on('click',function(e) {
          e.preventDefault();
          $("#edit_nameError").text('');
          $("#edit_imageError").text('');
  
          var storeCity = route('cities.update', {'city':editId});
          var formData = new FormData($("#update_city_form")[0]);
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
            url: storeCity,
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: (data) => {
                  Toast.fire({
                      icon: 'success',
                      title: 'City Update in successfully'
                  })
              //  console.log(data);
                  $('#update_city_form').trigger("reset");
                  $('#updateCity').modal('hide');
                  table.draw();
              },
              error: function(data){
                  console.log(data);
                  $("#edit_nameError").text(data.responseJSON.errors.name);
                  $("#edit_imageError").text(data.responseJSON.errors.image);
              }
          });
      });
  
      // ........... destroy ...........
      $('body').on('click', '.deleteCity', function () {
       
          var city_id = $(this).data("id");
          var cityDestroy = route('cities.destroy',{'city':city_id});
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
                     type: "DELETE",
                     url: cityDestroy,
                     headers: {"Authorization": token},
                     success: function (data) {
                       Swal.fire({
                           toast: true,
                           position: 'top-end',
                           icon: 'success',
                           title: 'City Delete Successfull!',
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
  
      $(document).on('click','.updateCityStatus', function(){
        var status = $(this).children("i").attr("status");
        var city_id = $(this).attr("city_id");
        // console.log(status);
    
        $.ajax({
          headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token },
          type:"post",
          url: route('cities.updateCityStatus'),
          data:{status:status,city_id:city_id},
          success:function(resp){
            // console.log(resp);
            if(resp.status==0){
              $("#city-"+city_id).html('<i title="Inactive" class="fs-4 fa-solid fa-toggle-off" status="Inactive"></i>');
            }else if(resp.status==1){
              $("#city-"+city_id).html('<i title="Active" class="fs-4 fa-solid fa-toggle-on" status="Active"></i>');
  
            }
          },error:function(){
            console.log('Error');
          }
        });
    
      });
  
  });
   
   
  
  
  
   
  
  