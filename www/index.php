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
    <div id="selector">
        <div id="register" onclick="register()">Register</div>
        <div id="login" onclick="login()">Login</div>
    </div>
    <div id="forms"></div>
    <script>
        var forms = document.getElementById('forms')
        login()
        function login() {
            forms.innerHTML =
                `<form method="POST" action="index.php">
                <input type="text" name="username" placeholder="Username"> <br>
                <input type="password" name="password" placeholder="Password"><br>
                <input type="submit" name="login" value="Login">
                </form>`
        }
        function register() {
            forms.innerHTML =
                `<form method="POST" action="register.php">
                <input type="text" name="username" placeholder="Username"> <br>
                <input type="password" name="password" placeholder="Password"><br>
                <input type="password" name="confirmPassword" placeholder="Repeat Password"><br>
                <input type="submit" name="register" value="Register">
                </form>`
        }
        </script>
        <?php
            include 'login.php';
        ?>

    
</body>
</html>