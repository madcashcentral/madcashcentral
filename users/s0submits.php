<?php
// Start a session
session_start();

// Define script wide variables
include("../vars.php");

// Connect to Database
require_once("../db_connect.php");

// Load script functions

require("../functions.php");
require("admfunctions.php");



// Check if the user is logged in
if (isset($_SESSION["user_id"])) {
    // User is logged in, Display page header

    echo (getContent("admn"));

echo " a list of members paid submissions here ";


    echo (getContent("admnft"));
} else {
    // User is not logged in, go to login
    header("Location: /submit/madmin/login.php");
    exit();
}
?>