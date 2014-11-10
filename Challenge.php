<?php

function UpdateChallenge($ID,$db)
{
    $UpdateChallenge = "UPDATE challenges SET active = 0 WHERE ID = :ID";
    $StUpdate = $db->prepare($UpdateChallenge);
    $StUpdate->bindParam(':ID', $ID, PDO::PARAM_INT);
    $StUpdate->execute();
}

if($challenge_ID)
{
    try {
        $ID = $_GET['challenge_ID'];
        if ($_POST["challenge"] == "1")
        {

            UpdateChallenge($ID,$db);

            echo "Accepted </br>";
        } elseif ($_POST["challenge"] == "0")
        {
            UpdateChallenge($ID,$db);

            echo "Declined </br>";
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
}