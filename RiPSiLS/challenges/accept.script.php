<?php

require_once "../include/dbconnect.php";

if(isset($_POST["invitations"])) {

    foreach ($_POST["invitations"] as $InvID => $Status) {
        $stats = implode(" ", $Status);
    }

}
function Declined( $InvID){
    global $db;
    echo $InvID;
    try {
        $UpdateChallenge = "UPDATE challenges SET active = 0 WHERE ID = :ID";
        $StUpdate = $db->prepare($UpdateChallenge);
        $StUpdate->bindParam(':ID', $InvID, PDO::PARAM_INT);
        $StUpdate->execute();

    echo"declined";
         header("location: ../main/main.php?declined");
    }

    catch(PDOException $e)
    {
        $sMsg = '<p>
                Regelnummer: '.$e->getLine().' <br />
                Bestand: '.$e->getFile().' <br />
                Foutmelding: '.$e->getMessage().' <br />

                </p>';
        trigger_error($sMsg);
    }
}

function getMoveID($name) {
    switch ($name) {
        case "rock": return 1;
        case "paper": return 2;
        case "scissors": return 3;
        case "lizard": return 4;
        case "spock": return 5;
        default: throw new Exception("No valid move.");
    }
}

function acceptChallenge($challengID ,$moveID) {
    global $db;
    $date = date('YmdHi');

    try {
        $query = "UPDATE `challenges` SET `challenged_move`= :move, `active`=0 WHERE ID = :challengID";
        $statement = $db->prepare($query);
        $statement->bindParam(":challengID" , $challengID, PDO::PARAM_INT);
        $statement->bindParam(":move" , $moveID, PDO::PARAM_INT);
        $statement->execute();
    }
    catch(PDOException $e)
    {
        $sMsg = '<p>
                Regelnummer: '.$e->getLine().' <br />
                Bestand: '.$e->getFile().' <br />
                Foutmelding: '.$e->getMessage().' <br />

                </p>';
        trigger_error($sMsg);
    }
}


if ($stats === "decline") {

    Declined($InvID);
}
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Zet"])) {


        $moveName = $_POST["Zet"];
        $challengID = $_POST["accept"];

        $challengerID = $_SESSION["userID"];

        $moveID = getMoveID($moveName);
        acceptChallenge($challengID, $moveID);
        header("location:../main/main.php?Result");

}

?>