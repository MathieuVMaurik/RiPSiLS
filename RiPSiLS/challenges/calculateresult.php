<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 1-12-2014
 * Time: 12:09
 */

/**
 * Calculates the result of a Rock Paper Scissors Lizard Spock game.
 * @param int $move1 player 1's move. Number between 1-5.
 * @param int $move2 player 2's move. Number between 1-5.
 * @return int can be 0, 1 or 2, depending on which move won. 0 for draw.
 */
function calculate_result($move1, $move2)
{
    if($move1 == $move2)
    {
        return 0;
    }

    $rock = 1;
    $paper = 2;
    $scissors = 3;
    $lizard = 4;
    $spock = 5;
    $matches = array(
        $rock => array($scissors, $lizard),
        $paper => array($rock, $spock),
        $scissors => array($paper, $lizard),
        $lizard => array($spock, $paper),
        $spock => array($scissors, $rock),
    );

    return in_array($move2, $matches[$move1]) ? 1 : 2;
}