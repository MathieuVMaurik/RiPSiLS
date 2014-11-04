<?php
include"./dbconnect.php";


try
{
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->query("SET SESSION sql_mode = 'ANSI,ONLY_FULL_GROUP_BY'");
}
catch(PDOException $e)
{
    $sMsg = '<p>
            Regelnummer: '.$e->getLine().'<br />
            Bestand: '.$e->getFile().'<br />
            Foutmelding: '.$e->getMessage().'
        </p>';

    trigger_error($sMsg);

    $QueryInventations = "SELECT * FROM challenges
                          LEFT JOIN users where challenges.challenges_user_ID = user";

    $StIncertations = $db->prepare($QueryInventations);
    $StIncertations->execute();

    while($aRow = $StIncertations->fetch(PDO::FETCH_ASSOC))
    {
        echo $Inventations["username"];
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
