<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create and Read operations</title>
</head>
<body>
    <h2>Create Operations</h2>
    <form action="process.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required><br><br>

        <input type="submit" value="Submit">
    </form>

    <h2>Read Operations</h2>
    <?php
        // Display users stored in the database
        $conn = new mysqli("localhost", "root", "", "testdb");  // Replace with your DB connection info

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT id, name, age FROM users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Age</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['age']}</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No users found.";
        }

        $conn->close();
    ?>
</body>
</html>
