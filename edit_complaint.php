<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true || !isset($_SESSION['email'])) {
  header("Location: login.php");
  exit;
}

$complaint_id = intval($_GET['id']);
$user_email = $_SESSION['email'];

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'project';

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Ensure complaint ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo "Error: Invalid or missing complaint ID.";
  echo "<br><a href='dashboard.php'>Back to Dashboard</a>";
  exit;
}

// Fetch the complaint details from the database, ensuring it belongs to the logged-in user
$sql = "SELECT c.complaint, c.complaintfile 
        FROM complaints c 
        JOIN registration r ON c.id = r.id 
        WHERE c.complaintno = ? AND r.Email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $complaint_id, $user_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
  echo "Error: Complaint not found or you don't have permission to edit it.";
  echo "<br><a href='dashboard.php'>Back to Dashboard</a>";
  exit;
}

$row = $result->fetch_assoc();
$complaint_text = $row['complaint'];
$current_file = $row['complaintfile'];

// Handle form submission for updating the complaint
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $new_complaint_text = $_POST['complaint'];

  // File upload handling
  $target_dir = "complaintdocs/";
  $file_path = $current_file; // Default to current file if no new file is uploaded

  if ($_FILES["fileToUpload"]["size"] > 0) {
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedExtensions = array("jpg", "jpeg", "png", "gif", "pdf", "doc", "docx");
    if (!in_array($imageFileType, $allowedExtensions)) {
      echo "Sorry, only JPG, JPEG, PNG, GIF, PDF, DOC & DOCX files are allowed.";
      $uploadOk = 0;
    }

    // Upload file if everything is ok
    if ($uploadOk == 1) {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $file_path = $target_file;
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }
  }

  // Update the complaint in the database
  $update_sql = "UPDATE complaints c
                 JOIN registration r ON c.id = r.id
                 SET c.complaint = ?, c.complaintfile = ? 
                 WHERE c.complaintno = ? AND r.Email = ?";
  $update_stmt = $conn->prepare($update_sql);
  $update_stmt->bind_param("ssis", $new_complaint_text, $file_path, $complaint_id, $user_email);
  
  if ($update_stmt->execute()) {
    echo "Complaint updated successfully!";
    header("Location: dashboard.php");
    exit;
  } else {
    echo "Error updating complaint: " . $conn->error;
  }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Complaint</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0e6ff; /* Light purple background */
      margin: 0;
      padding: 20px;
    }

    h2 {
      color: #8e44ad; /* Dark purple */
      text-align: center;
      margin-bottom: 30px;
    }

    form {
      max-width: 600px;
      margin: 0 auto;
      background-color: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    label {
      display: block;
      margin-bottom: 5px;
      color: #8e44ad; /* Dark purple */
    }

    textarea, input[type="file"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #d7b8ff; /* Light purple border */
      border-radius: 4px;
      box-sizing: border-box;
    }

    input[type="submit"] {
      background-color: #ff69b4; /* Hot pink */
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }

    input[type="submit"]:hover {
      background-color: #ff1493; /* Deep pink */
    }

    a {
      display: block;
      text-align: center;
      margin-top: 20px;
      color: #8e44ad; /* Dark purple */
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <h2>Edit Complaint</h2>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?id=' . $complaint_id); ?>" enctype="multipart/form-data">
    <label for="complaint">Complaint:</label>
    <textarea id="complaint" name="complaint" rows="4" cols="50"><?php echo htmlspecialchars($complaint_text); ?></textarea>
    
    <label for="fileToUpload">Select file to upload:</label>
    <input type="file" name="fileToUpload" id="fileToUpload">
    
    <input type="submit" value="Submit" name="submit">
  </form>
  <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>