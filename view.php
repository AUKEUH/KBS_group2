<!-- dit bestand bevat alle code voor de pagina die één product laat zien -->
<?php
include __DIR__ . "/header.php";

    //?id=1 handmatig meegeven via de URL (gebeurt normaal gesproken als je via overzicht op artikelpagina terechtkomt)
    if (isset($_GET["id"])) {
        $stockItemID = $_GET["id"];
    } else {
        $stockItemID = 0;
    }

    if (isset($_GET["submit"])) {              // zelfafhandelend formulier
        $stockItemID = $_GET["id"];
        addProductToCart($stockItemID);         // maak gebruik van geïmporteerde functie uit cartfuncties.php
        header("Refresh:0; url=view.php?id=$stockItemID&succes=true");

    }

$query = "SELECT Temperature FROM coldroomtemperatures ORDER BY ColdRoomTemperatureID DESC";
$statement = mysqli_prepare($databaseConnection, $query);
mysqli_stmt_execute($statement);
$result = mysqli_stmt_get_result($statement);
$result = mysqli_fetch_all($result, MYSQLI_ASSOC);

$query = "SELECT AVG (rating) FROM reviews";
$statement = mysqli_prepare($databaseConnection, $query);
mysqli_stmt_execute($statement);
$rating = mysqli_stmt_get_result($statement);
$rating = mysqli_fetch_all($rating, MYSQLI_ASSOC);

$StockItem = getStockItem($_GET['id'], $databaseConnection);
$StockItemImage = getStockItemImage($_GET['id'], $databaseConnection);
function getVoorraadTekst($actueleVoorraad) {
    if (filter_var($actueleVoorraad, FILTER_SANITIZE_NUMBER_INT) > 1000){
        return "Ruime voorraad beschikbaar.";
    }else{
        return "$actueleVoorraad";
    }
  }
