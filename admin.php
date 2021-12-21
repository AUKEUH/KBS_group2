<?php
include "cartfuncties.php";
include "header.php";
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
</head>
<body>
<h1>cart data:</h1>
<?php
$cart = getCart();
print_r($cart);
?>
<h1>Voorraad:</h1> <?php
foreach($cart as $number => $aantal)
{
  echo 'product nummer: ' .$number;
  echo "<br>";
  $stockitem = getStockItem($number, $databaseConnection);
  echo "voorraad: ";
  echo $stockitem["QuantityOnHand"];
  echo '<hr>';
}
?>
