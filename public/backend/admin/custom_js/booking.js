function printDivSection(invoiceInfo) {
  var Contents_Section = document.getElementById(invoiceInfo).innerHTML;
  var originalContents = document.body.innerHTML;

  document.body.innerHTML = Contents_Section;

  window.print();

  document.body.innerHTML = originalContents;
}

  $(function () {

    // ........... token ............. 
    var token = document.querySelector('meta[name="api-token"]').content; 

    // ......... booking list .............
    var bookingList = route('adminbookings.adminIndex');
    var table = $('#bookings').DataTable({
        processing: true,
        serverSide: true,
        "async": true,
        "crossDomain": true,
        ajax:{
          headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
          url : bookingList,
        }, 
        'columns': [
        {'title': '#SL', data: 'id', class: "no-sort", width: '50px', render: function (data, row, type, col) {
          var pageInfo = table.page.info();
          return (col.row + 1) + pageInfo.start;
        }
      },
        {
          'title': 'Service Name', 'name':'service.name', data: 'service.name',class: 'text-right w72', render: function (data, type, row, col) {
              let url = route('ServiceDetails','url').replace("url",row.id);
              let returnData = '';
                returnData += '<a href="'+url+'" target="_blank">'+data+'</a>';
              return returnData;
          }
        },
        {
          'title':'Assign','name':'handyman',"data": "handyman", "width": "50px", "render": function (data, type, row, meta) {
            return ((data == null) ? '--' : data.name)
        }
  
        },
        {'title':'Image','name':'name',"data": "service.image" ,
                "render": function ( data) {
                return '<img src="'+data+'" width="40px" height="40px">';}
        },
        {'title':'Status','name':'status','data':'status', "render" : function(data, type, row, col){
          $Status = '';
            $Status = '<small class="btn btn-secondary btn-sm mb-1">'+data+'</small>'; 
          return $Status;
        }},
        {
            'title': 'Action', data: 'id',class: 'text-right w72', render: function (data, type, row, col) {
                let returnData = '';
                  returnData += (row.status == "Assign" || row.status == "Working" || row.status == "Complete" ? '<a title="Invoice" href="javascript:void(0);" data-id="'+data+'" class="bookingInvoice text-success text-center"><i class="fs-4 fa-solid fa-file-invoice"></i></a> ' : '');
                  returnData +=(row.status == "Assign" || row.status == "Working" || row.status == "Complete" ? '<a title="download Pdf" href="'+route('admin.orderInvoivePdf',data)+'" data-id="'+data+'" class="text-info text-center"><i class="fs-4 fas fa-file-download"></i></a> ' : '');
                  returnData += '<a title="Show Details" href="javascript:void(0);" data-id="'+data+'" class="viewBooking text-info text-center"><i class="fs-4 fa-solid fa-eye"></i></a> &nbsp;';
                  returnData += '<a title="Delete" data-id="'+data+'" class="text-danger deleteBooking"><i class="fs-4 fa-solid fa-trash"></i></a>';
                
                return returnData;
            }
        },
            ],

            columnDefs: [{
              searchable: false,
              orderable: false,
              targets: [0, 2, 3, 4, 5]
            }],
            responsive: true,
            autoWidth: false,
            serverSide: true,
            processing: true,
    });
    // ............ delete booking .......... 

    $('body').on('click', '.deleteBooking', function () {
     
     var booking_id = $(this).data("id");
     var destroyBooking = route('adminbookings.admindestroy',{'booking':booking_id});

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
                  url: destroyBooking,
                  success: function (data) {
                    Swal.fire({
                      toast: true,
                      position: 'top-end',
                      icon: 'success',
                      title: 'Booking Delete Successfull!',
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

    //  ............ view booking ............ 
    $('body').on('click', '.viewBooking', function () {
      var booking_id = $(this).data("id");
      var viewBooking = route('adminbookings.adminShow',{'booking':booking_id});
      $.ajax({
          headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
            type: "get",
            url: viewBooking,
            success: function (data) {
              $('#bookingInfo').html(
                `
                <table class="table table-bordered">
                    
                    <tr>
                      <th width="30%" colspan="2" class="text-center"><img src="`+(data.service.image == null ? '--' : data.service.image)+`" width="200px" height="120px"/></th>
                    </tr>
                    <tr>
                      <th width="30%">Category Name</th>
                      <td>`+(data.category.name == null ? '--' : data.category.name)+`</td>
                    </tr>
                    <tr>
                      <th width="30%">Service Name</th>
                      <td>`+(data.service.name == null ? '--' : data.service.name)+`</td>
                    </tr>
                    <tr>
                      <th width="30%">Service Detsils</th>
                      <td>`+(data.service.description == null ? '--' : data.service.description)+`</td>
                    </tr>
                    <tr>
                      <th width="30%">Booking Date</th>
                      <td>`+new Date(data.date_time).toString().substring(0,15)+`</td>
                    </tr>
                    <tr>
                      <th width="30%">Price</th>
                      <td>`+(data ? data.price : '--')+` `+(data.service ? data.service.price_type :'--')+`</td>
                    </tr>
                    <tr>
                      <th width="30%">Discount</th>
                      <td>`+(data.service ? data.service.discount : '--')+`</td>
                    </tr>
                    <tr>
                      <th width="30%">Status</th>
                      <td><span class="text-info">`+(data.status)+`</span></td>
                    </tr>
                    </table>
                    <table class="table table-bordered">
                        <tr>
                          <th width="30%" colspan="2" class="text-center">Seller Information</th>
                        </tr>
                        <tr>
                          <th width="30%">Full Name</th>
                          <td>`+(data.user == null ? '--' : data.user.name)+`</td>
                        </tr>
                        <tr>
                          <th width="30%">Email</th>
                          <td>`+(data.user.email == null ? '--' : data.user.email)+`</td>
                        </tr>
                        <tr>
                        <th width="30%">Mobile</th>
                          <td>`+(data.user.mobile == null ? '--' : data.user.mobile)+`</td>
                        </tr>
                    <tr>
                      <th width="30%">Address</th>
                      <td>`+(data.user.address == null ? '--' : data.user.address)+`</td>
                    </tr>
                    <tr>
                      <th width="30%">State</th>
                      <td>`+(data.user.state == null ? '--' : data.user.state)+`</td>
                    </tr>
                 
                      <th width="30%">City</th>
                      <td>`+(data.user.city == null ? '--' : data.user.city)+`</td>
                    </tr>
                    <tr>
                      <th width="30%">Country</th>
                      <td>`+(data.user.country == null ? '--' : data.user.country)+`</td>
                    </tr>
                   
                    </table>
                  `+(data.handyman==null ? '' : 
                  '<table class="table table-bordered"><tr><th width="30%" colspan="2" class="text-center">Handyman Information</th></tr> <tr><th width="30%">Handyman Name</th><td>'+data.handyman.name+'</td></tr><tr><th width="30%">Email</th><td>'+data.handyman.email+'</td></tr><tr><th width="30%">Mobile</th><td>'+data.handyman.mobile+'</td></tr><tr><th width="30%">Address</th><td>'+data.handyman.address+'</td></tr><tr><th width="30%">City</th><td>'+data.handyman.city+'</td></tr></table>')+`

                `
              );
              $('#viewBooking').modal('show'); 
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

    //invoice 
    $('body').on('click', '.bookingInvoice', function () {
      var invoice_id = $(this).data("id");
      var invoiceUrl = route('admin.booking.invoice','invoice_id').replace("invoice_id",invoice_id);
      $.ajax({
          headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
            type: "get",
            url: invoiceUrl,
            success: function (data) {
              $('#invoiceInfo').html(
                `
                <div class="card mb-5 card-print print-me" id="printarea">
            <div class="card-body">
              <div class="row d-flex flex-row align-items-center">
                <div class="col-12 col-md-6">
                  <img src="https://img.freepik.com/free-vector/branding-identity-corporate-vector-logo-design_460848-8717.jpg?w=2000" class="sw-17" alt="logo">
                </div>
                <div class="col-12 col-md-6 text-end">
                  <div class="mb-2">`+data.provider == null ? '--' : data.provider.name+`</div>
                  <div class="text-small text-muted">`+data.provider == null ? '--' : data.provider.email+`, `+data.provider == null ? '--' : data.provider.address+`,</div>
                  <div class="text-small text-muted">+`+data.provider == null ? '--' : data.provider.mobile+`</div>
                </div>
              </div>
              <div class="separator separator-light mt-5 mb-5"></div>
              <div class="row g-1 mb-5">
                <div class="col-12 col-md-8">
                  <div class="py-3">
                    <div>`+data.user.name+`</div>
                    <div>`+data.user.mobile == null ? '--' : data.user.mobile+` `+(data.user.address == null ? '--' : data.user.address)+`,`+(data.user.post_code == null ? '--' : data.user.post_code)+` </div>
                    <div> `+(data.user.state == null ? '--' : data.user.state)+`, `+(data.user.city == null ? '--' : data.user.city)+`</div>
                    <div> `+(data.user.country == null ? '--' : data.user.country)+`</div>
                  </div>
                </div>
                <div class="col-12 col-md-4">
                  <div class="py-3 text-md-end">
                    <div>Invoice #: `+data.id+`</div>
                    <div>`+new Date(data.created_at).toString().substring(0,15)+`</div>
                  </div>
                </div>
              </div>

              <div>
                <div class="row mb-4 d-none d-sm-flex">
                  <div class="col-6">
                    <p class="mb-0 text-small text-muted">ITEM NAME</p>
                  </div>
                  <div class="col-3">
                    <p class="mb-0 text-small text-muted">COUNT</p>
                  </div>
                  <div class="col-3 text-end">
                    <p class="mb-0 text-small text-muted">PRICE</p>
                  </div>
                </div>

                <div class="row mb-4 mb-sm-2">
                  <div class="col-12 col-sm-6">
                    <h6 class="mb-0">`+data.service.name+`</h6>
                  </div>
                  <div class="col-12 col-sm-3">
                    <p class="mb-0 text-alternate">1 Service</p>
                  </div>
                  <div class="col-12 col-sm-3 text-sm-end">
                    <p class="mb-0 text-alternate">`+data.price+` `+data.service.price_type+`</p>
                  </div>
                </div>
               
              </div>

              <div class="separator separator-light mt-5 mb-5"></div>

              <div class="row">
                <div class="col text-sm-end text-muted">
                  <div>Subtotal :</div>
                  <div>Tax :</div>
                  <div>Total :</div>
                </div>
                <div class="col-auto text-end">
                  <div>`+data.service.price_type+` `+data.price+`</div>
                  <div>`+data.service.price_type+` 0.0</div>
                  <div>`+data.service.price_type+` `+data.price+`</div>
                </div>
              </div>

              <div class="separator separator-light"></div>

              <div class="text-small text-muted text-center">Invoice was created on a computer and is valid without the signature and seal.</div>
            </div>
          </div>
                `);
            $('#bookingInvoice').modal('show'); 
           
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    
   
     //invoice print 
     $('body').on('click', '.Invoicedownload', function () {
      var invoice_id = $(this).data("id");
      var invoicePrint = route('admin.invoicePDFdownload','invoice_id').replace("invoice_id",invoice_id);
      $.ajax({
          headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
            type: "get",
            url: invoicePrint,
            xhrFields: {
              responseType: 'blob'
          },
            success: function(blob){
              var blob = new Blob([response]);
              var link = document.createElement('a');
              link.href = window.URL.createObjectURL(blob);
              link.download = "Sample.pdf";
              link.click();
          },
              error: function (data) {
                console.log('Error:', data);
            }
        });
    });

    




  });