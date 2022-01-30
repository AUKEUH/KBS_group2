<!-- dit bestand bevat alle code die verbinding maakt met de database -->
<?php

function connectToDatabase() {
    $Connection = null;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
    try {
        $Connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
        mysqli_set_charset($Connection, 'latin1');
        $DatabaseAvailable = true;
    } catch (mysqli_sql_exception $e) {
        $DatabaseAvailable = false;
    }
    if (!$DatabaseAvailable) {
        ?><h2>Website wordt op dit moment onderhouden.</h2><?php
        die();
    }

    return $Connection;
}

function getHeaderStockGroups($databaseConnection) {
    $Query = "
                SELECT StockGroupID, StockGroupName, ImagePath
                FROM stockgroups
                WHERE StockGroupID IN (
                                        SELECT StockGroupID
                                        FROM stockitemstockgroups
                                        ) AND ImagePath IS NOT NULL
                ORDER BY StockGroupID ASC";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $HeaderStockGroups = mysqli_stmt_get_result($Statement);
    return $HeaderStockGroups;
}

function getStockGroups($databaseConnection) {
    $Query = "
            SELECT StockGroupID, StockGroupName, ImagePath
            FROM stockgroups
            WHERE StockGroupID IN (
                                    SELECT StockGroupID
                                    FROM stockitemstockgroups
                                    ) AND ImagePath IS NOT NULL
            ORDER BY StockGroupID ASC";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $StockGroups = mysqli_fetch_all($Result, MYSQLI_ASSOC);
    return $StockGroups;
}

function getStockItem($id, $databaseConnection) {
    $Result = null;

    $Query = "
           SELECT SI.StockItemID,
            (RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice,
            StockItemName,
            CONCAT('Voorraad: ',QuantityOnHand)AS QuantityOnHand,
            SearchDetails,
            (CASE WHEN (RecommendedRetailPrice*(1+(TaxRate/100))) > 50 THEN 0 ELSE 6.95 END) AS SendCosts, MarketingComments, CustomFields, SI.Video,
            (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath
            FROM stockitems SI
            JOIN stockitemholdings SIH USING(stockitemid)
            JOIN stockitemstockgroups ON SI.StockItemID = stockitemstockgroups.StockItemID
            JOIN stockgroups USING(StockGroupID)
            WHERE SI.stockitemid = ?
            GROUP BY StockItemID";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $id);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    if ($ReturnableResult && mysqli_num_rows($ReturnableResult) == 1) {
        $Result = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC)[0];
    }

    return $Result;
}

function getStockItemImage($id, $databaseConnection) {

    $Query = "
                SELECT ImagePath
                FROM stockitemimages
                WHERE StockItemID = ?";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $id);
    mysqli_stmt_execute($Statement);
    $R = mysqli_stmt_get_result($Statement);
    $R = mysqli_fetch_all($R, MYSQLI_ASSOC);

    return $R;
}

function getUser($databaseConnection) {

    $Query = "SELECT
      *
    FROM
      `registratiedata`
    WHERE
      registratieId = ?";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $_SESSION['RegistratieId']);
    mysqli_stmt_execute($Statement);
    $R = mysqli_stmt_get_result($Statement);
    $R = mysqli_fetch_all($R, MYSQLI_ASSOC);

    return $R;
}
function review($databaseConnection, $stockItemID) {
    $query = "SELECT content from reviews where StockItemID = $stockItemID";
    $statement = mysqli_prepare($databaseConnection, $query);
    mysqli_stmt_execute($statement);
    $text = mysqli_stmt_get_result($statement);
    $text = mysqli_fetch_all($text, MYSQLI_ASSOC);

    return $text;
}
//function Reviews ($stockItemID, $databaseConnection) {
//
//    $Query = "
//                SELECT id
//                FROM reviews
//                WHERE StockItemID = $stockItemID";
//
//    $Statement = mysqli_prepare($databaseConnection, $Query);
//    mysqli_stmt_bind_param($Statement,"i", $stockItemID);
//    mysqli_stmt_execute($Statement);
//    $content = mysqli_stmt_get_result($Statement);
//    $content = mysqli_fetch_all($content, MYSQLI_ASSOC);
//
//    return $content;
//}
// placeOrderRow($cart, $databaseConnection){
//     $Query = "INSERT INTO orders (CustomerID, OrderDate, OrderStatus, OrderTotal) VALUES (?, ?, ?, ?)";
//     $Statement = mysqli_prepare($databaseConnection, $Query);
//     mysqli_stmt_bind_param($Statement, "issd", $CustomerID, $OrderDate, $OrderStatus, $OrderTotal);
//     mysqli_stmt_execute($Statement);
//     $OrderID = mysqli_insert_id($databaseConnection);
//     return $OrderID;

