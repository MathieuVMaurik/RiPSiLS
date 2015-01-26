<?php
/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 13-1-2015
 * Time: 12:00
 */
try {


    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $QueryInvite = "SELECT * FROM friends
      LEFT JOIN users ON friends.friend_ID = users.ID
      WHERE friends.user_ID = :UserID";

    $StInvite = $db->prepare($QueryInvite);
    $StInvite->bindParam(':UserID', $_SESSION['userID'], PDO::PARAM_INT);
    $StInvite->execute();

    while ($aRow = $StInvite->fetch(PDO::FETCH_ASSOC)) {
        $ID = $aRow["ID"];
        $friendName = $aRow["username"];

echo "<li><a href='../main/main.php?Create&friend=".$friendName."'>".$friendName."</a></li>";
    }
}
catch(PDOException $e)
{
    $sMsg = '<p>
            Regelnummer: '.$e->getLine().'<br />
            Bestand: '.$e->getFile().'<br />
            Foutmelding: '.$e->getMessage().'
        </p>';

    trigger_error($sMsg);
}