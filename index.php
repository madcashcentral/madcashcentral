<?php
// Start a session
session_start();

// Define script wide variables
include("vars.php");

// Connect to Database
require_once("db_connect.php");

// Load script functions
require("functions.php");

// Check if the user is logged in
if (isset($_SESSION["username"]) ) {
    header("Location: /users/");
    exit();
}

// Display page header
echo (getContent("head1"));

// Display page content
echo (getContent("1page"));

// Display page footer
echo (getContent("foot1"));
?>