<?php
session_start();

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true || !isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'project';

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION["email"];
$stmt = $conn->prepare("SELECT r.*, ud.course, ud.year, ud.degree, ud.profile_picture FROM registration r LEFT JOIN user_details ud ON r.Email = ud.Email WHERE r.Email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $admission_no = $row['Admissionno'];
    $course = $row['course'] ?? '';
    $year = $row['year'] ?? '';
    $degree = $row['degree'] ?? '';
    $profile_picture = $row['profile_picture'] ?? '';
} else {
    echo "Error retrieving profile information.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_course = filter_var($_POST["course"], FILTER_SANITIZE_STRING);
    $new_year = filter_var($_POST["year"], FILTER_SANITIZE_STRING);
    $new_degree = filter_var($_POST["degree"], FILTER_SANITIZE_STRING);

    $conn->begin_transaction();

    try {
        // Check if user exists in user_details
        $check_user = $conn->prepare("SELECT * FROM user_details WHERE Email = ?");
        $check_user->bind_param("s", $email);
        $check_user->execute();
        $user_result = $check_user->get_result();

        if ($user_result->num_rows > 0) {
            // User exists, update the details
            $update_details = $conn->prepare("UPDATE user_details SET course = ?, year = ?, degree = ? WHERE Email = ?");
            $update_details->bind_param("ssss", $new_course, $new_year, $new_degree, $email);
        } else {
            // User doesn't exist, insert new record
            $update_details = $conn->prepare("INSERT INTO user_details (Email, course, year, degree) VALUES (?, ?, ?, ?)");
            $update_details->bind_param("ssss", $email, $new_course, $new_year, $new_degree);
        }

        if (!$update_details->execute()) {
            throw new Exception("Error updating details: " . $conn->error);
        }

        // Handle profile picture upload
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
            $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
            $filename = $_FILES["profile_picture"]["name"];
            $filetype = $_FILES["profile_picture"]["type"];
            $filesize = $_FILES["profile_picture"]["size"];

            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");

            $maxsize = 5 * 1024 * 1024;
            if ($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");

            if (in_array($filetype, $allowed)) {
                // Create uploads directory if it doesn't exist
                if (!file_exists('uploads')) {
                    mkdir('uploads', 0777, true);
                }

                $file_destination = "uploads/" . uniqid() . "." . $ext;
                if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $file_destination)) {
                    $update_picture = $conn->prepare("UPDATE user_details SET profile_picture = ? WHERE Email = ?");
                    $update_picture->bind_param("ss", $file_destination, $email);
                    if (!$update_picture->execute()) {
                        throw new Exception("Error updating profile picture: " . $conn->error);
                    }
                    $profile_picture = $file_destination;
                } else {
                    echo "Error uploading file. ";
                }
            } else {
                echo "Error: There was a problem uploading your file. Please try again. ";
            }
        }

        $conn->commit();
        $course = $new_course;
        $year = $new_year;
        $degree = $new_degree;
        echo "Profile updated successfully!";
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error updating profile: " . $e->getMessage();
    }
}

// Fetch the latest user details after update
$stmt = $conn->prepare("SELECT r.*, ud.course, ud.year, ud.degree, ud.profile_picture FROM registration r LEFT JOIN user_details ud ON r.Email = ud.Email WHERE r.Email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $admission_no = $row['Admissionno'];
    $course = $row['course'] ?? '';
    $year = $row['year'] ?? '';
    $degree = $row['degree'] ?? '';
    $profile_picture = $row['profile_picture'] ?? '';
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        margin: 0;
        padding: 20px;
        background-color: #f4f4f4;
    }
    .container {
        max-width: 600px;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h2, h3 {
        color: #333;
    }
    form {
        margin-top: 20px;
    }
    input[type="text"], input[type="file"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    input[type="submit"]:hover {
        background-color: #45a049;
    }
    img {
        max-width: 200px;
        margin-top: 10px;
        border-radius: 5px;
    }
    small {
        color: #666;
    }
    a {
        color: #4CAF50;
        text-decoration: none;
    }
    a:hover {
        text-decoration: underline;
    }
</style>
</head>
<body>
<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($email); ?></h2>
    <h3>Profile Information:</h3>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        Email: <?php echo htmlspecialchars($email); ?><br><br>
        Admission Number: <?php echo htmlspecialchars($admission_no); ?><br><br>
        Course: <input type="text" name="course" value="<?php echo htmlspecialchars($course); ?>"><br>
        <small><?php echo $course ? '' : 'Details not provided'; ?></small><br><br>
        Year: <input type="text" name="year" value="<?php echo htmlspecialchars($year); ?>"><br>
        <small><?php echo $year ? '' : 'Details not provided'; ?></small><br><br>
        Degree: <input type="text" name="degree" value="<?php echo htmlspecialchars($degree); ?>"><br>
        <small><?php echo $degree ? '' : 'Details not provided'; ?></small><br><br>
        Profile Picture: <input type="file" name="profile_picture"><br>
        <?php if($profile_picture): ?>
            <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture" style="max-width: 200px;"><br>
        <?php else: ?>
            <small>Profile picture not provided</small><br>
        <?php endif; ?>
        <br>
        <input type="submit" value="Update Profile">
    </form>
    <br>
</div>
    <a href="login.php">Logout</a>
    <a href="dashboard.php">Dashboard</a>
</body>
</html>