// }

// function placeOrderLine($orderId, $productId, $quantity){
//     $query = "INSERT INTO bestelling_lines (BestellingID, ProductID, quantity) VALUES (?, ?, ?)";
//     $statement = mysqli_prepare($databaseConnection, $query);
//     mysqli_stmt_bind_param($statement, "iii", $BestellingID, $id, $quantity);
//     mysqli_stmt_execute($statement);
// }

// function getLastOrder($userId){
//     $query = "SELECT * FROM bestellingen WHERE CustomerID = ? ORDER BY OrderID DESC LIMIT 1";
//     $statement = mysqli_prepare($databaseConnection, $query);
//     mysqli_stmt_bind_param($statement, "i", $userId);
//     mysqli_stmt_execute($statement);
//     $result = mysqli_stmt_get_result($statement);
//     $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
//     return $result;
// }
//
// function getUserOrders($userId){
//     $query = "SELECT * FROM bestellingen WHERE CustomerID = ?";
//     $statement = mysqli_prepare($databaseConnection, $query);
//     mysqli_stmt_bind_param($statement, "i", $userId);
//     mysqli_stmt_execute($statement);
//     $result = mysqli_stmt_get_result($statement);
//     $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
//     return $result;
// }
//
// function getOrderLines($orderId){
//     $query = "SELECT * FROM bestelling_lines WHERE BestellingID = ?";
//     $statement = mysqli_prepare($databaseConnection, $query);
//     mysqli_stmt_bind_param($statement, "i", $orderId);
//     mysqli_stmt_execute($statement);
//     $result = mysqli_stmt_get_result($statement);
//     $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
//     return $result;
// }

function placeOrder($cart, $databaseConnection) {
    // Maak dit dynamisch zodra registratie/login werkt door de ID van gebruiker op te halen.
    if($_SESSION["login"]){
        if(isset($_SESSION['RegistratieId'])){
            $sql = "INSERT INTO bestellingen (PersonID) VALUES (". $_SESSION['RegistratieId'] .");";

            if(mysqli_query($databaseConnection, $sql)){
                $last_id = mysqli_insert_id($databaseConnection);

                foreach ($cart as $productId => $quantity) {
                if ($quantity > 0) {
                    $q3 = "INSERT INTO bestelling_lines (BestellingID, ProductID, quantity) VALUES ('$last_id', '$productId', '$quantity');";
                    mysqli_query($databaseConnection, $q3);
                }
                }
            }
            $_SESSION['cart'] = array();
        }
    } else{
        $_SESSION['registerError'] = "Uw hoort ingelogd te zijn om een bestelling te kunnen plaatsen.";
    }
}

function updateStock($cart, $databaseConnection) {

  foreach ($cart as $productId => $aantal) {
    $Query = "

      UPDATE stockitemholdings
      SET QuantityOnHand = QuantityOnHand-?
      WHERE StockItemID =?;

        ";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "ii", $aantal, $productId);
    mysqli_stmt_execute($Statement);
  }

}
