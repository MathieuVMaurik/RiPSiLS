<?php
/**
 * Created by Armand Mahieu.
 * Published for RiPSiLS
 * Date: 04-11-2014
 */

require_once"dbconnect.php";
require"index.php";


if(isset($_SESSION['user'])) {
    $username = $_SESSION['user'];
}


?>
<body>
Terug naar <a href="index.php">Home</a>
<p>
<h1>Daag iemand uit</h1>


<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <!-- Naam van tegenstander -->
    <label for="tegenstander">Type the name of your opponent</label>

    <input id="tegenstander" name="Tegenstander" placeholder="Tegenspeler" required="" type="text">
    </p>
    <p>
        <!-- Uiterst aantal dagen van actieve uitnodiging --
        <label for="verloopdatum">Amount of days that the challenge stays available</label>

        <input id="verloopdatum" name="Verloopdagen" placeholder="3"  max="7" type="number">
        -->
    </p>
    <p>
        <!-- Zet kiezen -->
        <label for="lbzet">Choose your challenge<br></label>



        <label class="button">
            <input id="zet" type="radio" name="Zet" value="rock" />
            <img src="img/rock.png">
        </label>
        <label class="button">
            <input id="zet" type="radio" name="Zet" value="paper" />
            <img src="img/paper.png">
        </label>
        <label class="button">
            <input id="zet" type="radio" name="Zet" value="scissors" />
            <img src="img/scissors.png">
        </label>
        <label class="button">
            <input id="zet" type="radio" name="Zet" value="lizard" />
            <img src="img/lizard.png">
        </label>
        <label class="button">
            <input id="zet" type="radio" name="Zet" value="spock" />
            <img src="img/spock.png">
        </label>


        <!-- Backup solution for buttons
        <input type="radio" name="Zet" value="rock"><img src="img/rock.png">
        <input type="radio" name="Zet" value="paper"><img src="img/paper.png">
        <input type="radio" name="Zet" value="scissors"><img src="img/scissors.png">
        <input type="radio" name="Zet" value="lizard"><img src="img/lizard.png">
        <input type="radio" name="Zet" value="spock"><img src="img/spock.png">
        -->



        <input type="submit" value="Challenge!"/>


</form>

<?php


/**
 *
 */
if (isset($_SERVER["REQUEST_METHOD"]) == "POST") {
    if (isset($_POST["Tegenstander"])) {
        if (isset($_POST["Verloopdagen"])) {
            if (isset($_POST["Zet"])) {
                $tegenstander = $_POST["Tegenstander"];
                $verloopdagen = $_POST["Verloopdagen"];

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
    }
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

    //Eigen ID
    $QueryownID = "SELECT ID FROM users WHERE username = :username";
    $stownID = $db->prepare($QueryownID);
    $stownID->bindParam(':username', $username, PDO::PARAM_STR);
    $stownID->execute();

    while($bRow = $stownID->fetch(PDO::FETCH_ASSOC))
    {
        $EigenID = $bRow["ID"];
    }

    $date = date('YmdHi');
    if (isset($_SERVER["REQUEST_METHOD"]) == "POST") {
        if (isset($_POST["Tegenstander"])) {
            if (isset($_POST["Verloopdagen"])) {
                if (isset($_POST["Zet"])) {
                    $QueryChallenge = "INSERT INTO challenges (create_date, active, expiration_date, challenger_user_ID, challenger_move, challenged_user_ID, challenged_move) VALUES ($date,1,3,$EigenID,$eerstezet, $tegenstanderid,0)";
                    $stChallenge = $db->prepare($QueryChallenge);
                    $stChallenge->execute();
                }
            }
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
?>
</body>