$(function () {


    PopularServiceAll();
    function PopularServiceAll() {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: "get",
            dataType: 'json',
            processing: true,
            serverSide: true,
            async: true,
            crossDomain: true,
            url: route('getPopularServiceAll'),
            success: function (data) {
                // console.log(data);
                // alert(data);

                $.each(data, function (Index, val) {
                    //   console.log(val.id) 
                    var detailsUrl = route('ServiceDetails', 'service_id').replace("service_id", val.id);
                    var providerUrl = route('providerDetailsService', 'provider_id').replace("provider_id", val.providers.id);

                    var text = val.description;
                    var count = 90;
                    var result = text.slice(0, count) + (text.length > count ? "..." : "");

                    $("#allPopular_Service_id").append(`
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


});