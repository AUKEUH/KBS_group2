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
  <h1 class="winkelwagen_titel">Bestelling gegevens</h1>
  <div class="box_100">
    <div class="bestelling_titel">Producten:</div>
    <div class="bestelling_titel">Adres:</div>
  </div>
<div class="box_100">
  <div class="bestelling_inhoud">
  <?php

    $bestelling = $cart;
    $totaal = 0;

    if (!empty($bestelling)) { //checkt of er iets in de winkel wagen zit
      foreach ($bestelling as $number => $aantal) {
        $stockitem = getStockItem($number, $databaseConnection);
        $StockItemImage = getStockItemImage($number, $databaseConnection);

        $prijs = $aantal * ($stockitem["SellPrice"]- $userKorting);
        $PrijsPerStuk = $stockitem["SellPrice"];
        $totaal = $totaal += $prijs;
        print("<div class='order_row'>");
        if(isset($StockItemImage[0]['ImagePath'])){
          print("<div><img style='width:120px;' src='Public/StockItemIMG/".$StockItemImage[0]['ImagePath']."'></div>");
        }
        print("<div class='order_text_perstuk'>" . str_replace('.', ',', sprintf("€ %.2f", number_format((float)$PrijsPerStuk, 2, '.', ''))) . " per stuk</div>");       // prijs per stuk
        print("<div class='order_text_aantal'>aantal: " . $aantal . "</div>");                                                                                     // aantal producten
        print("<div><a class='cart_product_link order_margin_right' href='view.php?id=". ($stockitem["StockItemID"]) ."'>" . ($stockitem["StockItemName"]) . "</a></div>"); // artikel naam
        print("<div class='order_text_style'>totaal: " . str_replace('.', ',', sprintf("€ %.2f", number_format((float)$prijs, 2, '.', ''))) . "</div>");              // prijs per stuk keer het aantal (subtotaal)
        print("</div>");
      }
    }else{
      echo '<h4>Bestelling is niet gelukt!</h4>';
    }
  ?>

  </div>
  <div class="bestelling_inhoud">
    <div class="margintop_60"></div>
    <div class="adres_row">
      <div class="adres_label">Naam: Henk</div>
      <div class="adres_label">email: henk@gmail.com</div>
    </div>
      <div class="adres_row">
        <div class="adres_label">Straat: Dropsweg</div>
        <div class="adres_label">huisnummer: 103</div>
      </div>
    <div class="adres_row">
      <div class="adres_label">plaats: Utrecht</div>
      <div class="adres_label">postcode: 3738CC</div>
    </div>
  </div>
</div>
</body>
</html>
