<?php
// Retrieve data from your database
$host = "localhost";
$username = "u379614330_submit";
$password = "]BpD^6cXmR+J0=[8";
$database = "u379614330_sublink";

// Create a database connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check if the connection is successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch the required data from your database
$query = "SELECT title, category, description, address FROM links";
$result = mysqli_query($conn, $query);

// Check if data retrieval was successful
if (!$result) {
    die("Data retrieval failed: " . mysqli_error($conn));
}

// Create the form
echo '<form method="post" action="https://ussitedir.com/add-url">';

// Loop through the fetched data
while ($row = mysqli_fetch_assoc($result)) {
    // Extract the values
    $title = $row['title'];
    $category = $row['category'];
    $description = $row['description'];
    $address = $row['address'];

    // Output the form fields with the retrieved data
    echo '<input type="text" name="title" value="' . $title . '"><br>';
    echo '<input type="text" name="category" value="' . $category . '"><br>';
    echo '<input type="text" name="description" value="' . $description . '"><br>';
    echo '<input type="text" name="address" value="' . $address . '"><br>';

    // Add any additional fields as needed for the submission form

    echo '<input type="submit" value="Submit">';
}

// Close the form
echo '</form>';

// Close the database connection
mysqli_close($conn);
?>