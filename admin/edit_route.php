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
    <h2>Edit Route - Bus Management</h2>

    <h3>Update Route</h3>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $route['id']; ?>">
      <div class="mb-3">
        <label for="via_city" class="form-label">Via City:</label>
        <input type="text" class="form-control" id="via_city" name="via_city" value="<?php echo $route['via_city']; ?>" required>
      </div>
      <div class="mb-3">
        <label for="destination" class="form-label">Destination:</label>
        <input type="text" class="form-control" id="destination" name="destination" value="<?php echo $route['destination']; ?>" required>
      </div>
      <div class="mb-3">
        <label for="bus_name" class="form-label">Bus Name:</label>
        <input type="text" class="form-control" id="bus_name" name="bus_name" value="<?php echo $route['bus_name']; ?>" required>
      </div>
      <div class="mb-3">
        <label for="bus_number" class="form-label">Bus Number:</label>
        <input type="text" class="form-control" id="bus_number" name="bus_number" value="<?php echo $route['bus_number']; ?>" required>
      </div>
      <div class="mb-3">
        <label for="departure_date" class="form-label">Departure Date:</label>
        <input type="date" class="form-control" id="departure_date" name="departure_date" value="<?php echo $route['departure_date']; ?>" required>
      </div>
      <div class="mb-3">
        <label for="departure_time" class="form-label">Departure Time:</label>
        <input type="time" class="form-control" id="departure_time" name="departure_time" value="<?php echo $route['departure_time']; ?>" required>
      </div>
      <div class="mb-3">
        <label for="ticket_price" class="form-label">Ticket Price:</label>
        <input type="number" class="form-control" id="ticket_price" name="ticket_price" value="<?php echo $route['ticket_price']; ?>" required>
      </div>
      <button type="submit" name="update" class="btn btn-primary">Update Route</button>
    </form>
  </div>
</body>
</html>
