<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "xpressmart"; // Create in phpMyAdmin

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$firstname = $_POST['FirstName'];
$lastname  = $_POST['LastName'];
$email     = $_POST['Email'];
$phone     = $_POST['PhoneNo'];
$address   = $_POST['Address'];
$password  = $_POST['Passcode'];
$confirm   = $_POST['ConfirmPasscode'];

// Validate passwords
if ($passcode !== $confirm) {
    die("Passwords do not match!");
}

// Hash password
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Insert user
$sql = "INSERT INTO users (FirstName, LastName, Email, phone, PhoneNo, Passcode)
        VALUES ('$firstname', '$lastname', '$email', '$phone', '$address', '$hashedPassword')";

if ($conn->query($sql) === TRUE) {
    echo "Signup successful!";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
