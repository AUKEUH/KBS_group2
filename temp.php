<?php
require_once 'ophalendata/connect.php';

// Stond aanvankelijk $_SESSION i.p.v. $_GET, aangepast. Werkt nu. - Misha
 if(isset($_GET['secret']) && $_GET['secret'] === "geheimwachtwoord"){

     $temp = $_GET['temp'];

     $sql = "INSERT INTO `coldroomtemperatures`(`ColdRoomSensorNumber`, `RecordedWhen`, `Temperature`, `ValidFrom`, `ValidTo`)
          VALUES ('1','NOW()','$temp','NOW()','9999-12-31')";

     $statement = mysqli_prepare($connection, $sql);
    
    // mysqli_stmt_execute returnt niet de daadwerkelijke resultaat, maar een boolean op basis van of alless successvol is uitgevoerd. - Misha
    mysqli_stmt_execute($statement);
    // Hiermee wordt het resultaat opgehaald van de query. - Misha
    $response = mysqli_stmt_get_result($statement);
 }
 ?>
