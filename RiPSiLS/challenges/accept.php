<?php require_once 'accept.script.php' ?>

<h1>Make your move</h1>

<form method="post" >
    <input type="hidden" name="accept" value="<?php echo $InvID; ?>">
    
    <p>
        <?php require_once 'movecontrol.php' ?>
    </p>

    <p>
        <input type="submit" value="final smash!"/>
    </p>
</form>