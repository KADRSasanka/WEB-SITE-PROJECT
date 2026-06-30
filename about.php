<?php
include('config.php');
$stmt = $conn->prepare("SELECT content FROM pages WHERE page_name='about' LIMIT 1");
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$content = $row['content'] ?? file_get_contents('About.html');
?>
<!doctype html><html><head><meta charset='utf-8'><title>About</title></head>
<body>
<?php echo $content; ?>
<p><a href="main.php">Home</a></p>
</body></html>