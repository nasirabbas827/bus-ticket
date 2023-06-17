<?php
require 'config.php';

// Check if the user is already logged in
if (!isset($_SESSION['email'])) {
  // Redirect to the login page
  header("Location: login.php");
  exit;
}

// Retrieve user details from the session
$user_email = $_SESSION['email'];

// Fetch user details from the database based on the email
$sql = "SELECT * FROM users WHERE email = '$user_email'";
$result = $conn->query($sql);

if ($result !== false && $result->num_rows > 0) {
    // Fetch the user record
    $user = $result->fetch_assoc();
    $user_name = $user['username'];
    $user_phone = $user['phone'];
} else {
    // Handle error if user record not found
    echo "Error retrieving user details.";
    exit;
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

// Book Route
if (isset($_POST['book'])) {
    $user_email = $_SESSION['email'];
    $user_name = $user['username']; // Updated
    $user_number = $user['phone']; // Updated
    $route_id = $_POST['route_id'];
    $num_tickets = $_POST['num_tickets'];

    // Fetch the selected route details from the database
    $sql = "SELECT * FROM routes WHERE id = $route_id";
    $result = $conn->query($sql);

    if ($result !== false && $result->num_rows > 0) {
        $route = $result->fetch_assoc();
        $ticket_price = $route['ticket_price'];

        // Calculate the total price
        $total_price = $num_tickets * $ticket_price;

        // Insert the booking details into the database
        $sql = "INSERT INTO bookings (user_email, user_name, user_number, route_id, num_tickets, total_price)
                VALUES ('$user_email', '$user_name', '$user_number', $route_id, $num_tickets, $total_price)";

        if ($conn->query($sql) === TRUE) {
            // Redirect to the booking details page after successful booking
            header("Location: booking_details.php?booking_id=" . $conn->insert_id);
            exit();
        } else {
            echo "Error booking route: " . $conn->error;
        }
    } else {
        echo "Selected route not found.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Routes - Bus Management</title>
</head>
<body>
<div>
    <p>Welcome, <?php echo $user_name; ?>!</p>
    <p>Email: <?php echo $user_email; ?></p>
    <p>Phone: <?php echo $user_phone; ?></p>
  </div>
  <h2>Routes - Bus Management</h2>

  <h3>Available Routes</h3>
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
      <th>Action</th>
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
        <td>
          <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="route_id" value="<?php echo $route['id']; ?>">
            <label for="num_tickets">Number of Tickets:</label>
            <input type="number" id="num_tickets" name="num_tickets" required>
            <button type="submit" name="book">Book Now</button>
          </form>
        </td>
      </tr>
    <?php } ?>
  </table>
</body>
</html>
