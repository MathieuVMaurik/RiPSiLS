<?php
/**
 * Created by Armand Mahieu.
 * Published for RiPSiLS
 * Date: 10-11-2014
 */

require_once"dbconnect.php";

session_start();
if(isset($_SESSION['user'])) {
    $username = $_SESSION['user'];
}
echo "Je bent ingelogd als $username .";
?>
Terug naar <a href="index.php">Home</a>
<link rel="stylesheet" href="include/style.css" type="text/css" media="screen" />
<?php
try {

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



    //Eigen ID
    $QueryownID = "SELECT ID FROM users WHERE username = :username";
    $stownID = $db->prepare($QueryownID);
    $stownID->bindParam(':username', $username, PDO::PARAM_STR);
    $stownID->execute();

    while($bRow = $stownID->fetch(PDO::FETCH_ASSOC))
    {
        $EigenID = $bRow["ID"];
    }




//Verzonden uitdagingen opvragen
    $QueryActivechallenges = "SELECT * FROM challenges WHERE challenger_user_ID = :id";
    $stActivechallenges = $db->prepare($QueryActivechallenges);
    $stActivechallenges->bindParam(':id', $EigenID, PDO::PARAM_STR);
    $stActivechallenges->execute();

    while ($aRow = $stActivechallenges->fetch(PDO::FETCH_ASSOC)) {
        $listID = $aRow["ID"];
        $listYourMove = $aRow["challenger_move"];
        $listOpposingMove = $aRow["challenged_move"];
        $listOpposingPlayer = $aRow["challenged_user_ID"];
    }

    //Tegenstander Naam
    $QueryoppName = "SELECT username FROM users WHERE ID = :oppid";
    $stoppName = $db->prepare($QueryoppName);
    $stoppName->bindParam(':oppid', $listOpposingPlayer, PDO::PARAM_STR);
    $stoppName->execute();

    while($cRow = $stoppName->fetch(PDO::FETCH_ASSOC))
    {
        $OppName = $cRow["username"];
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
?>

<p>Challenge ID | Your move | Opposing move | Opponent</p>
<p>

<?php

echo $listID;
echo " | ";

//Jouw zet
if($listYourMove == 1) {
    echo "Rock";
}
elseif($listYourMove == 2) {
    echo "Paper";
}
elseif($listYourMove == 3) {
    echo "Scissors";
}
elseif($listYourMove == 4) {
    echo "Lizard";
}
elseif($listYourMove == 5) {
    echo "Spock";
}

echo " | ";

//Tegenstanders zet
if($listOpposingMove == 1) {
    echo "Rock";
}
elseif($listOpposingMove == 2) {
    echo "Paper";
}
elseif($listOpposingMove == 3) {
    echo "Scissors";
}
elseif($listOpposingMove == 4) {
    echo "Lizard";
}
elseif($listOpposingMove == 5) {
    echo "Spock";
}
else{ echo "Your opponent has not yet made a move";}

echo " | ";

//Tegenstander
echo $OppName;


    ?>
</p>