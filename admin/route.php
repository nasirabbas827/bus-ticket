<?php

session_start();

// Include the configuration file
include 'config.php';

if (!isset($_SESSION["id"]) || $_SESSION["usertype"] != "admin") {
    header("location: login.php");
    exit;
}
?>
<?php

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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
 <style>
  /* styles.css */
  body {
background-color: #f2f2f2;
    }
.container {
  margin-top: 50px;
}

h2 {
  margin-bottom: 30px;
}

.form-label {
  font-weight: bold;
}

.btn-primary {
  margin-top: 20px;
}

table {
  margin-top: 30px;
}

table th {
  font-weight: bold;
}

table td {
  vertical-align: middle;
}

 </style>
</head>
<body>
  <?php include('admin_navbar.php') ?>

  <div class="container">
    <h2>Admin - Bus Management</h2>

    <h3 class="text-center">Create Route</h3>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <div class="mb-3">
        <label for="via_city" class="form-label">Via City:</label>
        <input type="text" class="form-control" id="via_city" name="via_city" required>
      </div>
      <div class="mb-3">
        <label for="destination" class="form-label">Destination:</label>
        <input type="text" class="form-control" id="destination" name="destination" required>
      </div>
      <div class="mb-3">
        <label for="bus_name" class="form-label">Bus Name:</label>
        <input type="text" class="form-control" id="bus_name" name="bus_name" required>
      </div>
      <div class="mb-3">
        <label for="bus_number" class="form-label">Bus Number:</label>
        <input type="text" class="form-control" id="bus_number" name="bus_number" required>
      </div>
      <div class="mb-3">
        <label for="departure_date" class="form-label">Departure Date:</label>
        <input type="date" class="form-control" id="departure_date" name="departure_date" required>
      </div>
      <div class="mb-3">
        <label for="departure_time" class="form-label">Departure Time:</label>
        <input type="time" class="form-control" id="departure_time" name="departure_time" required>
      </div>
      <div class="mb-3">
        <label for="ticket_price" class="form-label">Ticket Price:</label>
        <input type="number" class="form-control" id="ticket_price" name="ticket_price" required>
      </div>
      <button type="submit" name="create" class="btn btn-primary">Create Route</button>
    </form>

    <h3 class="mt-4 text-center">Route List</h3>
    <table class="table">
      <thead>
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
      </thead>
      <tbody>
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
            <td><a href="edit_route.php?id=<?php echo $route['id']; ?>" class="btn btn-sm btn-primary">Edit</a></td>
            <td><a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=delete&id=<?php echo $route['id']; ?>" class="btn btn-sm btn-danger">Delete</a></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</body>
</html>
