<?php
// Include the database connection file
require('config/db.php');

// Initialize variables to store user input
$name = $email = $comment = '';
$errors = array();

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user inputs to prevent SQL injection
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    // Basic validation
    if (empty($name)) {
        $errors[] = 'Name is required';
    }
    if (empty($email)) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    }
    if (empty($comment)) {
        $errors[] = 'Comment is required';
    }

    // If no errors, insert data into database
    if (empty($errors)) {
        $sql = "INSERT INTO comment (name, email, comment, created_at) VALUES ('$name', '$email', '$comment', NOW())";

        if (mysqli_query($conn, $sql)) {
            echo '<div class="alert alert-success">Comment added successfully</div>';
            // Clear input fields after successful submission
            $name = $email = $comment = '';
        } else {
            echo '<div class="alert alert-danger">Error: ' . mysqli_error($conn) . '</div>';
        }
    } else {
        // Display validation errors
        foreach ($errors as $error) {
            echo '<div class="alert alert-danger">' . $error . '</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #C1E899  ; /* Light yellow background */
            color: #333; /* Dark text color */
            padding: 20px;
        }
        .container {
            background-color: #fff; /* White background for the form container */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1); /* Soft shadow effect */
            max-width: 600px;
            margin: 0 auto;
        }
        h2 {
            color: #9A6735;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            color: #9A6735; 
            font-weight: bold;
        }
        .form-control {
            width: 97%;
            padding: 8px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        textarea.form-control {
            height: 100px; /* Adjust height for textarea */
        }
        .btn-primary {
            background-color: #9A6735; /* Dark pink button background */
            color: #fff; /* White text color */
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
        }
        .btn-primary:hover {
            background-color: #7A0A32; /* Darker shade on hover */
        }
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #D4EDDA; /* Success alert background color */
            border-color: #C3E6CB; /* Success alert border color */
            color: #155724; /* Success alert text color */
        }
        .alert-danger {
            background-color: #F8D7DA; /* Error alert background color */
            border-color: #F5C6CB; /* Error alert border color */
            color: #721C24; /* Error alert text color */
        }
        .welcome-container {
            margin-bottom: -30px;
            text-align: center;
        }
        .welcome-container h1 {
            color: white;
        }
        .image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: none;
            border-radius: 10px;
            overflow: hidden;
        }
        .image-container img {
            width: 30%;
        }
    </style>
</head>
<body>
<div class="welcome-container">
        <h1>Welcome to Bon Appétit Blog</h1>
    </div>
    <div class="image-container">
        <img src="logo.png" alt="Descriptive Alt Text">
    </div>
<div class="container">
    <h2>Add a Comment</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>">
        </div>
        <div class="form-group">
            <label for="comment">Comment:</label>
            <textarea id="comment" name="comment" class="form-control"><?php echo htmlspecialchars($comment); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="dashboard.php" class="btn btn-primary">Back</a>
    </form>
    <br>
</div>

    
</body>
</html>
