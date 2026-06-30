<?php
include('config.php');
$res = $conn->query('SELECT * FROM faqs ORDER BY id DESC');
?>
<!doctype html><html><head><meta charset='utf-8'><title>FAQ</title></head>
<body>
<h1>FAQ</h1>
<?php while($row = $res->fetch_assoc()): ?>
  <h3><?php echo htmlspecialchars($row['question']); ?></h3>
  <p><?php echo nl2br(htmlspecialchars($row['answer'])); ?></p>
<?php endwhile; ?>
<p><a href="index.php">Home</a></p>
</body></html>