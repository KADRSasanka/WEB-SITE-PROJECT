<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "xpressmart"; // Updated database name

// Create connection
$connection = new mysqli($servername, $username, $password, $database);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$fname = "";
$lname = "";
$email = "";
$phone = "";
$address = "";
$passcode = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname   = $_POST["fname"] ?? "";
    $lname   = $_POST["lname"] ?? "";
    $email   = $_POST["email"] ?? "";
    $phone   = $_POST["phone"] ?? "";
    $address = $_POST["address"] ?? "";
    $passcode = $_POST["passcode"] ?? "";

    do {
        if (empty($fname) || empty($lname) || empty($email) || empty($passcode)) {
            $errorMessage = "First Name, Last Name, Email, and Password are required!";
            break;
        }

        // Hash the password
        $hashedPass = password_hash($passcode, PASSWORD_BCRYPT);

        // Prepared statement without signup_method
        $stmt = $connection->prepare("INSERT INTO users (FirstName, LastName, Email, PhoneNo, Address, Passcode) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $fname, $lname, $email, $phone, $address, $passcode);

        if ($stmt->execute()) {
            $successMessage = "New user added successfully!";
            // Reset fields
            $fname = $lname = $email = $phone = $address = $passcode = "";
            // Redirect to users list page
            header("Location: /htdocs/index.php"); 
            exit;
        } else {
            $errorMessage = "Error: " . $stmt->error;
            break;
        }

    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="semantic.css">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="SignUP.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="shortcut icon" href="Images & Logos/novax-black.png" type="image/x-icon">
    <title>Xpress Mart</title>
    
</head>
<body>
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
    <!--
    <div style="margin-top: 15px;">
            <p>Or sign up with:</p>
            <button class="googleButton" type="button" onclick="googleSignIn()">
                <i class="fab fa-google"></i> Google
            </button>
    </div>
    -->
  </div>
  <script>
        document.getElementById('signupForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const phone = document.getElementById('phone').value;
            const address = document.getElementById('address').value;
            if (password !== document.getElementById('confirm').value) {
                alert('Passwords do not match!');
                return;
            }
            // Call the emailSignUp function
            window.emailSignUp(email, password, phone, address);
        });
  </script>

</body>
</html>