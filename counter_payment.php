<!DOCTYPE html>
<html>
<head>
  <title>Cash On Counter</title>
  <style>
    /* CSS styling for the print button */
    .print-button {
      margin-top: 20px;
    }
  </style>
  <script>
    function printInvoice() {
      window.print();
    }
  </script>
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

  // Retrieve user details from the session
  $user_email = $_SESSION['email'];

  // Fetch user details from the database based on the email
  $sql = "SELECT * FROM users WHERE email = '$user_email'";
  $result = $conn->query($sql);

  if ($result !== false && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // Retrieve the user details
    $company_name = "Online Bus Station Ticketing System";
    $user_name = $user['username'];
    $user_email = $user['email'];
    $phone_number = $user['phone'];

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

          // Display the company name, user details, booking information, and route details
          ?>
          <h2>Company Name:<?php echo $company_name; ?></h2>
          <h3>Invoice</h3>
          <p><strong>User Name:</strong> <?php echo $user_name; ?></p>
          <p><strong>User Email:</strong> <?php echo $user_email; ?></p>
          <p><strong>Phone Number:</strong> <?php echo $phone_number; ?></p>
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
              <th>Payment Status</th>
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
              <td><?php echo $booking['status']; ?></td>
            </tr>
          </table>

          <h3>Payment Method: Cash On Counter</h3>
          <p>Please visit the counter to make the payment and collect your ticket.</p>
          <p>Your booking will be confirmed upon payment.</p>

          <button class="print-button" onclick="printInvoice()">Print Invoice</button>
          <?php
        } else {
          echo "<p>Route details not found.</p>";
        }
      } else {
        echo "<p>Booking details not found.</p>";
      }
    } else {
      echo "<p>Invalid booking ID.</p>";
    }
  } else {
    echo "<p>User details not found.</p>";
  }
  ?>
</body>
</html>
