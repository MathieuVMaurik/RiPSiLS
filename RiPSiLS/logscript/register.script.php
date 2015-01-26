<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 13-1-2015
 * Time: 14:47
 */

require_once "../include/dbconnect.php";

if(isset($_POST['submit']))
{
    $errors = array();
    if(empty($_POST['username']))
    {
        $errors[] = 'Je hebt geen gebruikersnaam ingevuld!';
    }
    if(empty($_POST['password']) || empty($_POST['password_confirm']))
    {
        $errors[] = 'Je hebt geen wachtwoord ingevuld!';
    }
    if((isset($_POST['password']) && isset($_POST['password_confirm'])) && ($_POST['password'] != $_POST['password_confirm']))
    {
        $errors[] = 'Wachtwoorden komen niet overeen!';
    }

    //No errors, time to continue
    if(!$errors)
    {
        //First check if username is already taken
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $_POST['username']);
        $stmt->execute();

        if($stmt->fetch())
        {
            $errors[] = 'Deze gebruikersnaam bestaat al';
        }

        //Username does not yet exist
        if(!$errors)
        {
            $query = "INSERT INTO users (create_date, username, password) VALUES (:date, :username, :password)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':date', date('Y-m-d H:i:s'));
            $stmt->bindParam(':username', $_POST['username']);
            $stmt->bindParam(':password', password_hash($_POST['password'],PASSWORD_BCRYPT));
            $stmt->execute();

            header("Location: login.php?registered=1");
        }
    }
}