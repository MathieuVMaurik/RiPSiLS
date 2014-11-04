<?php
/**
 * Created by CasualVictim.
 * Date: 04-11-2014
 */


require_once"dbconnect.php";

?>

    <h1>Daag iemand uit:</h1>
    <br>
    <br>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        //Naam van tegenstander
        <label for="tegenstander">Voer hier de naam van je tegenspeler in</label>
        <br>
        <input id="tegenstander" name="Tegenstander" placeholder="Tegenspeler" required="" type="text">
        <br><br>
        //Uiterst aantal dagen van actieve uitnodiging
        <label for="verloopdatum">Aantal dagen dat de uitnodiging actief blijft</label>
        <br>
        <input id="verloopdatum" name="Verloopdagen" placeholder="3"  max="7" type="number">
        <br><br>
        //
        <label for="zet">Kies je zet</label>
        <br>
        <input type="radio" name="Zet" value="rock"><img src="img/rock.png">
        <input type="radio" name="Zet" value="paper"><img src="img/paper.png">
        <input type="radio" name="Zet" value="scissors"><img src="img/scissors.png">
        <input type="radio" name="Zet" value="lizard"><img src="img/lizard.png">
        <input type="radio" name="Zet" value="spock"><img src="img/spock.png">
        <br><br>
        <br>
        <br>
        <input type="submit" value="Daag uit!"/>
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
                } elseif ($_POST["Zet"] == "paper") {
                    $eerstezet = 2;
                } elseif ($_POST["Zet"] == "scissors") {
                    $eerstezet = 3;
                } elseif ($_POST["Zet"] == "lizard") {
                    $eerstezet = 4;
                } elseif ($_POST["Zet"] == "spock") {
                    $eerstezet = 5;
                }

            }
        }
    }
}

try {

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->query("SET SESSION sql_mode = 'ANSI, ONLY_FULL_GROUP_BY'");


    $QueryChallenge = "INSERT INTO challenges(create_date, active, expiration_date, challenger_user_ID, challenger_move, challenged_user_ID, challenged_move) VALUES (NOW(),0,$datum,$userid,$eerstezet,(SELECT ID FROM users WHERE username = '$tegenstander'),0)";
    $stChallenge = $db->prepare($QueryChallenge);
    $stChallenge->execute();

    $id = $db->lastInsertId();

    echo $id;


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