

$(function () {

  // ........... token ............ 
  var token = document.querySelector('meta[name="api-token"]').content;
  var editId = 0;


  // ...... header menu list .......... 

  menu();
  function menu() {
    $.ajax({
      headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token },
      type: "get",
      url: route('menus.index'),
      processing: true,
      serverSide: true,
      async: true,
      crossDomain: true,

      success: function (data) {
        var loopdata = '';

        $.each(data, function (k, val) {
          // console.log(val);
          loopdata += `<tr>`;
          loopdata += `<td>` + val.name + `</td>`;
          loopdata += `<td>` + val.parent_id + `</td>`;
         
          loopdata += `<td>`+(val.status ==1 ? '<a href="javascript:void(0)" class="updateMenuStatus text-success" id="menu-' + val.id +'" menu_id="' + val.id + '"><i class="fs-5 fa-solid fa-toggle-on" status="Active"></i></a>&nbsp;' : '<a href="javascript:void(0)" class="updateMenuStatus text-success" id="menu-' + val.id +'" menu_id="'+ val.id + '"><i class="fs-5 fa-solid fa-toggle-off" status="Inactive"></i></a>&nbsp;')+`<a title="Edit" href="javascript:void(0);" data-id="` + val.id + `" class="editMenu fs-5 text-primary text-center"><i class="fa-solid fa-pen-to-square"></i></a> &nbsp;<a title="Delete" href="javascript:void(0);" data-id="` + val.id+ `" class="fs-5 text-danger deleteMenu"><i class="fa-solid fa-trash"></i></a></td>`;

          loopdata += `</tr>`;
        });
        $("#Headermenu").html(loopdata);
        // console.log(data)


      }
    });
  }
  $("#UpdateMenuForm").css("display", "none");
  $("#headerMenuForm").css("display", "block");

  //     // ............. create .............. 

  $('#savebtn').on('click', function (e) {

    e.preventDefault();
    var storemenu = route('menus.store');
    var formData = new FormData($("#headerMenuForm")[0]);
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
      url: storemenu,
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: (data) => {
        Toast.fire({
          icon: 'success',
          title: 'Menu Create in successfully'
        })
        menu();
        // console.log(data);
        $('#headerMenuForm').trigger("reset");
      },
      error: function (data) {
        console.log(data);
        $("#nameError").text(data.responseJSON.errors.name);
        $(".urlError").text(data.responseJSON.errors.url);
        $(".edit_parent_idError").text(data.responseJSON.errors.parent_id);
        $(".serialError").text(data.responseJSON.errors.serial);
      }
    });
  });

  // .......... edit ...........
  $(document).on('click', '.editMenu', function () {
    var menu_id = $(this).data('id');
    $('.savebtn').text("Update");
    $("#headerMenuForm").css("display", "none");
    $("#UpdateMenuForm").css("display", "block");
    // console.log(menu_id);
    var editmenu = route('menus.edit', { 'menu': menu_id });
    $.ajax({
      headers: { "Authorization": token },
      type: "get",
      url: editmenu,
      success: function (data) {
        // editId = data.id;
        $('#name').val(data.name);
        $('#parent_id').val(data.parent_id);
        $('#url').val(data.url);
        $('#serial').val(data.serial);
        $('#menu_id').val(data.id);
        editId = data.id;

        // console.log(data.status);
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });

  });

  // ........... update ........... 
  $('#updatebtn').on('click', function (e) {
    e.preventDefault();
    $("#nameError").text('');
    $("#edit_parent_idError").text('');
    $("#urlError").text('');
    $("#serialError").text('');

    var updatemenu = route('menus.update', { 'menu': editId });
    var formData = new FormData($("#UpdateMenuForm")[0]);
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
      url: updatemenu,
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: (data) => {
        Toast.fire({
          icon: 'success',
          title: 'Menu Update in successfully'
        })
        menu();
        //  console.log(data);
        $("#headerMenuForm").css("display", "block");
        $("#UpdateMenuForm").css("display", "none");
      },
      error: function (data) {
        console.log(data);

      }
    });
  });

      // ........... destroy ...........
    $('body').on('click', '.deleteMenu', function () {
     
        var menu_id = $(this).data("id");
        var menuDestroy = route('menus.destroy',{'menu':menu_id});
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
                   url: menuDestroy,
                   headers: {"Authorization": token},
                   success: function (data) {
                     Swal.fire({
                         toast: true,
                         position: 'top-end',
                         icon: 'success',
                         title: 'Menu Delete Successfull!',
                         showConfirmButton: false,
                         timer: 1500
                       })
                    
               menu();
                     
                     },
                     error: function (data) {
                         console.log('Error:', data);
                    }
                });
            }
        })
   
    });

    $(document).on('click','.updateMenuStatus', function(){
      var status = $(this).children("i").attr("status");
			var menu_id = $(this).attr("menu_id");
      // console.log(status);
  
      $.ajax({
        headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token },
        type:"post",
        url: route('menus.updateMenuStatus'),
        data:{status:status,menu_id:menu_id},
        success:function(resp){
          // console.log(resp);
          if(resp.status==0){
            $("#menu-"+menu_id).html('<i class="fs-4 fa-solid fa-toggle-off" status="Inactive"></i>');
          }else if(resp.status==1){
            $("#menu-"+menu_id).html('<i class="fs-4 fa-solid fa-toggle-on" status="Active"></i>');

          }
        

        },error:function(){
          console.log('Error');
        }
      });
  
    });

    getSubmanu();
    function getSubmanu() {
      var getSubmanu = route('admin.menu.getsubmenu');
      $.ajax({
        headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token },
        type: "get",
        dataType: 'json',
        processing: true,
        serverSide: true,
        async: true,
        crossDomain: true,
        url: getSubmanu,
        success: function (data) {
          $.each(data, function (index, val) {
            // console.log(index, val)
            $(".parent_id").append(`<option value="` + val.id + `">` + val.name + `</option>`);
  
          });
  
        }
      });
    }


});