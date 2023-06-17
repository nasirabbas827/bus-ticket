<?php
session_start();
if (!isset($_SESSION['report_bookings'])) {
  echo "No sales report data available.";
  exit;
}

$reportBookings = $_SESSION['report_bookings'];
unset($_SESSION['report_bookings']);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Sales Report - Bus Management</title>
</head>
<body>
  <h2>Sales Report - Bus Management</h2>
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
    </tr>
    <?php foreach ($reportBookings as $booking) { ?>
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
      </tr>
    <?php } ?>
  </table>

  <button onclick="printReport()">Print Report</button>

  <script>
    function printReport() {
      window.print();
    }
  </script>
</body>
</html>
