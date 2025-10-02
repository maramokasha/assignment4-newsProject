<?php
require '../db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$sql = "SELECT news.*, categories.name AS category_name, users.name AS author
        FROM news
        JOIN categories ON news.category_id = categories.id
        JOIN users ON news.user_id = users.id
        WHERE news.deleted = 1
        ORDER BY news.created_at DESC";
$res = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>الأخبار المحذوفة</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-body">
            <h2 class="mb-4">الأخبار المحذوفة</h2>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>العنوان</th>
                        <th>الفئة</th>
                        <th>الكاتب</th>
                        <th>التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; while ($r = $res->fetch_assoc()): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($r['title']) ?></td>
                            <td><?= htmlspecialchars($r['category_name']) ?></td>
                            <td><?= htmlspecialchars($r['author']) ?></td>
                            <td>
                                <a href="restore.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-success">استعادة</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <a href="../dashboard.php" class="btn btn-secondary">العودة للوحة التحكم</a>
        </div>
    </div>
</div>
</body>
</html>
