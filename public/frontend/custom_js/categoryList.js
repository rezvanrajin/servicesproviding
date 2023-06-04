$(function(){
    // ........ get provider Details........ 

    getCategoryDetails();
    function getCategoryDetails(){

        // console.log(route().params.id);
        var urlid =  route('categoryDetails.ServiceList',{'category' : route().params.id});
        $.ajax({
            headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "get",
            dataType: 'json',
            processing: true,
            serverSide: true,
            async: true,
            crossDomain: true,
            url: urlid,
            success: function(data) {
                // console.log(data.name);
                var catUrl = route('service.listing','category_id').replace("category_id",data.id);

               $("#CategoryDetails").html(`
                    <div class="banner-inner-contents">
                        <ul class="inner-menu">
                            <li><a href="${route('index')}">Home</a></li>
                            <li><a href="${catUrl}">`+data.name+`</a></li>
                        </ul>
                        <h2 class="banner-inner-title">`+data.name+`</h2>
                    </div>
               
              `);
            }
            
            
        });
        
        var urlid =  route('getcategoryServiceList',{'category': route().params.id});
        $.ajax({
            headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "get",
            dataType: 'json',
            processing: true,
            serverSide: true,
            async: true,
            crossDomain: true,
            url: urlid,
            success: function(data) {
                var totoal_rating = 0;
                $.each(data , function(Index,val) { 
                    var avarate_rating = 0;
                    if (val.rating != null && val.rating.length > 0) {
                        $.each(val.rating, function (Index, value) {
                            totoal_rating += value.ratting;
                        });
                        avarate_rating = totoal_rating / val.rating.length;
                    }

                    var text = val.description;
                    var count = 120;
                    var result = text.slice(0, count) + (text.length > count ? "..." : "");
                    var detailsUrl = route('ServiceDetails','service_id').replace("service_id",val.id);
                    var providerUrl = route('providerDetailsService','provider_id').replace("provider_id",val.provider.id);
                   

                    var discount = val.price - val.discount;
                    
                    //   console.log(val)
                      $("#category_service_list").append(`
    
                      <div class="col-lg-4 col-md-6 mt-30">
                        <div class="service-single">
                            <a href="`+detailsUrl+`" class="service-thumb" style="
                                    background-image: url('`+val.image+`');
                                ">
                                <div class="location">
                                    <span class="single_location">
                                        <i class="fa fa-map-marker-alt"></i>
                                        `+val.provider.city+`
                                    </span>
                                </div>
                            </a>
                            <div class="service-contents">
                                <ul class="author-tag">
                                    <li class="tag-list">
                                        <a href="${providerUrl}">
                                            <div class="authors">
                                                <div class="thumb">
                                                    <img src="`+val.provider.photo+`">
                                                    <span class="notification-dot"></span>
                                                </div>
                                                <span class="author-title">
                                                   `+val.provider.name+`
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="tag-list">
                                        <span class="reviews">
                                        Avarage Rating ${avarate_rating}
                                        </span>
                                    </li>
                                </ul>
                                <h5 class="common-title">
                                    <a href="${detailsUrl}">
                                    `+val.name+`
                                    </a>
                                </h5>
                                <h5 class="common-title">
                                    <a href="#">
                                    `+(val.discount ==0 ? ' ' : val.discount) +` `+(val.discount ==0 ? ' ' : val.price_type)+`
                                    </a>
                                </h5>
                                <p class="common-pera">
                                `+result+`
                                </p>
                                <div class="service-price">
                                    <span class="starting">Starting At</span>
                                    <span class="price"> `+val.price_type+` `+discount+`  </span>
                                </div>
                                <div class="btn-wrapper d-flex justify-content-between flex-wrap">
                                    <form class="addToCartForm">
                                        <input type="hidden" name="service_id" value="`+val.id+`">
                                        <a data-id="${val.id}" class="common-btn btn-small">Book Now</a>
                                    </form>
                                    <a href="${detailsUrl}" class="common-btn common-btn-outline">View Details</a>
                                </div>
                            </div>
                        </div>
                  
                      
                      `);
                      
                        

                });
                
            }
            
        });
        
    }

    $(document).on('click','.addToCartForm',function(e) {
        e.preventDefault();
        
        var formData = new FormData();
        formData.append('service_id', $(e.target).data('id'));

        $.ajax({
          headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          type:'POST',
          url: route('index.cart'),
          data: formData,
          cache:false,
          contentType: false,
          processData: false,
          success: (data) => {
          //  console.log(data);
          alert("Successfully add Your Service In Your Cart");
            $('#addToCartForm').trigger("reset");
          },
          error: function(data){
            console.log(data);
          }
        });
    });
  
});

