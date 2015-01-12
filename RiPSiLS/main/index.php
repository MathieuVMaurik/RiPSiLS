<?php
/*
 * This script will NOT work on any PHP version lower than 5.4.
 */
session_start();

require_once "../include/dbconnect.php";

//Everything that happens when you're logged in
if(isset($_SESSION['user']))
{
    //Include the header, homepage, and invitations
    require_once "../main/header.php";
    include "../main/home.php";
    include "../challenges/inventations.php";

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

       echo "
<form action='index.php?Create' method='post'>
    ". $ChallengeName ."
<input type='submit' name='invitations[$ID][accept]'  value='accept' >
<input type='submit' name='invitations[$ID][decline]' value='decline'>
</form>
</div>";
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

    if(isset($_GET['Create']))
    {
        include "../challenges/createscript.php";
    }
    elseif(isset($_GET['Sent']))
    {
        include "../challenges/sent.php";
    }
    elseif(isset($_GET['History']))
    {
        include "../challenges/history.php";
    }
    elseif(isset($_GET['Declined']))
    {
        include "../challenges/Declined.php";
    }
    elseif(isset($_GET['Result']))
    {
        include "../challenges/result.php";
    }
    require_once "../main/footer.php";
}

//Everything that happens when you are not logged in
else
{
    require_once "../logscript/login.php";
}