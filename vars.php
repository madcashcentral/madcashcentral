<?php
// MySQL database access host - usually localhost or mysql

//MySQL database host
define("DB_HOST", "localhost");
$DB_HOST=DB_HOST;

//MySQL database username
define("DB_USER", "root");
$DB_USER = DB_USER;

//MySQL database password
define("DB_PASS", "");
$DB_PASS = DB_PASS;

//MySQL database name
define("DB_NAME", "u379614330_sublink");
$DB_NAME = DB_NAME;

define("CONN", "");
$conn=CONN;

global $conn, $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

//The name of your traffic exchange

define("SITE_TITLE", "Link Directory Submitter");

//Your traffic exchange domain - do not add http:// or a trailing slash!
define("SITE_DOMAIN", "submit.studio4tunes.com");


//Your site URL - no need to edit
define("SITE_URL", "https://" . SITE_DOMAIN . "/");

// reCAPTCHA configuration
$recaptchaSiteKey = "6LcRgRIaAAAAABVCdKc5y1WEEhsal5J63mFOPv4G";
$recaptchaSecretKey = "6LcRgRIaAAAAABeU589G39732MmwcAhI0ftebUWq";

?>