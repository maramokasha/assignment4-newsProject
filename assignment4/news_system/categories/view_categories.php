<?php
require '../db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$cats = $conn->query("SELECT * FROM categories ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>عرض الفئات</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-body">
            <h2 class="mb-4">الفئات</h2>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>اسم الفئة</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($c = $cats->fetch_assoc()): ?>
                        <tr>
                            <td><?= $c['id'] ?></td>
                            <td><?= htmlspecialchars($c['name']) ?></td>
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
