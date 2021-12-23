<?php
include "header.php";
?>
<div id="CenteredContent">
    <h1>Regristreren (2/3)</h1>

    <form method="POST" action="ophalendata/insert.php">
        <label for="username">Voornaam* (voorvoegsel):</label>
        <input type="text" placeholder="Henk" name="voornaam" id="username" required>
        <br>
        <label for="password">Achternaam*:</label>
        <input type="text" placeholder="Janssen" name="achternaam" id="password" required>
        <br>
        <label for="geboorte">Geboortedatum*:</label>
        <input type="date" name="geboorte" id="geboorte" required>
        <br>
        <label for="emailadres">Emailadres*:</label>
        <input type="email" placeholder="example@outlook.com" name="emailadres" id="emailadres" required>
        <br>
        <label for="telefoonnummer">Telefoonnummer:</label>
        <input type="number" placeholder="0612345678" name="telefoonnummer" id="telefoonnummer">
        <br>
        <label for="straat">Straat*:</label>
        <input type="text" placeholder="Romeostraat" name="straat" id="straat" required>
        <br>
        <label for="huisnummer">Huisnummer*:</label>
        <input type="text" placeholder="13b" name="huisnummer" id="huisnummer" required>
        <br>
        <label for="postcode">Postcode*:</label>
        <input type="text" placeholder="1234AB" name="postcode" id="postcode" required>
        <br>
        <label for="plaats">Plaats*:</label>
        <input type="text" placeholder="Zwolle" name="plaats" id="plaats" required>
        <br>
        <label for="wachtwoord">Wachtwoord*:</label>
        <input type="password" min="8" name="wachtwoord" id="wachtwoord" required>
        <button type="submit" name="submit" class="btn  mt-2 btn-primary">Regristreren</button>
        <br>
        <a href="login.php" class="HrefDecoration">Ik heb al een account</a>
    </form>
