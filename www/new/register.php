<?php
    if(!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['password-confirm']) || !isset($_POST['register'])) {
        setcookie("error", "You haven't filled all fields.", time()+15);
        echo $_POST['username'];
        header('Location: ./index.html');        
    }
    if($_POST['password'] !== $_POST['password-confirm']) {
        setcookie("error", "Passwords do not match.", time()+15);
        header('Location: ./index.html');        
    }
    $mysqli = new mysqli(
        //"remotemysql.com", "cldhl9QKa9", "xF2D0SXPJL", "cldhl9QKa9"
        "localhost", "root", "", "clicker"
    );
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO `users` (username, password) VALUES ('$_POST[username]', '$password')";
    if($mysqli->query($sql) === FALSE) {
        echo $mysqli->error;
    }

?>