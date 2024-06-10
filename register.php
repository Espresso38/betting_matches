<?php
session_start();

if(isset($_POST['email'])) {
    // Good validation
    $all_good = true;

    // Checking username
    $username = $_POST['username'];

    if((strlen($username) < 3) || (strlen($username) > 15)) {
        $all_good = false;
        $_SESSION['e_username'] = "Nazwa użytkownika musi zawierać od 3 do 15 znaków";
    }

    if(!ctype_alnum($username)) {
        $all_good = false;
        $_SESSION['e_username'] = "Nazwa użytkownika może się składać tylko z liter i cyfr";
    }

    // Checking email
    $email = $_POST['email'];
    $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

    if((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email)) {
        $all_good = false;
        $_SESSION['e_email'] = "Podaj poprawny adres e-mail";
    }

    // Checking password
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if((strlen($password) < 6) || (strlen($password) > 15)) {
        $all_good = false;
        $_SESSION['e_password'] = "Hasło musi zawierać od 6 do 15 znaków";
    }

    if($password != $cpassword) {
        $all_good = false;
        $_SESSION['e_cpassword'] = "Hasła muszą być takie same";
    }

    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try {
        $connecting = new mysqli($host, $db_user, $db_password, $db_name);
        if($connecting->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {
            // Checking existing email
            $result = $connecting->query("SELECT id FROM logs WHERE email='$email'");
            if(!$result) throw new Exception($connecting->error);

            $n_email = $result->num_rows;
            if($n_email > 0) {
                $all_good = false;
                $_SESSION['e_email'] = "Istnieje już konto o podanym e-maliu";
            }

            // Checking existing username
            $result = $connecting->query("SELECT id FROM logs WHERE login='$username'");
            if(!$result) throw new Exception($connecting->error);

            $n_user = $result->num_rows;
            if($n_user > 0) {
                $all_good = false;
                $_SESSION['e_username'] = "Istnieje już konto o podanej nazwie użytkownika";
            }

            if($all_good == true) {
                // Adding user to database
                if($connecting->query("INSERT INTO logs VALUES (NULL, '$username', '$hashed_pass', '$email')")) {
                    $_SESSION['successfull'] = true;
                    header('Location: welcome.php');
                    exit(); // Ensure the script stops after redirection
                } else {
                    throw new Exception($connecting->error);
                }
            }

            $connecting->close();
        }
    } catch(Exception $e) {
        echo '<span>Błąd serwera! Zarejestruj się później</span>';
        echo '<br>Informacja deweloperska: ' . $e;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Rejestracja</title>
</head>
<body>
<div class="register_view">
    <form class="register" action="register.php" method="post">
        <p>Nazwa użytkownika:</p> <br> <input type="text" name="username"/> <br>
        <?php
        if(isset($_SESSION['e_username'])) {
            echo '<div class="error">' . $_SESSION['e_username'] . '</div>';
            unset($_SESSION['e_username']);
        }
        ?>
        <p>Email:</p> <br> <input type="text" name="email"/> <br>
        <?php
        if(isset($_SESSION['e_email'])) {
            echo '<div class="error">' . $_SESSION['e_email'] . '</div>';
            unset($_SESSION['e_email']);
        }
        ?>
        <p>Twoje hasło:</p> <br> <input type="password" name="password"/> <br>
        <?php
        if(isset($_SESSION['e_password'])) {
            echo '<div class="error">' . $_SESSION['e_password'] . '</div>';
            unset($_SESSION['e_password']);
        }
        ?>
        <p>Powtórz hasło:</p> <br> <input type="password" name="cpassword"/> <br>
        <?php
        if(isset($_SESSION['e_cpassword'])) {
            echo '<div class="error">' . $_SESSION['e_cpassword'] . '</div>';
            unset($_SESSION['e_cpassword']);
        }
        ?>
        <br>
        <input type="submit" value="Zarejestruj się"> <br> <br>
        <?php
        if(isset($_SESSION['users_error'])) echo $_SESSION['users_error'];
        ?>
        <div>
            <p class="rejestr">Masz już konto? <a href="#">Zaloguj się</a> </p>
        </div>
    </form>
</div>
<footer>@Espresso38</footer>
</body>
</html>
