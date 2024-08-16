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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $user_email = $_SESSION["email"];
    $sql_id = "SELECT id FROM registration WHERE Email = ?";
    $stmt = $conn->prepare($sql_id);
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result_id = $stmt->get_result();
    $row_id = $result_id->fetch_assoc();
    $user_id = $row_id["id"];

    $name = htmlspecialchars(trim($_POST["name"]));
    $complaint = htmlspecialchars(trim($_POST["complaint"]));

    $target_dir = "complaintdocs/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check file size
    if ($_FILES["file"]["size"] > 5000000) {
        echo "Error: File is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedExtensions = array("jpg", "jpeg", "png", "gif", "pdf", "doc", "docx");
    if (!in_array($fileType, $allowedExtensions)) {
        echo "Error: Only JPG, JPEG, PNG, GIF, PDF, DOC & DOCX files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $file_path = $target_file;

            $sql = "INSERT INTO complaints (id, name, complaint, complaintfile) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isss", $user_id, $name, $complaint, $file_path);

            if ($stmt->execute()) {
                echo "Complaint submitted successfully!";
                header("Location: dashboard.php");
                exit;
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error uploading file.";
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 255, 0.5), 0 0 40px rgba(0, 255, 0, 0.5);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
        }

        select,
        textarea,
        input[type="file"],
        input[type="submit"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Submit a Complaint</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <label for="subject">Subject:</label>
            <select id="subject" name="name" required>
                <option value="finance">Finance</option>
                <option value="exams">Exams</option>
                <option value="lecturer">Lecturer</option>
                <option value="general">General</option>
            </select>
            <label for="complaint">Complaint:</label>
            <textarea id="complaint" name="complaint" rows="4" cols="50" required></textarea>
            <label for="file">File (if any):</label>
            <input type="file" id="file" name="file">
            <input type="submit"name="submit" value="Submit">
     <a href="dashboard.php">Back to Dashboard</a>
        </form>
    </div>
     
</body>

</html>