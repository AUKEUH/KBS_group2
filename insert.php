<?php
require_once 'connect.php';
require_once '../CartFuncties.php';

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

$hashed = password_hash(hash('sha512', $wachtwoord), PASSWORD_DEFAULT);

$sql = "INSERT INTO `registratiedata`(`Voornaam`, `Achternaam`, `Geboortedatum`, `Emailadres`, `Telefoonnummer`, `Straat`, `Huisnummer`, `Postcode`, `Plaats`,`Wachtwoord`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$statement = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($statement, 'ssssssdsss', $voornaam, $achternaam, $geboorte, $emailadres, $telefoonnummer, $straat, $huisnummer, $postcode, $plaats, $hashed);
mysqli_stmt_execute($statement);
$result = mysqli_stmt_get_result($statement);

header("Refresh:0; url=../login.php");