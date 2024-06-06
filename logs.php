<?php
    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if((!isset($_POST['login'])) || (!isset($_POST['password']))) {
        header('Location: log_in.php');
        exit();
    }

    require_once "connect.php";

    $connecting = new mysqli($host, $db_user, $db_password, $db_name);

    if ($connecting->connect_errno != 0) {
        echo "Error: ".$connecting->connect_errno . " Description: ".$connecting->connect_error;
    } else {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        $password = htmlentities($password, ENT_QUOTES, "UTF-8");

        $stmt = $connecting->prepare("SELECT * FROM logs WHERE login = ? AND password = ?");
        $stmt->bind_param("ss", $login, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        $n_users = $result->num_rows;
        if($n_users > 0) {
            $_SESSION['logged'] = true;

            $row = $result->fetch_assoc();
            $_SESSION['id'] = $row['id'];
            $_SESSION['login'] = $row['login'];

            unset($_SESSION['user_error']);
            $result->close();
            header('Location: index.php');
            exit();
        } else {
            $_SESSION['user_error'] = '<span>Nieprawidłowy login lub hasło!</span>';
            header('Location: log_in.php');
            exit();
        }

        $stmt->close();
        $connecting->close();
    }
?>
