<?php

    class Board{

        public $totalColumns;
        public $totalRows;

        public $faces;
        public $winningLines;

        public function __construct($totalColumns = 2, $totalRows = 4){

            $this->setTotalColumns($totalColumns);
            $this->setTotalRows($totalRows);

        }

        public function setTotalColumns($totalColumns){
            $this->totalColumns = $totalColumns;
        }

        public function setTotalRows($totalRows){
            $this->totalRows = $totalRows;
        }

        public function setFaces($availableFaces){
            
            if(empty($availableFaces) || !is_array($availableFaces)){
                throw New Exception("Invalid Faces Passed.");
            }

            $this->faces = $availableFaces;
        }

        public function setWinningLines($winningLines){

            if(empty($winningLines) || !is_array($winningLines)){
                throw New Exception("Invalid Winning Lines Passed.");
            }

            $this->winningLines = $winningLines;
        
        }

        public function createBoard(){

            $totalFaces = count($this->faces);
            $board = [];

            for($row = 0; $row <= $this->totalColumns; $row++){
                for($pos = 0; $pos <= $this->totalRows; $pos++){
                    $randomFace = random_int(0,($totalFaces - 1));
                    $board[$row][$pos] = $this->faces[$randomFace]['id'];
                }
            }

            return $board;

        }

        public function getWinningCoordinates($line) {
        
            $coordinates = [];
            $count = count($line);

            for ($i = 0; $i < $count; $i++) {
                for ($j = 0; $j < count($line[$i]); $j++) {
                    if ($line[$i][$j] === 1) {
                        $coordinates[] = ['col'=>$i, 'row'=>$j];
                    }
                }
            }
        
            return $coordinates;

        }

        public function compareCoordinates($coordinates, $winningLine) {

            $coordinates = $this->sortArrayByPos($coordinates);
            $winningLine = $this->sortArrayByPos($this->getWinningCoordinates($winningLine));

            if($coordinates[0] != $winningLine[0]) {
                return false;
            }
        
            $numMatching = 0;
            $total = count($coordinates);

            for ($i = 0; $i < $total; $i++) {

                if ($coordinates[$i] != $winningLine[$i]) {
                    return false;
                }

                $numMatching++;

            }
        
            if ($numMatching >= 3) {
                return $numMatching;
            } else {
                return false;
            }

        }

        public function sortArrayByPos($array) {

            usort($array, function($a, $b){
                return $a['row'] <=> $b['row'];
            });

            return $array;
        }

        public static function reArray($board){

            $temp = [];
            $count = count($board[0]);
            
            for ($i = 0; $i < $count; $i++) {

                $row = [];

                foreach ($board as $element) {
                    $row[] = $element[$i];
                }

                $temp[] = $row;

            }

            return $temp;

        }

        public function checkBoard($board) {

            $wins = [];
        
            foreach ($this->winningLines as $key => $value) {

                foreach ($this->faces as $face) {

                    $coordinates = [];

                    for ($row = 0; $row <= $this->totalColumns; $row++) {

                        $line = $value['line'][$row];

                        for ($pos = 0; $pos <= $this->totalRows; $pos++) {

                            if ($line[$pos] === 1 && $board[$row][$pos] == $face['id']) {
                                $coordinates[] = ['col'=>$row, 'row'=>$pos];
                            } elseif($line[$pos] === 1 && $board[$row][$pos] != $face['id']){
                                break;
                            }

                        }

                    }

                    if(!empty($coordinates) && ($check = $this->compareCoordinates($coordinates, $value['line']))){
                        $wins[] = [
                            'face'          => $face['id'],
                            'multiplier'    => number_format(($face['multiplier'] * $check), 2),
                            'line'          => $key,
                            'amount'        => $check
                        ];
                    }
        
                }

            }
        
            return $wins;

        }

    }

?>