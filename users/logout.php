<?php
// Start a session
session_start();

// Define script wide variables
include("../vars.php");

// Connect to Database
require_once("../db_connect.php");

// Load script functions

require("../functions.php");

// Check if the user is logged in
if (isset($_SESSION["username"])) {
    // User is logged in, Display page header

    echo (getContent("head1"));
    echo "<H3>You have been logged out of the system </H3>";
    // Close the database connection
    echo (getContent("foot1"));
    $conn = null;

    // Erase Session Information
    unset($_SESSION['username']);
    $_SESSION = array();
    session_destroy();

} else {
    // User is not logged in, go to login
    header("Location: /login.php");
    exit();
}
?>