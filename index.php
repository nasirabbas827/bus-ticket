<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['email'])) {
  // User is logged in, redirect to another page
  header("Location: home.php"); 
  exit;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Online Bus Ticketing System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    body {
      background-image: url(image/1.jpg);
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }
    .home_details {
      color: #fff;
      font-family: inherit;
      font-size: 74px;
      padding: 162px 5px 5px 185px;
    }
    .font {
      color: #F9522E;
    }
    .btnHome {
      font-family: inherit;
      background-color: #F9522E;
      padding: 13px 44px 13px 44px;
      font-size: 18px;
      border-style: none;
    }
    .btnHome:hover {
      background-color: orange;
      cursor: pointer;
    }
    .section {
      position: relative;
      height: 100vh;
      overflow: hidden;
    }
    .section video {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      min-width: 100%;
      min-height: 100%;
      width: auto;
      height: auto;
      z-index: -1;
    }
  </style>
</head>
<body>
  <div id="container">
    <!-- Navbar -->
    <?php include "navbar.php"; ?>
    <h1 class="home_details">Your Bus Pass. Anytime. <br><font class="font">Anywhere..</font><br>
      <a href="register.php">
        <button class="btnHome">SIGN UP NOW</button>
      </a>
    </h1>
  </div>
  <div class="section">
    <video autoplay loop muted class="section">
      <source src="video/video.mp4" type="video/mp4">
    </video>
  </div>
  <!-- Footer -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
