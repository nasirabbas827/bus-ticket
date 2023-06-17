<?php
session_start();

// Connect to the database
$conn = new mysqli("localhost", "root", "", "bus_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the bus record to be edited based on the provided ID
if (isset($_GET['id'])) {
    $bus_id = $_GET['id'];
    $sql = "SELECT * FROM buses WHERE id = $bus_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $bus = $result->fetch_assoc();
    } else {
        echo "Bus not found.";
        exit();
    }
}

// Update Bus
if (isset($_POST['update'])) {
    $bus_id = $_POST['bus_id'];
    $bus_name = $_POST['bus_name'];
    $tel_number = $_POST['tel_number'];

    // Update the bus record in the database
    $sql = "UPDATE buses SET bus_name = '$bus_name', tel_number = '$tel_number' WHERE id = $bus_id";
    $conn->query($sql);

    // Redirect back to the admin page after updating the bus
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Bus</title>
</head>
<body>
  <h2>Edit Bus</h2>

  <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" name="bus_id" value="<?php echo $bus['id']; ?>">
    <label for="bus_name">Bus Name:</label>
    <input type="text" id="bus_name" name="bus_name" value="<?php echo $bus['bus_name']; ?>" required>
    <label for="tel_number">Tel Number:</label>
    <input type="tel" id="tel_number" name="tel_number" value="<?php echo $bus['tel_number']; ?>" required>
    <button type="submit" name="update">Update Bus</button>
  </form>
</body>
</html>
