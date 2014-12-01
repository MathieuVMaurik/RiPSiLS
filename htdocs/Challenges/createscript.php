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
if($_POST["accept"]== null)
{
    $EigenID = $_SESSION["userID"];
}
$ID = $_POST["accept"];
echo $_POST["Zet"];
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
                    if ($_POST["accept"] !== null)
                    {
                        $tweedezet = 1;
                    }
                    else
                    {
                        $eerstezet = 1;
                    }
                    echo "You have selected Rock and are playing against: $tegenstander";
                } elseif ($_POST["Zet"] == "paper") {
                    if ($_POST["accept"] !== null)
                    {
                        $tweedezet = 2;
                    }
                    else
                    {
                        $eerstezet = 2;
                    }
                    echo "You have selected Paper and are playing against: $tegenstander";
                } elseif ($_POST["Zet"] == "scissors") {
                    if ($_POST["accept"] != null)
                    {
                        $tweedezet = 3;
                        echo "hi";
                    }
                    else
                    {
                        echo "2";
                        $eerstezet = 3;
                    }
                    echo "You have selected Scissors and are playing against: $tegenstander";
                } elseif ($_POST["Zet"] == "lizard") {
                    if ($_POST["accept"] !== null)
                    {
                        $tweedezet = 4;
                    }
                    else
                    {
                        $eerstezet = 4;
                    }
                    echo "You have selected Lizard and are playing against: $tegenstander";
                } elseif ($_POST["Zet"] == "spock") {
                    if ($_POST["accept"] !== null)
                    {
                        $tweedezet = 5;
                    }
                    else
                    {
                        $eerstezet = 5;
                    }
                    echo "You have selected Spock and are playing against: $tegenstander";
                }
                else{
                    echo "You have not selected a challenge <br />";
                }
            }
        }
    //}
}
echo $tweedezet;
try {

    if ($_POST["accept"] != null)
    {

        $QueryChallengeUpdate = "UPDATE `challenges` SET `challenged_move`= '$tweedezet', `active`=0 WHERE ID = $ID";
        $stChallengeUpdate = $db->prepare($QueryChallengeUpdate);
        //$stChallengeUpdate->bindParam(':move', $tweedezet, PDO::PARAM_STR);
        $stChallengeUpdate->execute();
var_dump($stChallengeUpdate);
    }
    else {


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
if($_POST["accept"] !== null)
{
   // header("location:../index.php?Result");
}
else
{
   // header("location:../index.php?Create");
}
?>