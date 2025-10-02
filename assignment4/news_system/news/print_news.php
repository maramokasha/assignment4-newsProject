<?php
session_start();
require '../db.php';
if(!isset($_SESSION['user_id'])){ header('Location: ../login.php'); exit; }
$user_id = $_SESSION['user_id'];

$sql = "SELECT news.title, news.details, categories.name AS category_name, news.created_at
        FROM news JOIN categories ON news.category_id = categories.id
        WHERE news.user_id=? AND news.deleted=0
        ORDER BY news.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

//جربت انه يكون في زر لما يضغط عليه المستخدم يطبعله كل الخبار في بي دي اف
?>
<!DOCTYPE html>
<html lang="ar">
<head><meta charset="UTF-8"><title>طباعة الأخبار</title></head>
<body>
<h2>جميع الأخبار الخاصة بك</h2>
<?php while($row=$result->fetch_assoc()): ?>
  <h3><?= htmlspecialchars($row['title']) ?></h3>
  <p><strong>الفئة:</strong> <?= htmlspecialchars($row['category_name']) ?></p>
  <p><strong>التفاصيل:</strong> <?= htmlspecialchars($row['details']) ?></p>
  <p><strong>تاريخ الإضافة:</strong> <?= $row['created_at'] ?></p>
  <hr>
<?php endwhile; ?>
<script>window.print();</script>
</body>
</html>
