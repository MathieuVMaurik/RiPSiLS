<?php
include"./dbconnect.php";
include "./Challenge.php";

try {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $QueryInvite = "SELECT username,challenges.ID FROM challenges
                          LEFT JOIN users ON challenges.challenger_user_ID = users.ID
                          WHERE challenged_user_ID = '1' AND active = '1'";

    $StInvite = $db->prepare($QueryInvite);
    $StInvite->execute();

    while ($aRow = $StInvite->fetch(PDO::FETCH_ASSOC))
    {
        echo $aRow["username"]."  <a href='index.php?challenge=1&challenge_ID=".$aRow["ID"]."'>accept</a>          <a href='index.php?challenge=0&challenge_ID=".$aRow["ID"]."'>NO!</a></br>";

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



echo "<h1>Uitnodigingen</h1>";
