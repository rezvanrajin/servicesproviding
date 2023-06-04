$(function () {
    // .......... token ..........

    /*------------------------------------------
     Favorite Service
    --------------------------------------------*/

    var table = $("#favorite").DataTable({
        processing: true,
        serverSide: true,
        async: true,
        crossDomain: true,
        ajax: {
            url: route('favorites.index'),
        },
        columns: [
            // { title: "ID", name: "id", data: "id" },
            {
                'title': '#SL', data: 'id', class: "no-sort", width: '50px', render: function (data, row, type, col) {
                  var pageInfo = table.page.info();
                  return (col.row + 1) + pageInfo.start;
                }
            },
            {
                'title': 'Service Name', data: 'service.name', class: 'text-right w72', render: function (data, type, row, col) {
                    let url = route('ServiceDetails', 'url').replace("url", row.service.id);
                    let returnData = '';
                    returnData += '<a href="' + url + '" target="_blank">' + data + '</a>';
                    return returnData;
                }
            },
            {
                'title': 'Image', 'name': 'image', "data": "service.image",
                "render": function (data) {
                    return '<img src="' + data + '" width="40px" height="40px">';
                }
            },
            
              {
                'title': 'Action', data: 'id',class: 'text-right w72', render: function (data, type, row, col) {
                    let returnData = '';
                    
                    returnData += '<a title="Favorite Details" href="javascript:void(0);" data-id="'+data+'" class="viewFavorite text-info text-center"><i class="fs-5 fa-solid fa-eye"></i></a> &nbsp;';
                      returnData += '<a title="Delete" href="javascript:void(0);" data-id="'+data+'" class="text-danger text-center deleteFavorite"><i class="fs-5 fa-solid fa-trash"></i></a>';
                    
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

    /*------------------------------------------
    Delete Favorite 
    --------------------------------------------*/
    $("body").on("click", ".deleteFavorite", function () {
        var favorite_id = $(this).data("id");
        var destroyFavorite = route('favorites.destroy',{'favorite' : favorite_id});
            

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
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    type: "DELETE",
                    url: destroyFavorite,
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

    $('body').on('click', '.viewFavorite', function () {
       
        var favorite_id = $(this).data("id");
        var viewFavorites = route('favorites.show',{'favorite' : favorite_id});
      
   $.ajax({
       type: "get",
       url: viewFavorites,
       success: function (data) {
        
       $('#favoriteInfo').html(
         `<table class="table table-bordered">
                   
                   <tr>
                     <th width="30%" colspan="2" class="text-center"><img src="`+data.service.image+`" width="200px" height="120px"/></th>
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
                     <td>`+data.service.price+` `+data.service.price_type+`</td>
                   </tr>
                     
                   <tr>
                    <th width="30%">Status</th>
                    <td>`+(data.service.status ==1 ? '<spna class="text-success">Active</span>' : '<span class="text-danger">Inctive</span>')+`</td>
                  </tr>
                   <tr>
                   <th width="30%">Created At</th>
                   <td>`+moment(data.created_at).format("MMM d YYYY")+`</td>
                 </tr>
                   
               </table>
             
               `
       ); 
       $('#FavoriteDetails').modal('show'); 
       
       },
       error: function (data) {
           console.log('Error:', data);
       }
   });
 });
 
});
