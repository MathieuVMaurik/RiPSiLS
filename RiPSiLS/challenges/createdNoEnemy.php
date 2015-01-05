<?php
/**
 * Created by PhpStorm.
 * User: CV
 * Date: 09/12/2014
 * Time: 10:26
 */



    echo"1";
    if (isset($_POST["Tegenstander"]))
    {
        echo"2";
        $tegenstander = $_POST["Tegenstander"];
    }

//Challenger ID opvragen
    $QueryDoesOpponentExist = "SELECT username FROM users WHERE username = :tegenstander";
    $stDoesOpponentExist = $db->prepare($QueryDoesOpponentExist);
    $stDoesOpponentExist->bindParam(':tegenstander', $tegenstander, PDO::PARAM_STR);
    $stDoesOpponentExist->execute();


    while ($aRow = $stDoesOpponentExist->fetch(PDO::FETCH_ASSOC)) {
        $DoesOpponentExist = $aRow["ID"];
        echo"Fetch";
    }

    if(isset($_POST["Tegenstander"]) & $DoesOpponentExist != "$tegenstander")
    {
        echo"<p>This player does not exist, please choose another or check your spelling.</p>";
        ?>
            <a href="/index.php?Create">Back to challenging</a>";
        <?php
    }
    else
    {
        header("location:../Challenges/createscript.php");
    }