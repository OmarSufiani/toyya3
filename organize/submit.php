<?php
require '../database/db.php';
include 'header.php';
$uploadDir = '../uploads/';
$allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$confirmation = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName    = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName     = mysqli_real_escape_string($conn, $_POST['lastName']);
    $category     = mysqli_real_escape_string($conn, $_POST['category']);
    $age          = intval($_POST['age']);
    $idNo         = mysqli_real_escape_string($conn, $_POST['idNo']);
    $county       = mysqli_real_escape_string($conn, $_POST['county']);
    $ward         = mysqli_real_escape_string($conn, $_POST['ward']);
    $contact      = mysqli_real_escape_string($conn, $_POST['contact']);
    $kin          = mysqli_real_escape_string($conn, $_POST['kin']);
    $relationship = mysqli_real_escape_string($conn, $_POST['relationship']);
    $kin_contact  = mysqli_real_escape_string($conn, $_POST['kin_contact']);

    $uploadedFiles = [];

    foreach ($_FILES['resume']['tmp_name'] as $key => $tmpName) {
        $fileName = basename($_FILES['resume']['name'][$key]);
        $fileType = $_FILES['resume']['type'][$key];

        if (!in_array($fileType, $allowedTypes)) {
            $confirmation = "<div class='confirmation error'>Invalid file type: $fileName</div>";
            break;
        }

        $safeName = time() . '_' . preg_replace("/[^a-zA-Z0-9.\-_]/", "_", $fileName);
        $targetPath = $uploadDir . $safeName;

        if (!move_uploaded_file($tmpName, $targetPath)) {
            $confirmation = "<div class='confirmation error'>Failed to upload file: $fileName</div>";
            break;
        }

        $uploadedFiles[] = $targetPath;
    }

    if (!$confirmation) {
        $uploadedString = implode(", ", $uploadedFiles);

        $sql = "INSERT INTO applications 
            (firstName, lastName, category, age, idNo, county, ward, contact, kin, relationship, kin_contact, uploaded_files) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param(
                $stmt,
                "sssissssssss",
                $firstName,
                $lastName,
                $category,
                $age,
                $idNo,
                $county,
                $ward,
                $contact,
                $kin,
                $relationship,
                $kin_contact,
                $uploadedString
            );

            if (mysqli_stmt_execute($stmt)) {
                $confirmation = "<div class='confirmation success'><h2>🎉 Application Submitted Successfully!</h2><p>Thank you, <strong>$firstName $lastName</strong>. We have received your application.</p></div>";
            } else {
                $confirmation = "<div class='confirmation error'>Error: " . mysqli_stmt_error($stmt) . "</div>";
            }

            mysqli_stmt_close($stmt);
        } else {
            $confirmation = "<div class='confirmation error'>Database error: " . mysqli_error($conn) . "</div>";
        }

        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Application Form</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    * { box-sizing: border-box; }

    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, sans-serif;
        background-color: #f3f6fa;
    }

    .main-header {
        background-color: #1e2a38;
        padding: 20px 40px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .main-header .logo {
        font-size: 22px;
        font-weight: bold;
    }

    .nav-links a {
        color: white;
        text-decoration: none;
        margin-left: 20px;
        font-size: 14px;
    }

    .nav-links a:hover {
        text-decoration: underline;
    }

    .form-container {
        max-width: 700px;
        background: #fff;
        margin: 40px auto;
        padding: 30px 40px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .form-container h2 {
        margin-bottom: 25px;
        color: #333;
        font-size: 24px;
        text-align: center;
    }

    form label {
        display: block;
        margin: 15px 0 6px;
        font-weight: bold;
        color: #444;
    }

    form input[type="text"],
    form input[type="number"],
    form input[type="tel"],
    form input[type="file"] {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 6px;
        transition: border-color 0.3s;
    }

    form input:focus {
        border-color: #007BFF;
        outline: none;
    }

    form input[type="submit"] {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 12px;
        font-size: 16px;
        margin-top: 20px;
        width: 100%;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    form input[type="submit"]:hover {
        background-color: #218838;
    }

    .confirmation {
        max-width: 700px;
        margin: 30px auto;
        padding: 20px;
        border-radius: 8px;
        font-size: 16px;
        background-color: #e0f8e9;
        border: 1px solid #a6e6b7;
        color: #155724;
    }

    .confirmation.error {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }

    .confirmation.success {
        background-color: #e6ffed;
        border-color: #b3f7c8;
        color: #155724;
    }
  </style>
</head>
<body>
<br><br>

<?php echo $confirmation; ?>

<div class="form-container">
  <h2>Application Form</h2>
  <form action="submit.php" method="POST" enctype="multipart/form-data">

  <label for="idno">ID Number:</label>
    <input type="number" id="idno" name="idNo" required>
    <label for="firstName">First Name:</label>
    <input type="text" id="firstName" name="firstName" required>

    <label for="lastName">Last Name:</label>
    <input type="text" id="lastName" name="lastName" required>

    <label for="category">Type of Competition:</label>
    <input type="text" id="category" name="category" required>

    <label for="age">Age:</label>
    <input type="number" id="age" name="age" min="1" required>

    

    <label for="county">County of Residence:</label>
    <input type="text" id="county" name="county" required>

    <label for="ward">Ward:</label>
    <input type="text" id="ward" name="ward" required>

    <label for="contact">Contact Number:</label>
    <input type="tel" id="contact" name="contact" required>

    <label for="kin"> Your Next of Kin:</label>
    <input type="text" id="kin" name="kin" required>

    <label for="relationship">Relationship With Next of Kin:</label>
    <input type="text" id="relationship" name="relationship" required>

    <label for="kin_contact">Next of Kin Contact:</label>
    <input type="tel" id="kin_contact" name="kin_contact" required>

    <label for="resume">Upload Documents, i.e ID or birth, dully signed registration form ,and any testimonial inform of  (PDF, DOC, DOCX):</label>
    <input type="file" name="resume[]" id="resume" multiple accept=".pdf,.doc,.docx" required>

    <input type="submit" value="Submit Application">
  </form>
</div>

</body>
</html>
