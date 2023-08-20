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
echo (getContent("privhead"));

// Display main page
echo (getContent("privp"));

// Display page footer
echo (getContent("foot1"));
?>