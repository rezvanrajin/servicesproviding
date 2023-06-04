
$(function () {
  // ......... token .......... 
  var token = document.querySelector('meta[name="api-token"]').content; 
 
  //    .......... user list ............ 
  var table = $('#admin_users').DataTable({
      processing: true,
      serverSide: true,
      async: true,
      crossDomain: true,
      ajax:{
        headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
        url : route('user.admiindex'),
        type: 'get',
      }, 
      'columns': [
      {'title':'ID','name':'id','data':'id'},
      {'title':'Name','name':'name','data':'name'},
      {'title':'Email','name':'email','data':'email'},
      {'title': 'Mobile', 'name': 'mobile', data: "mobile", render: function (data, type, row, col) {
              if (data == null) {
                  return "---";
              } else {
                  return data;
              }
          }
      },
      {
          'title': 'Status', data: 'id',class: 'text-right w72', render: function (data, type, row, col) {
              let returnData = '';
                returnData += (row.status == 1 ? '<a href="javascript:void(0)" class="updateUserStatus text-success"  id="user-'+row.id+'" user_id="'+row.id+'"><i class="fs-4 fa-solid fa-toggle-on" status="Active"></i></a> &nbsp;' : '<a href="javascript:void(0)" class="updateUserStatus text-success" id="user-'+row.id+'" user_id="'+row.id+'"><i class="fs-4 fa-solid fa-toggle-off" status="Inactive"></i></a>&nbsp;');
              return returnData;
          }
      },
      {
        'title': 'Action', data: 'id',class: 'text-right w72', render: function (data, type, row, col) {
            let returnData = '';
              returnData += '<a title="view" data-id="'+data+'" class="text-info viewUser"><i class="fs-4 fa-solid fa-eye"></i></a> &nbsp;';
              returnData += ' <a title="Delete" data-id="'+data+'" class="text-danger deleteUser"><i class="fs-4 fa-solid fa-trash"></i></a>';
            return returnData;
        }
    },
          
      
      
    ],

    columnDefs: [{
      searchable: false,
      orderable: false,
      targets: [0, 4,5]
    }],
    responsive: true,
    autoWidth: false,
    serverSide: true,
    processing: true,
  });
  // ............ view user details ........ 
 
  $(document).on('click', '.viewUser', function () {
   
      var user_id = $(this).data("id");
      var viewUser = route('admin.user.details','user_id').replace("user_id",user_id);
      $.ajax({
          headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
          type: "get",
          url: viewUser,
          success: function (data) {
            
            $("#userInfo").html(`<table class="table table-bordered">
                <tr>
                  <th width="30%">Full Name</th>
                  <td>`+(data.name == null ? '--' : data.name)+`</td>
                </tr>
                <tr>
                  <th width="30%">Email</th>
                  <td>`+(data.email == null ? '--' : data.email)+`</td>
                </tr>
                <tr>
                  <th width="30%">Mobile</th>
                  <td>`+(data.mobile == null ? '--' : data.mobile)+`</td>
                </tr>
                <tr>
                  <th width="30%">Address</th>
                  <td>`+(data.address == null ? '--' : data.address)+`</td>
                </tr>
                <tr>
                  <th width="30%">City</th>
                  <td>`+(data.city == null ? '--' : data.city)+`</td>
                </tr>
                <tr>
                  <th width="30%">State</th>
                  <td>`+(data.state == null ? '--' : data.state)+`</td>
                </tr>
                <tr>
                  <th width="30%">Post Code</th>
                  <td>`+(data.post_code == null ? '--' : data.post_code)+`</td>
                </tr>
                <tr>
                  <th width="30%">Country</th>
                  <td>`+(data.country == null ? '--' : data.country)+`</td>
                </tr>
                <tr>
                  <th width="30%">Status</th>
                  <td>`+(data.status ? '<span class="text-success">Active</span>' : '<span class="text-danger">Inactive</span>')+`</td>
                </tr>
                <tr>
                  <th width="30%">Photo</th>
                  <td>`+(data.photo== null ? '<img src="/uploads/user/no-image.png" width="70" height="70"/>' : '<img src="`+data.photo+`" width="70" height="70"/>')+`</td>
                </tr>
            </table>`);
            $('#userDetails').modal('show'); 
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });
      
  });
  // ........ destroy ............ 
  $('body').on('click', '.deleteUser', function () {
   
   var user_id = $(this).data("id");
   var destroyUser = route('admin.user.destroy','user_id').replace("user_id",user_id);

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
                url: destroyUser,
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
  
  $(document).on('click','.updateUserStatus', function(){
    var status = $(this).children("i").attr("status");
    var user_id = $(this).attr("user_id");
    // console.log(status);

    $.ajax({
      headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token },
      type:"post",
      url: route('users.updateUserStatus'),
      data:{status:status,user_id:user_id},
      success:function(resp){
        // console.log(resp);
        if(resp.status==0){
          $("#user-"+user_id).html('<i class="fs-4 fa-solid fa-toggle-off" status="Inactive"></i>');
        }else if(resp.status==1){
          $("#user-"+user_id).html('<i class="fs-4 fa-solid fa-toggle-on" status="Active"></i>');

        }
      },error:function(){
        console.log('Error');
      }
    });

  });

      //    .......... user Inactive list ............ 
      var userInactiveList = route('admin.user.indexIactive');
      var table = $('#user_inactive').DataTable({
          processing: true,
          serverSide: true,
          "async": true,
          "crossDomain": true,
          ajax:{
            headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
            url : userInactiveList,
          }, 
          'columns': [
          {'title': '#SL', data: 'id', class: "no-sort", width: '50px', render: function (data, row, type, col) {
            var pageInfo = table.page.info();
            return (col.row + 1) + pageInfo.start;
          }},
          {'title':'Name','name':'name','data':'name'},
          {'title':'Email','name':'email','data':'email'},
          {'title': 'Mobile', name: 'mobile', data: "mobile", render: function (data, type, row, col) {
                  if (data == null) {
                      return "---";
                  } else {
                      return data;
                  }
              }
          },
          {
              'title': 'Status', data: 'id',class: 'text-right w72', render: function (data, type, row, col) {
                  let returnData = '';
                  returnData += (row.status == 1 ? '<a href="javascript:void(0)" class="updateUserStatus text-success"  id="user-'+row.id+'" user_id="'+row.id+'"><i class="fs-4 fa-solid fa-toggle-on" status="Active"></i></a> &nbsp;' : '<a href="javascript:void(0)" class="updateUserStatus text-success" id="user-'+row.id+'" user_id="'+row.id+'"><i class="fs-4 fa-solid fa-toggle-off" status="Inactive"></i></a>&nbsp;');
                  return returnData;
              }
          },
          {
            'title': 'Action', data: 'id',class: 'text-right w72', render: function (data, type, row, col) {
                let returnData = '';
                  returnData += '<a title="view" data-id="'+data+'" class="fs-4 text-info viewUserstatus"><i class="fa-solid fa-eye"></i></a> &nbsp;';
                  returnData += ' <a title="Delete" data-id="'+data+'" class="fs-4 text-danger deleteUser"><i class="fa-solid fa-trash"></i></a>';
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
      $(document).on('click', '.viewUserstatus', function () {
   
        var user_id = $(this).data("id");
        var viewUserstatus = route('admin.user.details','user_id').replace("user_id",user_id);
        $.ajax({
            headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
            type: "get",
            url: viewUserstatus,
            success: function (data) {
              
              $("#userInfostatus").html(`<table class="table table-bordered">
                  <tr>
                    <th width="30%">Full Name</th>
                    <td>`+(data.name == null ? '--' : data.name)+`</td>
                  </tr>
                  <tr>
                    <th width="30%">Email</th>
                    <td>`+(data.email == null ? '--' : data.email)+`</td>
                  </tr>
                  <tr>
                    <th width="30%">Mobile</th>
                    <td>`+(data.mobile == null ? '--' : data.mobile)+`</td>
                  </tr>
                  <tr>
                    <th width="30%">Address</th>
                    <td>`+(data.address == null ? '--' : data.address)+`</td>
                  </tr>
                  <tr>
                    <th width="30%">City</th>
                    <td>`+(data.city == null ? '--' : data.city)+`</td>
                  </tr>
                  <tr>
                    <th width="30%">State</th>
                    <td>`+(data.state == null ? '--' : data.state)+`</td>
                  </tr>
                  <tr>
                    <th width="30%">Post Code</th>
                    <td>`+(data.post_code == null ? '--' : data.post_code)+`</td>
                  </tr>
                  <tr>
                    <th width="30%">Country</th>
                    <td>`+(data.country == null ? '--' : data.country)+`</td>
                  </tr>
                  <tr>
                    <th width="30%">Status</th>
                    <td>`+(data.status ? '<span class="text-success">Active</span>' : '<span class="text-danger">Inactive</span>')+`</td>
                  </tr>
                  <tr>
                    <th width="30%">Photo</th>
                    <td>`+(data.photo== null ? '<img src="/uploads/user/no-image.png" width="70" height="70"/>' : '<img src="`+data.photo+`" width="70" height="70"/>')+`</td>
                  </tr>
              </table>`);
              $('#userDetails').modal('show'); 
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
        
    });


});