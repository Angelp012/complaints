<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>SCIT Complaint System</title>
 <style>
   @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

   body {
     font-family: 'Montserrat', sans-serif;
     margin: 0;
     padding: 0;
     background-color: #f5f5f5; /* Light gray background */
     color: #333; /* Dark text color for better contrast */
   }

   .container {
     max-width: 800px;
     margin: 0 auto;
     padding: 40px 20px;
     text-align: center;
   }

   h1 {
     margin-bottom: 30px;
     font-size: 36px;
     color: #007bff; /* Primary color */
     text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2); /* Text shadow */
   }

   p {
     font-size: 18px;
     line-height: 1.6;
     margin-bottom: 40px;
   }

   .btn {
     padding: 15px 30px;
     background-color: #007bff; /* Primary button color */
     color: #fff; /* Button text color */
     border: none;
     border-radius: 30px;
     cursor: pointer;
     text-decoration: none;
     margin: 10px;
     font-weight: 700;
     box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Button shadow */
     transition: all 0.3s ease; /* Smooth transition */
   }

   .btn:hover {
     background-color: #0056b3; /* Darker hover color */
     box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2); /* Increased shadow on hover */
   }

   img {
     max-width: 100%;
     height: auto;
     margin-bottom: 40px;
     border-radius: 10px;
     box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Image shadow */
   }
 </style>
</head>
<body>

<div class="container">
 <h1>Welcome to the SCIT Complaint System</h1>
 <img src="assets/images/complain.jpg" alt="SCIT Complaint System" width="400">
 <p>The SCIT Complaint System is a user-friendly platform designed to streamline the process of addressing and managing complaints within our institution. Our goal is to provide a transparent and efficient system that fosters open communication and ensures timely resolution of concerns.</p>
 <p>This system empowers you to voice your complaints or manage reported issues with ease. By promoting a culture of active feedback and responsiveness, we strive to continuously improve our services and create a positive learning environment for all.</p>
 <a href="login.php" class="btn">Student Login</a>
 <a href="admin/admnlogin.php" class="btn">Admin Login</a>
</div>

</body>
</html>