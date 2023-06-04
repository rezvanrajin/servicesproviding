var user_id = document.querySelector('meta[name="user-id"]').content; 
var token = document.querySelector('meta[name="api-token"]').content; 


$(function () {
    
    // ........ get provider Details........ 

    getProviderDetails();
    function getProviderDetails() {

        // console.log(route().params.id);
        var urlid = route('providerDetails.ServiceList', 'provider_id').replace("provider_id", route().params.id);
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: "get",
            dataType: 'json',
            processing: true,
            serverSide: true,
            async: true,
            crossDomain: true,
            url: urlid,
            success: function (data) {
                // console.log(data.provider.name);
                var providerUrl = route('providerDetailsService', 'provider_id').replace("provider_id", data.id);
                var rating="";
                for($i=0; $i<data.avarage_sellerRating; $i++)
                {
                        rating+=`<i class="fa fa-star active"></i>`;
                }
                for($j=0; $j<5-data.avarage_sellerRating; $j++)
                {
                    rating+=`<i class="fa fa-star"></i>`;
                }
                $("#ProviderDetails").html(`
                       <div class="row align-items-center">
                        <div class="col-lg-4 col-md-6 mt-30">
                            <div class="profile-author-contents provider-area">
                                <div class="single-seller-profile">
                                    <div
                                        class="thumb"
                                        style="
                                            background-image: url('`+ data.provider.photo + `');
                                        "
                                    ></div>
                                    <div class="content-area-wrap">
                                        <h4 class="seller-title">
                                            <a href="${providerUrl}">` + data.provider.name + `</a>
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
                                                ${rating}
                                            </span>
                                            <span class="order-completed">(${Math.round(data.avarage_sellerRating)} out 5)</span>
                                        </div>
                                        <div class="seller-social-links mt-20">
                                            <a href="#"
                                                ><i
                                                    class="fa-brands fa-facebook-f"
                                                ></i
                                            ></a>
                                            <a href="#"
                                                ><i class="fa-brands fa-twitter"></i
                                            ></a>
                                            <a href="#"
                                                ><i
                                                    class="fa-brands fa-instagram"
                                                ></i
                                            ></a>
                                            <a href="#"
                                                ><i class="fa-brands fa-youtube"></i
                                            ></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mt-30">
                            <div class="profile-author-contents">
                                <ul class="profile-about">
                                    <li>From: <span>`+ (data.provider.city == null ? '--' : data.provider.city) + `</span></li>
                                    <li>Seller Since: <span>`+ moment(data.provider.created_at).format("YYYY") + `</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-5 mt-30">
                            <div class="profile-author-contents">
                                <div class="profile-single-achieve">
                                    <div class="single-achieve">
                                        <div class="icon">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="contents mt-10">
                                            <h3>${data.booking}</h3>
                                            <span>Order Completed</span>
                                        </div>
                                    </div>
                                    <div class="single-achieve">
                                        <div class="icon">
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="contents mt-10">
                                            <h3>80%</h3>
                                            <span>Seller Rating</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`);
            }

        });
    }

    getProviderList();
    function getProviderList() {

        // console.log(route().params.id);
        var urlid = route('getproviderServiceList', {'provider' : route().params.id})
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: "get",
            dataType: 'json',
            processing: true,
            serverSide: true,
            async: true,
            crossDomain: true,
            url: urlid,
            success: function (data) {

                $.each(data, function (Index, val) {
                    var text = val.description;
                    var count = 120;
                    var result = text.slice(0, count) + (text.length > count ? "..." : "");
                   
                    var discount = val.price - val.discount;
                    var detailsUrl = route('ServiceDetails', 'provider_id').replace("provider_id", val.id);
                    var bookingUrl = route('checkout', 'booking_id').replace("booking_id", val.id);
                    //   console.log(val)
                    $("#provider_service_list").append(`
            
                              <div class="col-lg-4 col-md-6 mt-30">
                              <div class="service-single p-0 bg-white">
                                  <a href="${detailsUrl}" class="service-thumb" style="background-image: url('`+ val.image + `');">
                                      <div class="fav-icon favariteItem" data-favariteid="`+ val.id + `">
                                          <i class="fa-regular fa-heart"></i>
                                      </div>
                                      <div class="location">
                                          <span class="single_location">
                                              <i class="fa fa-map-marker-alt"></i>
                                              `+ val.provider.city + `
                                          </span>
                                      </div>
                                  </a>
                                  
                                  <div class="service-contents p-20">
                                    <h5 class="common-title">
                                        <a href="${detailsUrl}">
                                        `+ val.name + `
                                        </a>
                                    
                                    </h5>
                                      <h5 class="common-title">
                                          <a href="#">
                                              `+ (val.discount == 0 ? ' ' : val.discount) + ` ` + (val.discount == 0 ? ' ' : val.price_type) + `
                                          </a>
                                      </h5>
                                      <p class="common-pera">
                                         `+ result + `
                                      </p>
                                      <div class="service-price">
                                          <span class="starting">Starting At</span>
                                          <span class="price price-hover">
                                          `+ val.price_type + ` ` + discount + ` 
                                          </span>
                                      </div>
                                      <div class="btn-wrapper">
                                          <a href="${bookingUrl}" class="common-btn width-100"
                                              >Book Now</a
                                          >
                                      </div>
                                  </div>
                              </div>
                          </div>
                          
                              
                    `);

                    $("#sellerReview_id").html(`
                        <form action="#" id="sellerReviewForm">
                            <input type="hidden" name="provider_id" id="provider_id" value="`+val.provider.id+`">
                            <input type="hidden" name="user_id" id="user_id" value="`+user_id+`">
                            <div class="">
                                <textarea class="form-control area-border" name="review" id="review" placeholder="Write Seller Review..." rows="2"></textarea>
                            </div>
                            <div class="star-rating">
                                <input type="radio" id="5-stars" name="rating" value="5" />
                                <label title="5-Star" for="5-stars" class="star">&#9733;</label>
                                <input type="radio" id="4-stars" name="rating" value="4" />
                                <label title="4-Start" for="4-stars" class="star">&#9733;</label>
                                <input type="radio" id="3-stars" name="rating" value="3" />
                                <label title="3-Star" for="3-stars" class="star">&#9733;</label>
                                <input type="radio" id="2-stars" name="rating" value="2" />
                                <label title="2-Star" for="2-stars" class="star">&#9733;</label>
                                <input type="radio" id="1-star" name="rating" value="1" />
                                <label title="1-Star" for="1-star" class="star">&#9733;</label>
                            </div>
                            <button type="button" id="sellerReviewBtn" class="review-btn">Comment</button>
                        </form>
                    `);

                    // console.log(val.provider.id);
                    // console.log();
                });

            }

        });
    }

    
    getSellerReviews();
    function getSellerReviews() {
        var urlProvider = route('getSellerReviews', 'providerReview_id').replace("providerReview_id", route().params.id);
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: "get",
            dataType: 'json',
            processing: true,
            serverSide: true,
            async: true,
            crossDomain: true,
            url: urlProvider,
            success: function (data) {
               
                // console.log(data.provider.name);
                $.each(data.sellerReviews, function (Index, val) {
                    var rating="";
                    for($i=0; $i<val.rating; $i++)
                    {
                            rating+=`<i class="fa fa-star active"></i>`;
                    }
                    for($j=0; $j<5-val.rating; $j++)
                    {
                        rating+=`<i class="fa fa-star"></i>`;
                    }

                    $("#sellerReview").append(`
                        <div class="single-seller-profile mt-3 review_cart">
                            <img class="thumb" src="${val.user.photo}" />
                            <div class="content-area-wrap">
                                <h4 class="seller-title">`+ val.user.name + `</h4>
                                <div class="profiles-review">
                                    <span class="reviews">
                                    ${rating}
                                    </span>
                                </div>
                                <p class="seller-review-pera">
                                    `+ val.review + `
                                    
                                </p>
                                <span class="review-date">${moment(val.created_at).format("MMM m YYYY")}</span>
                            </div>
                        </div>
                    `);

                });


            }

        });
    }

    $(document).on('click','#sellerReviewBtn', function (e) {
        e.preventDefault();
       
        var formData = new FormData($("#sellerReviewForm")[0]);
        $.ajax({
          headers: { "Authorization": token },
          type: 'POST',
          url: route('providerReview'),
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          success: (data) => {
            //  console.log(data);
            confirm("Comment has been successfull");
            $('#sellerReviewForm').trigger("reset");
            getSellerReviews();
          },
          error: function (data) {
            console.log(data);
          }
        });
      });

});