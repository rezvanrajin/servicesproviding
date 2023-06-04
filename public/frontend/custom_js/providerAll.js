$(function () {


    getAllProvider();
    function getAllProvider() {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: "get",
            dataType: 'json',
            processing: true,
            serverSide: true,
            async: true,
            crossDomain: true,
            url: route('getProviderAll'),
            success: function (data) {
                // console.log(data);

                $.each(data.provider, function (Index, val) {

                    var booking_length = 0;
                    if (val.booking != null) {
                        booking_length = val.booking.length;
                    }

                    var id_provider = val.id;
                    // console.log(id);
                    var urldd = route('providerDetailsService', 'id_provider').replace("id_provider", id_provider);

                    //   console.log(val)
                    $("#allProvider_id").append(`
                  <div class="col-lg-3 col-md-6">
                  <div class="single-seller-profile">
                      <div
                          class="thumb"
                          style="
                              background-image: url('`+ val.photo + `');
                          "
                      ></div>
                      <div class="content-area-wrap">
                          <h4 class="seller-title">
                              <a href="`+ urldd + `" class="viewProvider" data-id="` + val.id + `"> ` + val.name + ` </a>
                              <div
                                  data-bs-toggle="tooltip"
                                  data-bs-placement="top"
                                  title="This seller is verified."
                                  class="varified-tooltip"
                              >
                                  <i class="fa fa-check"></i>
                              </div>
                          </h4>
                          <div class="profiles-review">
                              <span class="reviews">
                              <i class="fa fa-star active"></i
                              ><i class="fa fa-star active"></i
                              ><i class="fa fa-star active"></i
                              ><i class="fa fa-star active"></i>
                             <i class="fa fa-star active"></i>
                              </span>
                          </div>
                          <span class="order-complete">${booking_length} Order Completed</span
                          >
                      </div>
                  </div>
              </div>  

                  `);
                });

            }


        });
    }


});