<?php

    session_start();
    if(!isset($_SESSION['logged']))
    {
        header('Location: log_in.php');
        exit();
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Liga typera</title>
</head>
<body>
<div class="navbar">
    <ul class="nav_justify_content_end">
        <li class="nav_item">
            <a class="nav_link_active" href="#">Strona główna</a>
        </li>
        <li class="nav_item">
            <a class="nav_link" href="#">Crystal ball</a>
        </li>
        <li class="nav_item">
            <a class="nav_link" href="#">Obstawianie</a>
        </li>
        <li class="nav_item">
            <a class="nav_link" href="#">Tabela wyników</a>
        </li>
    </ul>
</div>
<div class="main_view">
    <div id="text">
<?php
    echo "<p>".$_SESSION['login'].", </p>";
?>
        <p>witaj w Lidze typera! <br> To tutaj będziesz mógł rywalizować z innymi <br> obstawiając mecze</p>
        <button><a class="button" href="logout.php">Wyloguj się</a></button>
    </div>
    <div id="football">
        <img src="footballer.png" alt="Football player">
    </div>
</div>
<footer>@Espresso38</footer>
</body>
</html>
