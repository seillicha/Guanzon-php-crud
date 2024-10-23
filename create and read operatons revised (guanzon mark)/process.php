<?php
// Connecting to the database
$conn = new mysqli("localhost", "root", "", "testdb");  // Replace with your DB connection info

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];

    // Insert user data into the users table
    $sql = "INSERT INTO users (name, age) VALUES ('$name', $age)";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully.";
        header("Location: index.php");  // Redirect to the main page
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
