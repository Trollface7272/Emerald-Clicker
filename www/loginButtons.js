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
        `<form method="POST" action="index.php">
        <input type="text" name="username" placeholder="Username"> <br>
        <input type="password" name="password" placeholder="Password"><br>
        <input type="password" name="confirmPassword" placeholder="Repeat Password"><br>
        <input type="submit" name="register" value="Register">
        </form>`
}