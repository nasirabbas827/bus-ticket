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

// Fetch booking details based on the booking ID
if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    $sql = "SELECT * FROM bookings WHERE id = $booking_id";
    $result = $conn->query($sql);

    if ($result !== false && $result->num_rows > 0) {
        // Fetch the booking details
        $booking = $result->fetch_assoc();

        // Fetch the route details based on the route ID
        $route_id = $booking['route_id'];
        $sql = "SELECT * FROM routes WHERE id = $route_id";
        $result = $conn->query($sql);

        if ($result !== false && $result->num_rows > 0) {
            $route = $result->fetch_assoc();
            $ticket_price = $route['ticket_price'];
        } else {
            // Handle error if route details not found
            echo "Route details not found.";
            exit;
        }
    } else {
        // Handle error if booking details not found
        echo "Booking details not found.";
        exit;
    }
} else {
    // Handle error if booking ID is not provided
    echo "Invalid booking ID.";
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the selected payment option
    $payment_option = $_POST['payment_option'];

    // Update the booking status based on the payment option
    if ($payment_option === 'easy_paisa') {
        // Redirect to Easy Paisa page
        header("Location: easy_paisa_payment.php?booking_id=" . $booking['id']);
        exit;
    } elseif ($payment_option === 'cash_on_counter') {
        // Update the booking status to "pending"
        $sql = "UPDATE bookings SET status = 'pending' WHERE id = $booking_id";
        if ($conn->query($sql) === true) {
            echo "Booking confirmed. Please pay at the counter.";
        } else {
            echo "Error updating booking status: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Booking Details - Bus Management</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>


body{
  background-color: #f2f2f2;
}
    h2 {
      margin-bottom: 30px;
    }

    table {
      margin-bottom: 30px;
    }

    th {
      text-align: center;
    }
  </style>
</head>
<body>
<?php include('navbar.php') ?>

<div class="container mt-4">
  <div class="row">
    <div class="col">
      <p class="lead">Welcome, <?php echo $user_name; ?>!</p>
      <p>User Email: <?php echo $user_email; ?></p>
      <p>User Phone Number: <?php echo $user_phone; ?></p>
    </div>
  </div>
</div>

<div class="container mt-4">
  <h2 class="mb-4">Booking Details - Bus Management</h2>
  <h3>Booking Information</h3>
  <table class="table table-striped">
    <thead class="table-dark">
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

  <h3 class="mt-3">Payment Options</h3>
  <form action="" method="post">
  <div class="col-auto">
      <div class="form-check">
        <input class="form-check-input" type="radio" name="payment_option" id="payment_option_easy_paisa" value="easy_paisa">
        <label class="form-check-label" for="payment_option_easy_paisa">Easy Paisa</label>
      </div>
    </div>
    <div class="col-auto">
      <div class="form-check">
        <input class="form-check-input" type="radio" name="payment_option" id="payment_option_cash_on_counter" value="cash_on_counter">
        <label class="form-check-label" for="payment_option_cash_on_counter">Cash on Counter</label>
      </div>
    </div>
    <div class="col-auto">
      <button type="submit" name="submit_payment" class="btn btn-primary">Submit Payment</button>
    </div>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
