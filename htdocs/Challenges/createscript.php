<?php
/**
 * Created by Armand Mahieu.
 * Published for RiPSiLS
 * Date: 24-11-2014
 * Time: 14:53
 */
include "../include/dbconnect.php";
require_once "../index.php";

$eerstezet = null;
$EigenID = $_SESSION["userID"];

/**
 *
 */
if (isset($_SERVER["REQUEST_METHOD"]) == "POST") {
    if (isset($_POST["Tegenstander"])) {
        //if (isset($_POST["Verloopdagen"])) {
            if (isset($_POST["Zet"])) {
                $tegenstander = $_POST["Tegenstander"];
                //$verloopdagen = $_POST["Verloopdagen"];

                if ($_POST["Zet"] == "rock" ) {
                    $eerstezet = 1;
                    echo "You have selected Rock and are playing against: $tegenstander";
                } elseif ($_POST["Zet"] == "paper") {
                    $eerstezet = 2;
                    echo "You have selected Paper and are playing against: $tegenstander";
                } elseif ($_POST["Zet"] == "scissors") {
                    $eerstezet = 3;
                    echo "You have selected Scissors and are playing against: $tegenstander";
                } elseif ($_POST["Zet"] == "lizard") {
                    $eerstezet = 4;
                    echo "You have selected Lizard and are playing against: $tegenstander";
                } elseif ($_POST["Zet"] == "spock") {
                    $eerstezet = 5;
                    echo "You have selected Spock and are playing against: $tegenstander";
                }
                else{
                    echo "You have not selected a challenge <br />";
                }
            }
        }
    //}
}

try {

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //$db->query("SET SESSION sql_mode = 'ANSI, ONLY_FULL_GROUP_BY'");

    //Challenger ID opvragen
    $QuerychallengerID = "SELECT ID FROM users WHERE username = :tegenstander";
    $stChallengerID = $db->prepare($QuerychallengerID);
    $stChallengerID->bindParam(':tegenstander', $tegenstander, PDO::PARAM_STR);
    $stChallengerID->execute();


    while($aRow = $stChallengerID->fetch(PDO::FETCH_ASSOC))
    {
        $tegenstanderid = $aRow["ID"];
    }




    $date = date('YmdHi');
    if (isset($_SERVER["REQUEST_METHOD"]) == "POST") {
        if (isset($_POST["Tegenstander"])) {

            //if (isset($_POST["Verloopdagen"])) {

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

catch(PDOException $e)
{
    $sMsg = '<p>
                Regelnummer: '.$e->getLine().' <br />
                Bestand: '.$e->getFile().' <br />
                Foutmelding: '.$e->getMessage().' <br />

                </p>';
    trigger_error($sMsg);
}

header("location:../index.php?Create");
?>