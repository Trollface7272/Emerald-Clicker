<?php
    if(isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $mysqli = new mysqli(
            "remotemysql.com", "cldhl9QKa9", "xF2D0SXPJL", "cldhl9QKa9"
            //"localhost", "root", "", "clicker"
        );
        $sql = "INSERT INTO users (user, password) VALUES ('$username', '$password')";
        if($mysqli->query($sql)){
            header('./clicker.php');
        } else {
            if(startsWith($mysqli->error,'Duplicate entry')) {
                echo 'Username is already in use.';
            else
                echo $mysqli->error;
            exit
        }
        
    }

    function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }
?>