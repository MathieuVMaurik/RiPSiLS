<?php
if(isset($_GET["challenge_ID"]))
{
    try {
        $ID = $_GET['challenge_ID'];
        echo $ID;
        echo "</br>";
        if ($_GET["challenge"] == "1")
        {
            $UpdateChallenge = "UPDATE challenges SET active = 0 WHERE ID ='.$ID.'";
            $StUpdate = $db->prepare($UpdateChallenge);
            $StUpdate->execute();


            echo "accepted";
        } elseif ($_GET["challenge"] == "0")
        {
            echo "NO!";
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