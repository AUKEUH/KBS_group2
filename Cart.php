<?php
include "header.php";
?>
  <h1 class="winkelwagen_titel">Winkelmand <?php if(!$_SESSION['login']){ echo "(Stap 1/3)"; } ?></h1>
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

?>
<?php

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
          $thisQuantityOnHand = preg_replace('/\D/', '', $stockitem["QuantityOnHand"]);
          print("<tr>");
          print("<input type='hidden' id='quantityOnHand".($stockitem["StockItemID"])."' value='".$thisQuantityOnHand."'>");
          if(isset($StockItemImage[0]['ImagePath'])){
            print("<td><img style='width:120px;' src='Public/StockItemIMG/".$StockItemImage[0]['ImagePath']."'></td>");
          }
          print("<td><a class='cart_product_link' href='view.php?id=". ($stockitem["StockItemID"]) ."'>" . ($stockitem["StockItemName"]) . "</a></td>"); // artikel naam
          print("<td><a class='cart_button_small' href='cart.php?min=true&id=". ($stockitem["StockItemID"]) ."'>-</a></td>");                          // min knop
          print("<td class='cart_text_style'><input step='0.01' id='" . ($stockitem["StockItemID"]) . "' type='text' maxlength='3' class='cart_input_style' value='" . $aantal . "'></td>");                                                                                     // aantal producten
          if ($thisQuantityOnHand > $aantal){ //checkt of het product nog op voorraad is
               print("<td><a class='cart_button_small extra_cart_button_small' href='cart.php?plus=true&id=". ($stockitem["StockItemID"]) ."'> + </a></td>");
          }else{ // zo niet dan krijgt deze knop een class waardoor je deze niet meer gebruiken kan
              print("<td class='cart_button_hover'><a class='cart_button_small_false extra_cart_button_small' href='cart.php?plus=true&id=". ($stockitem["StockItemID"]) ."'> + </a></td>");
          }
          print("<td class='cart_text_style'>" . str_replace('.', ',', sprintf("€ %.2f", number_format((float)$PrijsPerStuk, 2, '.', ''))) . "</td>");       // prijs per stuk
          print("<td class='cart_text_style'>" . str_replace('.', ',', sprintf("€ %.2f", number_format((float)$prijs, 2, '.', ''))) . "</td>");              // prijs per stuk keer het aantal (subtotaal)
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
    if($_SESSION['login']){
        print("<a href='cart.php?order=true' class='cart_button'>Bestellen</a>");
    }
    print("<a href='index.php' class='cart_button'>Verder Winkelen</a>");
    print("<th class='cart_text_style'></th>");
    print("</div>");



}else if(isset($_GET['order-success'])){
    if( $_GET['order-success'] == true ) {
    print('<h3 syle="text-align: center; margin-top: 250px;">Uw bestelling is succesvol ontvangen! (3/3)</h3>');
    print('<a href="index.php" class="cart_button">Terug naar Home</a>');
    }
  }
  else {
    print('<h3>Uw winkelmand is leeg!</h3>');
  }

  if(isset($_SESSION['registerError']) | !$_SESSION['login']){
      print('<div style="text-align: center; padding: 50px 0;">');
      print('<h3 style="color: white;">Uw hoort ingelogd te zijn om een bestelling te kunnen plaatsen 🙂</h3>');
      print('<a href="login.php" class="cart_button" style=" margin-top: 10px;">Inloggen</a>');
      print('<a href="register.php" class="cart_button" style="margin-bottom: 30px;">Registreren</a> <br>');
      print('</div>');
  }
?>

<!-- <div class="cart_buttons_box">
  <a href="cart.php?order=true" class="cart_button">Bestellen</a>
  <a href='index.php' class="cart_button">Verder Winkelen</a>
</div> -->
</body>
</html>
<script src="Public/JS/custom.js"></script>
