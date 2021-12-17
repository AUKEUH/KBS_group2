<?php
include "header.php";
?>
<div id="CenteredContent">
    <h1>Regristreren</h1>

    <form method="POST" action="login.php">
        <label for="username">Emailadres:</label>
        <input type="text" placeholder="example@email.com" name="username" id="username" required>
        <br>
        <label for="password">naam:</label>
        <input type="text" name="password" id="password" required>
        <button type="submit" name="submit" class="btn  mt-2 btn-primary">Regristreren</button>
        <br>
        <a href="login.php" class="HrefDecoration">Ik heb al een account</a>
    </form>

