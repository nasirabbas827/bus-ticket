<?php
  require 'config.php';

  // Check if the user is already logged in
  if (!isset($_SESSION['email'])) {
    // Redirect to the login page
    header("Location: login.php");
    exit;
  }
  ?>
<!DOCTYPE html>
<html>
<head>
  <title>Invoice - Bus Management</title>
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
<?php include('navbar.php') ?>

<div class="container">
  <?php
  // Check if the form is submitted
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the booking ID and total price from the form data
    $booking_id = $_POST['booking_id'];
    $total_price = $_POST['total_price'];

    // Perform the Easy Paisa payment processing logic here

    // Assuming the payment is successful, update the booking status
    $sql = "UPDATE bookings SET status = 'confirmed' WHERE id = $booking_id";
    if ($conn->query($sql) === true) {
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

            // Generate the invoice HTML
            $invoice_html = "
            <h2 class='mt-4'>Invoice - Online Bus Station Ticketing System</h2>
            <h3>User Details</h3>
            <div class='row'>
              <div class='col-md-6'>
                <p><strong>Name:</strong> {$user['username']}</p>
                <p><strong>Email:</strong> {$user['email']}</p>
                <p><strong>Phone Number:</strong> {$user['phone']}</p>
              </div>
            </div>
            <hr>
            <h3>Booking Information</h3>
            <table class='table'>
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
                  <th>Payment Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>{$booking['id']}</td>
                  <td>{$route['via_city']}</td>
                  <td>{$route['destination']}</td>
                  <td>{$route['bus_name']}</td>
                  <td>{$route['bus_number']}</td>
                  <td>{$route['departure_date']}</td>
                  <td>{$route['departure_time']}</td>
                  <td>{$ticket_price}</td>
                  <td>{$booking['num_tickets']}</td>
                  <td>{$booking['total_price']}</td>
                  <td>{$booking['status']}</td>
                </tr>
              </tbody>
            </table>
            <script>
              window.onload = function() {
                window.print();
              }
            </script>
            ";

            // Output the invoice HTML
            echo $invoice_html;
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
      echo "<p>Error updating booking status: " . $conn->error . "</p>";
    }
  } else {
    echo "<p>Invalid request.</p>";
  }
  ?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
