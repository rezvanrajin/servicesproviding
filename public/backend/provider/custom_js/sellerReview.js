$(function () {
  // .......... token ..........
  var token = document.querySelector('meta[name="api-token"]').content;

  
  
  var table = $('#sellerReview').DataTable({
      processing: true,
      serverSide: true,
      "async": true,
      "crossDomain": true,
      ajax: {
        headers: { "Authorization": token},
        url : route('sellerReviews.index'),
      },
      'columns': [
        {
          'title': '#SL', data: 'id', class: "no-sort", width: '50px', render: function (data, row, type, col) {
            var pageInfo = table.page.info();
            return (col.row + 1) + pageInfo.start;
          }
        },

      {
        'title': 'Buyer Name', data: 'user.name',class: 'text-right w72', render: function (data, type, row, col) {
          
            let returnData = '';
              returnData += '<a href="#" target="_blank">'+data+'</a>';
            return returnData;
        }
    },
      {
        'title': 'Rating', data: 'rating',class: 'text-right w72', render: function (data, type, row, col) {
          
            let returnData = '';
              returnData += data+'*';
            return returnData;
        }
    },
    {'title':'Review','name':'review','data':'review'},
          
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

 


});