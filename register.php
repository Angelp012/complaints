<?php
$HOSTNAME = 'localhost';
$USERNAME = 'root';
$PASSWORD = '';
$DATABASE = 'project';

$conn = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admission_no = trim($_POST['Admissionno'] ?? '');
    $email = trim($_POST['Email'] ?? '');
    $password = $_POST['Password'] ?? '';
    $confirmPassword = $_POST['ConfirmPassword'] ?? '';

    $validPrefixes = "/^(scci|sccf|scii|sccj|scie)/i";

    if (empty($admission_no) || empty($email) || empty($password) || empty($confirmPassword)) {
        echo "All fields are required.";
    } elseif (!preg_match($validPrefixes, $admission_no)) {
        echo "Registration Failed: Admission number must start with scci, sccf, scii, sccj, or scie.";
    } elseif (substr($email, -23) !== '@students.tukenya.ac.ke') {
        echo "Registration Failed: Email address must be from the 'students.tukenya.ac.ke' domain.";
    } elseif ($password !== $confirmPassword) {
        echo "Registration Failed: Passwords do not match.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO registration (Admissionno, Email, Password) VALUES (?, ?, ?)");
        
        if ($stmt) {
            $stmt->bind_param("sss", $admission_no, $email, $hashedPassword);
            if ($stmt->execute()) {
                echo "Registration successful! You can now log in.";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SCIT COMPLAINT SYSTEM</title>
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
               <h4 class="text-center fw-bolder fs-2">Login</h4>
               <p class="mb-3 fs-7">Already have an account ?</p>
               <a href="login.php"><button class="btn fw-bold mb-5 btn-outline-success px-4 rounded-pill">log In</button></a>
               <div class="img-cover p-4">
                    <img src="assets/images/loginbg.svg" alt="">
               </div>
            </div>
            <div class="col-lg-6 p vh-100">
               <div class="row d-flex vh-100">
                   <div class="col-md-8 p-4 ikigui m-auto text-center ,align-items-center">
                       <h4 class="text-center fw-bolder mb-4 fs-2">Register</h4>
                       <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"> 
                           <div class="input-group mb-4">
                               <span class="input-group-text border-end-0 inbg" id="basic-addon1"><i class="bi bi-person"></i></span>
                               <input type="text" class="form-control ps-2 border-start-0 fs-7 inbg form-control-lg mb-0" placeholder="Enter admission" name="Admissionno" required aria-describedby="basic-addon1">
                           </div>
                           <div class="input-group mb-4">
                               <span class="input-group-text border-end-0 inbg" id="basic-addon2"><i class="bi bi-envelope"></i></span>
                               <input type="email" class="form-control ps-2 border-start-0 fs-7 inbg form-control-lg mb-0" placeholder="Enter Email Address" name="Email" required aria-describedby="basic-addon2">
                           </div>
                           <div class="input-group mb-4">
                               <span class="input-group-text border-end-0 inbg" id="basic-addon3"><i class="bi bi-lock"></i></span>
                               <input type="password" class="form-control ps-2 fs-7 border-start-0 form-control-lg inbg mb-0" placeholder="Enter Password" name="Password" required aria-describedby="basic-addon3">
                           </div>    
                           <div class="input-group mb-4">
                               <span class="input-group-text border-end-0 inbg" id="basic-addon4"><i class="bi bi-lock"></i></span>
                               <input type="password" class="form-control ps-2 fs-7 border-start-0 form-control-lg inbg mb-0" placeholder="Confirm Password" name="ConfirmPassword" required aria-describedby="basic-addon4">
                           </div>  
                           <button type="submit" class="btn btn-primary">Register</button>
                       </form>
                   </div>
               </div>
            </div>
        </div>
    </div>  
</body>

<script src="assets/js/jquery-3.2.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/plugins/scroll-fixed/jquery-scrolltofixed-min.js"></script>
<script src="assets/plugins/testimonial/js/owl.carousel.min.js"></script>
<script src="assets/js/script.js"></script>

</html>