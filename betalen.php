<?php
include "header.php";

if (isset($_GET["saveAdress"])) {//save custom adress
    $user = Array (
      'Voornaam' => $_POST['naam'],
      'Straat' => $_POST['straat'],
      'Emailadres' => $_POST['email'],
      'Huisnummer' => $_POST['huisnummer'],
      'Postcode'=> $_POST['postcode'],
      'Plaats' => $_POST['plaats']  );
    $_SESSION["userinfo"] = $user;
    header("Refresh:0; url=betalen.php");
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
  <div class="bar_block bar_active">
    Betaling
  </div>
  <div class="bar_line"></div>
  <div class="bar_block">
    Overzicht
  </div>
</div>

<a href="bestelling.php?order=true" class="betalen_button">Betalen</a>
</body>
</html>
