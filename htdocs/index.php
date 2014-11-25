<script type="text/javascript" src="include/jquery.js"></script>
<script>
    $(function () {
        $(".rulesresize").click(function() {
            var img = $(".rulesimg");

            if (img.width() < 200)
            {
                img.animate({width: "250px", height: "250px"}, 750);
            }
            else
            {
                img.animate({width: "50px", height: "50px"}, 750);
            }
        });

    });

</script>

<?php

/*
 * This script will NOT work on any PHP version lower than 5.4.
 */

session_start();


require_once "include/dbconnect.php";

if(isset($_SESSION['user']))
{
    ?>

    <link rel="stylesheet" href="include/style.css" type="text/css" media="screen" />

    <p>Je bent ingelogd als <strong><?= $_SESSION['user']; ?></strong>. <a href="log script/logout.php">Klik hier</a> om uit te loggen.</p>
    <div class="rules"><p>click for the rules</p><a class="rulesresize"><img class="rulesimg" id="rulesimg" src="./img/rpssl.png" width="50" /></a></div>
    <div class="menu">
    <a href="index.php">Home</a>
    <a href="index.php?Create">Challenge someone!</a>
    <a href="index.php?Sent">Sent challenges</a>
    </div>
    <h1>Uitnodigingen</h1>
<?php
}
else
{
    ?>
    <p><a href="log script/login.php">Inloggen</a></p>
    <?php
}



try {

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $QueryInvite = "SELECT username,challenges.ID FROM challenges
                          LEFT JOIN users ON challenges.challenger_user_ID = users.ID
                          WHERE challenged_user_ID = :UserID AND active= '1'";

    $StInvite = $db->prepare($QueryInvite);
    $StInvite->bindParam(':UserID', $_SESSION['userID'], PDO::PARAM_INT);
    $StInvite->execute();

    while ($aRow = $StInvite->fetch(PDO::FETCH_ASSOC))
    {
        $ID = $aRow["ID"];
        $ChallengeName = $aRow["username"];
        echo "<div class='received'>
        <form action='index.php?Create' method='post'>
        " . $ChallengeName ."
        <input type='submit' name='invitations[".$ID."][accept]'  value='accept' >
        <input type='submit' name='invitations[".$ID."][decline]' value='decline'>
        </form>
        </div>
        " ;

    }

}
catch(PDOException $e)
{
    $sMsg = '<p>
            Regelnummer: '.$e->getLine().'<br />
            Bestand: '.$e->getFile().'<br />
            Foutmelding: '.$e->getMessage().'
        </p>';

    trigger_error($sMsg);
}
?>
<div class="content">
    <?php
    if(isset($_GET['Create']))
    {
        require_once"challenges/create.php";
    }
    elseif(isset($_GET['Sent']))
    {
        require_once"challenges/sent.php";
    }




    ?>

</div>

