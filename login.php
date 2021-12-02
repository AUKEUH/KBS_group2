<?php
include "header.php";
?>
<div id="CenteredContent">
    <h1>Inloggen</h1>

    <form method="GET" action="login.php">
        <label for="username">Emailadres:</label>
        <input type="text" placeholder="example@email.com" name="username" id="username" required>
        <br>
        <label for="password">Wachtwoord:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit" name="submit" class="btn  mt-2 btn-primary">Log in</button>
        <a href='login.php?logout=true' class="btn  mt-2 btn-primary">Log out</a>
        <br>
        <a href="/register" class="HrefDecoration">Ik heb nog geen account</a>
    </form>

<?php
if (isset($_GET["submit"])){
    if ($_GET["username"] === "inkoper" && $_GET["password"] === "spekkoper"){
        $_SESSION["login"] = TRUE;
        print "U bent ingelogd";
        $_SESSION["username"] = $_GET["username"];
    }else{
        $_SESSION["login"] = FALSE;
        print "De inlog gegevens zijn fout";
    }
}

if (isset($_GET["logout"])){
    $_SESSION["login"] = FALSE;
    $_SESSION["username"] = '';
    header("Refresh:0; url=login.php");
}
