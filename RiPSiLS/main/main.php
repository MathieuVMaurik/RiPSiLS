<?php
/*
 * This script will NOT work on any PHP version lower than 5.4.
 */
session_start();

require_once "../include/dbconnect.php";

if(isset($_SESSION['user']))
{
    require_once "../main/header.php";
    require_once "../main/home.php";
    require_once "../main/invlist.php";

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
                <form action='../main/main.php?answer' method='post'>
                    " . $ChallengeName . "
                    <input type='submit' name='invitations[$ID][accept]'  value='accept' >
                    <input type='submit' name='invitations[$ID][decline]' value='decline'>
                </form>";
        }
        echo"</div><div class='content'>";
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
        include "../challenges/create.php";
    }
    elseif(isset($_GET['Sent']))
    {
        include "../challenges/sent.php";
    }
    elseif(isset($_GET['History']))
    {
        include "../challenges/history.php";
    }
    elseif(isset($_GET['declined']))
    {
        include "../challenges/Declined.php";
    }
    elseif(isset($_GET['Created']))
    {
        include "../challenges/created.php";
    }
    elseif(isset($_GET['answer']))
    {
        include "../challenges/accept.php";
    }
    elseif(isset($_GET['Result']) && isset($_GET['game']))
    {
        include "../challenges/result.php";
    }
    require_once "../main/footer.php";
}
else
{
    require_once "../logscript/login.php";
}