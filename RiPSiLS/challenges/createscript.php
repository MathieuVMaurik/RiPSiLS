<?php
/**
 * Created by Armand Mahieu.
 * Published for RiPSiLS
 * Date: 24-11-2014
 * Time: 14:53
 *
 * voor mathieu check de $tweede zet die klopt niet
 *
 */
include "../include/dbconnect.php";
$eerstezet = null;
$tweedezet = null;
$InvID = null;
if(isset($_POST["accept"]))
{
    $InvID = $_POST["accept"];
}
session_start();
$EigenID = $_SESSION["userID"];

var_dump($InvID);
/**
 *
 */


if (isset($_POST["Tegenstander"]) || !empty($InvID)) {
    //if (isset($_POST["Verloopdagen"])) {
    if (isset($_POST["Zet"])) {
        $tegenstander = $_POST["Tegenstander"];
        //$verloopdagen = $_POST["Verloopdagen"];

        if ($_POST["Zet"] == "rock" ) {
            if (empty($InvID))
            {
                echo "hi";
                $eerstezet = 1;
            }
            else
            {
                $tweedezet = 1;
            }
            echo "You have selected Rock and are playing against: $tegenstander";
        } elseif ($_POST["Zet"] == "paper") {
            if (empty($InvID))
            {
                $eerstezet = 2;
            }
            else
            {
                $tweedezet = 2;
            }
            echo "You have selected Paper and are playing against: $tegenstander";
        } elseif ($_POST["Zet"] == "scissors") {
            if (empty($InvID))
            {
                $eerstezet  = 3;
                echo "hi";
            }
            else
            {
                echo "2";
                $tweedezet = 3;
            }
            echo "You have selected Scissors and are playing against: $tegenstander";
        } elseif ($_POST["Zet"] == "lizard") {
            if (empty($InvID))
            {
                $eerstezet  = 4;
            }
            else
            {
                $tweedezet = 4;
            }
            echo "You have selected Lizard and are playing against: $tegenstander";
        } elseif ($_POST["Zet"] == "spock") {
            if (empty($InvID))
            {
                $eerstezet = 5;
            }
            else
            {
                $tweedezet = 5;
            }
            echo "You have selected Spock and are playing against: $tegenstander";
        }
        else{
            echo "You have not selected a challenge <br />";
        }
    }
}
//}

try {
    var_dump($eerstezet);
    var_dump($tweedezet);
    echo "-tweede-".$tweedezet;
    echo "-eeste-".$eerstezet;
    if(!empty($tweedezet))
    {
        echo"tweede2";
        $QueryChallengeUpdate = "UPDATE `challenges` SET `challenged_move`= '$tweedezet', `active`=0 WHERE ID = $InvID";
        $stChallengeUpdate = $db->prepare($QueryChallengeUpdate);
        //$stChallengeUpdate->bindParam(':move', $tweedezet, PDO::PARAM_STR);
        $stChallengeUpdate->execute();

        $challenge_stmt = $db->prepare("SELECT * FROM challenges WHERE ID = ".$InvID.";");
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

        header('Location: index.php?result=1&game='.$gameID);

    }
    elseif(!empty($eerstezet))
    {

        echo"eerste2";

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //$db->query("SET SESSION sql_mode = 'ANSI, ONLY_FULL_GROUP_BY'");

        //Challenger ID opvragen
        $QuerychallengerID = "SELECT ID FROM users WHERE username = :tegenstander";
        $stChallengerID = $db->prepare($QuerychallengerID);
        $stChallengerID->bindParam(':tegenstander', $tegenstander, PDO::PARAM_STR);
        $stChallengerID->execute();


        while ($aRow = $stChallengerID->fetch(PDO::FETCH_ASSOC)) {
            $tegenstanderid = $aRow["ID"];
        }


        $date = date('YmdHi');
        if (isset($_SERVER["REQUEST_METHOD"]) == "POST") {
            if (isset($_POST["Tegenstander"])) {

                //if (isset($_POST["Verloopdagen"])) {
                echo $eerstezet;
                if (isset($_POST["Zet"])) {
                    $QueryChallenge = "INSERT INTO challenges (create_date, active, expiration_date, challenger_user_ID, challenger_move, challenged_user_ID, challenged_move) VALUES ($date,1,3,$EigenID,$eerstezet, $tegenstanderid,0)";
                    $stChallenge = $db->prepare($QueryChallenge);
                    $stChallenge->execute();
                }
                //}
            }


        }


        $id = $db->lastInsertId();

    }

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
if(!empty($tweedezet))
{
    header("location:../index.php?Result");
}
else
{
    header("location:../index.php?Created");
}
?>