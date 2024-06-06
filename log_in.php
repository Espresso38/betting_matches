<?php

    session_start();
    if((isset($_SESSION['logged'])) && ($_SESSION['logged']==true))
    {
        header('Location: index.php');
        exit();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Logowanie</title>
</head>
<body>
<div class="login_view">
    <form class="login" action="logs.php" method="post">
        <p>Login:</p> <br> <input type="text" name="login"/> <br>
        <p>Hasło:</p> <br> <input type="password" name="password"/> <br> <br>
        <input type="submit" value="Zaloguj się"> <br> <br>
<?php
    if(isset($_SESSION['user_error'])) echo$_SESSION['user_error'];
?>
    <div>
        <p class="rejestr">Nie masz jeszcze konta? <a href="register.php">Zarejestruj się</a> </p>
    </div>
    </form>
</div>
<footer>@Espresso38</footer>
</body>
</html>
