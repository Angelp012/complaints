<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$HOSTNAME = 'localhost';
$USERNAME = 'root';
$PASSWORD = '';
$DATABASE = 'project';

$conn = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $issue = $_POST['issue'];

    $sql = "INSERT INTO admins (name, password, issue) VALUES ('$name', '$password', '$issue')";
    if ($conn->query($sql) === TRUE) {
        header("Location: admnlogin.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <style>
        body {
            background-color: white; /* Maintain white background */
            font-family: Arial, sans-serif; /* Use a common font */
        }

        h2 {
            color: blue; /* Set heading color to blue */
            text-align: center; /* Align heading center */
        }

        #registration-form {
            margin: 0 auto; /* Center align the form */
            width: 300px; /* Set width of the form */
            padding: 20px; /* Add some padding */
            border: 1px solid #ccc; /* Add border to the form */
            border-radius: 5px; /* Add border radius */
            box-shadow: 0 0 10px #00FF00; /* Add green illuminating shadow */
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%; /* Make input fields and select dropdown full width */
            padding: 10px; /* Add padding for input elements */
            margin-bottom: 10px; /* Add margin below input elements */
            border: 1px solid #ccc; /* Add border to input elements */
            border-radius: 5px; /* Add border radius */
        }

        input[type="submit"] {
            background-color: green; /* Set background color of submit button to green */
            color: white; /* Set text color of submit button to white */
            padding: 10px 20px; /* Add padding for submit button */
            border: none; /* Remove border from submit button */
            border-radius: 5px; /* Add border radius */
            cursor: pointer; /* Change cursor to pointer on hover */
            width: 100%; /* Make submit button full width */
        }

        input[type="submit"]:hover {
            background-color: darkgreen; /* Darken background color on hover */
        }

        #login-link {
            text-align: center; /* Center align the login link */
            margin-top: 20px; /* Add margin on top of the login link */
        }
        
        #login-link a {
            color: blue; /* Set link color to blue */
            text-decoration: none; /* Remove default underline */
        }

        #login-link a:hover {
            text-decoration: underline; /* Underline the link on hover */
        }
    </style>
</head>

<body>
    <h2>Admin Registration</h2>
    <div id="registration-form">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            Name: <input type="text" name="name" required><br><br>
            Password: <input type="password" name="password" required><br><br>
            Issue to Deal With:
            <select name="issue" required>
                <option value="finance">Finance</option>
                <option value="exams">Exams</option>
                <option value="lecturer">Lecturer</option>
            </select><br><br>
            <input type="submit" value="Register">
        </form>
    </div>
    <div id="login-link">
        <a href="login.php">Already have an account? Login here</a>
    </div>
</body>

</html>
