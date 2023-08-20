<?php
// Database configuration
// defined('BASEPATH') OR exit('No direct script access allowed'); //prevent direct script access
Global $conn;
$DB_HOST = 'localhost'; // database host name or ip address
$DB_USER = 'root'; // database username
$DB_PASS = ''; // database password
$DB_NAME = 'sublinks'; // database name
$DB_ENCODING = 'utf8mb4'; // db character encoding. set to match your database table's character set. note: utf8 is an alias of utf8mb3/utf8mb4
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // set the error mode to exceptions (this is the default setting now in php8+)
			PDO::ATTR_EMULATE_PREPARES => false, // run real prepared queries
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // set default fetch mode to assoc
			];
$conn = new pdo("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=$DB_ENCODING",$DB_USER,$DB_PASS,$options);
?>