?>
<div id="CenteredContent">
    <?php
    if ($StockItem != null) {
        ?>
        <?php
        if (isset($StockItem['Video'])) {
            ?>
            <div id="VideoFrame">
                <?php print $StockItem['Video']; ?>
            </div>
        <?php }
        ?>


        <div id="ArticleHeader">
            <?php
            if (isset($StockItemImage)) {
                // één plaatje laten zien
                if (count($StockItemImage) == 1) {
                    ?>
                    <div id="ImageFrame"
                         style="background-image: url('Public/StockItemIMG/<?php print $StockItemImage[0]['ImagePath']; ?>'); background-size: cover;"></div>
                    <?php
                } else if (count($StockItemImage) >= 2) { ?>
                    <!-- meerdere plaatjes laten zien -->
                    <div id="ImageFrame">
                        <div id="ImageCarousel" class="carousel slide" data-interval="false">
                            <!-- Indicators -->
                            <ul class="carousel-indicators">
                                <?php for ($i = 0; $i < count($StockItemImage); $i++) { ?>
                                    <li data-target="#ImageCarousel"
                                        data-slide-to="<?php print $i ?>" <?php print (($i == $i) ? 'class="active"' : 'class="active"'); ?>></li>
                                    <?php
                                } ?>
                            </ul>

                            <!-- slideshow -->
                            <div class="carousel-inner">
                                <?php for ($i = 0; $i < count($StockItemImage); $i++) {
                                    ?>
                                    <div class="carousel-item <?php print ($i == 1) ? 'active' : ''; ?>">
                                        <img src="Public/StockItemIMG/<?php print $StockItemImage[$i]['ImagePath'] ?>">
                                    </div>
                                <?php } ?>
                            </div>

                            <!-- knoppen 'vorige' en 'volgende' -->
                            <a class="carousel-control-prev" href="#ImageCarousel" data-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </a>
                            <a class="carousel-control-next" href="#ImageCarousel" data-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div id="ImageFrame"
                     style="background-image: url('Public/StockGroupIMG/<?php print $StockItem['BackupImagePath']; ?>'); background-size: cover;"></div>
                <?php
            }
            ?>


            <h1 class="StockItemID">Artikelnummer: <?php print $StockItem["StockItemID"]; ?></h1>
            <h2 class="StockItemNameViewSize StockItemName">
                <?php print $StockItem['StockItemName']; ?>
            </h2>

                        <?php
                        echo "De huidige temperatuur van dit product: " . $result[0]['Temperature'];  ?>
        </br>
            <?php
                        echo "De gemiddelde rating van dit product: " . sprintf("%01.1f",$rating[0]['AVG (rating)']);
            ?>
            <?php
            $actueleVoorraad = filter_var($StockItem["QuantityOnHand"], FILTER_SANITIZE_NUMBER_INT);
            if ($actueleVoorraad > 0 && $actueleVoorraad < 21){
              print("<div class='bijna_uitverkocht'>Bijna uitverkocht!</div>");
            }
              ?>
            <div class="QuantityText"><?php print getVoorraadTekst($StockItem["QuantityOnHand"]); ?>
              <div class="info_icon_block"><i class='fas fa-info-circle'></i></div>
              <div class="show_info_block">Je product wordt niet gereserveerd. Dus koop je product snel!</div>
            </div>


            <div id="StockItemHeaderLeft">
                <div class="CenterPriceLeft">
                    <div class="CenterPriceLeftChild">
                        <p class="StockItemPriceText"><b><?php print str_replace('.', ',', sprintf("€ %.2f", $StockItem['SellPrice'] - $userKorting)); ?></b></p>
                        <h6> Inclusief BTW </h6>
                            <input type="number" name="stockItemID" value="<?php print($stockItemID) ?>" hidden>
                            <?php $cart = getCart();
                                    if (isset($cart[$stockItemID])) {
                                      $cart_aantal = $cart[$stockItemID];
                                    }else{
                                      $cart_aantal = 0;
                                    }
                                    if (preg_replace('/\D/', '', $StockItem["QuantityOnHand"]) > $cart_aantal){ //checkt of het product nog op voorraad is
                                      ?><a class="winkelmand_button" href="view.php?submit=true&id=<?php print($stockItemID)?>">Voeg toe aan winkelmand</a>
                                      <?php
                                    }else{ // zo niet dan krijgt deze knop een class waardoor je deze niet meer gebruiken kan
                                      ?><div class="cart_button_hover"><div class="winkelmand_button" >Voeg toe aan winkelmand</div></div><?php
                                    }
                                    if (isset($_GET['succes'])){
                                      print("<h6>Product is toegevoegd aan winkel mand</h6>");
                                      print("<a href='cart.php' class='view_button_cart'>Naar winkelmand</a>");
                                    }


                                    ?>
                            <!-- <input type="submit" name="submit" value="Voeg toe aan winkelmandje"> -->
                    </div>
                </div>
            </div>
        </div>

        <div id="StockItemDescription">
            <h3>Artikel beschrijving</h3>
            <p><?php print $StockItem['SearchDetails']; ?></p>
        </div>
        <div id="StockItemSpecifications">
            <h3>Artikel specificaties</h3>
            <?php
            $CustomFields = json_decode($StockItem['CustomFields'], true);
            if (is_array($CustomFields)) { ?>
                <table>
                <thead>
                <th>Naam</th>
                <th>Data</th>
                </thead>
                <?php
                foreach ($CustomFields as $SpecName => $SpecText) { ?>
                    <tr>
                        <td>
                            <?php print $SpecName; ?>
                        </td>
                        <td>
                            <?php
                            if (is_array($SpecText)) {
                                foreach ($SpecText as $SubText) {
                                    print $SubText . " ";
                                }
                            } else {
                                print $SpecText;
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                </table><?php
            } else { ?>

                <p><?php print $StockItem['CustomFields']; ?>.</p>
                <?php
            }
            ?>
        </div>
        <?php
    } else {
        header("Refresh:0; url=http://localhost/git/KBS_group2/404.php");
        ?>

    <?php
    if (isset($ReturnableResult) && count($ReturnableResult) > 0) {
        foreach ($ReturnableResult as $row) {
            ?>
            <!--  coderegel 1 van User story: bekijken producten  -->
    <a class="ListItem" href='view.php?id=<?php print $row['StockItemID']; ?>'>



            <!-- einde coderegel 1 van User story: bekijken producten   -->
                <div id="ProductFrame">
                    <?php
                    if (isset($row['ImagePath'])) { ?>
                        <div class="ImgFrame"
                             style="background-image: url('<?php print "Public/StockItemIMG/" . $row['ImagePath']; ?>'); background-size: cover;"></div>
                    <?php } else if (isset($row['BackupImagePath'])) { ?>
                        <div class="ImgFrame"
                             style="background-image: url('<?php print "Public/StockGroupIMG/" . $row['BackupImagePath'] ?>'); background-size: cover;"></div>
                    <?php }
                    ?>

                    <div id="StockItemFrameRight">
                        <div class="CenterPriceLeftChild">
                            <h1 class="StockItemPriceText"><?php print str_replace('.', ',', sprintf(" %0.2f", berekenVerkoopPrijs($row["RecommendedRetailPrice"], $row["TaxRate"])- $userKorting)); ?></h1>
                            <h6>Inclusief BTW </h6>
                        </div>
                    </div>
                    <h1 class="StockItemID">Artikelnummer: <?php print $row["StockItemID"]; ?></h1>
                    <p class="StockItemName"><?php print $row["StockItemName"]; ?></p>
                    <p class="StockItemComments"><?php print $row["MarketingComments"]; ?></p>
                    <h4 class="ItemQuantity"><?php print getVoorraadTekst($row["QuantityOnHand"]); ?></h4>
                </div>
            <!--  coderegel 2 van User story: bekijken producten  -->



            <!--  einde coderegel 2 van User story: bekijken producten  -->
        <?php } ?>

        <form id="PageSelector">

<!-- code deel 4 van User story: Zoeken producten  -->

<input type="hidden" name="search_string" id="search_string"
       value="<?php if (isset($_GET['search_string'])) {
           print ($_GET['search_string']);
       } ?>">
<input type="hidden" name="sort" id="sort" value="<?php print ($_SESSION['sort']); ?>">


<!-- einde code deel 4 van User story: Zoeken producten  -->
            <input type="hidden" name="category_id" id="category_id" value="<?php if (isset($_GET['category_id'])) {
                print ($_GET['category_id']);
            } ?>">
            <input type="hidden" name="result_page_numbers" id="result_page_numbers"
                   value="<?php print (isset($_GET['result_page_numbers'])) ? $_GET['result_page_numbers'] : "0"; ?>">
            <input type="hidden" name="products_on_page" id="products_on_page"
                   value="<?php print ($_SESSION['products_on_page']); ?>">

            <?php
            if ($AmountOfPages > 0) {
                for ($i = 1; $i <= $AmountOfPages; $i++) {
                    if ($PageNumber == ($i - 1)) {
                        ?>
                        <div id="SelectedPage"><?php print $i; ?></div><?php
                    } else { ?>
                        <button id="page_number" class="PageNumber" value="<?php print($i - 1); ?>" type="submit"
                                name="page_number"><?php print($i); ?></button>
                    <?php }
                }
            }
            ?>
        </form>
        <?php
    } else {
        ?>
        <h2 id="NoSearchResults">
            Yarr, er zijn geen resultaten gevonden.
        </h2>
        <?php
    }
    ?>
</div>
        <?php
    } ?>
</div>
<script src="Public/JS/custom.js"></script>
