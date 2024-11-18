<?php
    session_start();
    session_destroy();
    header('Location: /GAME_ROAD_MAP/index.php');
?>