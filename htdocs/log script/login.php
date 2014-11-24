<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 4-11-2014
 * Time: 11:01
 *
 * This login script will not work on any PHP version lower than 5.4.
 */

session_start();

require_once "../include/dbconnect.php";

if(isset($_POST['username']) && isset($_POST['password']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $db->prepare('SELECT ID, password FROM users WHERE username = :username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch();

    if($user)
    {
        if(password_verify($password, trim($user['password'])))
        {
            $_SESSION['userID'] = $user['ID'];
            $_SESSION['user'] = $username;
            header('Location: index.php');
            exit();
        }
        else
        {
            $login_incorrect = true;
        }
    }
    else
    {
        $login_incorrect = true;
    }
}

?>

<html>
<head>
    <title>Login</title>
</head>

<body>

    <h1>Inloggen</h1>

    <?php if(!empty($login_incorrect)) { ?>
    <p class="warning">Verkeerd username of wachtwoord!</p>
    <?php } ?>

    <form action="login.php" method="post">
        Gebruikersnaam: <input name="username" type="text" /><br />
        Wachtwoord: <input name="password" type="password" /><br />
        <button type="submit">Inloggen</button>
    </form>
</body>

</html>