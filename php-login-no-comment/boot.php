<?php

// This file boots the php app
require 'vendor/autoload.php';

session_start();

$dotenv = new Symfony\Component\Dotenv\Dotenv();
$dotenv->load(__DIR__ . '/.env');
