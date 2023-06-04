
$(function () {
  // ........... token ..............
  var token = document.querySelector('meta[name="api-token"]').content; 
  
  // ........... assign log .......... 
  var assignLog = route('assign_handymen.index');
  var table = $('#assignHandyman').DataTable({
      processing: true,
      serverSide: true,
      "async": true,
      "crossDomain": true,
      ajax:{
        headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token},
        url : assignLog,
      } ,
      'columns': [
      // {'title':'ID','name':'id','data':'id'},
      {
        'title': '#SL', data: 'id', class: "no-sort", width: '50px', render: function (data, row, type, col) {
          var pageInfo = table.page.info();
          return (col.row + 1) + pageInfo.start;
        }
      },
      {
        'title': 'Service Name','name':'service.name', data: 'service.name',class: 'text-right w72', render: function (data, type, row, col) {
            let url = route('ServiceDetails','url').replace("url",row.id);
            let returnData = '';
              returnData += '<a href="'+url+'" target="_blank">'+data+'</a>';
            return returnData;
        }
      },
      {'title':'Handyman','name':'handyman_id','data':'handyman.name'},
      {
          'title': 'Action', data: 'id',class: 'text-right w72', render: function (data, type, row, col) {
              let returnData = '';
                returnData += '<a title="Booking Details" href="javascript:void(0);" data-id="'+data+'" class="viewAssign btn btn-sm btn-info text-white text-center"><i class="fa-solid fa-eye"></i></a> ';
              
              return returnData;
          }
      },
          
      
      
    ],
    columnDefs: [{
      searchable: false,
      orderable: false,
      targets: [0,1, 2, 3]
    }],
    responsive: true,
    autoWidth: false,
    serverSide: true,
    processing: true,
  });

    /*------------------------------------------
  assign handyman details
  --------------------------------------------*/
  $('body').on('click', '.viewAssign', function () {
    var assign_id = $(this).data("id");
    var viewAssign = route('assign_handymen.show',{'assign_handyman':assign_id});
    $.ajax({
          headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token},
          type: "get",
          url: viewAssign,
          success: function (data) {
           
          $('#assignInfo').html(
            `<table class="table table-bordered">
                <tr>
                  <th width="30%" colspan="2"><h2>Booking ID.#`+data.booking.id+`</h2></th>
                </tr>
                <tr>
                  <th colspan="2" class="text-center">Service Information</th>
                </tr> 
                <tr>
                  <th width="30%">Service Name</th>
                  <td>`+data.service.name+`</td>
                </tr>
                <tr>
                  <th width="30%">Price</th>
                  <td>`+data.booking.price+` `+data.service.price_type+`</td>
                </tr>
                <tr>
                  <th width="30%">Date</th>
                  <td>`+moment(data.booking.date_time).format("MMM d YYYY")+`</td>
                </tr>
                <tr>
                  <tr>
                  <th colspan="2" class="text-center">Buyer Information</th>
                </tr>
                <tr>
                  <th width="30%">Buyer Name</th>
                  <td>`+data.user.name+`</td>
                </tr>
                <tr>
                  <th width="30%">Email</th>
                  <td>`+data.user.email+`</td>
                </tr>
                <tr>
                  <th width="30%">Mibile</th>
                  <td>`+data.user.mobile+`</td>
                </tr>
                <tr>
                  <th width="30%">Address</th>
                  <td>`+data.user.address+`</td>
                </tr>
                <tr>
                  <th width="30%">State</th>
                  <td>`+data.user.state+`</td>
                </tr>
                <tr>
                  <th width="30%">City</th>
                  <td>`+data.user.city+`</td>
                </tr>
                <tr>
                  <th colspan="2" class="text-center">Handyman Information</th>
                </tr>
                <tr>
                  <th width="30%">Handyman Name</th>
                  <td>`+data.handyman.name+`</td>
                </tr>
                <tr>
                  <th width="30%">Email</th>
                  <td>`+data.handyman.email+`</td>
                </tr>
                <tr>
                  <th width="30%">Mobile</th>
                  <td>`+data.handyman.mobile+`</td>
                </tr>
                <tr>
                  <th width="30%">Address</th>
                  <td>`+data.handyman.address+`</td>
                </tr>
                <tr>
                  <th width="30%">City</th>
                  <td>`+data.handyman.city+`</td>
                </tr>
            </table>
            `
            
          ); 

            $('#bookingDetails').modal('show'); 
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });
  });

});