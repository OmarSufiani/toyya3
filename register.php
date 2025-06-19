<?php
session_start();
include 'database/db.php'; // Adjust path if needed

include 'header1.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: organize/dashboard.php");
    exit();
}

$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $FirstName = trim($_POST['FirstName']);
    $LastName = trim($_POST['LastName']);
    $email = trim($_POST['email']);
    $idNo = trim($_POST['idNo']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if (empty($FirstName) || empty($LastName) || empty($email) || empty($idNo) || empty($password) || empty($confirmPassword)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match. Please try again.";
    } else {
        // Check if ID or Email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE idNo = ? OR email = ?");
        $stmt->bind_param("ss", $idNo, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "ID or Email already registered. Please use a different one.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $insertStmt = $conn->prepare("INSERT INTO users (FirstName, LastName, email, idNo, password) VALUES (?, ?, ?, ?, ?)");
            $insertStmt->bind_param("sssss", $FirstName, $LastName, $email, $idNo, $hashedPassword);

            if ($insertStmt->execute()) {
                $success = "Registration successful.";
            } else {
                $error = "Registration failed. Please try again.";
            }

            $insertStmt->close();
        }

        $stmt->close();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        
        
        }

        .login-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 300px;
            text-align: center;
            align-items:center;
            margin:40px auto;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
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

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<br>
    <div class="login-container">
        <h2>Sign up</h2>
        <form method="POST" action="">
            <input type="text" name="FirstName" placeholder="First Name" required>
            <input type="text" name="LastName" placeholder="Last Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="idNo" placeholder="Enter ID or Birth" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirmPassword" placeholder="Confirm Password" required>
            <input type="submit" value="Register">
        </form>

        <div class="register-link">
            <p>Already have an account? <a href="index.php">Sign in</a></p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php elseif (!empty($success)): ?>
            <div class="success-message"><?php echo $success; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
