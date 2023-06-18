<!DOCTYPE html>
<html>
<head>
  <title>My Bookings - Bus Management</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>


body{
  background-color: #f2f2f2;
}
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
  </style>
</head>
<body>
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
<?php include('navbar.php'); ?>
  <div class="container mt-4">
    <h2 class="text-center mt-3 mb-4">My Bookings - Bus Management</h2>
    <table class="table">
      <thead>
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
      </thead>
      <tbody>
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
                <a href="booking_details.php?booking_id=<?php echo $booking['id']; ?>" class="btn btn-primary">Make Payment</a>
              <?php } ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
  <?php
} else {
  echo "No bookings found for the logged-in user.";
}
?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
