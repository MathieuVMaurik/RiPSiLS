<?php
/**
 * Created by Armand Mahieu.
 * Published for RiPSiLS
 * Date: 04-11-2014
 */

require_once"dbconnect.php";

//Tijdelijk
$tempuserid = 55;

?>
    <link rel="stylesheet" href="include/style.css" type="text/css" media="screen" />

    <h1>Daag iemand uit:</h1>
    <br>
    <br>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <!-- Naam van tegenstander -->
        <label for="tegenstander">Type the name of your opponent</label>
        <br>
        <input id="tegenstander" name="Tegenstander" placeholder="Tegenspeler" required="" type="text">
        <br><br>

        <!-- Uiterst aantal dagen van actieve uitnodiging -->
        <label for="verloopdatum">Amount of days that the challenge stays available</label>
        <br>
        <input id="verloopdatum" name="Verloopdagen" placeholder="3"  max="7" type="number">
        <br><br>

        <!-- Zet kiezen -->
        <label for="lbzet">Choose your challenge</label>
        <br>


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
        <br><br>
        <br>
        <br>
        <input type="submit" value="Challenge!"/>
        <br>
        <br>
    </form>
<?php



if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    $QuerychallengerID = "SELECT ID FROM users WHERE username = '$tegenstander'";
    $stChallengerID = $db->prepare($QuerychallengerID);
    $stChallengerID->execute();

    while($aRow = $stChallengerID->fetch(PDO::FETCH_ASSOC))
    {
        $tegenstanderid = $aRow["ID"];
    }

    $date = date('YmdHi');

    $QueryChallenge = "INSERT INTO challenges (create_date, active, expiration_date, challenger_user_ID, challenger_move, challenged_user_ID, challenged_move) VALUES ($date,1,$verloopdagen,$tempuserid,$eerstezet, $tegenstanderid,0)";
    $stChallenge = $db->prepare($QueryChallenge);
    $stChallenge->execute();



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