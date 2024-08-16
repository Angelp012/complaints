<?php
session_start();

$HOSTNAME = 'localhost';
$USERNAME = 'root';
$PASSWORD = ''; 
$DATABASE = 'project';

$conn = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}



if(isset($_POST["submit"])){
    if(isset($_POST["Password"])) { // Check if "Password" key exists
        $Email = $_POST["Email"];
        $Password = $_POST["Password"];
        
        // Modified SQL query to check email or admission number
        $result = mysqli_query($conn, "SELECT * FROM registration WHERE Email='$Email'");
        $row = mysqli_fetch_assoc($result);
        
        if (mysqli_num_rows($result) > 0) {
            if (password_verify($Password, $row["Password"])) { // Verify hashed password
                $_SESSION["logged_in"] = true;
                // $_SESSION['id'] = $user_id;
                $_SESSION['id'] = $row["id"];
                $_SESSION["email"] = $row["Email"];
                    echo "Email from database: " . $row["Email"];
                    echo  "<script> alert('Login successful'); </script>";
                header("Location: dashboard.php");
                exit(); // Add exit to prevent further script execution
            } else {
                echo "<script> alert('Password is not correct'); </script>";
            }  
        } else {
            echo "<script> alert('Username is not registered'); </script>";
        }
    } else {
        // Handle the case where "Password" key is not set
        echo "<script> alert('Password is required'); </script>";
    }
   
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SCIT COMPLAINT</title>
    <link rel="shortcut icon" href="assets/images/fav.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="assets/images/fav.jpg">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
</head>
<body class="bg-white">
    <div class="container-fluid vh-100 overflow-auto">
        <div class="row vh-100 ">
            <div class="col-lg-6 bg-gray p-5 text-center">
               <h4 class="text-center fw-bolder fs-2">Register</h4>
               <p class="mb-3 fs-7">Register Now</p>
               <a href="register.php">
                   <button class="btn fw-bold mb-5 btn-outline-success px-4 rounded-pill">Sign Up</button>
               </a>
               <div class="img-cover p-4">
                    <img src="assets/images/loginbg.svg" alt="">
               </div>
            </div>
            <div class="col-lg-6 p vh-100">
               <div class="row d-flex vh-100">
                   <div class="col-md-8 p-4 ikigui m-auto text-center align-items-center">
                       <h4 class="text-center fw-bolder mb-4 fs-2">Login</h4>
                       <form action="login.php" method="post"> 
                           <div class="input-group mb-4">
                                <span class="input-group-text border-end-0 inbg" id="basic-addon1"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control ps-2 border-start-0 fs-7 inbg form-control-lg mb-0" placeholder="Enter Email address" aria-label="Username" aria-describedby="basic-addon1" name="Email">
                           </div>
                           <div class="input-group mb-4">
                                <span class="input-group-text border-end-0 inbg" id="basic-addon1"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control ps-2 fs-7 border-start-0 form-control-lg inbg mb-0" placeholder="Enter Password" aria-label="Password" aria-describedby="basic-addon1" name="Password">
                           </div>
                           <button type="submit" class="btn btn-lg fw-bold fs-7 btn-success w-100" name="submit">Login</button>
                           
                       </form>
                   </div>
               </div>
            </div>
        </div>
    </div>  
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/plugins/scroll-fixed/jquery-scrolltofixed-min.js"></script>
    <script src="assets/plugins/testimonial/js/owl.carousel.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
