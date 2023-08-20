<?php
// Start a session
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define script wide variables
include("./vars.php");

// Connect to Database
require_once("./db_connect.php");

// Load script functions
require("./functions.php");

// Check if the user is logged in
if (isset($_SESSION["userid"])) {
    header("Location: /users/");
    exit();
}

// Display page header
echo getContent("reghead");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["CreateAccount"])) {

    // Perform input validation
    $username = sanitizeInput($_POST["username"]);
    $contact_name = sanitizeInput($_POST["contact_name"]);
    $contact_street = sanitizeInput($_POST["contact_street"]);
    $contact_postcode = sanitizeInput($_POST["contact_postcode"]);
    $email = sanitizeInput($_POST["email"]);
    $password = sanitizeInput($_POST["password"]);
//    $membershipLevel = sanitizeInput($_POST["membership_level"]);



    // Check if username already exists
	// Prepare SQL statement to select username
	$stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
	
	// Bind parameter
	$stmt->bindParam(1, $username);
		
	// Execute the statement
	$stmt->execute();
		
	// Fetch the result
	$result = $stmt->fetch();
		
	if ($result) {
		echo "Username '$username' already exists.<br /><a href='./registration.php'>Click here to try again</a>";
	} else {
		
	        // Generate activation token
	        $activationToken = generateActivationToken();
	        // Hash the password
	        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
		// Prepare SQL statement to insert a new User record
		$stmt = $conn->prepare("INSERT INTO users (username, contact_name, contact_street, contact_postcode, email, password, registration_date, verification_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		
		// Bind parameters
		$stmt->bindParam(1, $username);
		$stmt->bindParam(2, $contact_name);
		$stmt->bindParam(3, $contact_street);
		$stmt->bindParam(4, $contact_postcode);
		$stmt->bindParam(5, $email);
		$stmt->bindParam(6, $hashedPassword);
		$stmt->bindParam(7, $date);
		$stmt->bindParam(8, $activationToken);
		// Execute the statement
//			$stmt->execute();
		if ($stmt->execute()) { 
			// Send account activation email
			sendActivationEmail($email, $activationToken);
			echo "Registration successful!";
			// Redirect to the account activation page
			header("Location: activation.php");
			exit();
		} else {
			handleError($stmt->error);
			handleError("Registration failed.");
		}    
		echo "User record created successfully!";
	}

} else {

    echo '


<div class="container">
    <div class="row">
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h3>~ User Account Registration ~</h3>
                </div>
                <div class="card-body">
		<p class="text-center text-body-secondary">Submit your website to top Internet directories, gain Domain Authority (DA), supercharge your Search Engine Results Page ranking, and amplify your website SEO.</p>


<h6>Boost Your Online Presence with High Domain Authority and Enhanced SERP Ranking</h6><p class="text-center text-body-secondary">User Account Registration</p>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <form method="POST" action="' . $_SERVER["PHP_SELF"] . '">
        <label for="username"><b>Username :</b></label><input type="text" placeholder="Enter Username" name="username" required> 
	<label for="contact_name"><b>Name :</b></label><input type="text" placeholder="Enter Name" name="contact_name" id="contact_name" required><br /><br />
	<label for="contact_street"><b>Street :</b></label><input type="text" placeholder="Enter StreetName" name="contact_street" id="contact_street" required>
	<label for="contact_postcode"><b>Postcode :</b></label><input type="text" placeholder="Enter Postcode" name="contact_postcode" id="contact_postcode" required><br /><br />
        <label for="email"><b>Email :</b></label><input type="text" placeholder="Enter Email" name="email" required>
        <label for="password"><b>Password :</b></label><input type="password" placeholder="Secure Password" name="password" required><br /><br />
        <div class="g-recaptcha" data-sitekey="' . $recaptchaSiteKey . '"></div><br>
        <input type="submit" name="CreateAccount" value="CreateAccount">
        </form>


    </div>

</div>




<br /><br />
    ';


}

// Display page footer
echo (getContent("foot1"));
?>