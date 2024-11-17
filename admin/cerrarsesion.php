<?php
    session_start();
    session_destroy();
    header('Location: /cine2/index.php');
?>