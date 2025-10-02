<?php
session_start();
require '../db.php';

if(!isset($_SESSION['user_id'])){
    header('Location: ../login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// جلب الأخبار الخاصة بالمستخدم
$sql = "SELECT news.*, categories.name AS category_name 
        FROM news 
        JOIN categories ON news.category_id = categories.id 
        WHERE news.user_id = ? AND news.deleted = 0
        ORDER BY news.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<title>أخبارك</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.news-card img { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; margin-left: 15px; }
.card:hover { transform: translateY(-5px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); transition: 0.3s; }
</style>
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="mb-4">الأخبار الخاصة بك</h2>
    <div class="row g-3">
        <?php while($news = $result->fetch_assoc()): ?>
        <div class="col-md-6">
            <div class="card p-3 d-flex flex-row align-items-center news-card">
                <?php if(!empty($news['image'])): ?>
                    <img src="../uploads/<?= htmlspecialchars($news['image']) ?>" alt="صورة الخبر">
                <?php else: ?>
                    <img src="../uploads/default.png" alt="بدون صورة">
                <?php endif; ?>

                <div class="flex-grow-1">
                    <h5><?= htmlspecialchars($news['title']) ?></h5>
                    <p class="mb-1"><strong>الفئة:</strong> <?= htmlspecialchars($news['category_name']) ?></p>
                    <p class="mb-1"><?= htmlspecialchars(substr($news['details'],0,60)) ?>...</p>
                    <small><?= $news['created_at'] ?></small>
                </div>

                <!-- أزرار التعديل والحذف -->
                <div class="ms-3 d-flex flex-column">
                    <a href="edit_news.php?id=<?= $news['id'] ?>" 
                       class="btn btn-sm btn-warning mb-1"> تعديل</a>
                    <a href="delete_news.php?id=<?= $news['id'] ?>" 
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('هل أنت متأكد من حذف هذا الخبر؟')"> حذف</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

</body>
</html>
