<?php
// Start a session
session_start();

// Define script wide variables
include("vars.php");

// Connect to Database
require_once("db_connect.php");

// Load script functions
require("functions.php");

// Display page header
echo (getContent("termhead"));

// Display main page
echo (getContent("terms"));

// Display page footer
echo (getContent("foot1"));
?>