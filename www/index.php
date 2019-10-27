<!DOCTYPE html>
<html>
<head>
    <?php
        session_start();
    ?>
    <link rel="stylesheet" type="text/css" href="LoginStyle.css">
    <meta charset="UTF-8-CZ">
    <title>Login</title>
</head>
<body>
    <div id="check"></div>
    <div id="selector">
        <div id="register" onclick="register()">Register</div>
        <div id="guest" onclick="window.location.href = './clicker.php'">Play as Guest</div>
        <div id="login" onclick="login()">Login</div>
    </div>
    <div id="forms"></div>
    <script src="./loginButtons.js"></script>
    <?php
        include 'login.php';
        include 'register.php';
    ?>
    <script>
        <?php if(isset($errorMessage) && $errorMessage != null){ ?>
            var error = '<?php echo $errorMessage?>';
            document.getElementById('check').innerHTML = error
            document.getElementById('check').style.visibility = 'visible'
        <?php }?>
    </script>
    
</body>
</html>