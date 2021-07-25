<?php

namespace App\Models;

class Card
{
    protected $intervalBetweenColumns;
    protected $rowLength;
    protected $grid;

    function __construct($intervalBetweenColumns, $rowLength, $grid = null)
    {
        $this->intervalBetweenColumns = $intervalBetweenColumns;
        $this->rowLength = $rowLength;
        $this->grid = $grid ? $grid : $this->setGrid();
    }

    public function setGrid(){
        $card = array_fill(0, $this->rowLength, array_fill(0, 4, "FREE"));
        $center = ["col" => ~~($this->rowLength / 2), "row" => ~~(count($card) / 2)];

        for($col=0; $col < count($card); $col++){
            for($row=0; $row < $this->rowLength; $row++){

                if($col == $center["col"] && $row == $center["row"]){
                    continue;
                }

                $lowerBound = ($this->intervalBetweenColumns * $col) + 1;
                $upperBound = ($this->intervalBetweenColumns * $col) + $this->intervalBetweenColumns;
                while($option = random_int($lowerBound, $upperBound)){
                    if(!in_array($option, $card[$col])){
                        $card[$col][$row] = $option;
                        break;
                    }
                }
            }
        }

        return $card;
    }

    public function getGrid(){
        return $this->grid;
    }

    private function flattern(){
        $flatGrid = array_merge( ...array_values( $this->grid ) );
        return array_filter($flatGrid, function($option){
            return $option !== 'FREE';
        });
    }

    public function isWinner($calls){
        foreach($this->flattern() as $option){
            if(!in_array($option, $calls)) return false;
        }

        return true;
    }

}