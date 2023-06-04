
$(function () {

  // ............ token ...........
  var token = document.querySelector('meta[name="api-token"]').content;   
  $(".logo").change(function () {
    let reader = new FileReader();
    reader.onload = (e) => {
      $(".photo_preview").attr('src', e.target.result);
    }
    reader.readAsDataURL(this.files[0]);
  });

//   .......... footerSetting .......... 
  footerSetting();
function footerSetting(){
      var urlData=route('admin.footer-setting.edit');
  $.ajax({
      headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
      type: "get",
      url: urlData,
      processing: true,
      serverSide: true,
      async: true,
      crossDomain: true,
      
        success: function(data) {
          
            // console.log(data)
            // $('#logo').val(data.logo);
            $(".imageShow").html(`<img class='photo_preview' src="` + data.logo + `" width='70' height='70'">`);
            $('#contact_detaile').val(data.contact_detaile);
            $('#email').val(data.email);
            $('#location').val(data.location);
            $('#description').val(data.description);       
      }
  });
}

/*------------------------------------------
update
--------------------------------------------*/   
$('#btnUpdate').on('click',function(e) {
      e.preventDefault();
     
      var formData = new FormData($("#footer_settingForm")[0]);
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
      console.log(formData);
      $.ajax({
        headers: {"Authorization": token},
        type:'POST',
        url: route('admin.footer-setting.update'),
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