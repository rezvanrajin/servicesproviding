$(function () {

    // ............ token ................ 
    var token = document.querySelector('meta[name="api-token"]').content;   
    // ............. get seo data ............... 
    getSEO();
  function getSEO(){
    $.ajax({
        headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
        type: "get",
        dataType: 'json',
        processing: true,
        serverSide: true,
        async: true,
        crossDomain: true,
        url: route('admin.getting.SEOget'),
        success: function(data) {
          
            // console.log(data)
            $('#meta_title').val(data.meta_title);
            $('#meta_keyword').val(data.meta_keyword);
            $('#meta_description').val(data.meta_description);
         
      }
    });
  }

//    ........... update ............... 

  $('#saveBtn').on('click',function(e) {
      e.preventDefault();
      
      var formData = new FormData($("#SEOForm")[0]);
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
        url: route('admin.getting.SEOUpdate'),
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