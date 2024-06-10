<?php

    session_start();
    if(!isset($_SESSION['successfull']))
    {
        header('Location: log_in.php');
        exit();
    }
    else
    {
        unset($_SESSION['successfull']);
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
    <p>Dziękujemy za rejestrację! <br> Możesz się teraz zalogować na swoje konto</p>
    <br><br>
    <a href="log_in.php">Zaloguj się</a>
</div>
<footer>@Espresso38</footer>
</body>
</html>
