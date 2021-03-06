$(".fa-info-circle").hover(function(){
    console.log('test');
    $('.show_info_block').show();
},function(){
    $('.show_info_block').hide();
});

function getNumbers(inputString){
    var regex=/\d+\.\d+|\.\d+|\d+/g,
        results = [],
        n;

    while(n = regex.exec(inputString)) {
        results.push(parseFloat(n[0]));
    }

    return results;
}

$(".cart_input_style").keyup(function(event) { //trigger event voor enter in value
    if (event.keyCode === 13) {
      var stockId = $(this).attr('id');
      var input_value = $(this).val();
      var quantityOnHand = $('#quantityOnHand'+stockId).val();
      input_value = getNumbers(input_value);
      if (input_value >= 0){
        sendDate(stockId, input_value, quantityOnHand);
      }

    }
});
//hiermee stuurt die de data naar de php file
function sendDate(stockId, input_value, quantityOnHand){
  window.location.replace('Cart.php?changeProductToCart=true&input_value='+input_value+'&stockId='+stockId+'&QuantityOnHand='+quantityOnHand);
}


$("#ja").click(function() {
  $("#block_nee").slideUp(200);
  $("#block_ja").slideDown(200);
  $(".adres_button_box_nee").hide(10);
  $(".adres_button_box_ja").show(10);
});

$("#nee").click(function() {
  $("#block_ja").slideUp(200);
  $("#block_nee").slideDown(200);
  $(".adres_button_box_nee").show(10);
  $(".adres_button_box_ja").hide(10);
});
