<?php
session_start();

// Connect to the database
$conn = new mysqli("localhost", "root", "", "bus_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch route records from the database
$sql = "SELECT * FROM routes";
$result = $conn->query($sql);
$routeList = [];

if ($result !== false && $result->num_rows > 0 && $result instanceof mysqli_result) {
    // Fetch route records into an array
    while ($row = $result->fetch_assoc()) {
        $routeList[] = $row;
    }
} else {
    echo "No routes found.";
}


// Create Route
if (isset($_POST['create'])) {
    $via_city = $_POST['via_city'];
    $destination = $_POST['destination'];
    $bus_name = $_POST['bus_name'];
    $bus_number = $_POST['bus_number'];
    $departure_date = $_POST['departure_date'];
    $departure_time = $_POST['departure_time'];
    $ticket_price = $_POST['ticket_price'];

    // Insert new route record into the database
    $sql = "INSERT INTO routes (via_city, destination, bus_name, bus_number, departure_date, departure_time, ticket_price)
            VALUES ('$via_city', '$destination', '$bus_name', '$bus_number', '$departure_date', '$departure_time', $ticket_price)";
    if ($conn->query($sql) === TRUE) {
        // Redirect back to the admin page after creating the route
        header("Location: route.php");
        exit();
    } else {
        echo "Error creating route: " . $conn->error;
    }
}

// Delete Route
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $route_id = $_GET['id'];

    // Delete the route record from the database based on the provided ID
    $sql = "DELETE FROM routes WHERE id = $route_id";
    if ($conn->query($sql) === TRUE) {
        // Redirect back to the admin page after deleting the route
        header("Location: route.php");
        exit();
    } else {
        echo "Error deleting route: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin - Bus Management</title>
</head>
<body>
  <h2>Admin - Bus Management</h2>

  <h3>Create Route</h3>
  <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="via_city">Via City:</label>
    <input type="text" id="via_city" name="via_city" required>
    <label for="destination">Destination:</label>
    <input type="text" id="destination" name="destination" required>
    <label for="bus_name">Bus Name:</label>
    <input type="text" id="bus_name" name="bus_name" required>
    <label for="bus_number">Bus Number:</label>
    <input type="text" id="bus_number" name="bus_number" required>
    <label for="departure_date">Departure Date:</label>
    <input type="date" id="departure_date" name="departure_date" required>
    <label for="departure_time">Departure Time:</label>
    <input type="time" id="departure_time" name="departure_time" required>
    <label for="ticket_price">Ticket Price:</label>
    <input type="number" id="ticket_price" name="ticket_price" required>
    <button type="submit" name="create">Create Route</button>
  </form>

  <h3>Route List</h3>
  <table>
    <tr>
      <th>ID</th>
      <th>Via City</th>
      <th>Destination</th>
      <th>Bus Name</th>
      <th>Bus Number</th>
      <th>Departure Date</th>
      <th>Departure Time</th>
      <th>Ticket Price</th>
      <th>Update</th>
      <th>Delete</th>
    </tr>
    <?php foreach ($routeList as $route) { ?>
      <tr>
        <td><?php echo $route['id']; ?></td>
        <td><?php echo $route['via_city']; ?></td>
        <td><?php echo $route['destination']; ?></td>
        <td><?php echo $route['bus_name']; ?></td>
        <td><?php echo $route['bus_number']; ?></td>
        <td><?php echo $route['departure_date']; ?></td>
        <td><?php echo $route['departure_time']; ?></td>
        <td><?php echo $route['ticket_price']; ?></td>
        <td><a href="edit_route.php?id=<?php echo $route['id']; ?>">Edit</a></td>
        <td><a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=delete&id=<?php echo $route['id']; ?>">Delete</a></td>
      </tr>
    <?php } ?>
  </table>
</body>
</html>
