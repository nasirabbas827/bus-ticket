<?php
require 'config.php';

// Check if the booking ID is provided for deletion
if (isset($_GET['booking_id'])) {
  $booking_id = $_GET['booking_id'];

  // Delete the booking from the database
  $deleteSql = "DELETE FROM bookings WHERE id = $booking_id";
  if ($conn->query($deleteSql) === true) {
    // Redirect back to the same page
    header("Location: admin_bookings.php");
    exit;
  } else {
    echo "Error deleting the booking: " . $conn->error;
  }
}

// Check if the "Generate Report" form is submitted
if (isset($_POST['generate_report'])) {
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];

  // Fetch the bookings within the specified date range
  $reportSql = "SELECT bookings.*, routes.via_city, routes.destination, routes.bus_name, routes.bus_number, routes.departure_date, routes.departure_time
                FROM bookings
                JOIN routes ON bookings.route_id = routes.id
                WHERE routes.departure_date BETWEEN '$start_date' AND '$end_date'";
  $reportResult = $conn->query($reportSql);

  if ($reportResult !== false && $reportResult->num_rows > 0) {
    $reportBookings = $reportResult->fetch_all(MYSQLI_ASSOC);

    // Store the report bookings in a session variable
    $_SESSION['report_bookings'] = $reportBookings;

    // Redirect to the sales report page
    header("Location: sales_report.php");
    exit;
  } else {
    echo "No bookings found for the specified date range.";
  }
}

// Fetch all bookings
$sql = "SELECT bookings.*, routes.via_city, routes.destination, routes.bus_name, routes.bus_number, routes.departure_date, routes.departure_time
        FROM bookings
        JOIN routes ON bookings.route_id = routes.id";
$result = $conn->query($sql);

if ($result !== false && $result->num_rows > 0) {
  $bookings = $result->fetch_all(MYSQLI_ASSOC);

  // Display the bookings and the form to generate the sales report
  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <title>All Bookings - Bus Management</title>
  </head>
  <body>
    <h2>All Bookings - Bus Management</h2>
    <table>
      <tr>
        <th>Ticket ID</th>
        <th>User Email</th>
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
          <td><?php echo $booking['user_email']; ?></td>
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
            <a href="admin_bookings.php?booking_id=<?php echo $booking['id']; ?>">Delete</a>
          </td>
        </tr>
      <?php } ?>
    </table>

    <h2>Generate Sales Report</h2>
    <form method="post">
      <label for="start_date">Start Date:</label>
      <input type="date" id="start_date" name="start_date" required><br><br>
      <label for="end_date">End Date:</label>
      <input type="date" id="end_date" name="end_date" required><br><br>
      <input type="submit" name="generate_report" value="Generate Report">
    </form>
  </body>
  </html>
  <?php
} else {
  echo "No bookings found.";
}
?>
