<?php

session_start();

// Include the configuration file
include 'config.php';

if (!isset($_SESSION["id"]) || $_SESSION["usertype"] != "admin") {
    header("location: ../index.php");
    exit;
}
?>
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
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>All Bookings - Bus Management</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <style>
    body {
background-color: #f2f2f2;
    }
.container{
  margin-top: 50px;
}
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }

    .generate-report-form {
      margin-top: 30px;
    }
  </style>
</head>
<body>
  <?php include('admin_navbar.php') ?>

  <div class="container">
    <h2 class="text-center mb-4">All Bookings - Bus Management</h2>
    <table class="table">
      <thead>
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
      </thead>
      <tbody>
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
              <a href="admin_bookings.php?booking_id=<?php echo $booking['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>

    <h2>Generate Sales Report</h2>
    <form method="post" class="generate-report-form">
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="start_date" class="form-label">Start Date:</label>
            <input type="date" id="start_date" name="start_date" class="form-control" required>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="end_date" class="form-label">End Date:</label>
            <input type="date" id="end_date" name="end_date" class="form-control" required>
          </div>
        </div>
      </div>
      <button type="submit" name="generate_report" class="btn btn-primary">Generate Report</button>
    </form>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
