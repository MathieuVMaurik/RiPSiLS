
<html>
<head>
    <title>Login</title>
</head>

<body>

    <h1>Inloggen</h1>

    <?php if(!empty($login_incorrect)) { ?>
    <p class="warning">Verkeerde gebruikersnaam of wachtwoord!</p>
    <?php } ?>

    <?php if(isset($_GET['registered'])): ?>
        <p>Account succesvol aangemaakt, u kunt hieronder inloggen.</p>
    <?php endif; ?>

    <form action="../logscript/loginscript.php" method="post">
        Gebruikersnaam: <input name="username" type="text" /><br />
        Wachtwoord: <input name="password" type="password" /><br />
        <button type="submit">Inloggen</button>
    </form>

    <p><a href="../logscript/register.php">Nog geen account? Klik hier om jezelf te registreren.</a></p>
</body>

</html>