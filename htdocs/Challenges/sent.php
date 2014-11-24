<?php
/**
 * Created by Armand Mahieu.
 * Published for RiPSiLS
 * Date: 10-11-2014
 */

require_once "dbconnect.php";
require "index.php";
?>
<body class="challengessentbody">
<p>
    <?php
    if(isset($_SESSION['user'])) {
        $username = $_SESSION['user'];
    }


    ?>
    Terug naar <a href="../index.php">Home</a>
</p>
<?php
try {

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_SERVER["REQUEST_METHOD"]) == "POST") {
    if (isset($_POST["Challengedel"])) {
        $QueryChallengedel = "UPDATE challenges SET active=0 WHERE ID=$challengedelid";
        $stChallengedel = $db->prepare($QueryChallengedel);
        $stChallengedel->execute();
    }
}

    //Eigen ID
    $QueryownID = "SELECT ID FROM users WHERE username = :username";
    $stownID = $db->prepare($QueryownID);
    $stownID->bindParam(':username', $username, PDO::PARAM_STR);
    $stownID->execute();

    while($bRow = $stownID->fetch(PDO::FETCH_ASSOC))
    {
        $EigenID = $bRow["ID"];
    }

    ?>
    <p>
        <label class="id">Game ID</label> <label class="move1">Your move</label>   <label class="move2">Opposing move</label>   <label class="opp">Opponent</label>
    </p>
    <div class="list">
        <?php
        //Verzonden uitdagingen opvragen
        $QueryActivechallenges = "SELECT ID, challenger_move, challenged_move, challenged_user_ID, active FROM challenges WHERE challenger_user_ID = :id AND active != 0";
        $stActivechallenges = $db->prepare($QueryActivechallenges);
        $stActivechallenges->bindParam(':id', $EigenID, PDO::PARAM_STR);
        $stActivechallenges->execute();

        while ($aRow = $stActivechallenges->fetch(PDO::FETCH_ASSOC)) {
            $listID = $aRow["ID"];
            $listYourMove = $aRow["challenger_move"];
            $listOpposingMove = $aRow["challenged_move"];
            $listOpposingPlayer = $aRow["challenged_user_ID"];
            $listActive = $aRow["active"];
            echo '<br>';
            $count = 1;;
            foreach($aRow as $key => $value) {
                if($count == 1){
                    ?>
                    <label class="align"><?php
                        echo $listID;
                        ?></label>

                    <?php
                    $count++;
                }
                ?>

                <?php
                if($count == 2){
                    ?>
                    <label class="align"><?php
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
                        ?></label>
                    <?php
                    $count++;
                }
                ?>

                <?php
                if($count == 3){
                    ?>
                    <label class="align"><?php
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
                        else{ echo "None";}
                        ?></label>
                    <?php
                    $count++;
                }
                ?>

                <?php
                if($count == 4){
                    //Tegenstander Naam
                    $QueryoppName = "SELECT username FROM users WHERE ID = :oppid";
                    $stoppName = $db->prepare($QueryoppName);
                    $stoppName->bindParam(':oppid', $listOpposingPlayer, PDO::PARAM_STR);
                    $stoppName->execute();

                    while($cRow = $stoppName->fetch(PDO::FETCH_ASSOC))
                    {
                        $OppName = $cRow["username"];
                    }
                    ?>

                    <label class="align"><?php
                        echo $OppName;
                        ?></label>
                    <?php
                    $count++;

                }
                if($count == 5){
                    ?>
                    <label class="align"><?php
                        //activiteit
                        if($listActive == 1) {
                            echo "Not Yet Answered";
                        }
                        elseif($listActive == 2) {
                            echo "Accepted";
                        }
                        elseif($listActive == 0) {
                            echo "Played";
                        }
                        elseif($listActive == 3) {
                            echo "Declined";
                        }
                        ?></label>
                    <?php
                    $count++;
                }
            }
        }

        ?></div>
    <p>
        <label class="id">Game ID</label> <label class="move1">Your move</label>  <label class="move2">Opposing move</label>  <label class="opp">Opponent</label>
    </p>


<?php

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
</body>