
 
//  getHeaderMenu();
//     function getHeaderMenu(){
              
//         $.ajax({
//             headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
//             type: "get",
//             dataType: 'json',
//             processing: true,
//             serverSide: true,
//             async: true,
//             crossDomain: true,
//             url: route('index.getMenu'),
//             success: function (data) {
          
//                 var loopdata ='';
//                 $.each(data, function(k, val) {
//                     loopdata += `<li class="nav-item">
//                     <a href="`+val.hmenu_url+`" class="nav-link">`+val.hmenu_name+`</a>
//                     </li>`;
//                 });
//                 $("#menuBar").html(loopdata);

     
//             },
//             error: function (data) {
//                 console.log('Error:', data);
//             }
//         });
//     }
    
 