<?php

    session_start();

    require_once('./app/config/config.php');
    require_once('./app/core/board.php');
    require_once('./app/core/game.php');
    require_once('./app/core/statistics.php');
    require_once('./app/core/simple_render.php');


    $temp = new Game($faces, $winningLines);
    $game = $temp->play();

    $statistics = new GameStatistics;
    $statistics->update($game);

    Render::mainPage($game, $faces, $winningLines);
    Render::simpleStatistics($statistics, $game);

?>