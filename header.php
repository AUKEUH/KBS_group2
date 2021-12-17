<!-- de inhoud van dit bestand wordt bovenaan elke pagina geplaatst -->
<?php
session_start();
include "database.php";
$databaseConnection = connectToDatabase();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>NerdyGadgets</title>

    <!-- Javascript -->
    <script src="Public/JS/fontawesome.js"></script>
    <script src="Public/JS/jquery.min.js"></script>
    <script src="Public/JS/bootstrap.min.js"></script>
    <script src="Public/JS/popper.min.js"></script>
    <script src="Public/JS/resizer.js"></script>

    <!-- Style sheets-->
    <link rel="stylesheet" href="Public/CSS/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/style.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/view.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/typekit.css">
</head>
<body>
<div class="Background">
    <div class="row" id="Header">
        <div class="col-2"><a href="./index.php" id="LogoA">
                <div id="LogoImage"></div>
            </a></div>
        <?php
        if (isset ($_SESSION["username"])){
            if($_SESSION["login"] === TRUE){
                // print "<div class='hallo_user'> Hallo"." ".$_SESSION["username"]."</div>";
                $loginText = "Welkom ".$_SESSION["Voornaam"];
            }else{
              $loginText = "inloggen";
            }
        }else{
          $loginText = "inloggen";
        }

        ?>
        <div class="col-8" id="CategoriesBar">
            <ul id="ul-class">
                <?php
                $HeaderStockGroups = getHeaderStockGroups($databaseConnection);

                foreach ($HeaderStockGroups as $HeaderStockGroup) {
                    ?>
                    <li>
                        <a href="browse.php?category_id=<?php print $HeaderStockGroup['StockGroupID']; ?>"
                           class="HrefDecoration"><?php print $HeaderStockGroup['StockGroupName']; ?></a>
                    </li>
                    <?php
                }
                ?>
                <li>
                    <a href="categories.php" class="HrefDecoration">Alle categorieën</a>
                </li>
            </ul>
        </div>
<!-- code voor US3: zoeken -->

        <ul id="ul-class-navigation">
            <li>
                <a href="browse.php" class="HrefDecoration"><i class="fas fa-search nav-icon"></i> Zoeken</a>
            </li>
            <li>
                <a href="Cart.php" class="HrefDecoration"><i class="fas fa-shopping-cart nav-icon"></i> Winkelmand</a>
            </li>
            <li>
                <a href="login.php" class="HrefDecoration welkom_user_block"><i class="fas fa-user-alt nav-icon"></i> <?php echo $loginText; ?></a>
            </li>

        </ul>

<!-- einde code voor US3 zoeken -->
    </div>
    <div class="row" id="Content">
        <div class="col-12">
            <div id="SubContent">

<?php
if (isset ($_SESSION["username"])) {
    if ($_SESSION["login"] === TRUE) {
        $userKorting = 2;
    } else {
        $userKorting = 0;
    }
}
else{
    $userKorting =0;
}
?>
