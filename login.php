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
echo (getContent("loghead"));

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    // Perform input validation
    $username = sanitizeInput($_POST["username"]);
    $password = sanitizeInput($_POST["password"]);
    $userid = 0;
    // Retrieve the user from the database
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = :username");
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $hashedPassword = $result["password"];

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Start the session and set user information
            $_SESSION["username"] = $username;

            // Redirect to the membership page
            header("Location: /users/");
            exit();
        } else {
            handleError("Invalid username or password.");
		// Display page footer
		echo (getContent("foot1"));
        }
    } else {
        handleError("Invalid username or password.");
		// Display page footer
		echo (getContent("foot1"));
    }
}

// Close the database connection
$conn = null;
?>

<div class="container">
    <div class="row">
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h3>~ User Account Login ~</h3>
                </div>
                <div class="card-body">
		<p class="text-center text-body-secondary">Submit your website to top Internet directories, gain Domain Authority (DA), supercharge your Search Engine Results Page ranking, and amplify your website SEO.</p>

<style>
#content1 {
  padding: 0.5rem;
  display: flex;
}

#left,
#right {
  padding: 0.5rem;
  flex-grow: 1;
  color: #000;
}
</style>

<div id="content1" class="align-items-center">
  <div id="left">
     <div id="object1"><br />

<h6>BOOST YOUR ONLINE PRESENCE WITH HIGH DOMAIN AUTHORITY AND ENHANCED SERP RANKING</h6>

<p class="text-center text-body-secondary">Login to your User Account :</p>

	<form method="POST" action="login.php">
        <label for="username">Username :</label>
        <input type="text" name="username" required><br />

        <label for="password">Password :</label>
        <input type="password" name="password" required><br /><br />


        <input type="submit" name="login" value="Login">
        </form>
     </div>
  </div>

  <div id="right">
     <div id="object3"><a href="./registration.php" title="Create an account on Special Edition Link Directory Submitter"><img src="/banners/bigsitebanner1.png" width="540" height="350" alt="Create an account on Special Edition Link Directory Submitter"></a></div>
  </div>
</div>

                </div>
            </div>
        </div>
    </div>
</div>
<br /><br />
<?php
// Display page footer
echo (getContent("foot1"));
?>