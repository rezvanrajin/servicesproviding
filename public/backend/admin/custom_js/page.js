$(function () {
  // .......... token ............. 
  var token = document.querySelector('meta[name="api-token"]').content;
  var editId = 0;

  // ...... Pages list .......... 
  var pageList = route('pages.index');
  var table = $('#pages').DataTable({
    processing: true,
    serverSide: true,
    "async": true,
    "crossDomain": true,
    ajax: {
      headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token },
      url: pageList,
    },
    'columns': [
      {
        'title': '#SL', data: 'id', class: "no-sort", width: '50px', render: function (data, row, type, col) {
          var pageInfo = table.page.info();
          return (col.row + 1) + pageInfo.start;
        }
      },
      { 'title': 'Title', 'name': 'title', 'data': 'title' },



      {
        'title': 'Action', data: 'id', class: 'text-right w72', render: function (data, type, row, col) {
          let returnData = '';


          returnData += '<a title="Delete" href="javascript:void(0);" data-id="' + data + '" class="fs-5 text-center viewPages"><i class="fa-solid fa-eye"></i></a> &nbsp;';
          returnData += '<a title="Edit" href="javascript:void(0);" data-id="' + data + '" class="fs-5 text-primary text-center editPages"><i class="fa-solid fa-pen-to-square"></i></a> &nbsp;';
          returnData += '<a title="Delete" href="javascript:void(0);" data-id="' + data + '" class="fs-5 text-danger deletePages"><i class="fa-solid fa-trash"></i></a>';

          return returnData;
        }
      },

    ],
    columnDefs: [{
      searchable: false,
      orderable: false,
      targets: [0, 2]
    }],
    responsive: true,
    autoWidth: false,
    serverSide: true,
    processing: true,

  });


  // ............. create .............. 
  $('.createNewpages').on('click', function () {
    $('#createNewpages').modal('show');
    $('#saveBtn').val("create-Page");
    $('#page_id').val('');
    $('#pagesForm').trigger("reset");
    $('#modelHeading').html("Create New Page");
    $("#titleError").text('');
    $("#descriptionError").text('');
    $("#saveBtn").text('Create');

  });


  // .......... edit ...........
  $('body').on('click', '.editPages', function () {
    $("#editTitleError").text('');
    var page_id = $(this).data('id');
    var editPages = route('pages.edit', { 'page': page_id });
    $.ajax({
      headers: { "Authorization": token },
      type: "get",
      url: editPages,
      success: function (data) {
        $('#modelHeading').html("Edit Page");
        $('#UpdateNewpages').modal('show');
        $('#page_id').val(data.id);
        editId = data.id;
        $('#titlePage').val(data.title);
        $('#editDescriptionPage').val(data.description);

        // console.log(data.status);
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });

  });



  // ............ create or update store ......... 

  $('#saveBtn').on('click', function (e) {
    e.preventDefault();
    $(this).html('Sending..');
    var addEditStore = route('pages.store');
    var formData = new FormData($("#pagesForm")[0]);
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
    $.ajax({
      headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token },
      data: $('#pagesForm').serialize(),
      url: addEditStore,
      type: "POST",
      dataType: 'json',
      success: function (data) {
        Toast.fire({
          icon: 'success',
          title: 'Saved in successfully'
        })
        $('#pagesForm').trigger("reset");
        $('#createNewpages').modal('hide');
        table.draw();

      },
      error: function (data) {
        // console.log('Error:', data);
        $("#titleError").text(data.responseJSON.title);
        $("#descriptionError").text(data.responseJSON.description);
        $('#saveBtn').html('Save Changes');
      }
    });
  });


  // ........... update ........... 
  $('#UpdateBtn').on('click', function (e) {
    e.preventDefault();
    $("#editTitleError").text('');
    $("#editDescriptionError").text('');

    var storeCity = route('pages.update', {'page': editId });
    var formData = new FormData($("#updatePagesForm")[0]);
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
      url: storeCity,
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: (data) => {
        Toast.fire({
          icon: 'success',
          title: 'Pages Update in successfully'
        })
        //  console.log(data);
        $('#updatePagesForm').trigger("reset");
        $('#UpdateNewpages').modal('hide');
        table.draw();
      },
      error: function (data) {
        console.log(data);
        
      }
    });
  });


    // ........... destroy ...........
    $('body').on('click', '.deletePages', function () {
     
      var page_id = $(this).data("id");
      var pageDestroy = route('pages.destroy',{'page':page_id});
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
                 type: "DELETE",
                 url: pageDestroy,
                 headers: {"Authorization": token},
                 success: function (data) {
                   Swal.fire({
                       toast: true,
                       position: 'top-end',
                       icon: 'success',
                       title: 'Pages Delete Successfull!',
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

  $('body').on('click', '.viewPages', function () {
    var page_id = $(this).data("id");
    var viewpage = route('pages.show',{'page':page_id});
    $.ajax({
        headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token},
        type: "get",
        url: viewpage,
        success: function (data) {
         
        $('#pageInfo').html(
          `<table class="table table-bordered">
              <tr>
                <th width="30%">Title</th>
                <td>`+data.title+`</td>
              </tr>
              <tr>
                <th width="30%">Description</th>
                <td>`+data.description+`</td>
              </tr>
           
              
          </table>`
        ); 

          $('#pageDetails').modal('show'); 
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
});








})