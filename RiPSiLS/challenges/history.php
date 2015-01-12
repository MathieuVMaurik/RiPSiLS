<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 10-11-2014
 * Time: 15:12
 */


//session_start();

if(!isset($_SESSION['userID']))
{
    header('Location: login.php');
    session_destroy();
    exit();
}

$moves = array(
    1 => 'Rock',
    2 => 'Paper',
    3 => 'Scissors',
    4 => 'Lizard',
    5 => 'Spock'
);

?>

<html>
    <head>
        <title>Geschiedenis</title>
        <link rel="stylesheet" type="text/css" href="include/style.css" />
    </head>
    <body>
        <h1>Geschiedenis</h1>
        <p>Onderstaand een overzicht van uw potjes:</p>

        <?php

        $stmt = $db->prepare('SELECT t.*, challenger.username AS challenger, challenged.username AS challenged, winner.username AS winner FROM games t
        LEFT JOIN users challenger ON t.challenger_user_ID = challenger.ID
        LEFT JOIN users challenged ON t.challenged_user_ID = challenged.ID
        LEFT JOIN users winner ON t.winner_user_ID = winner.ID
        WHERE t.challenger_user_ID = :userid OR t.challenged_user_ID = :userid');
        $stmt->bindParam(':userid', $_SESSION['userID']);
        $stmt->execute();

        $gamesDB = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $db->prepare('SELECT t.*, u.username FROM moves t LEFT JOIN games g ON t.game_ID = g.ID LEFT JOIN users u ON t.user_ID = u.ID WHERE g.ID IN (SELECT t.ID FROM games t WHERE t.challenger_user_ID = :userid OR t.challenged_user_ID = :userid)');
        $stmt->bindParam(':userid', $_SESSION['userID']);
        $stmt->execute();

        $movesDB = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $games = array();
        foreach($gamesDB as $gameDB)
        {
            $game = array();

            $game['challenger'] = $gameDB['challenger'];
            $game['challenged'] = $gameDB['challenged'];
            $game['winner'] = $gameDB['winner'];
            $game['moves'] = array();

            $games[$gameDB['ID']] = $game;
        }
        unset($gameDB);
        unset($game);

        foreach($movesDB as $moveDB)
        {
            $games[$moveDB['game_ID']]['moves'][1][$moveDB['username']] = $moveDB['move'];
            $games[$moveDB['game_ID']]['datetime'] = $moveDB['datetime'];
        }

        foreach($games as $game)
        {
            ?>
            <div class="game">
                <h2><?= $game['challenger']; ?> vs. <?= $game['challenged'] ?></h2>

                <?php
                $date = new DateTime($game['datetime']);
                $datetime = $date->format('M j Y H:i');
                echo "<p>{$datetime}</p>";
                ?>

                <ul>

                    <?php

                    foreach($game['moves'][1] as $user => $move) //The [1] is temporary due to there only being one turn. Please change when multiple turns implemented.
                    {
                        echo "<li><strong>{$user}:</strong> {$moves[$move]} </li>";
                    }
                    ?>
                </ul>

                <?php if($game['winner']): ?>
                    <p>Winnaar: <strong><?= $game['winner']; ?></strong></p>
                <?php else: ?>
                    <p><strong>Gelijkspel</strong></p>
                <?php endif; ?>
                <hr />
            </div>
            <?php
        }

        ?>

    </body>
</html>