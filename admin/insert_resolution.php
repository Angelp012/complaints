<?php
session_start();

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection parameters
    $HOSTNAME = 'localhost';
    $USERNAME = 'root';
    $PASSWORD = '';
    $DATABASE = 'project';

    $conn = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get data from the form
    $complaint_no = $_POST['complaint_no'];
    $resolution = $_POST['resolution'];

    // Insert resolution into resolutions table
    $insert_sql = "INSERT INTO resolutions (complaintno, resolution) VALUES ('$complaint_no', '$resolution')";

    if ($conn->query($insert_sql) === TRUE) {
        echo "Resolution submitted successfully!";
    } else {
        echo "Error: " . $insert_sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
