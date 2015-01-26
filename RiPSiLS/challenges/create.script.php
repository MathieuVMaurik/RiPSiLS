
<?php
/**
 * Created by Armand Mahieu.
 * Published for RiPSiLS
 * Date: 04-11-2014
 */

if(isset($_SESSION['user'])) {
    require_once "../include/dbconnect.php";

    if (isset($_GET["friend"])) {
        $friend = $_GET["friend"];
    } else {
        $friend = null;
    }

//Check if the player that will be challenged, exists.
    $QueryChallengeeExists = "SELECT username FROM users WHERE username = :oppname";
    $stChallengeeExists = $db->prepare($QueryChallengeeExists);
    $stChallengeeExists->bindParam(':oppname', $_POST["Tegenstander"], PDO::PARAM_STR);
    $stChallengeeExists->execute();
    $count = $stChallengeeExists->rowCount();


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($count != 0) {

            //Requests the ID of the player that will be challenged.
            function getChallengeeID($name)
            {
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
                } catch (PDOException $e) {
                    trigger_error($e);
                }
            }

            //Returns the move that has been selected by the player.
            function getMoveID($name)
            {
                switch ($name) {
                    case "rock":
                        return 1;
                    case "paper":
                        return 2;
                    case "scissors":
                        return 3;
                    case "lizard":
                        return 4;
                    case "spock":
                        return 5;
                    default:
                        throw new Exception("No valid move.");
                }
            }

            //Puts the info of the challenge into the database.
            function createChallenge($challenger, $challengee, $move)
            {
                if (empty($_POST["Tegenstander"])) {
                    $challengee = $_POST["TegenstanderList"];
                } else {
                    global $db;
                    $date = date('YmdHi');

                    try {
                        $query = "INSERT INTO challenges (create_date, active, expiration_date, challenger_user_ID, challenger_move, challenged_user_ID, challenged_move) VALUES ($date, 1, 3, $challenger, $move, $challengee, 0)";
                        $statement = $db->prepare($query);
                        $statement->execute();
                    } catch (PDOException $e) {
                        trigger_error($e);
                    }
                }
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $challengeeName = $_POST["Tegenstander"];
                $moveName = $_POST["Zet"];

                $challengerID = $_SESSION["userID"];
                $challengeeID = getChallengeeID($challengeeName);
                $moveID = getMoveID($moveName);
                createChallenge($challengerID, $challengeeID, $moveID);
                header("location: ../main/main.php?Sent&challenge");
            } else {
                echo "These are not the droids you're looking for(The player you have selected does not exist)";
            }
        }
    }
}
else
{
    require_once "../logscript/login.php";
}


?>