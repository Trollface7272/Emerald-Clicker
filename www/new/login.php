<?php
    if(!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['login'])) {
        setcookie("error", `You entered wrong password or username.`, time()+15);
        header('Location: ./index.html');
    }
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $mysqli = new mysqli(
        //"remotemysql.com", "cldhl9QKa9", "xF2D0SXPJL", "cldhl9QKa9"
        "localhost", "root", "", "clicker"
    );
    $sql = "SELECT * FROM `users` WHERE `username` = $_POST[username] AND `password` = $password";
    $users = $mysqli->query($sql);
?>