<?php
// Start a session
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define script wide variables
include("vars.php");

// Connect to Database
require_once("db_connect.php");

// Load script functions
require("functions.php");


// Check if the user is logged in
if (isset($_SESSION["userid"])) {
    header("Location: ./users/");
    exit();
}

// Display page header
echo getContent("head1");
echo '<h1>Special Edition Directory Submitter</h1><br /> You can sign up here : <br /><br />';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["CreateAccount"])) {

    // Perform input validation
    $username = sanitizeInput($_POST["username"]);
    $email = sanitizeInput($_POST["email"]);
    $password = sanitizeInput($_POST["password"]);

    // Validate and process reCAPTCHA response
    $recaptchaResponse = $_POST["g-recaptcha-response"];
    $recaptchaValid = validateRecaptcha($recaptchaResponse);

    if ($recaptchaValid) {

        // Check if username already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            handleError("Username already exists.");
        } else {
            // Generate activation token
            $activationToken = generateActivationToken();

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the user into the database
	    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    
	    // Bind parameters
	    $stmt->bindParam(1, $username);
	    $stmt->bindParam(2, $email);
	    $stmt->bindParam(3, $hashedPassword);
    
	    // Execute the statement
	    $stmt->execute();

            if ($stmt->affected_rows == 1) {
                // Send account activation email
                // sendActivationEmail($email, $activationToken);
                echo "Registration successful!";
                // Redirect to the account activation page
                header("Location: ./activation.php");
                exit();
            } else {
                handleError($stmt->error);
                handleError("Registration failed.");
            }
	
        $stmt->close();

        closeDatabaseConnection($conn);
		} 
    } else {
        handleError("reCAPTCHA validation failed.");
    }
} else {



    echo '
<!DOCTYPE html>
<html>
<head>
    <title>Create User Account</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <h1>Create User Account</h1>

        <form method="POST" action="' . $_SERVER["PHP_SELF"] . '">
        <label for="username"><b>Username:</b></label>
        <input type="text" placeholder="Enter Username" name="username" required><br><br>
        <label for="email"><b>Email:</b></label>
        <input type="text" placeholder="Enter Email" name="email" required><br><br>
        <label for="password"><b>Password:</b></label>
        <input type="password" placeholder="Secure Password" name="password" required><br><br>
        <div class="g-recaptcha" data-sitekey="' . $recaptchaSiteKey . '"></div><br>
        <input type="submit" name="CreateAccount" value="CreateAccount">
        </form>
    ';


}
// Display page footer
echo (getContent("foot1"));
?>