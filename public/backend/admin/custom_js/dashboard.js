


$(function(){
    
    
    // ............. token ............... 
    var token = document.querySelector('meta[name="api-token"]').content; 

    getDashboardasWidget();
    function getDashboardasWidget(){
    $.ajax({
        headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token},
        type: "get",
        dataType: 'json',
        processing: true,
        serverphSide: true,
        async: true,
        crossDomain: true,
        url: route('admin.dashboard.widget'),
        success: function(data) {
        $("#dashborad_id").html(`
        
        <div class="row g-3">
        <div class="col-6 col-md-4 col-lg-3">
          <div class="card h-100 hover-scale-up cursor-pointer">
            <div class="card-body d-flex flex-column align-items-center">
              <div class="sw-6 sh-6 rounded-xl d-flex justify-content-center align-items-center border border-primary mb-4">
                <i class="fa-solid fa-dollar-sign text-primary"></i>
              </div>
              <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">TOTAL EARNINGS</div>
              <div class="text-primary cta-4">$ 315</div>
            </div>
          </div>
        </div>

        <div class="col-6 col-md-4 col-lg-3">
          <div class="card h-100 hover-scale-up cursor-pointer">
          <a href="`+route('admin.providers')+`">
            <div class="card-body d-flex flex-column align-items-center">
              <div class="sw-6 sh-6 rounded-xl d-flex justify-content-center align-items-center border border-primary mb-4">
                <i class="fa-sharp fa-solid fa-user-plus text-primary"></i>
              </div>
              <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25"> TOTAL PROVIDERS</div>
              <div class="text-primary cta-4">`+data.total_provider+`</div>
            </div>
            </a>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="card h-100 hover-scale-up cursor-pointer">
          <a href="`+route('admin.categories')+`">
            <div class="card-body d-flex flex-column align-items-center">
              <div class="sw-6 sh-6 rounded-xl d-flex justify-content-center align-items-center border border-primary mb-4">
                <i class="fa-solid fa-briefcase text-primary"></i>
              </div>
              <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">TOTAL CATEGORIES</div>
              <div class="text-primary cta-4">`+data.total_Categories+`</div>
            </div>
          </a>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="card h-100 hover-scale-up cursor-pointer">
            <div class="card-body d-flex flex-column align-items-center">
              <div class="sw-6 sh-6 rounded-xl d-flex justify-content-center align-items-center border border-primary mb-4">
                <i class="fa-solid fa-gift text-primary"></i>
              </div>
              <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25"> TOTAL COUPONS</div>
              <div class="text-primary cta-4">`+data.total_Coupons+`</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="card h-100 hover-scale-up cursor-pointer">
          <a href="`+route('admin.providerTypes')+`">
            <div class="card-body d-flex flex-column align-items-center">
              <div class="sw-6 sh-6 rounded-xl d-flex justify-content-center align-items-center border border-primary mb-4">
                <i class="fa-sharp fa-solid fa-users text-primary"></i>
              </div>
              <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">TOTATL PROVIDER TYPES</div>
              <div class="text-primary cta-4">`+data.total_Provider_type+`</div>
            </div>
            </a>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="card h-100 hover-scale-up cursor-pointer">
          <a href="`+route('admin.cities')+`">
            <div class="card-body d-flex flex-column align-items-center">
              <div class="sw-6 sh-6 rounded-xl d-flex justify-content-center align-items-center border border-primary mb-4">
                <i class="fa-solid fa-city text-primary"></i>
              </div>
              <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">TOTAL CITIES</div>
              <div class="text-primary cta-4">`+data.total_city+`</div>
            </div>
            </a>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="card h-100 hover-scale-up cursor-pointer">
          <a href="`+route('admin.services')+`">
            <div class="card-body d-flex flex-column align-items-center">
              <div class="sw-6 sh-6 rounded-xl d-flex justify-content-center align-items-center border border-primary mb-4">
              <i class="fas fa-paper-plane text-primary" data-acorn-size="18"></i>
              </div>
              <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">TOTAL SERVICES</div>
              <div class="text-primary cta-4">`+data.total_service+`</div>
            </div>
            </a>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="card h-100 hover-scale-up cursor-pointer">
          <a href="`+route('admin.handymans')+`">
            <div class="card-body d-flex flex-column align-items-center">
              <div class="sw-6 sh-6 rounded-xl d-flex justify-content-center align-items-center border border-primary mb-4">
                <i class="fa-solid fa-users text-primary"></i>
              </div>
              <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">TOTAL HANDYMAN</div>
              <div class="text-primary cta-4">`+data.total_handyman+`</div>
            </div>
            </a>
          </div>
          </div>
         </div>
      </div>
        
        `);
      }
    });
  }

  recentBookings();
  function recentBookings(){
      $.ajax({
          headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
          type: "get",
          dataType: 'json',
          processing: true,
          serverSide: true,
          async: true,
          crossDomain: true,
          url: route('admin.recentBooking'),
          success: function(data) {
              var recentBooking ='';

              $.each(data, function(k, val) {
              //  let serviceUrl = route('ServiceDetails','url').replace("url",val.id);
              
              recentBooking += `
                  <div class="card mb-2 sh-15 sh-md-6">
                  <div class="card-body pt-0 pb-0 h-100">
                    <div class="row g-0 h-100 align-content-center">
                      <div class="col-10 col-md-4 d-flex align-items-center mb-3 mb-md-0 h-md-100">
                        <a href="#" class="body-link stretched-link">Order #`+val.id+`</a>
                      </div>
                      <div class="col-2 col-md-3 d-flex align-items-center text-muted mb-1 mb-md-0 justify-content-end justify-content-md-start">
                        <span class="badge bg-outline-primary me-1">`+val.status+`</span>
                      </div>
                      <div class="col-12 col-md-2 d-flex align-items-center mb-1 mb-md-0 text-alternate">
                        <span>
                          <span class="text-small">`+val.service.price_type+`</span>
                          `+val.price+`
                        </span>
                      </div>
                      <div class="col-12 col-md-3 d-flex align-items-center justify-content-md-end mb-1 mb-md-0 text-alternate">`+moment(val.created_at).format('ll')+`</div>
                    </div>
                  </div>
                </div>
    
                  `;
              });
      
              $("#recentBookingShow").html(recentBooking);
          }
      });
  }


  recentemail();
  function recentemail()
  {
    // console.log(mailbox_id);
    $.ajax({
      headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token },
      type: "get",
      url: route('mailboxs.index'),
      processing: true,
      serverSide: true,
      async: true,
      crossDomain: true,

      success: function (data) {
        var recentEmail = '';
          $.each(data, function(k, val) {
          //  let serviceUrl = route('ServiceDetails','url').replace("url",val.id);
          
          recentEmail += `
          <div class="card mb-2 sh-15 sh-md-6">
          <div class="card-body pt-0 pb-0 h-100">
                <div class="row g-0 h-100 align-content-center">
                 
                  <div data-id="`+val.id+`" class="viewMail col-12 col-md-3 d-flex align-items-center mb-1 mb-md-0 text-alternate">
                    <a href="javascript:void(0);" class="body-link"><span class="badge bg-outline-primary me-1"><i class="fa-solid fa-eye"></i> View</span></a>
                  </div>
                  <div data-id="`+val.id+`" class="sendMailView col-12 col-md-3 d-flex align-items-center mb-1 mb-md-0 text-alternate">
                    <a href="javascript:void(0);" class="body-link"><span class="badge bg-outline-info me-1"><i class="fa-solid fa-envelope"></i>Email</span></a>
                  </div>
                  <div data-id="`+val.id+`" class="deleteMail col-12 col-md-3 d-flex align-items-center mb-1 mb-md-0 text-alternate">
                    <a href="javascript:void(0);" class="body-link"><span class="badge bg-outline-danger me-1"><i class="fa-solid fa-trash"></i> Delete</span></a>
                  </div>
                  <div class="col-12 col-md-3 d-flex align-items-center justify-content-md-end mb-1 mb-md-0 text-alternate">`+moment(val.created_at).format('ll')+`</div>
                </div>
              </div>
              </div>
              `;
          });
  
          $("#EmailList").html(recentEmail);
      }
    
});

  }

  $(document).on("click",".viewMail",function(){
    var mailbox_id = $(this).data("id");
    // console.log(mailbox_id);
    var mailUrl = route('admin.UserMailView','mailbox_id').replace("mailbox_id",mailbox_id);
    $.ajax({
        headers: {"Authorization": token},
        type: "get",
        url: mailUrl,
        success: function (data) {
          console.log(data.mailbox);
      
          $("#Mailtable").html(`                
          <div class="row">
          <div class="col-md-12" id="user_id">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <td width="20%">Full Name</td>
                  <td colspan"2">`+data.mailbox.user.name+`</td>
                </tr>
                <tr>
                <td width="20%">Email</td>
                <td colspan"2">`+data.mailbox.email+`</td>
              </tr>
                <tr>
                <td width="20%">Subject</td>
                  <td colspan"2">`+data.mailbox.subject+`</td>
                </tr>
                <tr>
                <td width="20%">Message</td>
                  <td class="colspan"2"">`+data.mailbox.description+`</td>
                </tr>
              </thead>
            </table>
          </div>
      </div>
      
      
          `);
        
          $('#DashboardMailDetails').modal('show'); 
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });    
  });

  $(document).on("click",".sendMailView",function() {
       
    var replay_id = $(this).data("id");
    console.log(replay_id);
    var mailUrl = route('admin.replayMail','replay_id').replace("replay_id",replay_id);
    $.ajax({
      headers: {"Authorization": token},
      type: "get",
      url: mailUrl,
      success: function (data) {
        console.log(data);
    
        $("#DashSendMail").html(`                
          <div class="row">
            <div class="col-md-12">
              <form name="ReplayMailForm" id="ReplayMailForm">
              <div class="col-md-6">
                <input type="name" class="form-control" name="name" id="name" value="`+data.user.name+`"/><br/>
                </div>
                <div class="col-md-6">
                <input type="email" class="form-control" name="email" id="email" value="`+data.email+`"/><br/>
                </div>
                <div class="col-md-6">
                <input type="text" class="form-control" name="subject" id="subject" value="`+data.subject+`"/><br/>
                </div
                <div class="mb-3">
                  <textarea class="form-control" placeholder="write..." id="description" name="description" rows="9"></textarea>
                </div>
                  <button type="button" class="btn btn-primary" id="ReplayBtn">Reply</button>
              </form>
            </div>
          </div>
    `);
     
        $('#DashReplayModal').modal('show'); 
        // $("#subject").val(data.subject);

        $('#ReplayBtn').on('click',function(e) {
          e.preventDefault();
         
          var formData = new FormData($("#ReplayMailForm")[0]);
          
          $.ajax({
            headers: {"Authorization": token},
            type:'POST',
            url: route('admin.sendMailProvider'),
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: (data) => {
                
          //  console.log(data);
              $('#ReplayMailForm').trigger("reset");
              $('#replayModal').modal('hide');
        
              recentemail();
                  
              },
              error: function(data){
                  console.log(data);

              }
          });
      });

      },
      error: function (data) {
          console.log('Error:', data);
      }
  });

  });

         // ............... destroy ............ 
         $('body').on('click', '.deleteMail', function () {
     
          var mailbox_id = $(this).data("id");
          console.log(mailbox_id);
          var Deletemail = route('admin.MailDelete','mailbox_id').replace("mailbox_id",mailbox_id);
    
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
                        recentemail()
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
              }
            })
    
        });
  
 });
