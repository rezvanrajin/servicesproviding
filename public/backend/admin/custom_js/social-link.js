
$(function (){
  // ........ token .......... 
      var token = document.querySelector('meta[name="api-token"]').content; 
      var editId = 0;

  
  //   .......... social link list ..........
      var social_links =  route('social_links.index');
      var table = $('#sociallink').DataTable({
          processing: true,
          serverSide: true,
          async: true,
          crossDomain: true,
          ajax: {
          url :social_links,
          headers: {"Authorization": token},
          },
          'columns': [
            {
              'title': '#SL', data: 'id', class: "no-sort", width: '50px', render: function (data, row, type, col) {
                var pageInfo = table.page.info();
                return (col.row + 1) + pageInfo.start;
              }
            },
          // {'title':'Icon','name':'icon','data':'icon'},
          {'title':'Link','name':'link',"data": "link"},
          {
            'title': 'Icon', data: 'icon',class: 'text-right w72', render: function (data, type, row, col) {
                let returnData = '';
                
                returnData += `<i class="`+data+`"></i>`;
               
                
                return returnData;
            }
        },
          {
              'title': 'Action', data: 'id',class: 'text-right w72', render: function (data, type, row, col) {
                  let returnData = '';
                  
                  returnData += '<a title="Edit" href="javascript:void(0);" data-id="'+data+'" class="btn btn-sm btn-primary text-white text-center editSocialLink"><i class="fa-solid fa-pen-to-square"></i></a> ';
                  returnData += '<a title="Delete" href="javascript:void(0);" data-id="'+data+'" class="btn btn-sm btn-danger text-white deleteSocialLink"><i class="fa-solid fa-trash"></i></a>';
                  
                  return returnData;
              }
          },
              
      ],
      
      columnDefs: [{
        searchable: false,
        orderable: false,
        targets: [0, 3]
      }],
      responsive: true,
      autoWidth: false,
      serverSide: true,
      processing: true,
    });

    $("#UpdateSocialLinkForm").css("display", "none");
    $("#add_sociallink_form").css("display", "block");
  

  
      //  ......... create or update store ..........
      $('#add_sociallink_btn').on('click',function(e) {
        e.preventDefault();  
        var storelink = route('social_links.store');
        var formData = new FormData($("#add_sociallink_form")[0]);
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
          url: storelink,
          data: formData,
          cache:false,
          contentType: false,
          processData: false,
          success: (data) => {
                Toast.fire({
                    icon: 'success',
                    title: 'Saved in successfully'
                })
            //  console.log(data);
              //   $("#icon").`<i class="`+data+`">data.icon</i>`);
                $('#add_sociallink_form').trigger("reset");
                table.draw();
            },
            error: function(data){
                console.log(data);
           
            }
        });
    });

      // .......... edit ...........
  $(document).on('click', '.editSocialLink', function () {
        var sociallink_id = $(this).data('id');
          $('.add_sociallink_btn').text("Update");
          $("#add_sociallink_form").css("display", "none");
          $("#UpdateSocialLinkForm").css("display", "block");
          console.log(sociallink_id);
        var editLink = route('social_links.edit', { 'social_link': sociallink_id });
          $.ajax({
                headers: {"Authorization": token},
                type: "get",
                url: editLink,
                success: function (data) {
                  $('#icon').val(data.icon);
                  $('#link').val(data.link);
                  $('#sociallink_id').val(data.id);
                  editId = data.id;
                 console.log(data.icon);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
          
       });

  // ........... update ........... 
  $('#update_socaillink_btn').on('click', function (e) {
    e.preventDefault();
    $("#icon_Error").text('');
    $("#link_Error").text('');

    var storelink = route('social_links.update', {'social_link':editId});
    var formData = new FormData($("#UpdateSocialLinkForm")[0]);
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
      headers: { "Authorization": token },
      type: 'POST',
      url: storelink,
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: (data) => {
        Toast.fire({
          icon: 'success',
          title: 'Links Update in successfully'
        })
        //  console.log(data);
        $("#add_sociallink_form").css("display", "block");
        $("#UpdateSocialLinkForm").css("display", "none");
        table.draw();
      },
      error: function (data) {
        console.log(data);
        
      }
    });
  });
  
      // ........... destroy ...........
      $('body').on('click', '.deleteSocialLink', function () {
       
        var socal_id = $(this).data("id");
        var destroy = route('social_links.destroy', {'social_link':socal_id});
        // console.log(linkDestroy);
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
                    headers: {"Authorization": token},
                     type: "DELETE",
                     url: destroy,
                     success: function (data) {
                       Swal.fire({
                           toast: true,
                           position: 'top-end',
                           icon: 'success',
                           title: 'Link Delete Successfull!',
                           showConfirmButton: false,
                           timer: 1500
                         })
                      
                       table.draw();
                       },
                       error: function (data) {
                           console.log('Error:', data);
                      }
                  });
              }
          })
     
      });
  
  });
   
    