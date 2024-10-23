<?php
$servername = "localhost"; // Your server name
$username = "root";         // Your MySQL username (default for XAMPP)
$password = "";             // Leave password blank for XAMPP
$dbname = "app_users";      // Your database name

// Display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        // Insert data
        $name = $_POST['name'];
        $age = $_POST['age'];

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (name, age) VALUES (?, ?)");
        $stmt->bind_param("si", $name, $age); // "si" means string and integer
        
        if ($stmt->execute()) {
            echo "New record created successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
    } elseif (isset($_POST['update'])) {
        // Update data
        $id = $_POST['id'];
        $name = $_POST['name'];
        $age = $_POST['age'];

        // Prepare and bind
        $stmt = $conn->prepare("UPDATE users SET name=?, age=? WHERE id=?");
        $stmt->bind_param("sii", $name, $age, $id); // "sii" means string, integer, integer
        
        if ($stmt->execute()) {
            echo "Record updated successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        // Delete data
        $id = $_POST['id'];

        // Prepare and bind
        $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("i", $id); // "i" means integer
        
        if ($stmt->execute()) {
            echo "Record deleted successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Read data
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Example</title>
</head>
<body>

<h2>Create Operations</h2>

<form method="POST">
    <input type="hidden" name="id" id="userId" value="">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" required>
    <label for="age">Age:</label>
    <input type="number" name="age" id="age" required>
    <button type="submit" name="submit">Submit</button>
    <button type="submit" name="update" style="display:none;">Update</button>
</form>

<h3>Read Operations</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Age</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['age']; ?></td>
        <td>
            <button onclick="editUser(<?php echo $row['id']; ?>, '<?php echo addslashes($row['name']); ?>', <?php echo $row['age']; ?>)">edit</button>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this record?');">Delete</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<script>
function editUser(id, name, age) {
    document.getElementById('userId').value = id;
    document.getElementById('name').value = name;
    document.getElementById('age').value = age;
    
    // Show the Update button and hide Submit button
    document.querySelector('button[name="update"]').style.display = 'inline';
    document.querySelector('button[name="submit"]').style.display = 'none';
}
</script>

</body>
</html>

<?php
$conn->close();
?>
