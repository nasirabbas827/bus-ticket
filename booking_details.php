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
</head>
<body>
<div>
    <p>Welcome, <?php echo $user_name; ?>!</p>
    <p>Email: <?php echo $user_email; ?></p>
    <p>Phone: <?php echo $user_phone; ?></p>
  </div>
  <h2>Booking Details - Bus Management</h2>
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

  <h3>Payment Options</h3>
  <form action="" method="post">
    <input type="radio" name="payment_option" value="easy_paisa"> Easy Paisa<br>
    <input type="radio" name="payment_option" value="cash_on_counter"> Cash on Counter<br>
    <button type="submit" name="submit_payment">Submit Payment</button>
  </form>

  <?php
  if (isset($_POST['submit_payment'])) {
    $payment_option = $_POST['payment_option'];
    if ($payment_option === 'easy_paisa') {
      // Redirect to Easy Paisa page
      header("Location: easy_paisa_payment.php?booking_id=" . $booking['id']);
      exit;
    } elseif ($payment_option === 'cash_on_counter') {
      // Redirect to next page with all details and payment method
      header("Location: counter_payment.php?booking_id=" . $booking['id']);
      exit;
    }
  }
  ?>
</body>
</html>

