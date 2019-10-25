<?php
if(isset($_POST['login']) && isset($_POST['username']) && isset($_POST['password'])) {
    $mysqli = new mysqli(
        "remotemysql.com", "cldhl9QKa9", "xF2D0SXPJL", "cldhl9QKa9"
        //"localhost", "root", "", "clicker"
    );
    $sql = "SELECT * FROM `users` WHERE `user` = '$_POST[username]' AND password = '$_POST[password]'";
    $user = $mysqli->query($sql);
    $userData = $user->fetch_assoc();
    if($userData['password'] == $_POST['password']) {
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['password'] = $_POST['password'];
        header('Location: ./clicker.php');
    }
}
?>