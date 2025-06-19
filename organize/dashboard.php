<?php


session_start();
if (!isset($_SESSION['idNo'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard with Header and Sidebar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header {
            height: 60px;
            background-color: teal;;
            color: white;
            display: flex;
            align-items: center;
            padding: 0 20px;
            justify-content: space-between;
        }

        .header h1 {
            font-size: 20px;
        }

        .header .user {
            font-size: 14px;
        }

        /* Page content container */
        .container {
            flex: 1;
            display: flex;
            height: calc(100vh - 60px); /* subtract header height */
        }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background-color: #2c3e50;
            color: #ecf0f1;
            display: flex;
            flex-direction: column;
            padding: 20px 0;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 22px;
        }

        .sidebar a {
            color: #ecf0f1;
            padding: 12px 20px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #34495e;
        }

        /* Main content */
        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .welcome {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .welcome h2 {
            margin: 0 0 10px;
            color: #333;
        }

        .welcome p {
            color: #666;
        }

        .logout {
            background-color: #e74c3c;
            color: white;
            padding: 8px 14px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }

        .logout:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h1>Applicant Portal </h1>
        <div class="user">
           <?php echo htmlspecialchars($_SESSION['FirstName']); ?> |
            <a class="logout" href="../logout.php">Logout</a>
        </div>
    </div>

    <!-- Sidebar + Main content -->
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Navigation</h2>
        
            <a href="categories.php">View categories</a>
           
             <a href="status.php">Status of my application</a>
             
<br><br>

             <a href="submit.php">Apply</a>
        </div>

        <!-- Main content -->
        <div class="main-content">
            <div class="welcome">
                <h2>Hello, <?php echo htmlspecialchars($_SESSION['FirstName']); ?>!</h2>
                <p>You are now logged into your dashboard. Use the sidebar to navigate through your account.</p>
            </div>
        </div>
    </div>

</body>
</html>
