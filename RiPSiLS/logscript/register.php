<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 13-1-2015
 * Time: 11:20
 */

include "register.script.php";
include "../main/header.php";

?>

<div class="content">

    <h1>Registreren</h1>

    <?php if(!empty($errors)): ?>
        <div class="error">
            <p><strong>Gelieve de volgende fouten op te lossen:</strong></p>
            <ul>
            <?php foreach($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post">
        Gebruikersnaam: <input type="text" name="username" /><br />
        Wachtwoord: <input type="password" name="password" /><br />
        Herhaal wachtwoord: <input type="password" name="password_confirm" /><br />
        <input type="submit" name="submit" value="Registreren" />
    </form>

<?php

include "../main/footer.php";

?>

    </div>