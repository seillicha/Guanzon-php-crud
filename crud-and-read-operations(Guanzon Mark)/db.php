<?php
$host = "localhost";  // Database host
$user = "root";       // Database user
$pass = "";           // Database password
$dbname = "peopleDB"; // Database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
