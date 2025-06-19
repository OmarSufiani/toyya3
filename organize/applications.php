<?php
session_start();

// Secure access: only allow specific admin IDs

if (!isset($_SESSION['idNo'])) {
    header("Location: ../login.php");
    exit();
}

include '../database/db.php'; // Adjust path as necessary
include 'header.php'; // Optional if it contains a header/navbar

$results = [];
$error = '';

// Fetch applications
$sql = "SELECT * FROM applications ORDER BY submitted_at DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $results = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $error = "No applications found.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Applications</title>
    <style>
        * {
            
            box-sizing: border-box;
        }

        body {
           font-family: 'Arial', sans-serif;
            background-color: #f4f4f9; /* Light background for the page */
            color: #333; /* Dark text for readability */
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

       


        .logo h1 {
            color: white;
            font-size: 2rem;
            text-transform: uppercase;
        }

        nav ul {
            list-style: none;
            display: flex;
        }

        nav ul li {
            margin-left: 30px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 1rem;
            text-transform: uppercase;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: #FFD700;
        }

        h2 {
            text-align: center;
            color: teal;
            margin-bottom: 30px;
        }

        table {
            margin: 0 auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            width: 95%;
            max-width: 1200px;
        }

        th, td {
            padding: 12px 10px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 14px;
        }

        th {
            background-color: teal;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .message {
            text-align: center;
            color: red;
            font-size: 18px;
            margin-top: 30px;
        }

        @media (max-width: 768px) {
        

            nav ul {
                flex-direction: column;
                padding: 0;
            }

            nav ul li {
                margin: 10px 0;
            }

            table, th, td {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>





<?php if (!empty($results)): ?>
    <table>
        <thead>
            <tr>   
                <th>S/N</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Type of Competetion</th>
                <th>Age</th>
                <th>ID No</th>
                <th>County</th>
                <th>Ward</th>
                <th>Contact</th>
                <th>Next of Kin Name</th>
                <th>Relationship with next of kin</th>
                <th>Next of Kin Contact</th>
                <th>Date Submitted</th>
               
            </tr>
        </thead>
        <tbody>
            <?php $sn = 1; ?>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= $sn++ ?></td>
                    <td><?= htmlspecialchars($row['firstName']) ?></td>
                    <td><?= htmlspecialchars($row['lastName']) ?></td>
                    <td><?= htmlspecialchars($row['category']) ?></td>
                    <td><?= htmlspecialchars($row['age']) ?></td>
                    <td><?= htmlspecialchars($row['idNo']) ?></td>
                    <td><?= htmlspecialchars($row['county']) ?></td>
                    <td><?= htmlspecialchars($row['ward']) ?></td>
                    <td><?= htmlspecialchars($row['contact']) ?></td>
                    <td><?= htmlspecialchars($row['kin']) ?></td>
                    <td><?= htmlspecialchars($row['relationship']) ?></td>
                    <td><?= htmlspecialchars($row['kin_contact']) ?></td>
                    <td><?= htmlspecialchars($row['submitted_at']) ?></td>
                 
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="message"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

</body>
</html>
