<?php
$host = "sql101.infinityfree.com";
$user = "if0_39023336";         // or your MySQL username
$password = "SUFIANI58";           // or your MySQL password
$database = "if0_39023336_toyya"; // change this to your DB name

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

