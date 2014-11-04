<?php
include"./dbconnect.php";


try {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->query("SET SESSION sql_mode = 'ANSI,ONLY_FULL_GROUP_BY'");


    $QueryInvit = "SELECT * FROM challenges
                          LEFT JOIN users ON challenges.challenger_user_ID = users.ID
                          WHERE challenged_user_ID = '1'";

    $StInvite = $db->prepare($QueryInvite);
    $StInvite->execute();

    while ($aRow = $StIncertations->fetch(PDO::FETCH_ASSOC)) {
        echo $aRow["username"];
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
