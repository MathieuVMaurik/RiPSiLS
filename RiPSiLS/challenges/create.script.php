
<?php
/**
 * Created by Armand Mahieu.
 * Published for RiPSiLS
 * Date: 04-11-2014
 */

require_once "../include/dbconnect.php";

function getChallengeeID($name) {
    global $db;

    try {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT ID FROM users WHERE username = :name";
        $statement = $db->prepare($query);
        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->execute();

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $id = $row["ID"];
        }

        return $id;
    }
    catch (PDOException $e) {
        trigger_error($e);
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

function createChallenge($challenger, $challengee, $move) {
    global $db;
    $date = date('YmdHi');

    try {
        $query = "INSERT INTO challenges (create_date, active, expiration_date, challenger_user_ID, challenger_move, challenged_user_ID, challenged_move) VALUES ($date, 1, 3, $challenger, $move, $challengee, 0)";
        $statement = $db->prepare($query);
        $statement->execute();
    }
    catch (PDOException $e) {
        trigger_error($e);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $challengeeName = $_POST["Tegenstander"];
    $moveName = $_POST["Zet"];

    $challengerID = $_SESSION["userID"];
    $challengeeID = getChallengeeID($challengeeName);
    $moveID = getMoveID($moveName);
    createChallenge($challengerID, $challengeeID, $moveID);
    header("location: ../main/main.php?Sent");
}

?>