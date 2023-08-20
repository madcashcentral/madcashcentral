<?php
// Check if the user is logged in
if (isset($_SESSION["username"])) {
    // User is logged in, display user area
    // Define script wide variables
    include("../vars.php");
    // Connect to Database
    require_once("../db_connect.php");
    // Load script functions
    require("../functions.php");
    require("memfunctions.php");
    // Display page header
    echo (getContentByType("head2"));
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["title"], $_POST["category"], $_POST["description"], $_POST["address"])) {
        // Retrieve form data
        $title = cleanInput($_POST["title"]);
        $category = cleanInput($_POST["category"]);
        $description = cleanInput($_POST["description"]);
        $address = cleanInput($_POST["address"]);
        // Validate form data
        $errors = validateForm($title, $category, $description, $address);
        if (count($errors) > 0) {
            // Display validation errors
            foreach ($errors as $error) {
                echo "<p>Error: $error</p>";
            }
        } else {
            // Insert the link into the links table for each directory
            $directories = getDirectories($connection);

            if ($directories !== false) {
                foreach ($directories as $directory) {
                    $directoryId = $directory["id"];

                    $sql = "INSERT INTO links (user_id, directory_id, title, category, description, address) VALUES (?, ?, ?, ?, ?, ?)";
                    $statement = $connection->prepare($sql);
                    $statement->bind_param("iissss", $_SESSION["user_id"], $directoryId, $title, $category, $description, $address);
                    $statement->execute();
                }

                echo "<p>Link submitted successfully.</p>";
            } else {
                echo "<p>No directories found.</p>";
            }
        }
    }

    // Display submission form
    echo '
        <h1>Link Submission</h1>

        <form method="POST" action="' . $_SERVER["PHP_SELF"] . '">
            <label for="title">Title:</label><br>
            <input type="text" name="title" required><br><br>

            <label for="category">Category:</label><br>
            <input type="text" name="category" required><br><br>

            <label for="description">Description:</label><br>
            <textarea name="description" required></textarea><br><br>

            <label for="address">Address:</label><br>
            <input type="text" name="address" required><br><br>

            <input type="submit" value="Submit">
        </form>

        <br>
        <a href="logout.php">Logout</a>
    ';
} else {
    // User is not logged in, go to login
    header("Location: /login.php");
    exit();
}
?>