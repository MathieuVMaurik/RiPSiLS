<script type="text/javascript" src="include/jquery.js"></script>
<script>
    $(document).ready(function() {
        var imageLinks = $('a[href$=".png"], a[href$=".jpg"], a[href$=".gif"], a[href$=".bmp"]');
        if (imageLinks.children('img').length) {
            imageLinks.children('img').each(function() {
                var currentTitle = $(this).attr('title');
                $(this).attr('title', currentTitle + ' (click to enlarge image)');
            });
            imageLinks.click(function(e) {
                e.preventDefault();
                $(this).children('img').toggleClass('expanded');

            });
        }
    });

</script>
<?php

/*
 * This script will NOT work on any PHP version lower than 5.4.
 */

session_start();


require_once "./dbconnect.php";

if(isset($_SESSION['user']))
{
    ?>

    <link rel="stylesheet" href="include/style.css" type="text/css" media="screen" />

    <p>Je bent ingelogd als <strong><?= $_SESSION['user']; ?></strong>. <a href="log script/logout.php">Klik hier</a> om uit te loggen.</p>
    <div class="rules"><p>click for the rules</p> <a href="./img/rpssl.png"><img src="./img/rpssl.png" /></a></div>
    <p><a href="Challenges/create.php">Challenge someone!</a></p>
    <p><a href="Challenges/sent.php">Sent challenges</a></p>
    <p><a href="Challenges/received.php">Received challenges</a></p>
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
    echo $_SESSION['user'];
        echo "
        <form action='Challenges/received.php' method='post'>
        " . $ChallengeName ."
        <input type='submit' name='invitations[".$ID."][accept]'  value='accept'>
        <input type='submit' name='invitations[".$ID."][decline]' value='decline'>
        </form>
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

