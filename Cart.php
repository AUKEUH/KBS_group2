<?php
include "header.php";
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <style link rel="public/css/mijn.css" type="text/css"></style>
    <title>Winkelmand</title>
</head>
<body>
  <h1 class="winkelwagen_titel">Winkelmand</h1>
<?php

// komt door merge conflict (waarschijnlijk useless)
// if (isset($_GET["delete"])) {              // zelfafhandelend formulier
//     $stockItemID = $_GET["id"];
//     removeProductToCart($stockItemID);         // maak gebruik van geïmporteerde functie uit cartfuncties.php
//     header("Refresh:0; url=cart.php");
// }
//
// if (isset($_GET["min"])) {              // zelfafhandelend formulier
//     $stockItemID = $_GET["id"];
//     minProductToCart($stockItemID);         // maak gebruik van geïmporteerde functie uit cartfuncties.php
//     header("Refresh:0; url=cart.php");
// }
//
// if (isset($_GET["plus"])) {              // zelfafhandelend formulier
//     $stockItemID = $_GET["id"];
//     plusProductToCart($stockItemID);         // maak gebruik van geïmporteerde functie uit cartfuncties.php
//     header("Refresh:0; url=cart.php");
// }

if (isset($_GET["delete"])) {              // zelfafhandelend formulier
    $stockItemID = $_GET["id"];
    removeProductToCart($stockItemID);         // maak gebruik van geïmporteerde functie uit cartfuncties.php
    header("Refresh:0; url=cart.php");
}

if (isset($_GET["min"])) {              // zelfafhandelend formulier
    $stockItemID = $_GET["id"];
    minProductToCart($stockItemID);         // maak gebruik van geïmporteerde functie uit cartfuncties.php
    header("Refresh:0; url=cart.php");
}

if (isset($_GET["plus"])) {              // zelfafhandelend formulier
    $stockItemID = $_GET["id"];
    plusProductToCart($stockItemID);         // maak gebruik van geïmporteerde functie uit cartfuncties.php
    header("Refresh:0; url=cart.php");
}

if (isset($_GET["order"])) {              // zelfafhandelend formulier
    saveOrder($databaseConnection);
}


$cart = getCart();
// print_r($cart);

if (!empty($cart)) { //checkt of er iets in de winkel wagen zit
    print('<table class="table table-dark">');
    print('<tr><th>Artikelplaatje</th><th>Artikelnaam</th><th></th><th>Aantal</th><th></th><th>Prijs per stuk</th><th>Subtotaal</th><th></th><tr>');

  $totaal = 0;

  foreach($cart as $number => $aantal){
      $stockitem = getStockItem($number, $databaseConnection);
          // print_r($stockitem);
          // $StockItem["QuantityOnHand"]
      $StockItemImage = getStockItemImage($number, $databaseConnection);


      if (isset($stockitem)){
          $prijs = $aantal * ($stockitem["SellPrice"]- $userKorting);
          $PrijsPerStuk = $stockitem["SellPrice"];
          $totaal = $totaal += $prijs;
          print("<tr>");
          print("<td><img style='width:120px;' src='Public/StockItemIMG/".$StockItemImage[0]['ImagePath']."'></td>");                                    // artikel plaatje
          print("<td><a class='cart_product_link' href='view.php?id=". ($stockitem["StockItemID"]) ."'>" . ($stockitem["StockItemName"]) . "</a></td>"); // artikel naam
          print("<td><a class='cart_button_small' href='cart.php?min=true&id=". ($stockitem["StockItemID"]) ."'>-</a></td>");                          // min knop
          print("<td class='cart_text_style'>" . $aantal . "</td>");                                                                                     // aantal producten
          print("<td><a class='cart_button_small extra_cart_button_small' href='cart.php?plus=true&id=". ($stockitem["StockItemID"]) ."'>+</a></td>");                         // plus knop
          print("<td class='cart_text_style'>" . number_format((float)$PrijsPerStuk, 2, '.', '') . "</td>");       // prijs per stuk
          print("<td class='cart_text_style'>" . number_format((float)$prijs, 2, '.', '') . "</td>");              // prijs per stuk keer het aantal (subtotaal)

          if (preg_replace('/\D/', '', $stockitem["QuantityOnHand"]) > $aantal){ //checkt of het product nog op voorraad is
//                print("<td><a class='cart_button_small' href='cart.php?plus=true&id=". ($stockitem["StockItemID"]) ."'> + </a></td>");
          }else{ // zo niet dan krijgt deze knop een class waardoor je deze niet meer gebruiken kan
              print("<td class='cart_button_hover'><a class='cart_button_small_false' href='cart.php?plus=true&id=". ($stockitem["StockItemID"]) ."'> + </a></td>");
          }
          print("<td><a class='cart_button_small' href='cart.php?delete=true&id=". ($stockitem["StockItemID"]) ."'> Verwijder </a></td>");
          print("</tr>");
      }
  }

    print("<th class='cart_text_style'>Totaal (inc. BTW)</th>");
    print("<th class='cart_text_style'></th>");
    print("<th class='cart_text_style'></th>");
    print("<th class='cart_text_style'>" . number_format((float)$totaal, 2, '.', '') . "</th>");
    print("<th class='cart_text_style'></th>");
    print("<th class='cart_text_style'></th>");
    print("<th class='cart_text_style'></th>");
    print("<div class='cart_buttons_box'>");
    print("<a href='cart.php?order=true' class='cart_button'>Bestellen</a>");
    print("<a href='index.php' class='cart_button'>Verder Winkelen</a>");
    print("<th class='cart_text_style'></th>");
    print("</div>");



}else if(isset($_GET['order-success'])){
    if( $_GET['order-success'] == true ) {
    print('<h3 syle="text-align: center; margin-top: 250px;">Uw bestelling is succesvol ontvangen!</h3>');
    print('<a href="index.php" class="cart_button">Terug naar Home</a>');
    }
  }
  else {
    print('<h3>Uw winkelmand is leeg!</h3>');
  }
?>

<!-- <div class="cart_buttons_box">
  <a href="cart.php?order=true" class="cart_button">Bestellen</a>
  <a href='index.php' class="cart_button">Verder Winkelen</a>
</div> -->
</body>
</html>
