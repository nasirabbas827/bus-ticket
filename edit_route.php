<?php
session_start();

// Connect to the database
$conn = new mysqli("localhost", "root", "", "bus_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch route record to be edited
if (isset($_GET['id'])) {
    $route_id = $_GET['id'];

    // Retrieve the route record from the database based on the provided ID
    $sql = "SELECT * FROM routes WHERE id = $route_id";
    $result = $conn->query($sql);

    if ($result !== false && $result->num_rows > 0 && $result instanceof mysqli_result) {
        $route = $result->fetch_assoc();
    } else {
        echo "Route not found.";
        exit();
    }
}

// Update Route
if (isset($_POST['update'])) {
    $via_city = $_POST['via_city'];
    $destination = $_POST['destination'];
    $bus_name = $_POST['bus_name'];
    $bus_number = $_POST['bus_number'];
    $departure_date = $_POST['departure_date'];
    $departure_time = $_POST['departure_time'];
    $ticket_price = $_POST['ticket_price'];

    // Update the route record in the database based on the provided ID
    $sql = "UPDATE routes SET via_city = '$via_city', destination = '$destination', bus_name = '$bus_name', bus_number = '$bus_number', departure_date = '$departure_date', departure_time = '$departure_time', ticket_price = $ticket_price WHERE id = $route_id";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to the admin page after updating the route
        header("Location: route.php");
        exit();
    } else {
        echo "Error updating route: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Route - Bus Management</title>
</head>
<body>
  <h2>Edit Route - Bus Management</h2>

  <h3>Update Route</h3>
  <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $route['id']; ?>">
    <label for="via_city">Via City:</label>
    <input type="text" id="via_city" name="via_city" value="<?php echo $route['via_city']; ?>" required>
    <label for="destination">Destination:</label>
    <input type="text" id="destination" name="destination" value="<?php echo $route['destination']; ?>" required>
    <label for="bus_name">Bus Name:</label>
    <input type="text" id="bus_name" name="bus_name" value="<?php echo $route['bus_name']; ?>" required>
    <label for="bus_number">Bus Number:</label>
    <input type="text" id="bus_number" name="bus_number" value="<?php echo $route['bus_number']; ?>" required>
    <label for="departure_date">Departure Date:</label>
    <input type="date" id="departure_date" name="departure_date" value="<?php echo $route['departure_date']; ?>" required>
    <label for="departure_time">Departure Time:</label>
    <input type="time" id="departure_time" name="departure_time" value="<?php echo $route['departure_time']; ?>" required>
    <label for="ticket_price">Ticket Price:</label>
    <input type="number" id="ticket_price" name="ticket_price" value="<?php echo $route['ticket_price']; ?>" required>
    <button type="submit" name="update">Update Route</button>
  </form>
</body>
</html>
