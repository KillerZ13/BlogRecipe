<?php
require('config/db.php');
session_start();

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
        .button-container button {
            width: 100%;
            padding: 10px;
            background-color: #9A6735;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .button-container button:hover {
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
    <form action="signin.php">
        <div class="welcome-container">
            <h1>Welcome to Bon Appétit Blog</h1>
        </div>
        <div class="image-container">
            <img src="logo.png" alt="Descriptive Alt Text">
        </div>
        <div class="button-container">
            <button type="submit">GO NOW</button>
        </div>
    </form>
</body>

</html>
