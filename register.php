<?php
include "header.php";
?>
<div id="CenteredContent">
    <h1>Regristreren</h1>

    <form method="POST" action="ophalendata/insert.php">
        <label for="Voornaam">Voornaam* (voorvoegsel):</label>
        <input type="text" placeholder="Henk" name="voornaam" id="username" required>
        <br>
        <label for="Achternaam">Achternaam*:</label>
        <input type="text" placeholder="Janssen" name="achternaam" id="password" required>
        <br>
        <label for="Geboortedatum">Geboortedatum*:</label>
        <input type="text" placeholder="02-21-1993" name="geboorte" id="username" required>
        <br>
        <label for="Emailadres">Emailadres*:</label>
        <input type="text" placeholder="example@outlook.com" name="emailadres" id="username" required>
        <br>
        <label for="Telefoonnummer">Telefoonnummer:</label>
        <input type="text" placeholder="0612345678" name="telefoonnummer" id="username">
        <br>
        <label for="Straat">Straat*:</label>
        <input type="text" placeholder="Romeostraat" name="straat" id="username" required>
        <br>
        <label for="HUisnummer">Huisnummer*:</label>
        <input type="text" placeholder="13b" name="huisnummer" id="username" required>
        <br>
        <label for="Postcode">Postcode*:</label>
        <input type="text" placeholder="1234AB" name="postcode" id="username" required>
        <br>
        <label for="Plaats">Plaats*:</label>
        <input type="text" placeholder="Zwolle" name="plaats" id="username" required>
        <br>
        <label for="Wachtwoord">Wachtwoord*:</label>
        <input type="password" min="8" name="wachtwoord" id="username" required>
        <button type="submit" name="submit" class="btn  mt-2 btn-primary">Regristreren</button>
        <br>
        <a href="login.php" class="HrefDecoration">Ik heb al een account</a>
    </form>

