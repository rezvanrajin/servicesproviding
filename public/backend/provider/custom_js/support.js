$(function () {

  // ........... token ............ 
  var token = document.querySelector('meta[name="api-token"]').content; 

    
      // mailbox list

      var mailboxList = route('sellersupport.index');
      var table = $('#Buyermail').DataTable({
         processing: true,
         serverSide: true,
         async: true,
         crossDomain: true,
         ajax: {
           headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
           url:mailboxList,
         },
         'columns': [
         

             {'title':'Email','name':'email','data':'email'},         
        {'title':'Subject','name':'subject','data':'subject'},
         {
             'title': 'Action', data: 'id',class: 'text-right w72', render: function (data, type, row, col) {
                 let returnData = '';
                 returnData += '<a title="View Mail" href="javascript:void(0);" data-id="'+data+'" class="btn btn-sm btn-success text-white text-center mailView"><i class="fa-solid fa-eye"></i></a> ';
                 returnData += '<a title="Delete" href="javascript:void(0);" data-id="'+data+'" class="btn btn-sm btn-danger text-white deleteMail"><i class="fa-solid fa-trash"></i></a>';
                 
                 return returnData;
             }
         },
      
       ]
     });

  getAllAdmin();
  function getAllAdmin(){
      var email = route('provider.adminData');
      $.ajax({
          headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
          type: "get",
          dataType: 'json',
          processing: true,
          serverSide: true,
          async: true,
          crossDomain: true,
          url: email,
          success: function(data) {
          $.each(data , function(index, val) { 
              console.log(index, val)
              $("#email").append(`<option value="`+val.email+`">`+val.email+`</option>`);
          });
          
      }
      });
  }




     $('#ReplayBtn').on('click',function(e) {
      e.preventDefault();

      var storebuyermail = route('sellersupport.store');
      var formData = new FormData($("#ReplayMailForm")[0]);
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
        url: storebuyermail,
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: (data) => {
              Toast.fire({
                  icon: 'success',
                  title: 'Mail Send Successfully'
              })
              
          //  console.log(data);
              $('#ReplayMailForm').trigger("reset");
              $('#Sendmail').modal('hide');
              table.draw();
          },
          error: function(data){
              console.log(data);
          }
      });
  });

   // ............... destroy ............ 
   $('body').on('click', '.deleteMail', function () {
   
    var mail_id = $(this).data("id");
    console.log(mail_id);
    var Deletemail = route('sellersupport.destroy',{'sellersupport':mail_id});

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
                url: Deletemail,
                success: function (data) {
                  Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Mail Delete Successfull!',
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


  $('body').on('click', '.mailView', function () {
     
    var mail_id = $(this).data("id");
    // console.log(mailbox_id);
    var mailUrl = route('sellersupport.show',{'sellersupport':mail_id});
    $.ajax({
        headers: {"Authorization": token},
        type: "get",
        url: mailUrl,
        success: function (data) {
          console.log(data.mailbox);
      
          $("#mailInfo").html(`                
          <div class="row">
          <div class="col-md-12" id="user_id">
            <table class="table table-bordered">
              <thead>
             
             
              
              <tr>
                <td width="20%">Email</td>
                <td colspan"2">`+data.email+`</td>
              </tr>
                <tr>
                <td width="20%">Subject</td>
                  <td colspan"2">`+data.subject+`</td>
                </tr>
                <tr>
                <td width="20%">Message</td>
                  <td class="colspan"2"">`+data.description+`</td>
                </tr>
              </thead>
            </table>
          </div>
      </div>
      
      
          `);
         
          
          $('#MailDetails').modal('show'); 
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });

   
});



  });