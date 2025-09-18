<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "xpressmart";

//create connection
$connection = new mysqli($servername, $username, $password, $database);

$fname = "";
$lname = "";
$email = "";
$id = "";
$phone = "";
$address = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET["id"])) {
        header("location: /WEB-SITE-PROJECT.github.io/user.php");
        exit;
    }
    $id = $_GET["id"];

    $sql = "SELECT * FROM users WHERE ID = $id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: /WEB-SITE-PROJECT.github.io/user.php");
        exit;
    }

    $id      = $row["ID"];
    $fname   = $row["FirstName"];
    $lname   = $row["LastName"];
    $email   = $row["Email"];
    $phone   = $row["PhoneNo"];
    $address = $row["Address"];

} else {
    $fname   = $_POST["fname"] ?? "";
    $lname   = $_POST["lname"] ?? "";
    $email   = $_POST["email"] ?? "";
    $id      = $_POST["id"] ?? "";
    $phone   = $_POST["phone"] ?? "";
    $address = $_POST["address"] ?? "";

    do {
        if (empty($fname) || empty($lname) || empty($email) || empty($id)) {
            $errorMessage = "First Name, Last Name, Email and ID are required";
            break;
        }

        // update user in db
        $sql = "UPDATE users 
                SET FirstName = '$fname', LastName = '$lname', Email = '$email', PhoneNo = '$phone', Address = '$address'
                WHERE ID = $id";

        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid Query: ".$connection->error;
            break;
        }

        $successMessage = "User updated Successfully.";

        header("location: /WEB-SITE-PROJECT.github.io/user.php");
        exit;

    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="shortcut icon" href="signup.png" type="image/x-icon">
  <title>Edit User</title>
  <link rel="stylesheet" href="SignUP.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
  <script src="index.js"></script>
</head>
<body>
  <?php
  if (!empty($errorMessage)) {
      echo "
      <div class='alert alert-warning d-flex align-items-center' role='alert'>
        <div>
          <strong>$errorMessage</strong>
        </div>
      </div>
      ";
  }
  ?>

  <?php
  if (!empty($successMessage)) {
      echo "
      <div class='alert alert-success d-flex align-items-center' role='alert'>
        <div>
          <strong>$successMessage</strong>
        </div>
      </div>
      ";
  }
  ?>

  <div class="signup-box">
    <a href="index.html"><i class="fa-solid fa-xmark close-btn" onclick="document.querySelector('.signup-box').style.display='none'"></i></a>

    <div class="logo">
      <img src="Images & Logos/novax-black.png" alt="Supermarket Logo">
    </div>

    <h2>REGISTRATION</h2>
    <form action="signUp.php" method="POST">
      <div class="row">
        <div class="col">
          <input type="text" id="firstname" name="fname" placeholder="First name" required>
        </div>
        <div class="col">
          <input type="text" id="lastname" name="lname" placeholder="Last name" required>
        </div>
      </div>

      <input type="email" class="full-input" id="email" name="email" placeholder="Enter your email" required>

      <input type="tel" class="full-input" id="phone" name="phone" placeholder="Mobile Number" required>

      <input type="text" class="full-input" id="address" name="address" placeholder="Address" required>

      <div class="row">
        <div class="col">
          <input type="password" id="password" name="passcode" placeholder="Enter password" required>
        </div>
        <div class="col">
          <input type="password" id="confirm" name="confirm" placeholder="Re-enter password" required>
        </div>
      </div>

      <button type="submit">SIGN UP</button>
    </form>
  </div>
</body>
</html>
