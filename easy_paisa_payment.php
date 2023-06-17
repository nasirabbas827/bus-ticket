<?php
require 'config.php';

// Check if the user is already logged in
if (!isset($_SESSION['email'])) {
  // Redirect to the login page
  header("Location: login.php");
  exit;
}

// Retrieve the booking ID from the query parameter
if (isset($_GET['booking_id'])) {
  $booking_id = $_GET['booking_id'];
  // Fetch the booking details based on the booking ID
  $sql = "SELECT * FROM bookings WHERE id = $booking_id";
  $result = $conn->query($sql);

  if ($result !== false && $result->num_rows > 0) {
    $booking = $result->fetch_assoc();

    // Fetch the route details based on the route ID
    $route_id = $booking['route_id'];
    $sql = "SELECT * FROM routes WHERE id = $route_id";
    $result = $conn->query($sql);

    if ($result !== false && $result->num_rows > 0) {
      $route = $result->fetch_assoc();

      // Retrieve the ticket price from the route details
      $ticket_price = $route['ticket_price'];

      // Retrieve user details from the session
      $user_email = $_SESSION['email'];

      // Fetch user details from the database based on the email
      $sql = "SELECT * FROM users WHERE email = '$user_email'";
      $result = $conn->query($sql);

      if ($result !== false && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Display the booking information, route details, and user details
        ?>
        
        <!DOCTYPE html>
<html>
<head>
  <title>Easy Paisa Payment - Bus Management</title>
</head>
<body>
  <h2>Easy Paisa Payment - Bus Management</h2>
  <h3>User Details</h3>
  <p><strong>Name:</strong> <?php echo $user['username']; ?></p>
  <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
  <p><strong>Phone Number:</strong> <?php echo $user['phone']; ?></p>
  <hr>
  <h3>Booking Information</h3>
  <table>
    <tr>
      <th>Ticket ID</th>
      <th>Via City</th>
      <th>Destination</th>
      <th>Bus Name</th>
      <th>Bus Number</th>
      <th>Departure Date</th>
      <th>Departure Time</th>
      <th>Ticket Price</th>
      <th>Number of Tickets</th>
      <th>Total Price</th>
    </tr>
    <tr>
      <td><?php echo $booking['id']; ?></td>
      <td><?php echo $route['via_city']; ?></td>
      <td><?php echo $route['destination']; ?></td>
      <td><?php echo $route['bus_name']; ?></td>
      <td><?php echo $route['bus_number']; ?></td>
      <td><?php echo $route['departure_date']; ?></td>
      <td><?php echo $route['departure_time']; ?></td>
      <td><?php echo $ticket_price; ?></td>
      <td><?php echo $booking['num_tickets']; ?></td>
      <td><?php echo $booking['total_price']; ?></td>
    </tr>
  </table>

  <h3>Payment Method: Easy Paisa</h3>
  <p>Please complete the payment through Easy Paisa to confirm your booking.</p>
  <p>After completing the payment, your ticket will be issued.</p>

  <!-- Easy Paisa payment instructions and form -->
  <form action="easy_payment.php" method="POST">
    <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
    <input type="hidden" name="total_price" value="<?php echo $booking['total_price']; ?>">
    <input type="submit" value="Proceed to Easy Paisa Payment">
  </form>
</body>
</html>

        <?php
      } else {
        echo "User details not found.";
      }
    } else {
      echo "Route details not found.";
    }
  } else {
    echo "Booking details not found.";
  }
} else {
  echo "Invalid booking ID.";
}
?>
