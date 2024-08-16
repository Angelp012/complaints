<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    // If not logged in, return an error response
    http_response_code(401); // Unauthorized
    echo "Unauthorized";
    exit;
}

// Database connection details (replace with your actual details)
$servername = "localhost";
$username = "root";
$password = "";
$database = "project";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check for connection errors
if ($conn->connect_error) {
    http_response_code(500); // Internal Server Error
    echo "Error connecting to the database: " . $conn->connect_error;
    exit;
}

// Get the user email from the session
$user_email = $_SESSION["email"];

// Get the form data from the POST request
$course = $_POST["course"];
$year = $_POST["year"];
$degree = $_POST["degree"];

$sql_check = "SELECT * FROM user_details WHERE email = '$user_email'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    // User exists, update the record
    $sql = "UPDATE user_details SET course = ?, year = ?, degree = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $course, $year, $degree, $user_email);
} else {
    // User does not exist, insert a new record
    $sql = "INSERT INTO user_details (email, course, year, degree) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $user_email, $course, $year, $degree);
}

// Execute the SQL statement
if ($stmt->execute()) {
    http_response_code(200); // OK
    echo "User details updated successfully";
} else {
    http_response_code(500); // Internal Server Error
    echo "Error updating user details: " . $stmt->error;
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();
?>