<?php
require('config/db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        // Set session variables
        $_SESSION['username'] = $username;
        // Redirect to index page
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #55883B;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .welcome-container {
            margin-bottom: -30px;
            text-align: center;
        }
        .welcome-container h1 {
            color: white;
        }
        .signin-container {
            background-color: #C1E899;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .signin-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .signin-container input {
            width: 93%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .signin-container button {
            width: 100%;
            padding: 10px;
            background-color: #9A6735;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .signin-container button:hover {
            background-color: #007BFF;
        }
        .error {
            color: red;
            text-align: center;
        }
        .image-container {
            /* width: 80%; */
            /* height: 80%; */
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: none;
            border-radius: 10px;
            overflow: hidden;
        }
        .image-container img {
            width: 50%;
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
    <div class="signin-container">
        <?php if (isset($error)) : ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <h2>Sign In</h2>
        <form action="signin.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign In</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Create</a></p>
    </div>
</body>
</html>
