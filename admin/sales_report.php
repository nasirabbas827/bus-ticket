<?php

session_start();

// Include the configuration file
include 'config.php';

if (!isset($_SESSION["id"]) || $_SESSION["usertype"] != "admin") {
    header("location: login.php");
    exit;
}
?>
<?php
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
  <style>

    .invoice-container {
      max-width: 800px;
      margin-top: 50px;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      padding: 30px;
    }

    .invoice-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .invoice-title {
      font-size: 24px;
      font-weight: bold;
    }

    .invoice-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
    }

    .invoice-label {
      font-weight: bold;
    }

    .invoice-data {
      flex-grow: 1;
      text-align: right;
    }

    .print-report-btn {
      margin-top: 20px;
    }

    @media print {
      .print-report-btn,
      .navbar {
        display: none;
      }
      .invoice-container {
        box-shadow: none;
      }
    }
  </style>
</head>
<body>
<div class="container invoice-container">
  <div class="invoice-header">
    <h2 class="invoice-title">Sales Report - Bus Management</h2>
    <button class="btn btn-primary print-report-btn" onclick="printReport()">Print Report</button>
  </div>
  
  <?php foreach ($reportBookings as $booking) { ?>
    <div class="invoice-row">
      <span class="invoice-label">Ticket ID:</span>
      <span class="invoice-data"><?php echo $booking['id']; ?></span>
    </div>
    <div class="invoice-row">
      <span class="invoice-label">User Email:</span>
      <span class="invoice-data"><?php echo $booking['user_email']; ?></span>
    </div>
    <div class="invoice-row">
      <span class="invoice-label">Via City:</span>
      <span class="invoice-data"><?php echo $booking['via_city']; ?></span>
    </div>
    <div class="invoice-row">
      <span class="invoice-label">Destination:</span>
      <span class="invoice-data"><?php echo $booking['destination']; ?></span>
    </div>
    <div class="invoice-row">
      <span class="invoice-label">Bus Name:</span>
      <span class="invoice-data"><?php echo $booking['bus_name']; ?></span>
    </div>
    <div class="invoice-row">
      <span class="invoice-label">Bus Number:</span>
      <span class="invoice-data"><?php echo $booking['bus_number']; ?></span>
    </div>
    <div class="invoice-row">
      <span class="invoice-label">Departure Date:</span>
      <span class="invoice-data"><?php echo $booking['departure_date']; ?></span>
    </div>
    <div class="invoice-row">
      <span class="invoice-label">Departure Time:</span>
      <span class="invoice-data"><?php echo $booking['departure_time']; ?></span>
    </div>
    <div class="invoice-row">
      <span class="invoice-label">Number of Tickets:</span>
      <span class="invoice-data"><?php echo $booking['num_tickets']; ?></span>
    </div>
    <div class="invoice-row">
      <span class="invoice-label">Total Price:</span>
      <span class="invoice-data"><?php echo $booking['total_price']; ?></span>
    </div>
    <div class="invoice-row">
      <span class="invoice-label">Payment Status:</span>
      <span class="invoice-data"><?php echo $booking['status']; ?></span>
    </div>
    <hr>
  <?php } ?>
</div>

<script>
  function printReport() {
    window.print();
  }
</script>
</body>
</html>
