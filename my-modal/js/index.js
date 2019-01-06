var modal = document.getElementById('myModal');
var span = document.getElementsByClassName("close")[0];
span.onclick = function() {
    modal.style.display = "none";
}
setTimeout( function () {
   $("#myModal").show();
}, 10000);
// event page
 $(document).ready(function(){
  $("#loading").hide();
   $("#order-submit").click( function() {
      var order_phone_1 = $("#order_phone_1").val() ;
      if(phonenumber(order_phone_1 ) ) {
        var order_name_1 = $("#order_name_1").val() ;
         if(order_name_1.length  > 1 ) {
            var order_quantity_1 = $("#order_quantity_1").val() ;
        if(Number.isInteger(parseInt(order_quantity_1))) {
                $("#erro_notify").html("");
                  $("#lable-order").hide();
            $("#loading").show();   
                   $.ajax({
                        url: 'http://localhost:81/api/orders/create.php',
                        type: 'POST',
                        data: JSON.stringify({
                                name :  order_name_1,
                                phone : order_phone_1,
                                count : order_quantity_1 
                                }),
                        contentType: 'application/json',
                        success: function(data) {
                           $("#erro_notify").html("")
                            console.log('SUCCESS: ', data);
                        },
                        error: function(data) {
                          $("#lable-order").show();
                          $("#loading").hide();
                          $("#myModal").hide();
                          if( data.status === 201 ) {
                               
                          } else {
                             $("#erro_notify").html("Vui lòng thử lại ...")
                          }
                        },
                    });
               
             } else {
                 $("#erro_notify").html('Số lượng nhập không hợp lệ');
             }
           } else {
              $("#erro_notify").html("Tên không được để trống");
           }
       
      } else {
        $("#erro_notify").html("Số điện thoại không hợp lệ");
      }
   });
 });

function phonenumber(inputtxt) {
  var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
  if(inputtxt.match(phoneno)) {
    return true;
  }
  else {
    return false;
  }
}