<?php
session_start();
include 'database/db.php'; // Uses $conn from db.php

// Hardcoded admin ID number
$adminIdNo = '26133604' ;

if (isset($_SESSION['idNo'])) {
    // User already logged in
    if ($_SESSION['idNo'] == $adminIdNo) {
        header("Location: admin/homepage.php");
    } else {
        header("Location: organize/dashboard.php");
    }
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idNo = $_POST['idNo'];
    $password = $_POST['password'];

    // Check user in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE idNo = ?");
    $stmt->bind_param("s", $idNo);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // If user exists and password is valid
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['idNo'] = $user['idNo'];
        $_SESSION['FirstName'] = $user['FirstName'];

        // Redirect based on hardcoded admin ID
        if ($user['idNo'] == $adminIdNo) {
            header("Location:admin/homepage.php"); // Admin homepage
        } else {
            header("Location: organize/dashboard.php"); // User dashboard
        }
        exit();
    } else {
        $error = "Invalid ID number or password.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <style>
        /* Resetting some default browser styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9; /* Light background for the page */
            color: #333; /* Dark text for readability */
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0;
        }

        header {
            background-color: teal; /* A fresh gray background */
            padding: 20px 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
            width: 100%;
        }

        .container {
            width: 90%;
            max-width: 1200px; /* Responsive container max width */
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo h1 {
            font-size: 2.5rem;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: bold;
        }

        nav ul {
            list-style-type: none;
            display: flex;
        }

        nav ul li {
            margin-left: 30px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 1.1rem;
            text-transform: uppercase;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        /* Hover effects for the navigation links */
        nav ul li a:hover {
            color: #FFD700; /* Gold color on hover */
            transform: scale(1.1); /* Slightly enlarge the text */
        }

        /* Responsive design */
        @media screen and (max-width: 768px) {
            .container {
                flex-direction: column;
                text-align: center;
            }

            nav ul {
                margin-top: 20px;
                flex-direction: column;
            }

            nav ul li {
                margin: 10px 0;
            }
        }

        .login-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 300px;
            text-align: center;
            margin: 30px 0;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .top-image {
            width: 100%;  /* Image will scale to the width of the login form */
            max-width: 300px;  /* Set image max-width same as login form width */
            height: auto;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 20px; /* Space between image and the "Login" text */
        }

        input[type="Number"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        .register-link {
            margin-top: 15px;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .login-container {
                width: 90%;
                padding: 20px;
            }

            .top-image {
                max-width: 90%;  /* Scale down the image for smaller screens */
            }
        }
    </style>
</head>
<body>

<header>
    <div class="container">
        <div class="logo">
            <h1>FIKRATUL JANNAH </h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="organize/about.php">About</a></li>
                <li><a href="organize/contact.php">Contact</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="login-container">
    <!-- Image Inside Form -->
    <img src="images/image.jpeg" alt="Top Banner" class="top-image">

    <h2>Login</h2>
    <form method="POST" action="">
        <input type="Number" name="idNo" placeholder="Enter ID or Birth" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>

    <div class="register-link">
        <p>Don't have an account? <a href="register.php">Sign up</a></p>
        <br>
        
          <a href="forgot_password.php">forgot_password</a>
    </div>

    <?php if (!empty($error)): ?>
        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
</div>

</body>
</html>
