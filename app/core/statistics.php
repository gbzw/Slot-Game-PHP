<?php

    class GameStatistics{

        public function __construct(){
            if(!isset($_SESSION['game'])){
                $this->initiateArray();
            }
        }

        public function initiateArray(){
            $_SESSION['game'] = [
                'cash'=>[
                    'cashFlow'          =>0,
                    'allocatedFunds'    =>0,
                    'wonCash'           =>0
                ],
                'plays'=>[
                    'gamesPlayed'       =>0,
                    'gamesWon'          =>0,
                    'percentWon'        =>0,
                    'winTypes'          =>[]
                ],
                'playFunctions'=>[
                    'nerfedPlays'       =>0
                ]
            ];
        }

        public static function cashFlow($bet, $win){
            $_SESSION['game']['cash']['cashFlow'] += ($bet + $win);
        }

        public static function totalAllocatedFunds($amount){
            $_SESSION['game']['cash']['allocatedFunds'] += $amount;
        }

        public static function totalWonCash($amount){
            $_SESSION['game']['cash']['wonCash'] += $amount;
        }

        public static function gamesTotal(){
            $_SESSION['game']['plays']['gamesPlayed']++;
        }

        public static function gamesWon($isWin){
            if(!empty($isWin))
                $_SESSION['game']['plays']['gamesWon']++;
        }

        public static function nerfedPlays(){
            if(!isset($_SESSION['game']['playFunctions']['nerfedPlays'])){
                $_SESSION['game']['playFunctions']['nerfedPlays'] = 1;
            } else {
                $_SESSION['game']['playFunctions']['nerfedPlays']++;
            }
        }

        public static function winType($data){

            if(!empty($data)){

                foreach($data as $key=>$game){
                    if(!isset($_SESSION['game']['plays']['winTypes'][$game['amount']])){
                        $_SESSION['game']['plays']['winTypes'][$game['amount']] = 1;
                    } else {
                        $_SESSION['game']['plays']['winTypes'][$game['amount']]++;
                    }
                }

            }

        }

        public static function gamesPercentWon(){
            $output = GameStatistics::calcPercent($_SESSION['game']['plays']['gamesPlayed'], $_SESSION['game']['plays']['gamesWon']);
            $_SESSION['game']['plays']['percentWon'] = $output;
        }

        public static function returnRate(){
            $output = GameStatistics::calcPercent($_SESSION['game']['cash']['allocatedFunds'], $_SESSION['game']['cash']['wonCash']);
            $_SESSION['game']['cash']['returnRate'] = $output;
        }

        public static function nerfedPlaysPercent(){
            $output = GameStatistics::calcPercent($_SESSION['game']['plays']['gamesPlayed'], $_SESSION['game']['playFunctions']['nerfedPlays']);
            $_SESSION['game']['playFunctions']['nerfedPlaysPercent'] = $output;
        }

        public static function calcPercent($var1, $var2){

            $temp = 0;

            if((isset($var1) && ($var1 > 1)) && (isset($var2) && ($var2 > 1))){
                $percent = ($var2 / $var1) * 100;
                $temp = number_format($percent,2);
            }

            return $temp;

        }

        public function update($data){
            
            $this->cashFlow($data['bet'], $data['win']);
            $this->totalAllocatedFunds($data['bet']);
            $this->totalWonCash($data['win']);
            $this->returnRate();

            $this->gamesTotal();
            $this->gamesWon($data['game']);
            $this->winType($data['game']);
            $this->gamesPercentWon();
            $this->nerfedPlaysPercent();

        }

        public function getStatistics(){
            return $_SESSION['game'];
        }

    }

?>