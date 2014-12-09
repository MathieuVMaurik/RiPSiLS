<?php

/**
 * Created by Armand Mahieu.
 * Published for RiPSiLS
 * Date: 24-11-2014
 * Time: 14:53
 *
 *
 */

if(isset($_POST['Zet'])) {
    echo"zet";
    include "../include/dbconnect.php";
    $eerstezet = null;
    $tweedezet = null;
    $InvID = null;
    if (isset($_POST["accept"])) {
        var_dump($_POST["accept"]);
        $InvID = (int)$_POST["accept"];
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

            if ($_POST["Zet"] == "rock") {
                if (empty($InvID)) {
                    echo "hi";
                    $eerstezet = 1;
                } else {
                    $tweedezet = 1;
                }
                echo "You have selected Rock and are playing against: $tegenstander";
            } elseif ($_POST["Zet"] == "paper") {
                if (empty($InvID)) {
                    $eerstezet = 2;
                } else {
                    $tweedezet = 2;
                }
                echo "You have selected Paper and are playing against: $tegenstander";
            } elseif ($_POST["Zet"] == "scissors") {
                if (empty($InvID)) {
                    $eerstezet = 3;
                    echo "hi";
                } else {
                    echo "2";
                    $tweedezet = 3;
                }
                echo "You have selected Scissors and are playing against: $tegenstander";
            } elseif ($_POST["Zet"] == "lizard") {
                if (empty($InvID)) {
                    $eerstezet = 4;
                } else {
                    $tweedezet = 4;
                }
                echo "You have selected Lizard and are playing against: $tegenstander";
            } elseif ($_POST["Zet"] == "spock") {
                if (empty($InvID)) {
                    $eerstezet = 5;
                } else {
                    $tweedezet = 5;
                }
                echo "You have selected Spock and are playing against: $tegenstander";
            } else {
                echo "You have not selected a challenge <br />";
            }
        }
    }
    //}

    try {
        echo $InvID;
        var_dump($eerstezet);
        var_dump($tweedezet);
        echo "-tweede-" . $tweedezet;
        echo "-eeste-" . $eerstezet;
        if (!empty($tweedezet)) {
            echo "tweede2";
            $QueryChallengeUpdate = "UPDATE `challenges` SET challenged_move = :move, `active`=0 WHERE ID = $InvID";
            $stChallengeUpdate = $db->prepare($QueryChallengeUpdate);
            $stChallengeUpdate->bindParam(':move', $tweedezet);
            $stChallengeUpdate->execute();
        } elseif (!empty($eerstezet)) {

            echo "eerste2";

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

    } catch (PDOException $e) {
        $sMsg = '<p>
                Regelnummer: ' . $e->getLine() . ' <br />
                Bestand: ' . $e->getFile() . ' <br />
                Foutmelding: ' . $e->getMessage() . ' <br />

                </p>';
        trigger_error($sMsg);
    }
    if (!empty($tweedezet)) {
          header("location:../main/index.php?Result");
    } else {
         header("location:../main/index.php?Create");
    }
}
else
{
    if(isset($_SESSION['user'])) {
        $username = $_SESSION['user'];
    }
    $stats = null;

    if($stats === "decline")
    {

        try
        {
            $UpdateChallenge = "UPDATE challenges SET active = 0 WHERE ID = :ID";
            $StUpdate = $db->prepare($UpdateChallenge);
            $StUpdate->bindParam(':ID', $ID, PDO::PARAM_INT);
            $StUpdate->execute();
        }
        catch (PDOException $e) {
            $sMsg = '<p>
            Regelnummer: ' . $e->getLine() . '<br />
            Bestand: ' . $e->getFile() . '<br />
            Foutmelding: ' . $e->getMessage() . '
        </p>';

            trigger_error($sMsg);
        }
        header("location: index.php?Declined");
    }
    else {
        foreach ($_POST["invitations"] as $InvID => $Status) {
            $stats = implode(" ", $Status);
        }

        ?>


        <form method="post" action="../challenges/createscript.php">
        <!-- Naam van tegenstander -->
        <?php
        if (isset($stats) == null) {
            ?>
            <label for="tegenstander">Type the name of your opponent</label>

            <input id="tegenstander" name="Tegenstander" placeholder="Tegenspeler" required="" type="text">
        <?php
        } else {
            echo '<input type="hidden" name="accept" value="'. $InvID .'">';

        }
        require_once "../challenges/create.php";
    }

}
?>