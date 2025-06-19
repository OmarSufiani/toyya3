<?php
$host = "localhost";
$user = "root";           // or your MySQL username
$password = "";           // or your MySQL password
$database = "toyya"; // change this to your DB name

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

