$(function(){
    var token = document.querySelector('meta[name="api-token"]').content; 

    getCartItemAll();
    function getCartItemAll(){

        $.ajax({
            headers: {"Content-Type": "application/x-www-form-urlencoded","Authorization": token},
            type: "get",
            dataType: 'json',
            processing: true,
            serverSide: true,
            async: true,
            crossDomain: true,
            url: route('getCartItem'),
            success: function(data) {
                $discount = 0;
                $item = 0;
                $total_price = 0;
                $type=0;
                $.each(data, function (Index, value) {
                  $discount = value.service.price - value.service.discount;
                    $("#cartItem").append(`
                    <div class="row maincart align-items-center">
                        <div class="col-2"><img class="img-fluid cart-image" src="${value.service.image}"></div>
                        <div class="col">
                            <div class="row text-muted">${value.service.name}</div>
                        </div>
                        <div class="col">
                            <a href="#" class="link-item">-</a><a href="#" class="border link-item">1</a><a href="#" class="link-item">+</a>
                        </div>
                        <div class="col amount">${value.service.price_type} ${$discount}</div>
                        <div class="col"><a href="#" class="close text-danger" data-id="${value.id}">&#10005;</a></div>
                    </div>
                    `);

                    $item = Index+1;
                    $total_price += $discount * value.qty;
                    $type = value.service.price_type;
                                   // console.log($total_price);
                $(".cartCount").html(`(${$item}) ITEMS`)
                $(".subtotal").html(`${$type} ${$total_price}`);
                });


            }
            
            
        });
        
        
    }

    $("body").on('click', '.close', function () {
       
        var cart_id = $(this).data("id");
        // console.log(cart_id);
        var cityDestroy = route('deleteCartItem',{'cart':cart_id});
      
        $.ajax({
            type: "DELETE",
            url: cityDestroy,
            headers: {"Authorization": token},
            success: function (data) {
            //  console.log(data);
               
              },
              error: function (data) {
                  console.log('Error:', data);
             }
         });
         getCartItemAll();
   
    });


});

