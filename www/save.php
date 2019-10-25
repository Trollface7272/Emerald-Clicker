<?php
    session_start();
    echo '<br>';
    $mysqli = new mysqli(
        "remotemysql.com", "cldhl9QKa9", "xF2D0SXPJL", "cldhl9QKa9"
        //"localhost", "root", "", "clicker"
    );
    $emeralds = $_POST['emeralds'];
    $cursors = implode($_POST['upgrades'][0]);
    $villagers = implode($_POST['upgrades'][1]);
    $farms = implode($_POST['upgrades'][2]);
    $mines = implode($_POST['upgrades'][3]);
    $factories = implode($_POST['upgrades'][4]);
    $sql = "UPDATE `users` SET 
        `emeralds`= $emeralds,
        `cursors`= $cursors,
        `villagers`= $villagers,
        `farms`= $farms,
        `mines`= $mines,
        `factories`= $factories 
    WHERE `user` = '$_SESSION[username]'";

    if($mysqli->query($sql))
        header('Location: ./clicker.php');
    else
        print_r($mysqli->error);
?>