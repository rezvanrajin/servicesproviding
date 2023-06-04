$(function () {
    // .......... token ..........

    var table = $('#allOrders').DataTable({
        processing: true,
        serverSide: true,
        "async": true,
        "crossDomain": true,
        ajax: {
          url :  route('usersbookings.index'),
        },
        'columns': [
        // {'title':'ID','name':'id','data':'id'},
        {
          'title': '#SL', data: 'id', class: "no-sort", width: '50px', render: function (data, row, type, col) {
            var pageInfo = table.page.info();
            return (col.row + 1) + pageInfo.start;
          }
      },
        
        {
          'title': 'Service Name', data: 'service.name',class: 'text-right w72', render: function (data, type, row, col) {
              let url = route('ServiceDetails','url').replace("url",row.id);
              let returnData = '';
                returnData += '<a href="'+url+'" target="_blank">'+data+'</a>';
              return returnData;
          }
      },
      {'title':'Image','name':'image',"data": "service.image" ,
      "render": function ( data) {
      return '<img src="'+data+'" width="40px" height="40px">';}
      },
        {
            'title': 'Status', data: 'status',class: 'text-right w72', render: function (data, type, row, col) {
                let returnData = '';
                  returnData += '<button type="button" class="btn btn-sm btn-success">'+data+'</button>';
                return returnData;
            }
        },
        {
          'title': 'Action', data: 'id',class: 'text-right w72', render: function (data, type, row, col) {
              let returnData = '';
                returnData += '<a title="Order Details" href="javascript:void(0);" data-id="'+data+'" class="viewBooking text-info text-center"><i class="fs-5 fa-solid fa-eye"></i></a> ';
                returnData += (row.status == "Assign" ? '<a title="download Pdf" href="'+route('buyer.orderInvoivePdf',data)+'" data-id="'+data+'" class="viewPDF btn btn-sm btn-success text-white text-center"><i class="fa-solid fa-file-pdf"></i></a>' : ' ');
                
              return returnData;
          }
      },
            
        
        
      ],
      columnDefs: [{
        searchable: false,
        orderable: false,
        targets: [0,1,2,3]
      }],
      responsive: true,
      autoWidth: false,
      serverSide: true,
      processing: true,
    });

//     $('body').on('click', '.viewPDF', function () {
//       var url_id = $(this).data("id");
//       console.log(url_id);
//       var urlPdf = route('buyer.orderInvoivePdf','url_id').replace("url_id",url_id);
//       $.ajax({
//         type: "get",
//         url: urlPdf,
//         success: function (data) {
//           console.log(data);
//       },
//       error: function (data) {
//           console.log('Error:', data);
//       }
// });

//     });

$('body').on('click', '.viewBooking', function () {
       
       var booking_id = $(this).data("id");
       var viewBooking = route('usersbookings.show',{'usersbooking':booking_id});
      //  var review_id = $(this).data("id");
      // var viewBooking = route('usersbookings.show',{'usersbooking':review_id});
  $.ajax({
      type: "get",
      url: viewBooking,
      success: function (data) {
       
      $('#oderInfo').html(
        `<table class="table table-bordered">
                  
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
                    <th width="30%">Status</th>
                    <td><span class="text-success">`+data.status+`</span></td>
                  </tr>
                  <tr>
                    <th width="30%">Booking Date</th>
                    <td>`+moment(data.date_time).format("MMM d YYYY")+`</td>
                  </tr>
                  
              </table>
            
              `
      ); 

        $('#OderDetails').modal('show'); 
      },
      error: function (data) {
          console.log('Error:', data);
      }
  });
});



});