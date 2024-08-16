<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs - Complaint System</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        line-height: 1.6;
    }
    
    .container {
        max-width: 800px;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    
    .header {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
    }
    
    .faq {
        margin-bottom: 20px;
    }
    
    .question {
        cursor: pointer;
        background-color: #e9e9e9;
        padding: 15px;
        border-radius: 4px;
        transition: background-color 0.3s ease;
        font-weight: bold;
        color: #333;
    }
    
    .question:hover {
        background-color: #d4d4d4;
    }
    
    .answer {
        display: none;
        padding: 15px;
        border: 1px solid #e9e9e9;
        border-radius: 4px;
        margin-top: 10px;
        background-color: #f9f9f9;
    }
    .answer.show {
        display: block;
    }
    .answer p {
        margin-bottom: 10px;
    }
    
    .answer ul {
        list-style-type: disc;
        margin-left: 20px;
    }
    
    .answer li {
        margin-bottom: 5px;
        line-height: 1.5;
    }
</style>
</head>
<body>
    <div class="container">
        <h1 class="header">FAQs - Complaint System</h1>
        
        <div class="faq">
            <h2 class="question">What is a complaint system?</h2>
            <div class="answer">
                <p>A complaint system allows individuals to register grievances or express dissatisfaction with a service or product provided by an organization.</p>
                <p>Complaint systems are designed to handle and resolve issues effectively, ensuring customer satisfaction and organizational improvement.</p>
            </div>
        </div>

        <div class="faq">
            <h2 class="question">Missing result for unit 'xxx'</h2>
            <div class="answer">
                <p>Contact lecturer who taught the unit </p>
                
            </div>
        </div>

        <div class="faq">
            <h2 class="question">Missing name on graduation list</h2>
            <div class="answer">
                <p>Check results if you have any missing marks, if you dont, head to director's office</p>
            </div>
        </div>
    </div>
    <a href="dashboard.php">dashboard</a>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const questions = document.querySelectorAll('.question');
        
            questions.forEach(question => {
                question.addEventListener('click', function() {
                    const answer = this.nextElementSibling;
                    answer.classList.toggle('show'); // Toggle the 'show' class
                });
            });
        });
                
    </script>
    <script src="push-notification.js"></script>
</body>
</html>