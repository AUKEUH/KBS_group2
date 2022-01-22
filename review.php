<?php
//deze pagina zorgt ervoor dat de reviews in de database worden gestopt
require_once 'ophalendata/connect.php';

    /* $sql = "INSERT INTO `reviews`(`id`, `page_id`, `name`, `content`, `rating`)
          VALUES ($id,$page_id,$name,$content,$rating)";

    $statement = mysqli_prepare($connection, $sql);
    mysqli_stmt_execute($statement); */

//zorgt ervoor dat de rating opgehaald wordt
$query = "SELECT AVG (rating) FROM reviews";
$statement = mysqli_prepare($databaseConnection, $query);
mysqli_stmt_execute($statement);
$rating = mysqli_stmt_get_result($statement);
$rating = mysqli_fetch_all($rating, MYSQLI_ASSOC);
?>