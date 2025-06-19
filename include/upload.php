<?php
// Include database connection
include '../database/db.php';

// Initialize upload message
$uploadMessage = "";

// Upload logic
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["file"])) {
    $uploadDir = "../uploads/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $uploadDir . $fileName;

    // Ensure uploads directory exists
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Upload file
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
        // Store file info in database
        $stmt = $conn->prepare("INSERT INTO files (filename, filepath) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("ss", $fileName, $targetFilePath);
            if ($stmt->execute()) {
                $uploadMessage = "✅ File uploaded and saved to database.";
            } else {
                $uploadMessage = "❌ Failed to save to database.";
            }
            $stmt->close();
        } else {
            $uploadMessage = "❌ SQL statement error.";
        }
    } else {
        $uploadMessage = "❌ Error uploading the file.";
    }
}

// Fetch uploaded files
$result = $conn->query("SELECT id, filename FROM files ORDER BY uploaded_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File Upload & Download</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f5f6fa;
        }
        h2 {
            color: #2f3640;
        }
        .message {
            padding: 10px;
            color: green;
        }
        ul {
            list-style: none;
            padding-left: 0;
        }
        li {
            margin-bottom: 8px;
        }
        a {
            color: blue;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        input[type="file"] {
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <h2>Upload a File</h2>
    <?php if ($uploadMessage): ?>
        <div class="message"><?php echo $uploadMessage; ?></div>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="file" required>
        <br><br>
        <button type="submit">Upload</button>
    </form>

    <h2>Download Files</h2>
    <ul>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <li>
                    <?php echo htmlspecialchars($row['filename']); ?>
                    - <a href="download.php?file_id=<?php echo $row['id']; ?>">Download</a>
                </li>
            <?php endwhile; ?>
        <?php else: ?>
            <li>No files uploaded yet.</li>
        <?php endif; ?>
    </ul>

</body>
</html>
