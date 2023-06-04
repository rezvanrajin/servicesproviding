
$(function () {
  // .......... token ...........
  var token = document.querySelector('meta[name="api-token"]').content; 


  // ............ booking customer list............. 
 
  var table = $('#customerBookingList').DataTable({
      processing: true,
      serverSide: true,
      async: true,
      crossDomain: true,
      ajax: {
        headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token},
        url : route('provider.sellerUserList'),
      },
      'columns': [
      {'title':'ID','name':'id','data':'id'},
      {'title':'Customer Name','name':'user.name','data':'user.name'},
      {
        'title':'Phone','name':'user.phone',"data": "user.phone", "width": "50px", "render": function (data, type, row, meta) {
          return ((data == null) ? '--' : data)
      }
      },   
      {'title':'Email','name':'user.email','data':'user.email'},
      {
          'title':'Image','name':'user.image',"data": "user.image", "width": "50px", "render": function (data, type, row, meta) {
            return ((data == null) ? '--' : '<img src="'+data+'" width="40px" height="40px">')
        }
       },    
      {
          'title': 'Action', data: 'id',class: 'text-right w72', "render": function (data, type, row, col) {
              let returnData = '';
                

                returnData += '<a title="View Details" href="javascript:void(0);" data-id="'+data+'" class="customerdetails btn btn-sm btn-warning text-white text-center"><i class="fa-solid fa-eye"></i></a> ';
               return returnData;
          }
      },
          
      
      
    ]
  });

      //  ............ view booking ............ 
      $('body').on('click', '.customerdetails', function () {
        var booking_id = $(this).data("id");
        // console.log(booking_id);
        var customerDetail = route('provider.providerCustomerList','booking_id').replace("booking_id",booking_id);
        $.ajax({
            headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
              type: "get",
              url: customerDetail,
              success: function (data) {
                         $('#customerBookingLists').html(
                  `
                  <table class="table table-bordered">
                  <tr>
                      <th width="25%" colspan="3">Full Name</th>
                        <td>`+(data.user.name == null ? '--' : data.user.name)+`</td>
                      </tr>
                      <tr>
                      <th width="25%" colspan="3">Phone</th>
                        <td>`+(data.user.phone == null ? '--' : data.user.phone)+`</td>
                      </tr>
                      <tr>
                      <th width="25%" colspan="3" >User Email</th>
                        <td>`+(data.user.email == null ? '--' : data.user.email)+`</td>
                      </tr>
                      <tr>
                        <th width="25%" colspan="3">Adress</th>
                        <td>`+(data.user.address == null ? '--' : data.user.address)+`</td>
                      </tr>
                      <tr>
                      <tr>
                        <th width="25%" colspan="3">City</th>
                        <td>`+(data.user.city == null ? '--' : data.user.city)+`</td>
                      </tr>
                      <tr>
                      <th width="25%" colspan="3">Post Code</th>
                      <td>`+(data.user.post_code ==null ? '--' : data.user.post_code)+`</td>
                    </tr>
                    <tr>
                        <th width="25%" colspan="3">State</th>
                        <td>`+(data.user.state ==null ? '--' : data.user.state)+`</td>
                      </tr>
                      <tr>
                        <th width="25%" colspan="3">Country</th>
                        <td>`+(data.user.country == null ? '--' : data.user.country)+`</td>
                      </tr>
                      <tr>
                      <th width="25%" colspan="3">Price</th>
                      <td>`+(data.price == null ? '--' : data.price)+`</td>
                    </tr>
                    
                  <tr>
                      <th width="25%" colspan="3">Status</th>
                      <td><button type="button" class="btn btn-secondary btn-sm mb-1">`+(data.user.status ==null ? 'Inactive' : 'Active')+`</button></td>
                    </tr>
                      </table>
                     
                  `
                );
                $('#customerdetails').modal('show'); 
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
      });

});