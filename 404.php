<?php

include_once 'header.php';

function getRandomProducts() {
    global $databaseConnection;
    // Haalt alle stock items op in een willekeurige volgorde, met 6 als maximum.
    $query = "SELECT * from StockItems ORDER BY RAND() LIMIT 6";
    // Prepared de query met eventuele variabelen / zorgt ervoor dat de query niet wordt uitgevoerd als de query niet geldig is.
    $statement = mysqli_prepare($databaseConnection, $query);
    // Voert de query uit.
    mysqli_stmt_execute($statement);
    // Haalt het resultaat van het statement op.
    $response = mysqli_stmt_get_result($statement);
    // Haalt het resultaat op als een array.
    $response = mysqli_fetch_all($response, MYSQLI_ASSOC);
    return $response;
}
/*
Functie haalt product op op basis van het StockItemID. 
*/
function getImageByStockItemId($id) {
    // Geeft aan dat $databaseConnection een globaal variabele is.
    global $databaseConnection;
    // Query om een product op te halen op basis van het StockItemID.
    $query = "SELECT ImagePath from stockitemimages WHERE StockItemID = ? LIMIT 1";
    // Zorgt ervoor dat de query niet wordt uitgevoerd als de query niet geldig is.
    $statement = mysqli_prepare($databaseConnection, $query);
    // Vult op een veilige manier de variabelen in de statement.
    mysqli_stmt_bind_param($statement, "i", $id);
    // Voert de query uit.
    mysqli_stmt_execute($statement);
    // Haalt het resultaat van het statement op.
    $response = mysqli_stmt_get_result($statement);
    // Haalt het resultaat op als een array.
    $response = mysqli_fetch_all($response, MYSQLI_ASSOC);
    // Geeft het resultaat terug.
    return $response;
}

function berekenVerkoopPrijs($adviesPrijs, $btw) {
    return $btw * $adviesPrijs / 100 + $adviesPrijs;
}

?>

<h2 id="NoSearchResults">
    Yarr, we hebben deze pagina niet kunnen vinden! Wellicht heb je hier wat aan:
</h2>
<div class="container">
    <div class="row" style="color: white;">
        <?php
        // Loop door alle producten dat door getRandomProducts() wordt teruggestuurd
        foreach (getRandomProducts() as $product) {
            // Bereken de verkoopprijs inclusief BTW d.m.v. product UnitPrice en TaxRate. Rond dit af op 2 decimalen en vervang de punt door een komma(number_format).
            $sellPrice = number_format(berekenVerkoopPrijs($product["UnitPrice"],  $product["TaxRate"]), 2, ',', '.');
            ?>
            <div class="col-sm-4">
                <div class="card" style="background-color: rgb(22 22 36); margin-top: 15px; min-height: 400px;">
                    <div class="card-body">
                        <h5 class="card-title" style="text-align: center; margin: 15px 0;"><?php print $product["StockItemName"] ?></h5>
                        <?php // Gebruikt getImageByStockItemId functie om de desbetreffende filename op te halen d.m.v. het StockItemID van het geloopte product ?>
                        <img src="Public/StockItemIMG/<?php print getImageByStockItemId($product["StockItemID"])[0]['ImagePath'] ?>" style="max-width: 70%; max-height: 200px; padding: 0 30px; margin: 0 auto; display: block;" alt="">
                        <?php // Gebruikt de UnitPrice en  ?>
                        <p class="card-text" style="font-size: 24px; font-weight: bold; position: absolute; bottom: 50px; left: 30px;">€ <?php print $sellPrice ?></p>
                        <a href="view.php?id=<?php print $product["StockItemID"]; ?>" class="btn btn-primary" style="width: 100%; position: absolute; bottom: 0; left: 0;">Bekijk
                            product</a>
                    </div>
                </div>
            </div>
        <?php } 

        // Basically dezelfde implementatie als in 
        $HeaderStockGroups = getHeaderStockGroups($databaseConnection);
        print "<ul style='display: block; margin: 45px auto;'>";
        foreach ($HeaderStockGroups as $HeaderStockGroup) {
            ?>

            <li style="list-style-type: none; display: inline-block; margin-left: 15px;">
                <a style="text-decoration: none; color: white; font-size: 24px; font-weight: bold;" href="browse.php?category_id=<?php print $HeaderStockGroup['StockGroupID']; ?>"
                    style=""><?php print $HeaderStockGroup['StockGroupName']; ?></a>
            </li>
            <?php
        }
        print "</ul>";
        ?>
    </div>
</div>