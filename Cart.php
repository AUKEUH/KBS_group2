<?php
include "cartfuncties.php";
include "header.php";
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <style link rel="public/css/mijn.css" type="text/css"></style>
    <title>Winkelwagen</title>
</head>
<body>
<h1>Inhoud Winkelwagen</h1>


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
    header("Refresh:0; url=cart.php");
}


$cart = getCart();
print_r($cart);

if (!empty($cart)) { //checkt of er iets in de winkel wagen zit
  print('<table class="table table-dark">');
  print('<tr><th>Artikelplaatje</th><th>Artikelnaam</th><th>Aantal</th><th>Prijs</th><tr>');

  $totaal = 0;

  foreach($cart as $number => $aantal)
  {
      $stockitem = getStockItem($number, $databaseConnection);
          // print_r($stockitem);
          // $StockItem["QuantityOnHand"]
      $StockItemImage = getStockItemImage($number, $databaseConnection);


      if (isset($stockitem)){
          $prijs = $aantal * ($stockitem["SellPrice"]);
          $totaal = $totaal += $prijs;
          print("<tr>");
          print("<td><img style='width:120px;' src='Public/StockItemIMG/".$StockItemImage[0]['ImagePath']."'></td>");
          print("<td><a class='cart_product_link' href='view.php?id=". ($stockitem["StockItemID"]) ."'>" . ($stockitem["StockItemName"]) . "</a></td>");
          print("<td>" . $aantal . "</td>");
          print("<td>" . number_format((float)$prijs, 2, '.', '') . "</td>");
          print("<td><a class='cart_button_small' href='cart.php?min=true&id=". ($stockitem["StockItemID"]) ."'> - </a></td>");
          if (preg_replace('/\D/', '', $stockitem["QuantityOnHand"]) > $aantal){ //checkt of het product nog op voorraad is
            print("<td><a class='cart_button_small' href='cart.php?plus=true&id=". ($stockitem["StockItemID"]) ."'> + </a></td>");
          }else{ // zo niet dan krijgt deze knop een class waardoor je deze niet meer gebruiken kan
            print("<td class='cart_button_hover'><a class='cart_button_small_false' href='cart.php?plus=true&id=". ($stockitem["StockItemID"]) ."'> + </a></td>");
          }
          print("<td><a class='cart_button_small' href='cart.php?delete=true&id=". ($stockitem["StockItemID"]) ."'> Verwijder </a></td>");
          print("</tr>");
      }


  }


  print("<th>Totaal</th>");
  print("<td></td>");
  print("<td></td>");
  print("<td>" . number_format((float)$totaal, 2, '.', '') . "</td>");

}else{ // winkelwagen is leeg
  print("<h2>Winkelwagen is leeg</h2>");
}

?>

<div class="cart_buttons_box">
  <a href="cart.php?order=true" class="cart_button">Bestellen</a>
  <a href='index.php' class="cart_button">Verder Winkelen</a>
</div>
</body>
</html>
