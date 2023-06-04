
$(function () {
    // ............ token ...........
    var token = document.querySelector('meta[name="api-token"]').content;   

    // ............ image preview ........... 
    $("#logo").change(function(){
      let reader = new FileReader();
      reader.onload = (e) =>{
        $("#logo_preview").attr('src', e.target.result);
      }
      reader.readAsDataURL(this.files[0]);
    });
    $("#favicon").change(function(){
      let reader = new FileReader();
      reader.onload = (e) =>{
        $("#favicon_preview").attr('src', e.target.result);
      }
      reader.readAsDataURL(this.files[0]);
    });
    $("#icon").change(function(){
      let reader = new FileReader();
      reader.onload = (e) =>{
        $("#icon_preview").attr('src', e.target.result);
      }
      reader.readAsDataURL(this.files[0]);
    });



//   .......... general setting .......... 
    generalSetting();
  function generalSetting(){
        
    $.ajax({
        headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
        type: "get",
        dataType: 'json',
        processing: true,
        serverSide: true,
        async: true,
        crossDomain: true,
        url: route('admin.getting-setting.edit'),
          success: function(data) {
            
              // console.log(data)
              $('#website_name').val(data.website_name);
              $('#contact_details').val(data.contact_details);
              $('#web_description').val(data.web_description);
              $('#copyright_info').val(data.copyright_info);
              $('#mobile').val(data.mobile);
              $('#service_location').val(data.service_location);
              $('#logo_Show').html(`<img id="logo_preview" src="`+data.logo+`" alt="" class="w-50 h-50" style="margin-top:28px">`);
              $('#favicon_Show').html(`<img id="favicon_preview" src="`+data.favicon+`" alt="" class="w-50 h-50" style="margin-top:28px">`);
              $('#icon_Show').html(`<img id="icon_preview" src="`+data.icon+`" alt="" class="w-50 h-50" style="margin-top:28px">`);
                  
        }
    });
  }

/*------------------------------------------
 update
 --------------------------------------------*/   
  $('#btnUpdate').on('click',function(e) {
        e.preventDefault();
       
        var formData = new FormData($("#generalSettingForm")[0]);
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
          url: route('admin.getting-setting.update'),
          data: formData,
          cache:false,
          contentType: false,
          processData: false,
          success: (data) => {
              Toast.fire({
                icon: 'success',
                title: 'Update in successfully'
              })
          //  console.log(data);
           
          },
          error: function(data){
            console.log(data);
          }
        });
  });

});