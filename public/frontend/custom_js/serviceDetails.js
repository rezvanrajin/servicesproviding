var user_id = document.querySelector('meta[name="user-id"]').content;
var token = document.querySelector('meta[name="api-token"]').content;


$(function () {

    getProviderDetails();
    function getProviderDetails() {

        //    console.log("test");
        // console.log(route().params.id);
        var urlid = route('getserviceDetails', { 'service': route().params.id });
        //  var urlchk = route('checkout','id').replace("id",route().params.id);

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

                var catUrl = route('service.listing', 'category_id').replace("category_id", data.service.category.id);

                $("#categoryLoop").html(`
                    <div class="banner-inner-contents">
                        <ul class="inner-menu">
                            <li><a href="${route('index')}">Home</a></li>
                            <li><a href="${catUrl}">` + data.service.category.name + `</a></li>
                        </ul>
                        <h2 class="banner-inner-title">`+ data.service.name + `</h2>
                    </div>
                `);
                //  console.log(data.name);
                $("#seviceDetails").html(`
          
             <div class="service-details-wrapper">
             <div class="details-thumb">
                 <div
                     class="service-details-background-image"
                     style="background-image: url('`+ data.service.image + `');"></div>
                </div>
             <ul class="details-tabs tabs mt-50" role="tablist">
                 <li
                     data-tab="tab1"
                     class="active"
                     data-bs-toggle="tab"
                     data-bs-target="#tab1"
                     role="tab"
                     aria-controls="overview"
                     aria-selected="true"
                 > Overview</li>
                 <li
                     data-tab="tab2"
                     data-bs-toggle="tab"
                     data-bs-target="#tab2"
                     role="tab"
                     aria-controls="tab2"
                     aria-selected="true"
                 >
                     About Seller
                 </li>
                 <li
                     data-tab="tab3"
                     data-bs-toggle="tab"
                     data-bs-target="#tab3"
                     role="tab"
                     aria-controls="tab3"
                     aria-selected="true"
                 >
                     Review
                 </li>
             </ul>
             <div
                 class="tab-content another-tab-content active"
                 id="tab1"
             >
                 <div class="details-content-tab pt-10">
                     <p class="details-tap-para">
                         `+ data.service.description + `
                     </p>
                 </div>
                 <div class="overview-single pt-60">
                     <h4 class="title">What you will get:</h4>
                     <ul class="overview-benefits mt-30">
                         <li>
                             <a href="#"
                                 >Business Module Build</a
                             >
                         </li>
                         <li>
                             <a href="#">Reach Your Customer</a>
                         </li>
                         <li>
                             <a href="#"
                                 >Branding Your Business</a
                             >
                         </li>
                         <li>
                             <a href="#">Get Business Logic</a>
                         </li>
                     </ul>
                 </div>
                 <div class="overview-single pt-60">
                     <h4 class="title">
                         Benefits of the premium Package:
                     </h4>
                     <ul class="overview-benefits mt-30">
                         <li>
                             <a href="#">Timely Work</a>
                         </li>
                         <li>
                             <a href="#">Professional work</a>
                         </li>
                         <li>
                             <a href="#">Task gurentee</a>
                         </li>
                         <li>
                             <a href="#">Profitable work get</a>
                         </li>
                     </ul>
                 </div>
                 <div class="faq-area pt-100 pb-100">
                     <div class="row justify-content-center">
                         <div class="col-lg-12">
                             <div class="accordion">
                                 <div
                                     class="faq-item accordion-item"
                                 >
                                     <h2
                                         class="faq-title accordion-header"
                                         id="headingOne"
                                     >
                                         <button
                                             class="accordion-button collapsed"
                                             type="button"
                                             data-bs-toggle="collapse"
                                             data-bs-target="#collapseOne"
                                             aria-expanded="true"
                                             aria-controls="collapseOne"
                                         >
                                             Faq
                                         </button>
                                     </h2>
                                     <div
                                         id="collapseOne"
                                         class="accordion-collapse collapse"
                                         aria-labelledby="headingOne"
                                         data-bs-parent="#accordionExample"
                                     >
                                         <div
                                             class="accordion-body"
                                         >
                                             <p class="faq-para">
                                                 Faq Description
                                             </p>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="tab-content another-tab-content" id="tab2">
                 <div class="details-content-tab pt-10">
                     <div class="about-seller-tab mt-30">
                         <div class="about-seller-flex-content">
                             <div class="about-seller-thumb">
                                 <img
                                     src="`+ data.service.provider.photo + `"
                                     alt="Seller Thumb"
                                 />
                             </div>
                             <div class="about-seller-content">
                                 <h5 class="title">
                                     <a href="#">`+ data.service.provider.name + `</a>
                                 </h5>
                                 <div class="about-seller-list">
                                     <span class="icon">
                                         Order Completed
                                     </span>
                                     <span class="reviews">
                                         (${data.booking})
                                     </span>
                                 </div>
                             </div>
                         </div>
                         <div class="seller-details-box mt-40">
                             <ul class="seller-box-list">
                                 <li class="box-list">
                                     From
                                     <strong>
                                         `+ data.service.provider.city + `
                                     </strong>
                                 </li>
                                 <li class="box-list">
                                     Seller Since
                                     <strong> ${moment(data.service.provider.created_at).format("YYYY")} </strong>
                                 </li>
                                 <li class="box-list">
                                     Order Completion Rate
                                     <strong> 80% </strong>
                                 </li>
                                 <li class="box-list">
                                     Order Completed
                                     <strong> ${data.booking} </strong>
                                 </li>
                             </ul>
                             <p class="seller-details-para">
                                 ${data.service.provider.about}
                             </p>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="tab-content another-tab-content" id="tab3">
            <div class="col-lg-12 mt-2">
            <div class="review-seller-wrapper">
            <div class="profile-author-contents" id="review_service">
                
         </div>
            </div>
            </div>
                <div class="details-content-tab">
                 
                     <div class="about-review-tab">
                 
                     <form action="#" id="serviceReviewForm">
                        <input type="hidden" name="user_id" value="`+user_id+`" />
                        <input type="hidden" name="service_id" value="`+data.service.id+`" />
                      
                        <div>
                            <textarea class="form-control area-border" name="review" id="exampleFormControlTextarea1"
                                placeholder="Write Service Review..." rows="2"></textarea>
                        </div>
                        <div class="star-rating">
                            <input type="radio" id="5-stars" name="ratting" value="5" />
                            <label for="5-stars" class="star">&#9733;</label>
                            <input type="radio" id="4-stars" name="ratting" value="4" />
                            <label for="4-stars" class="star">&#9733;</label>
                            <input type="radio" id="3-stars" name="ratting" value="3" />
                            <label for="3-stars" class="star">&#9733;</label>
                            <input type="radio" id="2-stars" name="ratting" value="2" />
                            <label for="2-stars" class="star">&#9733;</label>
                            <input type="radio" id="1-star" name="ratting" value="1" />
                            <label for="1-star" class="star">&#9733;</label>
                        </div>
                        `+user_id +` 
                        <button type="button" class="review-btn" id="reviewSubmit">Comment</button>
                     
                    </form>
                   
                </div>

                 </div>
             </div>
         </div>
        
        
             `);


                $("#OrderPrice").html(`
           
             <div class="service-details-package">
             <div class="single-packages">
                 <ul class="package-price">
                     <li>Package</li>
                     <li>`+ data.service.price_type + `` + data.service.price + `</li>
                 </ul>
                 <div class="details-available-price mt-20">
                     <span class="summery-title">
                         <ul class="onlilne-special-list">
                             <li>
                                 <i
                                     class="fa-regular fa-clock"
                                 ></i>
                                 Delivery Days: `+ data.service.duration + `
                             </li>
                         </ul>
                         <ul class="available-list">
                             <li>Business Module Build</li>
                             <li>Reach Your Customer</li>
                             <li>Branding Your Business</li>
                             <li>Get Business Logic</li>
                         </ul>
                     </span>
                 </div>
                 <div class="btn-wrapper text-center mt-30">
                    <form id="addToCartForm">
                        <input type="hidden" name="user_id" value="`+ user_id + `">
                        <input type="hidden" name="service_id" value="`+ data.service.id + `">
                        
                        <a id="addToCart" class="common-btn d-block">
                            Book Appointment
                        </a>
                       
                     </form>
                 </div>
             </div>
             <div class="order-pagkages">
                 <span class="single-order">
                     <i class="fa fa-check"></i>
                     ${data.booking} Order Completed
                 </span>
             </div>
             <div class="order-pagkages">
                 <span class="single-order">
                 <i class="fa fa-star"></i>
                     ${data.avarage_rating} Avarage Rating
                 </span>
             </div>
         </div>
                  
             
             `);


                var avarate_rating = 0;
                $.each(data.relatedProducts, function (k, val) {
                    var text = val.description;
                    var count = 120;
                    var result = text.slice(0, count) + (text.length > count ? "..." : "");
                    var detailsUrl = route('ServiceDetails', 'service_id').replace("service_id", val.id);
                    var providerUrl = route('providerDetailsService', 'provider_id').replace("provider_id", val.provider.id);
                    var bookingUrl = route('checkout', 'booking_id').replace("booking_id", val.id);
                    var avarate_rating = 0;

                    if (val.rating != null && val.rating.length > 0) {
                        var totoal_rating = 0;
                        $.each(val.rating, function (Index, value) {
                            totoal_rating += value.ratting;
                            console.log(value.ratting);
                        });
                        avarate_rating = totoal_rating / val.rating.length;
                    }

                    $("#anotherDetails").append(`    <div class="col-md-6 mt-30" >
                <div class="service-single">
                    <a
                        href="`+ detailsUrl + `"
                        class="service-thumb"
                        style="
                            background-image: url('`+ val.image + `');
                        "
                    >
                        <div class="location">
                            <span class="single_location">
                                <i
                                    class="fa fa-map-marker-alt"
                                ></i>
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
                                            <img
                                                src="`+ val.provider.photo + `"
                                                alt="Author Thumb"
                                            />
                                            <span
                                                class="notification-dot"
                                            ></span>
                                        </div>
                                        <span
                                            class="author-title"
                                        >
                                            `+ val.provider.name + `
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
                            <a href="`+ detailsUrl + `">
                            `+ val.name + `
                            </a>
                        </h5>
                        <p class="common-pera">
                        `+ result + `
                            
                        </p>
                        <div class="service-price">
                            <span class="starting"
                                >Starting At</span
                            >
                            <span class="price">
                                `+ val.price_type + ` ` + val.price + `
                            </span>
                        </div>
                        <div class="btn-wrapper">
                            <a href="${bookingUrl}" class="common-btn"
                                >Book Now</a
                            >
                        </div>
                    </div>
                </div>
            </div>`);
                });

                $.each(data.reviews, function (k, val) {
                    var ratin = "";
                    for ($i = 0; $i < val.ratting; $i++) {
                        ratin += `<i class="fa fa-star active"></i>`;
                    }
                    for ($j = 0; $j < 5 - val.ratting; $j++) {
                        ratin += `<i class="fa fa-star"></i>`;
                    }

                    $("#service_reviews").append(`     <div class="service-single">
                <div class="service-contents">
                    <ul class="author-tag">
                        <li class="tag-list">
                            <a href="#">
                                <div
                                    class="authors"
                                >
                                    <div
                                        class="thumb"
                                    >
                                        <img
                                            src="`+ val.user.photo + `"
                                            alt="Author Thumb"
                                        />
                                        <span
                                            class="notification-dot"
                                        ></span>
                                    </div>
                                    <span
                                        class="author-title">
                                       ${val.user.name}
                                    </span>
                                </div>
                            </a>
                        </li>
                        <li class="tag-list" >
                            <span class="reviews">
                                ${(ratin == 0 ? 0 : ratin)}
                            </span>
                        </li>
                        <li class="tag-list" >
                            <span class="reviews">
                            `+ val.review + `
                            </span>
                        </li>
                    </ul>
                    
                </div>
            </div>`);
                });
            }

        });
    }


    $(document).on('click', '#reviewSubmit', function (e) {
        e.preventDefault();

        var formData = new FormData($("#serviceReviewForm")[0]);
        $.ajax({
            headers: { "Authorization": token },
            type: 'POST',
            url: route('serviceReview'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                confirm("Comment has been successfull");
                //  console.log(data);
                $('#serviceReviewForm').trigger("reset");
            },
            error: function (data) {
                console.log(data);
            }
        });
    });

    $(document).on('click', '#addToCart', function (e) {

        var formData = new FormData($("#addToCartForm")[0]);
        $.ajax({
            headers: { "Authorization": token },
            type: 'POST',
            url: route('addToCart'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.success == true) {
                    alert("Your Item has been add in Your Cart");
                }
            },
            error: function (data) {
                alert("Please Login and Book Now");
            }
        });
    });

});

