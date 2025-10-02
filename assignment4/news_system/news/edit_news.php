<?php
require '../db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// جلب الخبر
$stmt = $conn->prepare("SELECT * FROM news WHERE id=? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$news = $stmt->get_result()->fetch_assoc();

if (!$news) {
    echo "الخبر غير موجود!";
    exit;
}

$cats = $conn->query("SELECT * FROM categories");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $category_id = (int)$_POST['category'];
    $details = trim($_POST['details']);
    $image = $news['image'];

    if (!empty($_FILES['image']['name'])) {
        $imgName = time() . '_' . basename($_FILES['image']['name']);
        $target = __DIR__ . '/../uploads/' . $imgName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image = $imgName;
        }
    }

    $stmt = $conn->prepare("UPDATE news SET title=?, category_id=?, details=?, image=? WHERE id=?");
    $stmt->bind_param("sissi", $title, $category_id, $details, $image, $id);
    if ($stmt->execute()) {
        $msg = 'تم تحديث الخبر بنجاح!';
        // إعادة جلب البيانات بعد التحديث
        $stmt = $conn->prepare("SELECT * FROM news WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $news = $stmt->get_result()->fetch_assoc();
    } else {
        $error = 'حدث خطأ: ' . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تعديل الخبر</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-body">
            <h2 class="mb-4">تعديل الخبر</h2>

            <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
            <?php if (!empty($msg)) echo "<div class='alert alert-success'>$msg</div>"; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">عنوان الخبر</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($news['title']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">الفئة</label>
                    <select name="category" class="form-select">
                        <?php while ($cat = $cats->fetch_assoc()):
                            $sel = $cat['id'] == $news['category_id'] ? 'selected' : '';
                        ?>
                            <option value="<?= $cat['id'] ?>" <?= $sel ?>><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">تفاصيل الخبر</label>
                    <textarea name="details" class="form-control" rows="5"><?= htmlspecialchars($news['details']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">الصورة الحالية</label><br>
                    <?= $news['image'] ? '<img src="../uploads/' . htmlspecialchars($news['image']) . '" width="120">' : 'لا توجد صورة' ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">تغيير الصورة</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                <a href="view_news.php" class="btn btn-secondary">العودة للأخبار</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
