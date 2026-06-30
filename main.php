<?php
include('config.php');
$stmt = $conn->prepare("SELECT content FROM pages WHERE page_name='home' LIMIT 1");
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$content = $row['content'] ?? file_get_contents('index.html');
?>
<!doctype html><html><head><meta charset='utf-8'><title>Home</title></head>
<body>
<?php echo $content; ?>
<p style="position:fixed;right:10px;bottom:10px;"><a href="admin/login.php">Admin</a></p>
</body></html>