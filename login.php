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
        <?php if($_SESSION["login"] === TRUE) { ?>
            <a class="logoutbutton" href='login.php?logout=true' >Uitloggen</a>
        <?php }
        else { ?>
            <button class="loginbutton" type="submit" name="submit" class="btn  mt-2 btn-primary">Inloggen</button>
        <?php } ?>
        <br>
        <a href="register.php" class="HrefDecoration">Ik heb nog geen account</a>
    </form>

<?php
if (isset($_GET['username'] )){
    $conn = mysqli_connect('localhost', 'root', '', 'nerdygadgets', 3306);
    $username = $_GET['username'];
    $password = $_GET['password'];
    $query = "select * from registratiedata where Emailadres = '$username'";
    $statement = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($statement);
    $resultSet = mysqli_stmt_get_result($statement);
    if (mysqli_num_rows($resultSet) > 0) {
        $row = mysqli_fetch_assoc($resultSet);
        if (password_verify(hash('sha512', $password), $row['Wachtwoord'])) {
            $_SESSION["login"] = TRUE;
            $_SESSION["username"] = $_GET["username"];
            $_SESSION["Voornaam"] = $row['Voornaam'];
            header("Refresh:0; url=index.php");
        }
        else {
            $_SESSION["login"] = FALSE;
            print "De inlog gegevens zijn fout";
        }
    }
}
if (isset($_GET["logout"])){
    $_SESSION["login"] = FALSE;
    $_SESSION["username"] = '';
    header("Refresh:0; url=login.php");
}
