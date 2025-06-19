<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filename'])) {
    // Sanitize and validate filename
    $file = basename($_POST['filename']);  // Prevent directory traversal
    $filePath = __DIR__ . 'organize/uploads' . $file;

    // Check if file exists
    if (file_exists($filePath)) {
        // Set headers for file download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));

        // Clear output buffer and read the file
        flush();
        readfile($filePath);
        exit;
    } else {
        echo "<h3>File not found.</h3>";
    }
} else {
    echo "<h3>Invalid request.</h3>";
}
?>
