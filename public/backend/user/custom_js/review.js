$(function () {
    // .......... token ..........

    
    
    var table = $('#BuyerReview').DataTable({
        processing: true,
        serverSide: true,
        "async": true,
        "crossDomain": true,
        ajax: {
          url :  route('usersreviews.index'),
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
              let url = route('ServiceDetails','url').replace("url",row.service.id);
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
            'title': 'Action', data: 'id',class: 'text-right w72', render: function (data, type, row, col) {
                let returnData = '';
                  returnData += '<a title="Review Details" href="javascript:void(0);" data-id="'+data+'" class="text-info text-center viewReview"><i class="fs-5 fa-solid fa-eye"></i></a> &nbsp;';
                  returnData += '<a title="Delete" href="javascript:void(0);" data-id="'+data+'" class="text-danger text-center deleteReview"><i class="fs-5 fa-solid fa-trash"></i></a>';
                
                return returnData;
            }
        },
            
      ],
      columnDefs: [{
        searchable: false,
        orderable: false,
        targets: [0,1,2]
      }],
      responsive: true,
      autoWidth: false,
      serverSide: true,
      processing: true,
    });

    $("body").on("click", ".deleteReview", function () {
      var review_id = $(this).data("id");
      var deleteReviews = route('usersreviews.destroy',{'usersreview':review_id});
      
          

      Swal.fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
      }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
           
                  type: "DELETE",
                  url: deleteReviews,
                  success: function (data) {
                      Swal.fire(
                          "Deleted!",
                          "Your file has been deleted.",
                          "success"
                      );
                      table.draw();
                  },
                  error: function (data) {
                      console.log("Error:", data);
                  },
              });
          }
      });
  });

    $('body').on('click', '.viewReview', function () {
      var review_id = $(this).data("id");
      var viewReviews = route('usersreviews.show',{'usersreview':review_id});
      // var booking_id = $(this).data("id");
      // var viewBooking = route('usersbookings.show',{'usersbooking':booking_id});
      $.ajax({
          type: "get",
          url: viewReviews,
          success: function (data) {
           
          $('#reviewInfo').html(
            `<table class="table table-bordered">
                <tr>
                  <th colspan="2" class="text-center">Service Information</th>
                </tr>
                <tr>
                  <th width="30%">Service Name</th>
                  <td> <a herf="">`+data.service.name+`</td>
                </tr>
                <tr>
                  <th width="30%">Price</th>
                  <td>`+data.service.price+` `+data.service.price_type+`</td>
                </tr>
                <tr>
                  <th width="30%">Discount</th>
                  <td>`+data.service.discount+` `+data.service.price_type+`</td>
                </tr>
                <tr>
                  <th width="30%">Duration</th>
                  <td>`+data.service.duration+`</td>
                </tr>
                
            </table>
            <table class="table table-bordered">
                <tr>
                  <th colspan="2" class="text-center">Review Information</th>
                </tr>
                <tr>
                  <th width="30%">Rating</th>
                  <td>`+data.ratting+`*</td>
                </tr>
                <tr>
                  <th width="30%">Review</th>
                  <td>`+data.review+`</td>
                </tr>
                
            </table>
            `
          ); 

            $('#reviewDetails').modal('show'); 
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });
  });




});