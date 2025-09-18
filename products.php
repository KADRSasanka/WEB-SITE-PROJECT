<?php
include('config.php');
$res = $conn->query('SELECT * FROM products ORDER BY id DESC');
?>
<!doctype html><html><head><meta charset='utf-8'><title>Products</title></head>
<body>
<h1>Products</h1>
<?php while($row = $res->fetch_assoc()): ?>
  <div style="border:1px solid #ccc;padding:10px;margin:10px;">
    <h3><?php echo htmlspecialchars($row['name']); ?> - <?php echo number_format($row['price'],2); ?></h3>
    <?php if(!empty($row['image'])): ?>
        <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" style="max-width:200px"><br>
    <?php endif; ?>
    <p><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
  </div>
<?php endwhile; ?>
<p><a href="index.php">Home</a></p>
</body></html>