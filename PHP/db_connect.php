<?php
$servername = "localhost";
$username = "Mehedi";
$password = "Mehedi@2310";
$dbname = "db1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";
?>