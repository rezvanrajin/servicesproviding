$(function () {

    getAllFeatureService();
    function getAllFeatureService() {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: "get",
            dataType: 'json',
            processing: true,
            serverSide: true,
            async: true,
            crossDomain: true,
            url: route('getFeaturedServiceAll'),
            success: function (data) {
                // console.log(data);
                var totoal_rating = 0;
               
                $.each(data.feature, function (Index, val) {
                    var avarate_rating = 0;
                    if (val.rating != null && val.rating.length > 0) {
                        $.each(val.rating, function (Index, value) {
                            totoal_rating += value.ratting;
                        });
                        avarate_rating = totoal_rating / val.rating.length;
                    }

                    // debugger;
                    //    console.log(avarate_rating);

                    var detailsUrl = route('ServiceDetails', 'service_id').replace("service_id", val.id);
                    var providerUrl = route('providerDetailsService', 'provider_id').replace("provider_id", val.provider.id);
                    var bookingUrl = route('checkout', 'booking_id').replace("booking_id", val.id);
                    var text = val.description;
                    var count = 90;
                    var result = text.slice(0, count) + (text.length > count ? "..." : "");
                    $("#allFeature_Service_id").append(`
                  <div class="col-xl-3 col-lg-4 col-md-6 p-0">
                  <div class="service-single">
                      <a href="${detailsUrl}"
                          class="service-thumb" style="background-image: url('`+ val.image + `');">
                          <div class="fav-icon">
                              <i class="fa-regular fa-heart"></i>
                          </div>
                          <div class="location">
                              <span class="single_location">
                                  <i class="fa fa-map-marker-alt"></i>
                                  `+ val.provider.city + `
                              </span>
                          </div>
                      </a>
                      <div class="service-contents">
                          <ul class="author-tag">
                              <li class="tag-list">
                                  <a href="${providerUrl}">
                                      <div class="authors">
                                          <div class="thumb">
                                              <img src="`+ val.provider.photo + `" alt="Author Thumb"/><span class="notification-dot"></span>
                                          </div>
                                          <span class="author-title">
                                              ${val.provider.name}
                                          </span>
                                      </div>
                                  </a>
                              </li>
                              <li class="tag-list">
                                  <span class="reviews">
                                    Avarage Rating (${avarate_rating})
                                  </span>
                              </li>
                          </ul>
                          <h5 class="common-title">
                              <a href="${detailsUrl}">
                                `+ val.name + `
                              </a>
                          </h5>
                          <p class="common-pera">
                          `+ result + `
                          </p>
                          <div class="service-price">
                              <span class="price"> `+ val.price_type + `` + val.price + ` </span>
                          </div>
                          <div class="btn-wrapper">
                              <a href="${bookingUrl}" class="common-btn">Book Now</a>
                          </div>
                      </div>
                  </div>
              </div>
               
                  `);
                });

            }
        });
    }
});