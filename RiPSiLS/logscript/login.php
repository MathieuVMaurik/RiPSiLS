
<html>
<head>
    <title>Login</title>
</head>

<body>

    <h1>Inloggen</h1>

    <?php if(!empty($login_incorrect)) { ?>
    <p class="warning">Verkeerd username of wachtwoord!</p>
    <?php } ?>

    <form action="../logscript/loginscript.php" method="post">
        Gebruikersnaam: <input name="username" type="text" /><br />
        Wachtwoord: <input name="password" type="password" /><br />
        <button type="submit">Inloggen</button>
    </form>
</body>

</html>