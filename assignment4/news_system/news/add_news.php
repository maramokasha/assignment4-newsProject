<?php
session_start();
require '../db.php';
if(!isset($_SESSION['user_id'])){ header('Location: ../login.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $details = trim($_POST['details']);
    $category_id = $_POST['category_id'];
    $user_id = $_SESSION['user_id'];

    // رفع صورة
    $image = null;
    if(!empty($_FILES['image']['name'])){
        $image = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/".$image);
    }

    $stmt = $conn->prepare("INSERT INTO news (title, details, category_id, image, user_id, created_at) VALUES (?,?,?,?,?,NOW())");
    $stmt->bind_param("ssisi", $title, $details, $category_id, $image, $user_id);
    if($stmt->execute()){
        header("Location: ../dashboard.php");
        exit;
    } else {
        $error = "فشل في إضافة الخبر!";
    }
}

$cats = $conn->query("SELECT * FROM categories");
?>
<!DOCTYPE html>
<html lang="ar" data-theme="light">
<head>
<meta charset="UTF-8">
<title>إضافة خبر جديد</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
:root {
  --primary-color: #0d6efd;
  --bg-dark: #121212;
  --text-light: #fff;
}
[data-theme="dark"] body { background: var(--bg-dark); color: var(--text-light); }
.theme-toggle { position: fixed; top: 10px; right: 10px; z-index: 1000; }
.card { border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
.card:hover { transform: scale(1.02); transition: 0.2s; }
</style>
</head>
<body class="bg-light">
<button class="btn btn-secondary theme-toggle" onclick="toggleTheme()"><i class="fa fa-moon"></i></button>

<div class="container mt-5">
  <div class="card p-4">
    <h3 class="mb-4 text-center">📰 إضافة خبر جديد</h3>

    <?php if(!empty($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label">العنوان</label>
        <input type="text" name="title" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">التفاصيل</label>
        <textarea name="details" rows="4" class="form-control" required></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">الفئة</label>
        <select name="category_id" class="form-select" required>
          <option value="">اختر الفئة</option>
          <?php while($c=$cats->fetch_assoc()): ?>
            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">الصورة</label>
        <input type="file" name="image" class="form-control">
      </div>
      <div class="d-flex justify-content-between">
        <a href="../dashboard.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> رجوع</a>
        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> حفظ الخبر</button>
      </div>
    </form>
  </div>
</div>

<script>
function toggleTheme(){
  let html=document.documentElement;
  html.setAttribute('data-theme', html.getAttribute('data-theme')==='light'?'dark':'light');
}
</script>
</body>
</html>
