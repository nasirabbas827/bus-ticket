<!DOCTYPE html>
<html>
<head>
  <title>Easy Paisa Payment - Bus Management</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>


body{
  background-color: #f2f2f2;
}
</style>
</head>
<body>
<?php include('navbar.php') ?>

<div class="container mt-4 mb-4">
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
          ?>

          <h2>Easy Paisa Payment - Bus Management</h2>
          <h3>User Details</h3>
          <div class="row">
            <div class="col-md-6">
              <p><strong>Name:</strong> <?php echo $user['username']; ?></p>
              <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
              <p><strong>Phone Number:</strong> <?php echo $user['phone']; ?></p>
            </div>
          </div>
          <hr>
          <h3>Booking Information</h3>
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
                <th>Ticket Price</th>
                <th>Number of Tickets</th>
                <th>Total Price</th>
              </tr>
            </thead>
            <tbody>
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
            </tbody>
          </table>

          <h3>Payment Method: Easy Paisa</h3>
          <p>Please complete the payment through Easy Paisa to confirm your booking.</p>
          <p>After completing the payment, your ticket will be issued.</p>

          <!-- Easy Paisa payment instructions and form -->
          <form action="easy_payment.php" method="POST">
            <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
            <input type="hidden" name="total_price" value="<?php echo $booking['total_price']; ?>">
            <button type="submit" class="btn btn-primary">Proceed to Easy Paisa Payment</button>
          </form>

          <?php
        } else {
          echo "<p>User details not found.</p>";
        }
      } else {
        echo "<p>Route details not found.</p>";
      }
    } else {
      echo "<p>Booking details not found.</p>";
    }
  } else {
    echo "<p>Invalid booking ID.</p>";
  }
  ?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
