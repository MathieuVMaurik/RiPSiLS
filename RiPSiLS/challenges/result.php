<?php

$gameID = $_GET['game'];

$gamestmt = $db->prepare('SELECT * FROM games WHERE ID = :gameid');
$gamestmt->bindParam(':gameid', $gameID);
$gamestmt->execute();

$game = $gamestmt->fetch(PDO::FETCH_OBJ);

$moves_stmt = $db->prepare('SELECT * FROM moves WHERE game_ID = :gameid');
$moves_stmt->bindParam(':gameid', $gameID);
$moves_stmt->execute();

$moves = $moves_stmt->fetchAll(PDO::FETCH_OBJ);

//Get the correct challenger and challenged moves from $moves
foreach($moves as $move)
{
    if($move->user_ID == $game->challenger_user_ID)
    {
        $challengermove = $move->move;
    }
    else
    {
        $challengedmove = $move->move;
    }
}

$challengerstmt = $db->prepare('SELECT * FROM users WHERE ID='.$game->challenger_user_ID);
$challengerstmt->execute();
$challenger = $challengerstmt->fetch(PDO::FETCH_OBJ)->username;

$challengedstmt = $db->prepare('SELECT * FROM users WHERE ID='.$game->challenged_user_ID);
$challengedstmt->execute();
$challenged = $challengedstmt->fetch(PDO::FETCH_OBJ)->username;
if(!empty($game->winner_user_ID))
{
    $winnerstmt = $db->prepare('SELECT * FROM users WHERE ID='.$game->winner_user_ID);
    $winnerstmt->execute();
    $winner = $winnerstmt->fetch(PDO::FETCH_OBJ)->username;
}
else
{
    $winner = false;
}

?>

<h1>Overzicht van spel</h1>

<ul>
    <li>Uitdager: <strong><?= $challenger ?></strong> met <strong><?= $challengermove ?></strong></li>
    <li>Uitgedaagde: <strong><?= $challenged ?></strong> met <strong><?= $challengedmove ?></strong></li>
    <?php if($winner): ?>
    <li>Winnaar: <strong><?= $winner ?></strong></li>
        <?php else: ?>
    <li><strong>Gelijkspel</strong></li>
    <?php endif; ?>
</ul>