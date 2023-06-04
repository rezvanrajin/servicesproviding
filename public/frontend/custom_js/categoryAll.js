$(function () {

    getAllCategory();
    function getAllCategory() {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: "get",
            dataType: 'json',
            processing: true,
            serverSide: true,
            async: true,
            crossDomain: true,
            url: route('getCategoryAll'),
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
                    $("#allCategory_id").append(`
                 
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


});