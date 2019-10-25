<?php
    if(isset($_POST['register']) && isset($_POST['username']) && isset($_POST['password'])) {
        if(empty($_POST['username']) || empty($_POST['password'])){echo 'You havn\'t entered name/password';return;};
        $username = $_POST['username'];
        $password = $_POST['password'];
        $mysqli = new mysqli(
            "remotemysql.com", "cldhl9QKa9", "xF2D0SXPJL", "cldhl9QKa9"
            //"localhost", "root", "", "clicker"
        );
        $sql = "INSERT INTO users (user, password) VALUES ('$username', '$password')";
        if($mysqli->query($sql)){
            header('Location: ./index.php');
        } else {
            if(startsWith($mysqli->error,'Duplicate entry'))
                echo 'Username is already in use.';
            else
                echo $mysqli->error;
            exit;
        }
        
    }

    function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }
?>