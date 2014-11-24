<?php
require_once "./dbconnect.php";



foreach($_POST["invitations"] as $ID => $Status)
{
$stats = implode( " ",$Status);

    function UpdateChallenge($ID, $db)
    {
        $UpdateChallenge = "UPDATE challenges SET active = 0 WHERE ID = :ID";
        $StUpdate = $db->prepare($UpdateChallenge);
        $StUpdate->bindParam(':ID', $ID, PDO::PARAM_INT);
        $StUpdate->execute();
    }


    try {
        if ($stats == "accept")
        {

             UpdateChallenge($ID,$db);

            echo "Accepted </br>";
        } elseif ($stats == "decline")
        {
             UpdateChallenge($ID,$db);

            echo "Declined </br>";
        }
    } catch (PDOException $e) {
        $sMsg = '<p>
            Regelnummer: ' . $e->getLine() . '<br />
            Bestand: ' . $e->getFile() . '<br />
            Foutmelding: ' . $e->getMessage() . '
        </p>';

        trigger_error($sMsg);
    }
}
header("location:./index.php");