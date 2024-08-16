<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>SCIT Complaint System</title>
 <style>
   @import url('https://fonts.googleapis.com/css2?family=Times+New+Roman&display=swap');

   body {
     font-family: 'Times New Roman', serif;
     margin: 0;
     padding: 0;
     background-color: #white; /* Dark background color */
     color: #333; /* Dark text color for better contrast */
   }

   .header {
     background-image: url('assets/images/cms.jpg');
     background-size: cover;
     background-position: center;
     height: 250px;
     padding: 10px 20px;
     display: flex; /* Make header a flex container */
     justify-content: flex-end; /* Align navigation to the right */
   }

   nav {
     margin: 0;
     padding: 0;
   }

   nav ul {
     display: flex; /* Make navigation list a flex container */
     list-style: none; /* Remove default bullet points */
   }

   nav li {
     margin-right: 10px; /* Add space between navigation items */
   }

   nav a {
     text-decoration: none; /* Remove underline from links */
     color: #FF69B4; /* Hot pink text color */
     font-weight: bold;
     text-shadow: 1px 1px 2px rgba(255, 105, 180, 0.5); /* Text shadow */
   }

   nav a:hover {
     color: #FF1493; /* Deep pink hover color */
   }

   .container-fluid {
     max-width: 1200px;
     margin: 0 auto;
     padding: 20px;
   }

   .content {
     display: flex; /* Make content area a flex container */
     justify-content: center; /* Center content horizontally */
     margin-top: 20px; /* Add space after header */
     flex-wrap: wrap;
   }

   .complaint-info {
     margin-top: 20px;
     padding: 20px;
     background-color: #FFE4E1; /* Light coral background */
     border-radius: 10px;
     box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Soft shadow */
   }

   h1 {
     margin-bottom: 20px;
     color: #FF69B4; /* Hot pink color */
     text-shadow: 2px 2px 4px rgba(255, 105, 180, 0.5); /* Text shadow */
     font-family: 'Times New Roman', serif; /* Times New Roman font */
     font-size: 36px;
     text-align: center;
   }

   p {
     line-height: 1.5; /* Adjust line height for better readability */
   }

   .col-md-6 {
     padding: 0 10px;
   }

   .card {
     background-color: #FAFAD2; /* Light yellow background */
     margin: 10px 0; /* Add space between containers */
     border-radius: 10px;
     box-sizing: border-box; /* Ensure consistent width calculation */
     box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add subtle shadow */
   }

   .card-body {
     padding: 20px;
     text-align: center; /* Center text within containers */
   }

   .btn {
     display: block;
     width: 100%;
     padding: 10px;
     border: none;
     border-radius: 5px;
     cursor: pointer;
     font-weight: bold;
     text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3); /* Text shadow */
   }

   .btn-primary {
     background-color: #FF69B4; /* Hot pink background */
     color: #fff; /* Button text color */
   }

   .btn-primary:hover {
     background-color: #FF1493; /* Deep pink hover color */
   }

   .btn-info {
     background-color: #FF69B4; /* Hot pink background */
     color: #fff; /* Button text color */
   }

   .btn-info:hover {
     background-color: #FF1493; /* Darker pink hover color */
   }
 </style>
</head>
<body>
<?php
 session_start();

 if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
   header("Location: login.php");
   exit;
 }
?>
<header class="header">
 <nav>
   <ul>
     <li><a href="profile.php">Profile</a></li>
     <li><a href="faqs.php">FAQs</a></li>
     <li><a href="login.php">Logout</a></li>
   </ul>
 </nav>
</header>
<div class="container-fluid">
 <div class="row">
   <div class="col-md-6"> 
     <div class="content">
       <div class="complaint-info">
         <h1>Efficient Complaint Handling</h1>
         <p>The SCIT Complaint System ensures all complaints are addressed in a timely and professional manner. We are committed to a fair and transparent process, and your privacy is always a priority.</p>
         <p>Our system streamlines the process of submitting complaints, tracking progress, and providing resolutions. We value your feedback and strive to continuously improve our services.</p>
       </div>
     </div>
   </div>
   <div class="col-md-6"> 
     <div class="row">
       <div class="col-md-6"> <!-- Adjust column width to half of the container width -->
         <div class="card">
           <div class="card-body text-center">
             <a href="make complaint.php" class="btn btn-primary btn-lg">Make a Complaint</a>
             <p>Report a new issue or concern.</p>
           </div>
         </div>
       </div>
       <div class="col-md-6"> <!-- Adjust column width to half of the container width -->
         <div class="card">
           <div class="card-body text-center">
             <a href="complaint_history.php" class="btn btn-info btn-lg">View Past Complaints</a>
             <p>Review your past complaints.</p>
           </div>
         </div>
       </div>
     </div>
   </div>
 </div>
</div>
<script src="push-notification.js"></script>
</body>
</html>