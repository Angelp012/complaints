<?php
session_start();

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: login.php");
    exit;
}

$HOSTNAME = 'localhost';
$USERNAME = 'root';
$PASSWORD = '';
$DATABASE = 'project';

$conn = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if resolution form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve complaint number and resolution from form
    $complaint_no = $_POST['complaint_no'];
    $resolution = $_POST['resolution'];

    // Insert resolution into resolutions table
    $insert_sql = "INSERT INTO resolutions (complaintno, resolution) VALUES ('$complaint_no', '$resolution')";

    if ($conn->query($insert_sql) === TRUE) {
        // Redirect back to the same page
        $user_email_sql = "SELECT email FROM complaints WHERE complaintno = ?";
        $stmt = $conn->prepare($user_email_sql);
        $stmt->bind_param("s", $complaint_no);
        $stmt->execute();
        $result = $stmt->get_result();
        $user_email = $result->fetch_assoc()['email'];

        // Send notification to the user
        require_once 'send-resolution-notification.php';
        notifyUserOfResolution($user_email, $complaint_no, $resolution);

        header("Location: exams_complaints.php");
        exit;
    } else {
        echo "Error inserting resolution: " . $conn->error;
    }
}

// Retrieve complaints for general
$sql = "SELECT * FROM complaints WHERE name='general' AND complaintno NOT IN (SELECT complaintno FROM resolutions)";
$result = $conn->query($sql);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>general Complaints</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        td a {
            text-decoration: none;
            color: #007bff;
        }

        td a:hover {
            text-decoration: underline;
        }

        textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            resize: vertical;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .no-complaints {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h2>Exam Complaints</h2>
    <table>
        <tr>
            <th>Complaint Number</th>
            <th>Complaint</th>
            <th>Complaint File</th>
            <th>Resolution</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["complaintno"] . "</td>";
                echo "<td>" . $row["complaint"] . "</td>";
                $file_path = $row["complaintfile"];
                $file_name = basename($file_path);
                if ($file_name) {
                    $file_path = "../complaintdocs/" . $file_name;
                    $file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

                    echo "<td>";
                    if (file_exists($file_path)) {
                        if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                            // Display image
                            echo "<img src='$file_path' alt='Complaint File' style='max-width: 100px; max-height: 100px;'>";
                        } elseif ($file_extension === 'pdf') {
                            // Display PDF icon and link
                            echo "<a href='$file_path' target='_blank'><img src='path/to/pdf-icon.png' alt='PDF Document' style='width: 50px; height: 50px;'></a>";
                        } elseif (in_array($file_extension, ['doc', 'docx'])) {
                            // Display Word document icon and link
                            echo "<a href='$file_path' target='_blank'><img src='path/to/word-icon.png' alt='Word Document' style='width: 50px; height: 50px;'></a>";
                        } else {
                            // For other file types, display a generic file icon and link
                            echo "<a href='$file_path' target='_blank'><img src='path/to/generic-file-icon.png' alt='File' style='width: 50px; height: 50px;'></a>";
                        }
                    } else {
                        echo "File not present";
                    }
                    echo "</td>";
                }
                // Check if complaint is resolved
                if (!empty($row["resolution"])) {
                    echo "<td>" . $row["resolution"] . "</td>";
                } else {
                    // Display resolution form
                    echo "<td>";
                    echo "<form class='resolution-form' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
                    echo "<input type='hidden' name='complaint_no' value='" . $row["complaintno"] . "'>";
                    echo "<input type='text' name='resolution' placeholder='Enter resolution'>";
                    echo "<input type='submit' value='Submit Resolution'>";
                    echo "</form>";
                    echo "</td>";
                }
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5' class='no-complaints'>No complaints found for exams.</td></tr>";
        }
        ?>
    </table>


</body>

</html>
