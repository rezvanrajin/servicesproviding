$(function () {
    var token = document.querySelector('meta[name="api-token"]').content; 
    var user_check = document.querySelector('meta[name="user-id"]').content; 
    // ........ get category........ 

    getCategory();
    function getCategory() {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: "get",
            dataType: 'json',
            processing: true,
            serverSide: true,
            async: true,
            crossDomain: true,
            url: route('index.category'),
            success: function (data) {
                // console.log(data);

                $.each(data.category, function (Index, val) {
                    var id = val.id;
                    var urlcat = route('service.listing', 'id').replace("id", id);
                    var serveice_length = 0;
                    if (val.service_count != null) {
                        serveice_length = val.service_count.length;
                    }
                    // var calUrl = route('categoryServiceList','id').replace("id",id);
                    // console.log(val.image);
                    $("#category_id").append(`
                 
                    <div class="col-xl-2 col-lg-3 col-sm-6 p-0 category-child">
                    <div class="single-category">
                        <div
                            class="image" style="background-image: url('`+ val.image + `'); "></div>
                        <div class="category-contents">
                            <h4 class="category-title">
                                <a href=`+ urlcat + `> ` + val.name + ` </a>
                            </h4>
                            <span class="category-para">${serveice_length} Service </span>
                        </div>
                    </div>
                </div>
                  `);
                });

            }

        });
    }


    // ........ get providers...... 
    getProvider();
    function getProvider() {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: "get",
            dataType: 'json',
            processing: true,
            serverSide: true,
            async: true,
            crossDomain: true,
            url: route('index.provider'),
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
                    $("#provider_id").append(`
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

    // ........ featured service ...... 
    getFeature();
    function getFeature() {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: "get",
            dataType: 'json',
            processing: true,
            serverSide: true,
            async: true,
            crossDomain: true,
            url: route('index.feature'),
            success: function (data) {
               
                var totoal_rating = 0;
              
                $.each(data.feature, function (Index, val) {
                    var avarate_rating = 0;
                    if (val.rating != null && val.rating.length > 0) {
                        $.each(val.rating, function (Index, value) {
                            totoal_rating += value.ratting;
                        });
                        avarate_rating = totoal_rating / val.rating.length;
                    }
                    // console.log(val.favorite);
                    var favoriteItem =0;
                    $.each(val.favorite, function (Index, value) {
                        favoriteItem += value.service_id;
                    });
                    var detailsUrl = route('ServiceDetails', 'service_id').replace("service_id", val.id);
                    var providerUrl = route('providerDetailsService', 'provider_id').replace("provider_id", val.providers.id);
                    var bookingUrl = route('checkout', 'booking_id').replace("booking_id", val.id);
                    var text = val.description;
                    var count = 90;
                    var result = text.slice(0, count) + (text.length > count ? "..." : "");
                    $("#feature_id").append(`
                  <div class="col-xl-3 col-lg-4 col-md-6 p-0">
                  <div class="service-single">
                      <a 
                          class="service-thumb" style="background-image: url('`+ val.image + `');">
                          `+(favoriteItem == val.id ? `<div class="fav-icon deletefavariteItem" data-id="`+val.id+`"><i class="fa-solid fa-heart"></i></div>` : `<div class="fav-icon favariteList" data-id="`+val.id+`"><i class="fa-regular fa-heart"></i></div>`)+`


                        
                           
                          <div class="location">
                              <span class="single_location">
                                  <i class="fa fa-map-marker-alt"></i>
                                  `+ val.providers.city + ` 
                              </span>
                          </div>
                      </a>
                      <div class="service-contents">
                          <ul class="author-tag">
                              <li class="tag-list">
                                  <a href="${providerUrl}">
                                      <div class="authors">
                                          <div class="thumb">
                                              <img src="`+ val.providers.photo + `" alt="Author Thumb"/><span class="notification-dot"></span>
                                          </div>
                                          <span class="author-title">
                                              ${val.providers.name}
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

        // ........ featured service ...... 
        popularService();
        function popularService() {
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: "get",
                dataType: 'json',
                processing: true,
                serverSide: true,
                async: true,
                crossDomain: true,
                url: route('index.popularService'),
                success: function (data) {
                    $.each(data, function (Index, val) {
                        var detailsUrl = route('ServiceDetails', 'service_id').replace("service_id", val.id);
                        var providerUrl = route('providerDetailsService', 'provider_id').replace("provider_id", val.providers.id);
                        var text = val.description;
                        var count = 90;
                        var result = text.slice(0, count) + (text.length > count ? "..." : "");
                        $("#popular_service").append(`
                        <div class="col-xl-3 col-lg-4 col-md-6 p-0">
                        <div class="service-single">
                        <a href="#" class="service-thumb"
                            style="
                                background-image: url('`+ val.image + `');
                            ">
                            <div class="fav-icon">
                                <i class="fa-regular fa-heart"></i>
                            </div>
                            <div class="location">
                                <span class="single_location">
                                    <i class="fa fa-map-marker-alt"></i>
                                    `+val.providers.city+`
                                </span>
                            </div>
                        </a>
                        <div class="service-contents">
                            <ul class="author-tag">
                                <li class="tag-list">
                                    <a href="`+providerUrl+`">
                                        <div class="authors">
                                            <div class="thumb">
                                                <img src="`+ val.providers.photo + `"
                                                    alt="Author Thumb" />
                                                <span class="notification-dot"></span>
                                            </div>
                                            <span class="author-title">
                                                `+val.providers.name+`
                                            </span>
                                        </div>
                                    </a>
                                </li>
                                <li class="tag-list">
                                    <span class="reviews"><i class="fa fa-star active"></i><i
                                            class="fa fa-star active"></i><i class="fa fa-star"></i><i
                                            class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </span>
                                </li>
                            </ul>
                            <h5 class="common-title">
                                <a href="`+detailsUrl+`">
                                   `+val.name+`
                                </a>
                            </h5>
                            <p class="common-pera">
                               `+result+`
                            </p>
                            <div class="service-price">
                                <span class="price"> `+val.price_type+``+val.price+` </span>
                            </div>
                            <div class="btn-wrapper">
                                <a href="#" class="common-btn">Book Now</a>
                            </div>
                        </div>
                    </div>
                    </div>
                      `);
                            
                    });
    
                }
            });
        }

    $(document).on('click','.favariteList', function(){
        var service_id = $(this).data('id');
        // alert(service_id);
        $.ajax({
            headers: { "Content-Type": "application/x-www-form-urlencoded", "Authorization": token},
            type:"post",
            url: route('favariteService'),
            data:{service_id:service_id},
            success:function(resp){
                // console.log(resp);
               alert("Successfully Added This Item ! Thank You.");
            },error:function(){
                alert("Please Login Then Add Faborite Item");
            }
        });
     });


     $(document).on('click','.deletefavariteItem', function(){
        alert("This Item has been added in Your Favorite Item");
     });



    getRecentlyService();
    function getRecentlyService() {

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: "get",
            dataType: 'json',
            processing: true,
            serverSide: true,
            async: true,
            crossDomain: true,
            url: route('recentService'),
            success: function (data) {
                // console.log(data);
                // alert(data);

                $.each(data.recentlyFeature, function (Index, val) {
                    //   console.log(val.id) 
                    var detailsUrl = route('ServiceDetails', 'service_id').replace("service_id", val.id);
                    var providerUrl = route('providerDetailsService', 'provider_id').replace("provider_id", val.providers.id);
                    var bookingUrl = route('checkout', 'booking_id').replace("booking_id", val.id);

                    var text = val.description;
                    var count = 90;
                    var result = text.slice(0, count) + (text.length > count ? "..." : "");

                    $("#Recently_Posted").append(`

                  <div class="col-xl-3 col-lg-4 col-md-6 p-0">
                  <div class="service-single">
                      <a
                          href="${detailsUrl}"
                          class="service-thumb"
                          style="
                          background-image: url('`+ val.image + `');
                          "
                      >
                          <div class="location">
                              <span class="single_location">
                                  <i class="fa fa-map-marker-alt"></i>
                                  `+ val.providers.city + `
                              </span>
                          </div>
                      </a>
                      <div class="service-contents">
                          <ul class="author-tag">
                              <li class="tag-list">
                                  <a href="${providerUrl}">
                                      <div class="authors">
                                          <div class="thumb">
                                              <img
                                                  src="`+ val.providers.photo + `"
                                                  alt="Author Thumb"
                                              />
                                              <span
                                                  class="notification-dot"
                                              ></span>
                                          </div>
                                          <span class="author-title">
                                              `+ val.providers.name + `
                                          </span>
                                      </div>
                                  </a>
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
                              <span class="starting">Starting At</span>
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