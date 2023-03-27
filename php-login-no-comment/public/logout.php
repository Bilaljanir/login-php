<?php

use PhpLogin\Auth\Auth;
use PhpLogin\Db\Db;

require_once '../boot.php';

$auth = new Auth(new Db());
$auth->logout();

header('Location: index.php');
