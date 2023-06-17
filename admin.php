<?php
session_start();

// Connect to the database
$conn = new mysqli("localhost", "root", "", "bus_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch bus records from the database
$sql = "SELECT * FROM buses";
$result = $conn->query($sql);
$busList = [];

if ($result->num_rows > 0) {
    // Fetch bus records into an array
    while ($row = $result->fetch_assoc()) {
        $busList[] = $row;
    }
}

// Create Bus
if (isset($_POST['create'])) {
    $bus_name = $_POST['bus_name'];
    $tel_number = $_POST['tel_number'];

    // Insert new bus record into the database
    $sql = "INSERT INTO buses (bus_name, tel_number) VALUES ('$bus_name', '$tel_number')";
    $conn->query($sql);

    // Redirect back to the admin page after creating the bus
    header("Location: admin.php");
    exit();
}

// Delete Bus
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $bus_id = $_GET['id'];

    // Delete the bus record from the database based on the provided ID
    $sql = "DELETE FROM buses WHERE id = $bus_id";
    $conn->query($sql);

    // Redirect back to the admin page after deleting the bus
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Bus Management</title>
</head>
<body>
  <h2>Bus Management</h2>

  <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <h3>Create Bus</h3>
    <label for="bus_name">Bus Name:</label>
    <input type="text" id="bus_name" name="bus_name" required>
    <label for="tel_number">Tel Number:</label>
    <input type="tel" id="tel_number" name="tel_number" required>
    <button type="submit" name="create">Create Bus</button>
  </form>

  <h3>Bus List</h3>
  <table>
    <tr>
      <th>ID</th>
      <th>Bus Name</th>
      <th>Tel Number</th>
      <th>Update</th>
      <th>Delete</th>
    </tr>
    <?php
    // Display bus records
    foreach ($busList as $bus) {
      echo "<tr>";
      echo "<td>" . $bus['id'] . "</td>";
      echo "<td>" . $bus['bus_name'] . "</td>";
      echo "<td>" . $bus['tel_number'] . "</td>";
      echo "<td><a href='edit.php?id=" . $bus['id'] . "'>Edit</a></td>";
      echo "<td><a href='" . $_SERVER['PHP_SELF'] . "?action=delete&id=" . $bus['id'] . "'>Delete</a></td>";
      echo "</tr>";
    }
    ?>
  </table>
</body>
</html>
