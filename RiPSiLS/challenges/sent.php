<?php
/**
 * Created by Armand Mahieu.
 * Published for RiPSiLS
 * Date: 10-11-2014
 */
?>
<body class="challengessentbody">
<p>
    <?php
    if(isset($_SESSION['user'])) {
        $username = $_SESSION['user'];
    }


    ?>
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
        <table>
        <thead>
        <tr>
            <th class="del">Delete</th> <th class="id">Game ID</th> <th class="move1">Your move</th>   <th class="move2">Opposing move</th>   <th class="opp">Opponent</th>
        </tr>
        </thead>
            <tbody>
        <?php
        //Verzonden uitdagingen opvragen
        $QueryActivechallenges = "SELECT ID, challenger_move, challenged_move, challenged_user_ID, active FROM challenges WHERE challenger_user_ID = :id AND active != 0";
        $stActivechallenges = $db->prepare($QueryActivechallenges);
        $stActivechallenges->bindParam(':id', $EigenID, PDO::PARAM_STR);
        $stActivechallenges->execute();

        //Delete button function
        if(isset($_POST["delbutton"]))
        {
            $DeleteChallenge = "UPDATE challenges SET active = 0 WHERE ID = :IDdel";
            $StDelete = $db->prepare($DeleteChallenge);
            $StDelete->bindParam(':IDdel', $IDdel, PDO::PARAM_INT);
            $StDelete->execute();

        }

        while ($aRow = $stActivechallenges->fetch(PDO::FETCH_ASSOC)) {
            $listID = $aRow["ID"];
            $listYourMove = $aRow["challenger_move"];
            $listOpposingMove = $aRow["challenged_move"];
            $listOpposingPlayer = $aRow["challenged_user_ID"];
            $listActive = $aRow["active"];
            ?>
            <tr>
            <?php
            $count = 1;
            foreach($aRow as $key => $value) {
                if($count == 1){
                    ?><td>
                    <input type="submit" value= "<?php $listID ?>" name="button"></td>
                    <td><?php
                        echo $listID;
                        ?>
                    </td>

                    <?php

                    $count++;
                }
                ?>

                <?php
                if($count == 2){
                    ?>
                    <td><?php
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
                        ?></td>
                    <?php
                    $count++;
                }
                ?>

                <?php
                if($count == 3){
                    ?>
                    <td><?php
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
                        ?></td>
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

                    <td><?php
                        echo $OppName;
                        ?></td>
                    <?php
                    $count++;

                }
                if($count == 5){
                    ?>
                    <td><?php
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
                        ?></td>
                    <?php
                    $count++;
                }
            }
            ?>
            </tr>
        <?php
        }

        ?>
    </tbody>
        <tfoot>
        <tr>
            <td class="del">Delete</td> <td class="id">Game ID</td> <td class="move1">Your move</td>  <td class="move2">Opposing move</td>  <td class="opp">Opponent</td>
        </tr>
        </tfoot>
            </table>


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