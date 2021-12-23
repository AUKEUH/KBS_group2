<?php
include "header.php";


if (isset($_GET["order"])) {              // zelfafhandelend formulier
    saveOrder($databaseConnection);
}
?>

<div class="bar_row">
  <div class="bar_block bar_done">
    Winkelmand
  </div>
  <div class="bar_line bar_done"></div>
  <div class="bar_block bar_done">
    Gevens
  </div>
  <div class="bar_line bar_done"></div>
  <div class="bar_block bar_done">
    Betaling
  </div>
  <div class="bar_line bar_done"></div>
  <div class="bar_block bar_active">
    Overzicht
  </div>
</div>
  <h1 class="winkelwagen_titel">Bestelling gegevens</h1>
  <div class="box_100">
    <div class="bestelling_titel">Producten:</div>
    <div class="bestelling_titel">Adres:</div>
  </div>
  <div class="border_vertical"></div>
<div class="box_100">
  <div class="bestelling_inhoud">
  <?php

    $bestelling = $_SESSION['orderinfo'];
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
  <?php $user = $_SESSION['userinfo']; ?>
    <div class="adres_row">
      <div class="adres_label">Naam: <?php print_r($user['Voornaam'])?></div>
      <div class="adres_label">email: <?php print_r($user['Emailadres'])?></div>
    </div>
      <div class="adres_row">
        <div class="adres_label">Straat: <?php print_r($user['Straat'])?></div>
        <div class="adres_label">huisnummer: <?php print_r($user['Huisnummer'])?></div>
      </div>
    <div class="adres_row">
      <div class="adres_label">plaats: <?php print_r($user['Plaats'])?></div>
      <div class="adres_label">postcode: <?php print_r($user['Postcode'])?></div>
    </div>
  </div>
</div>
<a href="index.php" class="adres_button">Home</a>
</body>
</html>
