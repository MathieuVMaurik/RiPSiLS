<?php
/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 20-1-2015
 * Time: 8:58
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userid = $_SESSION["userID"];

    if (isset($_POST["namefriend"])) {
        foreach ($_POST["namefriend"] as $friendID => $Status) {
            $stats = implode(" ", $Status);
        }


        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $QueryInvite = "SELECT * FROM friends      WHERE friend_ID = :friend AND user_ID = :userid ";


        $StInvite = $db->prepare($QueryInvite);
        $StInvite->bindParam(':friend', $friendID, PDO::PARAM_INT);
        $StInvite->bindParam(':userid', $userid, PDO::PARAM_INT);
        $StInvite->execute();

        $count = $StInvite->rowCount();


        if (empty($count)) {

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $date = date('YmdHi');

            $Query = "INSERT INTO `friends`( `create_date`, `user_ID`, `friend_ID`) VALUES (:date,:user,:friend)";


            $StInvite = $db->prepare($Query);
            $StInvite->bindParam(':date', $date, PDO::PARAM_STR);
            $StInvite->bindParam(':user', $userid, PDO::PARAM_INT);
            $StInvite->bindParam(':friend', $friendID, PDO::PARAM_INT);
            $StInvite->execute();
            echo "added";

        } else {
            while ($aRow = $StInvite->fetch(PDO::FETCH_ASSOC)) {
                echo "friend is already in your friend list";

            }
        }

    } else {
        try {
            if ($_POST["addfriend"] == $_SESSION["user"]) {
                echo "you can't friend your self";
            } else {
                $name = $_POST["addfriend"];
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


                $QueryInvite = "SELECT * FROM users
      WHERE username LIKE '%$name%'";


                $StInvite = $db->prepare($QueryInvite);
                $StInvite->bindParam(':name', $_POST["addfriend"], PDO::PARAM_INT);
                $StInvite->execute();

                while ($aRow = $StInvite->fetch(PDO::FETCH_ASSOC)) {
                    $friendID = $aRow["ID"];
                    $friendName = $aRow["username"];
                    echo "<p><from action ='post'><input type='submit' value='add friend' name='namefriend[$friendID][addfriend]' />" . $friendName . "</from></p>";

                }
            }
        }
        catch
            (PDOException $e) {
                $sMsg = '<p>
            Regelnummer: ' . $e->getLine() . '<br />
            Bestand: ' . $e->getFile() . '<br />
            Foutmelding: ' . $e->getMessage() . '
        </p>';

                trigger_error($sMsg);
            }
    }
}
