<?php
/**
 * Created by PhpStorm.
 * User: Dawid Pierzak
 * Date: 03.01.2019
 * Time: 18:31
 */

class Board
{
    private $board;
    private $lenght;
    private $ratings;
    private $tempRating;

    /**
     * Board constructor.
     * @param int $n
     */
    function __construct(int $n){
        $this->lenght = $n;
        $this->ratings = array();
        $this->board = array(array());
        for($i=0; $i<$n; $i++){
            for($j=0; $j<$n; $j++){
                $this->board[$i][$j] = 0;
            }
        }
        return $this->board;
    }

    /**
     * Print board on screen.
     */
    function getBoard(){
        echo '<div style="display: inline-block; margin-right: 20px;">';
        for($i=0; $i<$this->lenght; $i++){
            for($j=0; $j<$this->lenght; $j++){
                echo $this->board[$i][$j];
            }
            echo '<br />';
        }
        echo '</div>';
    }

    /**
     * Count all free to put Queen fields.
     * @return int
     */
    function countFree(){
        $free = 0;
        for($i=0; $i<$this->lenght; $i++){
            for($j=0; $j<$this->lenght; $j++){
                if($this->board[$i][$j] == 0) $free++;
            }
        }
        return $free;
    }

    /**
     * Print best ratings for Queens on screen.
     */
    function getRoute(){
        for($i=0; $i<count($this->ratings);$i++){
            echo 'x: '.$this->ratings[$i]['x'].' y: '.$this->ratings[$i]['y'].' rating: '.$this->ratings[$i]['rating'];
            echo '<br />';
        }
    }

    function nextLevel(){
        for($i=2;$i<=$this->lenght;$i++){

            //best board set from copy
            $boardCopy = $this->board;

            //restart temporary table
            $this->tempRating = array();

            for($j=0;$j<$this->lenght;$j++){
                //recreate board for next put option
                $this->board = $boardCopy;

                //Check if field is valid to put Queen
                if($this->board[$this->lenght-$i][$j] == 0){

                    //check if Queen is not checked from across
                    if($this->putQueen($this->lenght-$i,$j)){
                        $this->tempRating[$j] = $this->countFree();
                    }
                }
            }

            // check if max rating value exists
            if(!empty($this->tempRating)){

                //get max rating value
                $max = array_keys($this->tempRating, max($this->tempRating))[0];
                $this->ratings[] = array('x' => $this->lenght-$i, 'y' => $max, 'rating' => $this->tempRating[$max]);
                $this->putQueen($this->lenght-$i,$max);
                $this->getBoard();
            }
        }
    }

    /**
     * Put Queen in valid place on the board and then mark all fields where can move with flag 1
     * @param $x
     * @param $y
     * @return bool
     */
    function putQueen($x,$y){
        //vertical
        for($i=0;$i<$this->lenght;$i++){
            $this->board[$x][$i] = 1;
        }
        //horizontal
        for($i=0;$i<$this->lenght;$i++){
            $this->board[$i][$y] = 1;
        }
        //up left
        for($i=0; $i< $this->lenght;$i++){
            if($x-$i >=0 && $y-$i >= 0){
                if($this->board[$x-$i][$y-$i] == 2) return false;
                $this->board[$x-$i][$y-$i] = 1;
            }
        }
        //up right
        for($i=0; $i< $this->lenght;$i++){
            if($x-$i >=0 && $y+$i < $this->lenght){
                if($this->board[$x-$i][$y+$i] == 2) return false;
                $this->board[$x-$i][$y+$i] = 1;
            }
        }
        //down left
        //up right
        for($i=0; $i< $this->lenght;$i++){
            if($x+$i < $this->lenght && $y-$i >= 0){
                if($this->board[$x+$i][$y-$i] == 2) return false;
                $this->board[$x+$i][$y-$i] = 1;
            }
        }
        //down right
        for($i=0; $i< $this->lenght;$i++){
            if($x+$i < $this->lenght && $y+$i < $this->lenght){
                if($this->board[$x+$i][$y+$i] == 2) return false;
                $this->board[$x+$i][$y+$i] = 1;
            }
        }
        $this->board[$x][$y] = 2;
        return true;
     }
}