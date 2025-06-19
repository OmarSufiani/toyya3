<?php




// Check if the directory exists
$uploadDir = 'uploads/';
if (!is_dir($uploadDir)) {
    die("Upload directory does not exist.");
}

// Get all files except . and ..
$files = array_diff(scandir($uploadDir), array('.', '..'));
?>

<!DOCTYPE html>
<html>
<head>
<?php
include 'header1.php';
?>
    <title>Uploades</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f9f9f9;
        }
        h2 {
            color: #333;
        }
        ul.file-list {
            list-style: none;
            padding: 0;
        }
        ul.file-list li {
            background: #fff;
            border: 1px solid #ddd;
            padding: 12px 20px;
            margin-bottom: 10px;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .file-name {
            flex-grow: 1;
        }
        .file-actions a {
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            padding: 8px 14px;
            border-radius: 4px;
            margin-left: 10px;
        }
        .file-actions a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<br>

<?php if (empty($files)): ?>
    <p>No files uploaded.</p>
<?php else: ?>
    <ul class="file-list">
        <?php foreach ($files as $file): 
            $filePath = $uploadDir . $file;
        ?>
            <li>
                <div class="file-name">
                    <a href="<?= htmlspecialchars($filePath) ?>" target="_blank"><?= htmlspecialchars($file) ?></a>
                </div>
                <div class="file-actions">
                    <a href="<?= htmlspecialchars($filePath) ?>" download>Download</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

</body>
</html>
