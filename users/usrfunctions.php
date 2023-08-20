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


?>