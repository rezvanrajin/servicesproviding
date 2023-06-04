 // ........... token ................. 

 $("#Rsubmit").on('click',function(e){
     e.preventDefault();
     var formData = new FormData($("#contactUSfrom")[0]);
    $.ajax({
         headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
         type:'POST',
         url: route('user.sendMail'),
         data: formData, 
         cache:false,
         contentType: false,
         processData: false,
         success: (data) => {
            //  Toast.fire({
            //      icon: 'success',
            //      title: 'Email Send in successfully'
            //  })
         //  console.log(data);
          $('#contactUSfrom').trigger("reset");
          table.draw();
         },
         error: function(data){
             console.log(data);
             $('#Rsubmit').html('Send..');
         }
     });
 });
