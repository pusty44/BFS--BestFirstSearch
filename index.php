<?php
/**
 * Created by PhpStorm.
 * User: Dawid Pierzak
 * Date: 03.01.2019
 * Time: 18:31
 */
include 'class/Board.php';

$n = 7;
$board = new Board($n);
$board->putQueen($n-1,rand(0,$n-1));
echo 'NEXT STEP MATRIX:<br />';
$board->nextLevel();
echo '<hr /><hr />';
echo 'FINAL MATRIX:<br />';
$board->getBoard();
echo '<hr /><hr />';
echo '<br />BEST RATINGS LIST:<br />';
$board->getRoute();