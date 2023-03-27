<?php

use PhpLogin\Auth\Auth;
use PhpLogin\Db\Db;

require_once '../boot.php';

$auth = new Auth(new Db());

if ($auth->check()) {
    header('Location: dashboard.php');
    die();
}

if (isset($_POST['submit'])) {
    if ($auth->login($_POST['email'], $_POST['password'])) {
        header('Location: dashboard.php');
        die();
    }

    echo 'Il y a eu une erreur, veuillez réessayer !';
}


require '../src/components/header.php'
?>

    <h1>Le login</h1>

    <form action="login.php" method="post">
        <label for="email">Email</label>
        <input name="email" id="email" type="email">

        <label for="password">Password</label>
        <input name="password" id="password" type="password">
        <input type="submit" name="submit" value="Se connecter">
    </form>

<?php
require '../src/components/footer.php';
