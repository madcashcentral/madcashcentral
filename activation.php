<?php
if (isset($_SESSION["userid"])) {
    header("Location: /users/");
    exit();
}

// Start a session
session_start();

// Define script wide variables
include("vars.php");

// Connect to Database
require_once("db_connect.php");


// Load script functions
require("functions.php");

// Display page header
echo (getContent("head1"));

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["token"])) {
    $activationToken = sanitizeInput($_GET["token"]);

    $conn = connectToDatabase();

    // Check if the activation token is valid and hasn't expired
    $stmt = $conn->prepare("SELECT id FROM members WHERE activation_token = ? AND activation_expires > NOW()");
    $stmt->bind_param("s", $activationToken);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        // Activate the account
        $stmt = $conn->prepare("UPDATE users SET is_verified = 1 WHERE activation_token = ?");
        $stmt->bind_param("s", $activationToken);
        $stmt->execute();

        if ($stmt->affected_rows == 1) {
            // Redirect to the login page
            header("Location: login.php");
            exit();
        } else {
            handleError("Account activation failed.");
        }
    } else {
        handleError("Invalid or expired activation token.");
    }

    $stmt->close();
    closeDatabaseConnection($mysqli);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Account Activation</title>
</head>
<body>
    <h2>Account Activation</h2>
    <p>Please click the activation link that was sent to your email to activate your account.</p>
</body>
</html>

<?php
// Display page footer
echo (getContent("foot1"));
?>