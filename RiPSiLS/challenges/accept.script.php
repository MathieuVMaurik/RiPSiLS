<?php

require_once "../include/dbconnect.php";
include_once "calculateresult.php";

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
    $date = date('Y-m-d H:i:s');

    try {
        $query = "UPDATE `challenges` SET `challenged_move`= :move, `active`=0 WHERE ID = :challengID";
        $statement = $db->prepare($query);
        $statement->bindParam(":challengID" , $challengID, PDO::PARAM_INT);
        $statement->bindParam(":move" , $moveID, PDO::PARAM_INT);
        $statement->execute();

        //Get challenge to determine who wins
        $challenge_stmt = $db->prepare("SELECT * FROM challenges WHERE ID = ".$challengID.";");
        $challenge_stmt->execute();

        $challenge = $challenge_stmt->fetch(PDO::FETCH_OBJ);

        $gamestmt = $db->prepare("INSERT INTO `games` (challenger_user_ID, challenged_user_ID, winner_user_ID) VALUES (:challenger, :challenged, :winner)");
        $gamestmt->bindParam(':challenger', $challenge->challenger_user_ID);
        $gamestmt->bindParam(':challenged', $challenge->challenged_user_ID);
        $winner = calculate_result($challenge->challenger_move, $challenge->challenged_move);
        if($winner == 1)
        {
            $gamestmt->bindParam(':winner', $challenge->challenger_user_ID);
        }
        elseif($winner == 2)
        {
            $gamestmt->bindParam(':winner', $challenge->challenged_user_ID);
        }
        else
        {
            $gamestmt->bindParam(':winner', $dummy=NULL);
        }
        $gamestmt->execute();

        $gameID = $db->lastInsertId();
        $GLOBALS['gameID'] = $gameID;

        //Challenger move
        $movestmt = $db->prepare("INSERT INTO `moves` (datetime, move, user_ID, game_ID, turn) VALUES (:date, :move, :user, :game, 1)"); //The 1 is temporary, change when multiple turns implemented
        $movestmt->bindParam(':date', date('Y-m-d H:i:s'));
        $movestmt->bindParam(':move', $challenge->challenger_move);
        $movestmt->bindParam(':user', $challenge->challenger_user_ID);
        $movestmt->bindParam(':game', $gameID);
        $movestmt->execute();

        //Challenged move
        $movestmt = $db->prepare("INSERT INTO `moves` (datetime, move, user_ID, game_ID, turn) VALUES (:date, :move, :user, :game, 1)"); //The 1 is temporary, change when multiple turns implemented
        $movestmt->bindParam(':date', date('Y-m-d H:i:s'));
        $movestmt->bindParam(':move', $challenge->challenged_move);
        $movestmt->bindParam(':user', $challenge->challenged_user_ID);
        $movestmt->bindParam(':game', $gameID);
        $movestmt->execute();

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
        header('Location: index.php?Result=1&game='.$gameID);
}

?>