<?php
    session_start();
    if(!isset($_SESSION["id12"])) {
        header("Location: login.php");
        exit();
    }
?>