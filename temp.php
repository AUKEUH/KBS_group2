<?php
require_once 'ophalendata/connect.php';

// Stond aanvankelijk $_SESSION i.p.v. $_GET, aangepast. Werkt nu. - Misha
 if(isset($_GET['secret']) && $_GET['secret'] === "geheimwachtwoord"){

     $temp = $_GET['temp'];

     // 
     $sql = "INSERT INTO coldroomtemperatures (ColdRoomSensorNumber, RecordedWhen, Temperature, ValidFrom, ValidTo) VALUES (5, NOW(),${temp}, NOW(), NOW() + INTERVAL 1 HOUR)";
     $statement = mysqli_prepare($connection, $sql);
     // mysqli_stmt_execute returnt niet de daadwerkelijke resultaat, maar een boolean op basis van of alless successvol is uitgevoerd. - Misha
     mysqli_stmt_execute($statement);
     // Hiermee wordt het resultaat opgehaald van de query. - Misha

     // Verwijderd de laatste record in roomtemeratures, de trigger van coldroomtemperatures_archive zorgt ervoor dat de hoogste ID wordt gearchiveerd in de tussentijd. - Misha
     $query = "DELETE FROM `coldroomtemperatures` ORDER BY `ColdRoomTemperatureID` ASC LIMIT 1";
     $s = mysqli_prepare($connection, $query);
     mysqli_stmt_execute($s);

 }
 ?>
