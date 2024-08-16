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
        header("Location: finance_complaints.php");
        exit;
    } else {
        echo "Error updating resolution: " . $conn->error;
    }
}

// Retrieve complaints for finance
$sql = "SELECT * FROM complaints WHERE name='finance'AND complaintno NOT IN (SELECT complaintno FROM resolutions)";
$result = $conn->query($sql);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $question = $_POST["question"];
  $answer = $_POST["answer"];

  // SQL query to insert or update the FAQ
  $sql = "INSERT INTO faqs (question, answer) VALUES ('$question', '$answer')";

  if ($conn->query($sql) === TRUE) {
      echo "FAQ added/updated successfully.";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Finance Complaints</title>
 <style>
   @import url('https://fonts.googleapis.com/css2?family=Times+New+Roman&display=swap');

   body {
     font-family: 'Times New Roman', serif;
     background-color: #F8F8FF;
     color: #333;
     margin: 0;
     padding: 0;
   }

   h2 {
     text-align: center;
     margin-top: 30px;
     color: #8B008B;
     text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
     font-size: 36px;
   }

   table {
     width: 90%;
     border-collapse: collapse;
     margin: 30px auto;
     border: 2px solid #4B0082;
     border-radius: 10px;
     overflow: hidden;
     box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
   }

   th,
   td {
     padding: 15px;
     text-align: left;
   }

   th {
     background-color: #8B008B;
     color: #FFF;
     font-weight: bold;
   }

   tr:nth-child(even) {
     background-color: #F8F8FF;
   }

   tr:nth-child(odd) {
     background-color: #E6E6FA;
   }

   tr:hover {
     background-color: #DDA0DD;
     color: #FFF;
   }

   td a {
     text-decoration: none;
     color: #8B008B;
     font-weight: bold;
   }

   td a:hover {
     color: #4B0082;
     text-decoration: underline;
   }

   textarea {
     width: 100%;
     padding: 8px;
     box-sizing: border-box;
     resize: vertical;
     border: 1px solid #CCC;
     border-radius: 5px;
     font-family: inherit;
   }

   input[type="submit"] {
     background-color: #8B008B;
     color: #FFF;
     border: none;
     padding: 8px 16px;
     cursor: pointer;
     border-radius: 5px;
     font-family: inherit;
     font-weight: bold;
   }

   input[type="submit"]:hover {
     background-color: #4B0082;
   }

   .no-complaints {
     text-align: center;
     margin-top: 20px;
     font-style: italic;
   }

   .resolution-form {
     display: inline-flex;
     align-items: center;
   }

   .resolution-form input[type="text"] {
     margin-right: 10px;
   }
 </style>
</head>

<body>
 <h2>Finance Complaints</h2>
 <table>
   <tr>
     <th>Name</th>
     <th>Email</th>
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
       echo "<tr><td colspan='5' class='no-complaints'>No complaints found for finance.</td></tr>";
   }
?>
</table>
 
</form>
</body>

</html>
        
    
