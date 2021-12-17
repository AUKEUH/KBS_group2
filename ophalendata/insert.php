<?php
require_once 'connect.php';

$voornaam = $_POST["voornaam"];
$achternaam = $_POST["achternaam"];
$geboorte = $_POST["geboorte"];
$emailadres = $_POST["emailadres"];
$telefoonnummer = $_POST["telefoonnummer"];
$straat = $_POST["straat"];
$huisnummer = $_POST["huisnummer"];
$postcode = $_POST["postcode"];
$plaats = $_POST["plaats"];
$wachtwoord = $_POST["wachtwoord"];

$sql = "INSERT INTO `registratiedata`(`Voornaam`, `Achternaam`, `Geboortedatum`, `Emailadres`, `Telefoonnummer`, `Straat`, `Huisnummer`, `Postcode`, `Plaats`,`Wachtwoord`)
        VALUES ('$voornaam','$achternaam','$geboorte','$emailadres','$telefoonnummer','$straat','$huisnummer','$postcode','$plaats','$wachtwoord')";

  $statement = mysqli_prepare($connection, $sql);
  // mysqli_stmt_bind_param($statement, 'i', $gebruikersinput);
  mysqli_stmt_execute($statement);
  $result = mysqli_stmt_get_result($statement);

 header("Refresh:0; url=http://localhost/git/KBS_group2/login.php");
