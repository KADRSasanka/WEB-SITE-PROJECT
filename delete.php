<?php
if (isset($_GET["ID"])) {
    $id = $_GET["ID"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "xpressmart";

    // create connection
    $connection = new mysqli($servername, $username, $password, $database);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // delete user by ID
    $sql = "DELETE FROM users WHERE ID = $id";
    $connection->query($sql);
}


header("Location: /WEB-SITE-PROJECT.github.io/user.php");
exit;
?>
