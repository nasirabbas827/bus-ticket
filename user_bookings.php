<?php
require 'config.php';

// Check if the user is already logged in
if (!isset($_SESSION['email'])) {
  // Redirect to the login page
  header("Location: login.php");
  exit;
}

// Retrieve the user's email from the session
$user_email = $_SESSION['email'];

// Fetch the bookings for the logged-in user
$sql = "SELECT bookings.*, routes.via_city, routes.destination, routes.bus_name, routes.bus_number, routes.departure_date, routes.departure_time
        FROM bookings
        JOIN routes ON bookings.route_id = routes.id
        WHERE bookings.user_email = '$user_email'";
$result = $conn->query($sql);

if ($result !== false && $result->num_rows > 0) {
  $bookings = $result->fetch_all(MYSQLI_ASSOC);

  // Display the bookings for the user
  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <title>My Bookings - Bus Management</title>
  </head>
  <body>
    <h2>My Bookings - Bus Management</h2>
    <table>
      <tr>
        <th>Ticket ID</th>
        <th>Via City</th>
        <th>Destination</th>
        <th>Bus Name</th>
        <th>Bus Number</th>
        <th>Departure Date</th>
        <th>Departure Time</th>
        <th>Number of Tickets</th>
        <th>Total Price</th>
        <th>Payment Status</th>
        <th>Action</th>
      </tr>
      <?php foreach ($bookings as $booking) { ?>
        <tr>
          <td><?php echo $booking['id']; ?></td>
          <td><?php echo $booking['via_city']; ?></td>
          <td><?php echo $booking['destination']; ?></td>
          <td><?php echo $booking['bus_name']; ?></td>
          <td><?php echo $booking['bus_number']; ?></td>
          <td><?php echo $booking['departure_date']; ?></td>
          <td><?php echo $booking['departure_time']; ?></td>
          <td><?php echo $booking['num_tickets']; ?></td>
          <td><?php echo $booking['total_price']; ?></td>
          <td><?php echo $booking['status']; ?></td>
          <td>
            <?php if ($booking['status'] === 'pending') { ?>
              <a href="booking_details.php?booking_id=<?php echo $booking['id']; ?>">Make Payment</a>
            <?php } ?>
          </td>
        </tr>
      <?php } ?>
    </table>
  </body>
  </html>
  <?php
} else {
  echo "No bookings found for the logged-in user.";
}
?>
