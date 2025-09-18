<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="shortcut icon" href="Images & Logos/novax-black.png" type="image/x-icon">
    <title>Xpress Mart - User Management</title>
</head>
<body>
    <div class="container my-5">
        <h2>USER INFORMATION</h2>
        <div class="d-grid gap-2">
            <a href="/WEB-SITE-PROJECT.github.io/SignUP.php"><button class="btn btn-primary" type="button">+ Add New User</button></a>
        </div>
        <br>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Passcode</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "xpressmart"; // Updated database

                // Create connection
                $connection = new mysqli($servername, $username, $password, $database);

                // Check connection
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                // Read all users
                $sql = "SELECT * FROM users";
                $result = $connection->query($sql);

                if (!$result) {
                    die("Invalid query: " . $connection->error);
                }

                // Output each user
                while($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>{$row['ID']}</td>
                        <td>{$row['FirstName']}</td>
                        <td>{$row['LastName']}</td>
                        <td>{$row['Email']}</td>
                        <td>{$row['PhoneNo']}</td>
                        <td>{$row['Address']}</td>
                        <td>{$row['Passcode']}</td>
                        <td>
                            <a href='/edit.php?id={$row['ID']}'><button type='button' class='btn btn-outline-success'>Edit</button></a>
                            <a href='/delete.php?id={$row['ID']}'><button type='button' class='btn btn-outline-danger' onclick='return confirm('Are you sure you want to delete this user?');'>Delete</button></a>
                        </td>
                    </tr>
                    ";
                }

                $connection->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
