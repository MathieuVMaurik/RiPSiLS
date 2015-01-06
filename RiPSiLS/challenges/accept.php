<?php require_once 'accept.script.php' ?>

<h1>Make your move</h1>

<form method="post" action="../challenges/accepted.php">
    <input type="hidden" name="accept" value="<?php echo $InvID; ?>">
    
    <p>
        <?php include 'movecontrol.php' ?>
    </p>

    <p>
        <input type="submit" value="Challenge!" onclick="window.location='Challenges/createdNoEnemy.php'"/>
    </p>
</form>