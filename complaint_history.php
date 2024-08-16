<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit;
}

// Database connection details
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'project';

// Connect to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully";
}

// Get the user's email address from the session
if (isset($_SESSION['email'])) {
    $user_email = $_SESSION['email'];
} else {
    // If email isn't found in the session, show an error message and stop the script
    echo "Error: User email not found in session.";
    exit;
}

// Retrieve all complaints based on the user's email
$sql = "SELECT c.complaintno, c.complaint, r.resolution 
        FROM complaints c 
        LEFT JOIN resolutions r ON c.complaintno = r.complaintno 
        JOIN registration reg ON c.id = reg.id
        WHERE reg.Email = ?";

// Prepare and execute the statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

// Check for errors during query execution
if ($result === false) {
    echo "Error: " . $conn->error;
} else {
    // If no errors, process the query results (display complaints)
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint History</title>
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: white;
        color: #333;
        line-height: 1.6;
        padding: 20px;
    }
    h2 {
        text-align: center;
        color: #6c5ce7;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }
    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #fd79a8;
        color: white;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    tr:hover {
        background-color: #f1f1f1;
    }
    .back-link {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #6c5ce7;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    .back-link:hover {
        background-color: #5641d8;
    }
    .edit-link {
        color: #6c5ce7;
        text-decoration: none;
    }
    .edit-link:hover {
        text-decoration: underline;
    }
</style>
</head>
<body>
    <h2>Complaint History</h2>
    <table>
        <thead>
            <tr>
                <th>Complaint ID</th>
                <th>Complaint</th>
                <th>Resolution</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["complaintno"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["complaint"]) . "</td>";
                    echo "<td>" . (empty($row["resolution"]) ? "Pending" : htmlspecialchars($row["resolution"])) . "</td>";
                    echo "<td><a href='edit_complaint.php?id=" . htmlspecialchars($row["complaintno"]) . "' class='edit-link'>Edit</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No complaints found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <a href='dashboard.php' class="back-link">Back to Dashboard</a>
</body>
</html>

<?php
}
// Close the database connection
$stmt->close();
$conn->close();
?>