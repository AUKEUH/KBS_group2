<?php

$host = "localhost";
$user = "root";
$pass = "root";
$databaseName = "nerdygadgets";
$port = 3306;
$connection = mysqli_connect($host, $user, $pass, $databaseName, $port);


$sql = "SELECT * FROM medewerker WHERE afd=30";
$sql = "INSERT INTO `medewerker` (naam,voorl,chef,afd) 
    VALUES ('Twan','T', 300 , 20);";


$statement = mysqli_prepare($connection, $sql);
mysqli_stmt_execute($statement);
$result = mysqli_stmt_get_result($statement);

// loop stuk voor stuk langs alle resultaten
//while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
//{
//    $maandsal =$row["maandsal"];
//    print($maandsal . "<br>");
//
//}

//fetch alle gegevens in een associative array $medewerkers
//$medewerkers = mysqli_fetch_all($result, MYSQLI_ASSOC);

//$naam = trim(fgets(STDIN));
//$voorl = trim(fgets(STDIN));
//$chef = trim(fgets(STDIN));
//$afd = trim(fgets(STDIN));


//$statement = mysqli_prepare($connection, $sql);
////mysqli_stmt_bind_param($statement, 'ssii', $naam, $voorl, $chef, $afd);
//mysqli_stmt_execute($statement);
//$result = mysqli_stmt_get_result($statement);
//
//mysqli_free_result($result);
//mysqli_close($connection);
?>
<table>
  <tr>
    <th>naam</th>
    <th>voorl</th>
    <th>chef</th>
    <th>afd</th>
  </tr>
<?php

$sql = "SELECT * FROM medewerker";

$statement = mysqli_prepare($connection, $sql);
mysqli_stmt_execute($statement);
$result = mysqli_stmt_get_result($statement);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $naam = $row["naam"];
    $voorl = $row["voorl"];
    $chef = $row["chef"];
    $afd = $row["afd"];
    print(
        "<tr>
        <td>" . $naam . "<td> 
        <td>" . $voorl . "<td> 
        <td>" . $chef . "<td>
        <td>" . $afd . "<td>
      <tr>"
    );

}
?>
</table>

<form class="" action="update.php" method="post">
    <input type="submit" value="verhoog salaris 2%">
</form>