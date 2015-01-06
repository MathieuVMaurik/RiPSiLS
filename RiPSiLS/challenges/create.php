<?php require_once 'create.script.php' ?>

<h1>Challenge someone</h1>

<form method="post">
    <p>
        <!-- Naam van tegenstander -->
        <label for="tegenstander">Type the name of your opponent</label>
        <input id="tegenstander" name="Tegenstander" placeholder="Tegenspeler" required="" type="text">
    </p>

    <p>
        <!-- Uiterst aantal dagen van actieve uitnodiging --
        <label for="verloopdatum">Amount of days that the challenge stays available</label>

        <input id="verloopdatum" name="Verloopdagen" placeholder="3"  max="7" type="number">
        -->
    </p>

    <p>
        <?php include 'movecontrol.php' ?>
    </p>

    <p>
        <input type="submit" value="Challenge!" />
    </p>
</form>