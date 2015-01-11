<?php
$InvID = null;
$stats = null;
require_once "../include/dbconnect.php";
if(isset($_POST["invitations"])) {

    foreach ($_POST["invitations"] as $InvID => $Status) {
        $stats = implode(" ", $Status);
    }

}


if ($stats === "accept") {
echo "this works";

    require_once"../challenges/accept.php";

}
elseif ($stats === "decline") {
    echo "does you work?";
    try {
        $UpdateChallenge = "UPDATE challenges SET active = 0 WHERE ID = :ID";
        $StUpdate = $db->prepare($UpdateChallenge);
        $StUpdate->bindParam(':ID', $ID, PDO::PARAM_INT);
        $StUpdate->execute();

    }
    catch (PDOException $e) {
        $sMsg = '<p>
                 Regelnummer: ' . $e->getLine() . '<br />
                 Bestand: ' . $e->getFile() . '<br />
                 Foutmelding: ' . $e->getMessage() . '
                 </p>';

        trigger_error($sMsg);
    }
    header("location: ../main/main.php?declined");
}