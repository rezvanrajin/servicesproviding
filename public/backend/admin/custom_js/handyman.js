
$(function () {
  //   ............. token .............. 
      var token = document.querySelector('meta[name="api-token"]').content;   
  //    ............. handyman list ............ 
      var handymanList = route('handymen.adminIndex');
      var table = $('#handyman').DataTable({
          processing: true,
          serverSide: true,
          "async": true,
          "crossDomain": true,
          ajax:{
            headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
            url : handymanList,
          }, 
          'columns': [
            {
              'title': '#SL', data: 'id', class: "no-sort", width: '50px', render: function (data, row, type, col) {
                var pageInfo = table.page.info();
                return (col.row + 1) + pageInfo.start;
              }
          },
          {'title':'Provider','name':'provider.name','data':'provider.name'},
          {'title':'Name','name':'name','data':'name'},
          {'title':'Mobile','name':'mobile','data':'mobile'},
          {
              'title': 'Status', data: 'id' ,class: 'text-right', render: function (data, type, row, col) {
                  let returnData = '';
                    returnData += (row.status == 1 ? '<a href="javascript:void(0)" class="updateHandymanStatus text-success"  id="handyman-'+row.id+'" handyman_id="'+row.id+'"><i class="fs-4 fa-solid fa-toggle-on" status="Active"></i></a> &nbsp;' : '<a href="javascript:void(0)" class="updateHandymanStatus text-success" id="handyman-'+row.id+'" handyman_id="'+row.id+'"><i class="fs-4 fa-solid fa-toggle-off" status="Inactive"></i></a>&nbsp;');
                  return returnData;
              }
          },
          {
            'title': 'Action', data: 'id' ,class: 'text-right', render: function (data, type, row, col) {
                let returnData = '';
                  returnData += '<a title="Handyman Details" href="javascript:void(0);" data-id="'+data+'" class="viewhandyman text-info text-center"><i class="fs-4 fa-solid fa-eye"></i></a> &nbsp;';
                  returnData += '<a title="Delete" data-id="'+data+'" class="text-danger deleteHandyman"><i class="fs-4 fa-solid fa-trash"></i></a>';
                return returnData;
            }
        },
              
        ],
        columnDefs: [{
          searchable: false,
          orderable: false,
          targets: [0,1,4,5]
        }],
        responsive: true,
        autoWidth: false,
        serverSide: true,
        processing: true,
      });
      // ............. destroy handyman ........ 
      $('body').on('click', '.deleteHandyman', function () {
       
       var handyman_id = $(this).data("id");
       var destroyHandyman = route('handyman.handymanDestroy',{'handyman':handyman_id});
  
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
                    url: destroyHandyman,
                    success: function (data) {
                      Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Handyman Deleted Successfull!',
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
  
      // ...........handyman view .......... 
      $(document).on('click', '.viewhandyman', function () {
        var handyman_id = $(this).data("id");
        var viewhandyman = route('handymen.handymanShow',{'handyman':handyman_id});
        $.ajax({
          headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
              type: "get",
              url: viewhandyman,
              success: function (data) {
               
              $('#handymanInfo').html(
                `<table class="table table-bordered">
                    <tr>
                      <th width="30%">Provider Name</th>
                      <td>`+(data.provider.name==null ? '--' : data.provider.name)+`</td>
                    </tr>
                    <tr>
                      <th width="30%">Provider Email</th>
                      <td>`+(data.provider.email==null ?  '--' : data.provider.email)+`</td>
                    </tr>
                    <tr>
                      <th width="30%">Email</th>
                      <td>`+(data.email==null ? '--' : data.email)+`</td>
                    </tr>
                    <tr>
                      <th width="30%">Mobile</th>
                      <td>(+)`+(data.mobile ==null ? '--' : data.mobile)+`</td>
                    </tr>
                    <tr>
                      <th width="30%">Address</th>
                      <td>`+(data.address==null ? '--' : data.address)+`</td>
                    </tr>
                    <tr>
                      <th width="30%">City</th>
                      <td>`+(data.city==null ? '--' : data.city)+`</td>
                    </tr>
                    <tr>
                      <th width="30%">Status</th>
                      <td>`+(data.status==1 ? '<span class="text-success">Active</span>' : '<span class="text-danger">Inactive</span>')+`</td>
                    </tr>
                    <tr>
                      <th width="30%">Created At</th>
                      <td>`+moment(data.created_at).add(10, 'days').calendar()+`</td>
                    </tr>
                    <tr>
                      <th width="30%">Photo</th>
                      <td><img src="`+(data.photo ? data.photo : '--')+`" height="70" width="70"></td>
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
  
      $(document).on('click','.updateHandymanStatus', function(){
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