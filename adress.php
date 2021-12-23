<?php
include "header.php";
?>

<div class="bar_row">
  <div class="bar_block bar_done">
    Winkelmand
  </div>
  <div class="bar_line bar_done"></div>
  <div class="bar_block bar_active">
    Gevens
  </div>
  <div class="bar_line"></div>
  <div class="bar_block">
    Betaling
  </div>
  <div class="bar_line"></div>
  <div class="bar_block">
    Overzicht
  </div>
</div>
  <h1 class="winkelwagen_titel">Adres:</h1>
  <div class="choice_box">
    <div class="choice_box_row">
      <input type="radio" id="ja" name="adress_choice" value="yes">
      <label for="ja">Gebruik mijn adres</label>
    </div>
    <div class="choice_box_row">
      <input type="radio" id="nee" name="adress_choice" value="no">
      <label for="nee">Ander adres</label>
    </div>
  </div>
  <?php
  $user = getUser($databaseConnection);
  $newuser = $user[0];
  $_SESSION["userinfo"] = $newuser;
  $_SESSION["orderinfo"] = getCart();

  ?>
<div id="block_ja" class="adress_box">
  <div class="adres_box_row">
    <div class="adres_label">Naam: <?php print_r($user[0]['Voornaam'])?></div>
    <div class="adres_label">email: <?php print_r($user[0]['Emailadres'])?></div>
  </div>
    <div class="adres_box_row">
      <div class="adres_label">Straat: <?php print_r($user[0]['Straat'])?></div>
      <div class="adres_label">huisnummer: <?php print_r($user[0]['Huisnummer'])?></div>
    </div>
  <div class="adres_box_row">
    <div class="adres_label">plaats: <?php print_r($user[0]['Plaats'])?></div>
    <div class="adres_label">postcode: <?php print_r($user[0]['Postcode'])?></div>
  </div>
</div>

<div id="block_nee" class="adress_box">
  <form action="betalen.php?saveAdress=true" method="post">
    <div class="adres_box_row">
      <label class="adres_label">Naam: <input required name="naam" type="text" class="adres_box_input" placeholder="henk*"></label>
      <label class="adres_label">email: <input required name="email" type="email" class="adres_box_input" placeholder="example@outlook.com*"></label>
    </div>
      <div class="adres_box_row">
        <label class="adres_label">Straat: <input required name="straat" type="text" class="adres_box_input" placeholder="Romeostraat*"></label>
        <label class="adres_label">huisnummer: <input required name="huisnummer" type="number" class="adres_box_input" placeholder="13b*"></label>
      </div>
    <div class="adres_box_row">
      <label class="adres_label">plaats: <input required name="plaats" type="text" class="adres_box_input" placeholder="Zwolle*"></label>
      <label class="adres_label">postcode: <input required name="postcode" type="text" class="adres_box_input" placeholder="1234AB*"></label>
    </div>
</div>
<div class="adres_button_box_nee">
    <input type='submit' value='Bestelling overzicht' class="adres_button"></a>
</div>
  </form>
<div class="adres_button_box_ja">
    <a href="betalen.php" class="adres_button">Bestelling overzicht</a>
</div>
</body>
</html>
<script src="Public/JS/custom.js"></script>
