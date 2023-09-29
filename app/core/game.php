<?php

    class Game extends Board{

        public $bet;
        public $win;

        public $balance;
        public $results;

        public function __construct($availableFaces = [], $winningLines = [] ,$bet = 10000 , $totalColumns = 2, $totalRows = 4){

            parent::__construct($totalColumns, $totalRows);

            try{

                $this->setBetAmount($bet);
                $this->setFaces($availableFaces);
                $this->setWinningLines($winningLines);

            } catch(Exception $e){
                die("Error: {$e->getMessage()}");
            }

        }

        public function setBetAmount($bet){
            $this->bet = $bet;
        }

        public function play(){
            
            $board = $this->createBoard();
            $temp = $this->checkBoard($board);

            $output = [
                'game'=>$temp,
                'bet'=>$this->bet,
                'win'=>$this->calculateGame($temp),
                'board'=>$board,
            ];

            if(isset($_SESSION['game']['cash']['returnRate']) && $_SESSION['game']['cash']['returnRate'] > 40 && $output['win'] > 0){
                GameStatistics::nerfedPlays();
                return $this->play();
            } else {
                return $output;
            }
            
        }

        public function calculateGame($results){

            $totalWin = 0;
            $totalMultiplier = 0;

            foreach($results as $key=>$value){

                $temp = $this->faces[($value['face'] - 1)]['multiplier'];
                $win = ($this->bet *( $temp * $value['amount']));

                $totalWin += $win;

            }

            return (int)$totalWin;

        }

    }

?>