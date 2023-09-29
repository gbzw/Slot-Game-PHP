<?php

    class Render{

        public static function view($view, $params = []){
            require_once("./app/views/{$view}.php");
        }

        public static function mainPage($board, $faces, $winningLines, $params = []){

            $params = [
                'board'         =>$board,
                'faces'         =>$faces,
                'winningLines'  =>$winningLines,
                'action'        =>function($board, $faces, $winningLines){
                    Render::board($board, $faces, $winningLines);
                }
            ];

            Render::view('head');

            Render::view('board', $params);
            
            Render::view('footer');

        }

        public static function board($board, $faces, $lines){

            $board = Board::reArray($board['board']);

            $totalRows = count($board);

            for($row = 0; $row < $totalRows; $row++){

                $totalPositions = count($board[$row]);

                echo "<div class='slotRow roll'>";

                    for($pos = 0; $pos < $totalPositions; $pos++){
                        
                        echo "<div><img src='{$faces[($board[$row][$pos] - 1)]['img']}' /></div>";

                    }

                echo '</div>';

            }
            
        }

        public static function simpleStatistics($statistics, $game){
            ?>
                <div style="display:flex; flex-direction:row">
                    <div>
                        <h2>Statistics</h2>
                        <?php
                            echo '<pre>';
                                var_dump($statistics->getStatistics());
                            echo '</pre>';
                        ?>
                    </div>
                    <div>
                        <h2>Game</h2>
                        <?php
                            echo '<pre>';
                                var_dump($game);
                            echo '</pre>';
                        ?>
                    </div>
                </div>
            <?php
        }

    }

?>