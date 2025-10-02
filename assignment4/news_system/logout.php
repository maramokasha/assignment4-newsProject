<?php
session_start();
$user_name = $_SESSION['user_name'] ?? 'ضيف'; // لو الجلسة فاضية
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>تم تسجيل الخروج</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card text-center shadow-lg">
          <div class="card-body">
            <h3 class="card-title mb-4">مع السلامة، <?= htmlspecialchars($user_name) ?>!</h3>
            <p class="card-text mb-4">هل تريد الدخول مجددًا؟</p>
            <a href="login.php" class="btn btn-primary">تسجيل الدخول مرة أخرى</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
