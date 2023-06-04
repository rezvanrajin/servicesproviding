$(function () {
  /*------------------------------------------
   Pass Header Token
   --------------------------------------------*/ 
   var token = document.querySelector('meta[name="api-token"]').content; 
  
    
  /*------------------------------------------
  fatch review table
  --------------------------------------------*/
  var table = $('#review').DataTable({
      processing: true,
      serverSide: true,
      "async": true,
      "crossDomain": true,
      ajax: {
        headers: { "Authorization": token},
        url :  route('provider.review.index'),
      },
      'columns': [
      {'title':'ID','name':'id','data':'id'},
      {
        'title': 'Service Name', data: 'service.name',class: 'text-right w72', render: function (data, type, row, col) {
            let url = route('ServiceDetails','url').replace("url",row.id);
            let returnData = '';
              returnData += '<a href="'+url+'" target="_blank">'+data+'</a>';
            return returnData;
        }
    },
      {'title':'Rating','name':'ratting','data':'ratting'},
      {
          'title': 'Action', data: 'id',class: 'text-right w72', render: function (data, type, row, col) {
              let returnData = '';
                returnData += '<a title="Review Details" href="javascript:void(0);" data-id="'+data+'" class="viewReview btn btn-sm btn-info text-white text-center"><i class="fa-solid fa-eye"></i></a> ';
              
              return returnData;
          }
      },
          
      
      
    ]
  });


  /*------------------------------------------
  review details
  --------------------------------------------*/
  $('body').on('click', '.viewReview', function () {
      var review_id = $(this).data("id");
      var url = route('provider.review.details','review_id').replace("review_id",review_id);
      $.ajax({
          headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token},
          type: "get",
          url: url,
          success: function (data) {
           
          $('#reviewInfo').html(
            `<table class="table table-bordered">
                <tr>
                  <th colspan="2" class="text-center">Review Information</th>
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
                  <th width="30%">Duration</th>
                  <td>`+data.service.duration+`</td>
                </tr>
                <tr>
                <th width="30%">Rating</th>
                <td>`+data.ratting+`*</td>
              </tr>
              <tr>
                <th width="30%">Review</th>
                <td>`+data.review+`</td>
              </tr>
              <tr>
              <th width="30%">Buyer Name</th>
              <td>`+data.user.name+`</td>
            </tr>
            <tr>
              <th width="30%">Email</th>
              <td>`+data.user.email+`</td>
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