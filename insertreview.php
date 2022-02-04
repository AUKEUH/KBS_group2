<?php
require_once 'connect.php';
require_once 'header.php';


$content = $_POST["review"];
$ratingsgetaltoe = $_POST["ratingsgetal"];
$naam = $_SESSION["Voornaam"];



$sql = "INSERT INTO `reviews`(`name`, `content`, `rating`, `StockItemID`)
        VALUES ('$naam','$content','$ratingsgetaltoe','$stockItemID')";

$statement = mysqli_prepare($connection, $sql);
// mysqli_stmt_bind_param($statement, 'i', $gebruikersinput);
mysqli_stmt_execute($statement);
$result = mysqli_stmt_get_result($statement);

header("Refresh:0; url=/index.php");