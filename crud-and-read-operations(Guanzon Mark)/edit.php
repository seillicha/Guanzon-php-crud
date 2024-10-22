<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Get the current record data
    $sql = "SELECT * FROM people WHERE id = $id";
    $result = $conn->query($sql);
    $person = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $age = $_POST['age'];

    // Update the record
    $sql = "UPDATE people SET name = '$name', age = '$age' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Person</title>
</head>
<body>

<h1>Edit Person</h1>

<form action="edit.php" method="post">
    <input type="hidden" name="id" value="<?php echo $person['id']; ?>">
    <label for="name">Name:</label>
    <input type="text" name="name" value="<?php echo $person['name']; ?>" required>
    <br>
    <label for="age">Age:</label>
    <input type="number" name="age" value="<?php echo $person['age']; ?>" required>
    <br>
    <button type="submit">Update</button>
</form>

</body>
</html>
