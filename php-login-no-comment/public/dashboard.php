<?php

use PhpLogin\Auth\Auth;
use PhpLogin\Db\Db;

require_once '../boot.php';

$auth = new Auth(new Db());
if (!$auth->check()) {
    header('Location: login.php');
    die();
}

require '../src/components/header.php'
?>

    <h1>Dashboard</h1>

    <a href="logout.php">Logout</a>

<?php
require '../src/components/footer.php';
