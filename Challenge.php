<?php
if(isset($_GET["challenge_ID"]))
{
    try {
        $ID = $_GET['challenge_ID'];
        if ($_GET["challenge"] == "1")
        {


            $UpdateChallenge = "UPDATE challenges SET active = 0 WHERE ID ='".$ID."'";
            $StUpdate = $db->prepare($UpdateChallenge);
            $StUpdate->execute();



            echo "Accepted </br>";
        } elseif ($_GET["challenge"] == "0")
        {
            $UpdateChallenge = "UPDATE challenges SET active = 0 WHERE ID ='".$ID."'";
            $StUpdate = $db->prepare($UpdateChallenge);
            $StUpdate->execute();

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