<?php
// Function to clean user input
function cleanInput($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// Function to validate form data
function validateForm($title, $category, $description, $address)
{
    $errors = array();

    if (empty($title)) {
        $errors[] = "Title is required.";
    }

    if (empty($category)) {
        $errors[] = "Category is required.";
    }

    if (empty($description)) {
        $errors[] = "Description is required.";
    }

    if (empty($address)) {
        $errors[] = "Address is required.";
    }

    return $errors;
}

// Function to get all directories from the database
function getDirectories($connection)
{
    $directories = array();

    $sql = "SELECT * FROM directories";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $directories[] = $row;
        }
    } else {
        return false;
    }

    return $directories;
}
?>