$(function () {

    // ............ token ................ 
    var token = document.querySelector('meta[name="api-token"]').content;   
    // ............. get system_setting data ............... 
    systemSetting();
  function systemSetting(){
    $.ajax({
        headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
        type: "get",
        dataType: 'json',
        processing: true,
        serverSide: true,
        async: true,
        crossDomain: true,
        url: route('admin.system-setting.edit'),
        success: function(data) {
          
            // console.log(data)
            $('#google_map_Api_Key').val(data.google_map_Api_Key);
            $('#server_key').val(data.server_key);
           
         
      }
    });
  }

//    ........... update ............... 

  $('#btnUpdate').on('click',function(e) {
      e.preventDefault();
      
      var formData = new FormData($("#systemSettingForm")[0]);
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
        url: route('admin.system-setting.update'),
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: (data) => {

            Toast.fire({
              icon: 'success',
              title: 'Update in successfully'
            })
         console.log(data);
         
        },
        error: function(data){
          console.log(data);
         
        }
      });
});


});