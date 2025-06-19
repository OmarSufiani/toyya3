<?php
session_start();
include '../database/db.php';
include 'header.php';
$application = null;
$status = 'Not Submitted';
$idNo = '';
$name = '';
$category = '';
$submittedAt = 'N/A';

if (isset($_SESSION['idNo'])) {
    $idNo = trim($_SESSION['idNo']);

    $stmt = $conn->prepare("SELECT firstName, category, submitted_at FROM applications WHERE TRIM(idNo) = ?");
    $stmt->bind_param("s", $idNo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $application = $result->fetch_assoc();
        $name = $application['firstName'];
        $category = $application['category'];
        $submittedAt = $application['submitted_at'];
        $status = 'Submitted';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
            text-align: center;
        }

        .status-box {
            background: white;
            padding: 30px;
            border-radius: 8px;
            max-width: 800px;
            margin: 0 auto;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        h2 {
            color: teal;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
            text-align: left;
        }

        .submitted {
            color: green;
            font-weight: bold;
        }

        .not-submitted {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
<br>
<div class="status-box">
    <h2>Application Status</h2>

    <?php if (isset($_SESSION['idNo'])): ?>
        <table>
            <tr>
                <th>ID Number</th>
                <th>Name</th>
                <th>Competition Type</th>
                <th>Date Submitted</th>
                <th>Status</th>
            </tr>
            <tr>
                <td><?= htmlspecialchars($idNo) ?></td>
                <td><?= htmlspecialchars($name ?: 'N/A') ?></td>
                <td><?= htmlspecialchars($category ?: 'N/A') ?></td>
                <td><?= htmlspecialchars($submittedAt ?: 'N/A') ?></td>
                <td class="<?= $status === 'Submitted' ? 'submitted' : 'not-submitted' ?>">
                    <?= $status ?>
                </td>
            </tr>
        </table>
    <?php else: ?>
        <p>You are not logged in.</p>
    <?php endif; ?>
</div>

</body>
</html>
