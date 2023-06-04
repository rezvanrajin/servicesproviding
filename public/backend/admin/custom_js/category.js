
$(function () {

  // ............ token ................ 
  var token = document.querySelector('meta[name="api-token"]').content;
  var editId = 0;

  // ........ image preview ...........
  $(".image").change(function () {
    let reader = new FileReader();
    reader.onload = (e) => {
      $(".photo_preview").attr('src', e.target.result);
    }
    reader.readAsDataURL(this.files[0]);
  });

  // ......... category list ........... 
  var table = $('#category').DataTable({
    processing: true,
    serverSide: true,
    "async": true,
    "crossDomain": true,
    ajax: {
      url: route('categories.index'),
      headers: { "Authorization": token },
    },
    'columns': [
      {
        'title': '#SL', data: 'id', class: "no-sort", width: '50px', render: function (data, row, type, col) {
          var pageInfo = table.page.info();
          return (col.row + 1) + pageInfo.start;
        }
      },
      {
        'title': 'Category Name', 'name': 'name', data: 'name', class: 'text-right w72', render: function (data, type, row, col) {
          let returnData = '';
          returnData += '<a href="" target="_blank">' + data + '</a>';
          return returnData;
        }
      },
      {
        'title': 'Parent', 'name': 'parent', "data": "parent", "width": "50px", "render": function (data, type, row, meta) {
          return ((data == null) ? 'Root' : data.name)
        }

      },
      {
        'title': 'Image', 'name': 'name', "data": "image",
        "render": function (data) {
          return '<img src="' + data + '" width="40px" height="40px">';
        }
      },
      {
        'title': 'Featured', data: 'id', class: 'text-right w72', render: function (data, type, row, col) {
          let returnData = '';
          returnData += (row.featured == 1 ? '<a href="javascript:void(0)" class="updateCategoryFeaturedStatus text-success"  id="categoryFeatured-'+row.id+'" categoryFeatured_id="'+row.id+'"><i title="Featured" class="fs-4 fa-solid fa-bookmark" featured="Featured"></i></a>&nbsp;' : '<a href="javascript:void(0)" class="updateCategoryFeaturedStatus text-success" id="categoryFeatured-'+row.id+'" categoryFeatured_id="'+row.id+'"><i title="Inactive" class="fs-4 fa-regular fa-bookmark" featured="NoFeatured"></i>&nbsp;');
          return returnData;
        }
      },
      {
        'title': 'Status', data: 'id', class: 'text-right w72', render: function (data, type, row, col) {
          let returnData = '';
          returnData += (row.status == 1 ? '<a href="javascript:void(0)" class="updateCategoryStatus text-success"  id="category-'+row.id+'" category_id="'+row.id+'"><i title="Active" class="fs-4 fa-solid fa-toggle-on" status="Active"></i></a> &nbsp;' : '<a href="javascript:void(0)" class="updateCategoryStatus text-success" id="category-'+row.id+'" category_id="'+row.id+'"><i title="Inactive" class="fs-4 fa-solid fa-toggle-off" status="Inactive"></i></a>&nbsp;');
          return returnData;
        }
      },
      {
        'title': 'Action', data: 'id', class: 'text-right w72', render: function (data, type, row, col) {
          let returnData = '';
          returnData += ' <a title="Edit" href="javascript:void(0);" data-id="' + data + '" class="text-primary text-center editCategory"><i class="fs-4 fa-solid fa-pen-to-square"></i></a> &nbsp;';
          returnData += ' <a title="Delete" href="javascript:void(0);" data-id="' + data + '" class="text-danger deleteCategory"><i class="fs-4 fa-solid fa-trash"></i></a>';

          return returnData;
        }
      },
    ],

    columnDefs: [{
      searchable: false,
      orderable: false,
      targets: [0, 2, 3, 4,5,6]
    }],
    responsive: true,
    autoWidth: false,
    serverSide: true,
    processing: true,


  });
  // .......... create ............... 
  $('.createNewCategory').on('click', function () {

    $('#createNewCategory').modal('show');
    $("#nameError").text('');
    $('#categoryForm').trigger("reset");
    $("#status").attr('checked', false);
    $("#featured").attr('checked', false);
    $(".imageShow").html(`<img class="photo_preview" src="/uploads/category/no-image.png" width="70" height="70">`);
  });
  // ............ edit ..........

  $('body').on('click', '.editCategory', function () {
    $("#edit_nameError").text('');
    var category_id = $(this).data('id');
    // console.log(category_id);
    var editCategory = route('categories.edit',{'category':category_id});
    $.ajax({
      headers: { "Authorization": token },
      type: "get",
      url: editCategory,
      success: function (data) {
        $('#updateCategory').modal('show');
        $('#category_id').val(data.id);
        editId = data.id;
        $("#edit_parent_id").val(data.parent_id);
        $('#name').val(data.name);
        $(".imageShow").html(`<img class='photo_preview' src="` + data.image + `" width='70' height='70'">`);
  
      },
      error: function (data) {
        console.log('Error:', data);
        $("#edit_nameError").text(responseJSON.name);
      }
    });

  });
  //  ........... add or update store ...........
  $('#add_category_btn').on('click', function (e) {
    e.preventDefault();
    $("#nameError").text('');
    $("#imageError").text('');
    var formData = new FormData($("#categoryForm")[0]);
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
      headers: { "Authorization": token },
      type: 'POST',
      url: route('categories.store'),
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: (data) => {
        //  console.log(data);
        Toast.fire({
          icon: 'success',
          title: 'Category Created successfully'
        })
        $('#categoryForm').trigger("reset");
        $('#createNewCategory').modal('hide');
        table.draw();
      },
      error: function (data) {
        console.log(data);
        $("#nameError").text(data.responseJSON.name);
      }
    });
  });


  $('#update_category_btn').on('click', function (e) {
    e.preventDefault();
    $("#edit_nameError").text('');
    var update = route('categories.update', {'category':editId})
    var formData = new FormData($("#updateCategoryForm")[0]);
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
      url: update,
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: (data) => {
        // console.log(data);
        Toast.fire({
          icon: 'success',
          title: 'Category Update successfully'
        })
        $('#updateCategoryForm').trigger("reset");
        $('#updateCategory').modal('hide');
        table.draw();
      },
      error: function (data) {
        console.log(data);
        $("#edit_nameError").text(data.responseJSON.name);
      }
    });
  });
  // ............. destroy ............... 
  $('body').on('click', '.deleteCategory', function () {

    var category_id = $(this).data("id");
    var destroyCategory = route('categories.destroy',{'category':category_id});
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
          headers: { "Authorization": token },
          type: "DELETE",
          url: destroyCategory,
          success: function (data) {
            Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'success',
              title: 'Category has been Deleted Successfully!',
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

  getCategory();
  function getCategory() {
    var subCategory = route('admin.category.getSubcategory');
    $.ajax({
      headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token },
      type: "get",
      dataType: 'json',
      processing: true,
      serverSide: true,
      async: true,
      crossDomain: true,
      url: subCategory,
      success: function (data) {
        $.each(data, function (index, val) {
          // console.log(index, val)
          $(".parent_id").append(`<option value="` + val.id + `">` + val.name + `</option>`);

        });

      }
    });
  }

  
    $(document).on('click','.updateCategoryStatus', function(){
      var status = $(this).children("i").attr("status");
			var category_id = $(this).attr("category_id");
      // console.log(status);
  
      $.ajax({
        headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token },
        type:"post",
        url: route('categories.updateCategoryStatus'),
        data:{status:status,category_id:category_id},
        success:function(resp){
          // console.log(resp);
          if(resp.status==0){
            $("#category-"+category_id).html('<i title="Inactive" class="fs-4 fa-solid fa-toggle-off" status="Inactive"></i>');
          }else if(resp.status==1){
            $("#category-"+category_id).html('<i title="Active" class="fs-4 fa-solid fa-toggle-on" status="Active"></i>');

          }
        },error:function(){
          console.log('Error');
        }
      });
  
    });

    $(document).on('click','.updateCategoryFeaturedStatus', function(){
      var featured = $(this).children("i").attr("featured");
			var categoryFeatured_id = $(this).attr("categoryFeatured_id");
      // console.log(status);
  
      $.ajax({
        headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token },
        type:"post",
        url: route('categories.updateCategoryFeaturedStatus'),
        data:{featured:featured,categoryFeatured_id:categoryFeatured_id},
        success:function(resp){
          // console.log(resp);
          if(resp.featured==0){
            $("#categoryFeatured-"+categoryFeatured_id).html('<i title="NoFeatured" class="fs-4 fa-regular fa-bookmark" featured="NoFeatured"></i>&nbsp;');
          }else if(resp.featured==1){
            $("#categoryFeatured-"+categoryFeatured_id).html('<i title="Featured" class="fs-4 fa-solid fa-bookmark" featured="Featured"></i>&nbsp;');

          }
        },error:function(){
          console.log('Error');
        }
      });
  
    });


});