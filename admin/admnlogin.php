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
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE name='$name'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION["name"] = $name;
            $_SESSION["issue"] = $row['issue'];

            // Debugging: Check the value of $_SESSION["issue"]
            echo "Issue: " . $_SESSION["issue"];

            switch ($_SESSION["issue"]) {
                case 'finance':
                    header("Location: finance_complaints.php");
                    exit;
                case 'exams':
                    header("Location: exams_complaints.php");
                    exit;
                case 'lecturer':
                    header("Location: lecturer_complaints.php");
                    exit;
                default:
                    $login_err = "Invalid issue";
            }
        } else {
            $login_err = "Invalid username or password";
        }
    } else {
        $login_err = "Invalid username or password";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f2f9f2; /* Light green background */
        }

        .container {
            width: 300px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #eafaea; /* Light green background */
        }

        form {
            margin-bottom: 20px; /* Add some space below the form */
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p.error {
            color: red;
            margin-top: 10px;
            margin-bottom: 0; /* Remove default bottom margin */
        }

        .signup-link {
            text-align: center;
        }

        .signup-link a {
            color: #007bff;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 style="text-align: center;">Admin Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            Name: <input type="text" name="name" required><br><br>
            Password: <input type="password" name="password" required><br><br>
            <input type="submit" value="Login">
            <?php if (isset($login_err)) echo "<p class='error'>$login_err</p>"; ?>
        </form>
        <div class="signup-link">
            Don't have an account? <a href="admin_register.php">Sign up now</a> to register.
        </div>
    </div>
</body>

</html>
