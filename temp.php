<?php
require_once 'ophalendata/connect.php';

 if(isset($_SESSION['secret']) && $_SESSION['secret'] === "geheimwachtwoord"){

     $temp = $_GET['temp'];

     $sql = "INSERT INTO `coldroomtemperatures`(`ColdRoomSensorNumber`, `RecordedWhen`, `Temperature`, `ValidFrom`, `ValidTo`)
          VALUES ('1','NOW()','$temp','NOW()','9999-12-31')";

     $statement = mysqli_prepare($connection, $sql);
     // mysqli_stmt_bind_param($statement, "i", $temp);
     mysqli_stmt_execute($statement);
 }
 ?>
