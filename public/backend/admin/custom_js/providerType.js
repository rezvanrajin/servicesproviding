$(function () {
   
  // ........... token ............ 
   var token = document.querySelector('meta[name="api-token"]').content; 
   var editId = 0;
  // ................ provider type list .......... 
  var providerTypeList =  route('providerTypes.index');
  var table = $('#providerType').DataTable({
      processing: true,
      serverSide: true,
      "async": true,
      "crossDomain": true,
      ajax: {
        headers: { "Authorization": token },
        url:providerTypeList,
      },
      'columns': [
      {
        'title': '#SL', data: 'id', class: "no-sort", width: '50px', render: function (data, row, type, col) {
          var pageInfo = table.page.info();
          return (col.row + 1) + pageInfo.start;
        }
      },
      {'title':'Provider Type','name':'provider_type','data':'provider_type'},
      {'title':'Comission Rate (%)','name':'comission_rate','data':'comission_rate'},
      {
          'title': 'Action', data: 'id',class: 'text-right w72', render: function (data, type, row, col) {
              let returnData = '';
              
              returnData += '<a title="Edit" href="javascript:void(0);" data-id="'+data+'" class="text-primary text-center editProviderType"><i class="fs-4 fa-solid fa-pen-to-square"></i></a> &nbsp;';
              returnData += '<a title="Delete" href="javascript:void(0);" data-id="'+data+'" class="text-danger deleteProviderType"><i class="fs-4 fa-solid fa-trash"></i></a>';
              
              return returnData;
          }
      },
   
    ],
    columnDefs: [{
      searchable: false,
      orderable: false,
      targets: [0, 3]
    }],
    responsive: true,
    autoWidth: false,
    serverSide: true,
    processing: true,
  });
    
  // ............. create .............. 
  $('.createNewProviderType').on('click',function () {
      $('#ajaxModel').modal('show');
      $('#productType_id').val('');
      $('#providerTypeForm').trigger("reset");
      $("#provider_typeError").text('');
      $("#comission_rateError").text('');
      
  });
// ............ edit ............... 

  $('body').on('click', '.editProviderType', function () {
      $("#provider_typeError").text('');
      $("#comission_rateError").text('');

    var providerType_id = $(this).data('id');
    var editProvideType = route('providerTypes.edit',{'providerType':providerType_id});
    // console.log(url);
    $.ajax({
          headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
          type: "get",
          url: editProvideType,
          success: function (data) {
            $('#updateProviderType').modal('show');
            editId = data.id;
           $("#productType_id").val(data.id);
            $('#edit_provider_type').val(data.provider_type);
            $('#comission_rate').val(data.comission_rate);
            
          },
          error: function (data) {
              console.log('Error:', data);
            
          }
      });
    
 });
    
  // ............ create or update store ......... 


  $('#createProviderTypeBtn').on('click',function(e) {
    e.preventDefault();

    var providerTypeUrl = route('providerTypes.store');
    var formData = new FormData($("#providerTypeForm")[0]);
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
      headers: {"Authorization": token},
      type:'POST',
      url: providerTypeUrl,
      data: formData,
      cache:false,
      contentType: false,
      processData: false,
      success: (data) => {
            Toast.fire({
                icon: 'success',
                title: 'Provider Type Create successfully'
            })
        //  console.log(data);
            $('#providerTypeForm').trigger("reset");
            $('#createNewProviderType').modal('hide');
            table.draw();
        },
        error: function(data){
            console.log(data);
            $("#provider_typeError").text(data.responseJSON.provider_type);
            $("#comission_rateError").text(data.responseJSON.comission_rate);
        }
    });
});

$('#updateProviderTypeBtn').on('click',function(e) {
e.preventDefault();
$("#edit_nameError").text('');
$("#edit_imageError").text('');

var storeCity = route('providerTypes.update', {'providerType':editId});
var formData = new FormData($("#updateProviderTypeForm")[0]);
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
  headers: {"Authorization": token},
  type:'POST',
  url: storeCity,
  data: formData,
  cache:false,
  contentType: false,
  processData: false,
  success: (data) => {
        Toast.fire({
            icon: 'success',
            title: 'Provider Type Update in successfully'
        })
     console.log(data);
      $('#updateProviderTypeForm').trigger("reset");
      $('#updateProviderType').modal('hide');
      table.draw();
    },
    error: function(data){
        console.log(data);
        $("#provider_typeError").text(data.responseJSON.provider_type);
        $("#comission_rateError").text(data.responseJSON.comission_rate);
    }
});
});

  // ............... destroy ............ 
  $('body').on('click', '.deleteProviderType', function () {
   
    var providerType_id = $(this).data("id");
    var deleteProviderType = route('providerTypes.destroy',{'providerType':providerType_id});

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
                url: deleteProviderType,
                success: function (data) {
                  Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Provider Type Delete Successfull!',
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

});