<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "كلمة المرور غير صحيحة!";
        }
    } else {
        $error = "لا يوجد حساب بهذا البريد الإلكتروني!";
    }
}
?>
<!DOCTYPE html>
<html lang="ar" data-theme="light">
<head>
<meta charset="UTF-8">
<title>تسجيل الدخول</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
[data-theme="light"] body { background-color: #f8f9fa; color: #000; }
[data-theme="dark"] body { background-color: #121212; color: #fff; }

.theme-toggle { 
  position: fixed; 
  top: 10px; 
  right: 10px; 
  z-index: 1000; 
  border: none;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  font-size: 20px;
}
[data-theme="light"] .theme-toggle { background: #212529; color: #fff; }
[data-theme="dark"] .theme-toggle { background: #f8f9fa; color: #000; }
</style>
</head>
<body>
<button class="theme-toggle" onclick="toggleTheme()">
    <i class="fa fa-moon"></i>
</button>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-lg">
        <div class="card-body">
          <h3 class="text-center mb-4">تسجيل الدخول</h3>

          <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
          <?php endif; ?>

          <form method="post">
            <div class="mb-3">
              <label class="form-label">البريد الإلكتروني</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">كلمة المرور</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">دخول</button>
          </form>

          <p class="mt-3 text-center">
            ليس لديك حساب؟ <a href="register.php">سجل حساب جديد</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    /*حطيت زر للمستخدم عشان يغير من الدارك مود للايت مود والي بريحه*/ 
function toggleTheme(){
    let html = document.documentElement;
    let btn = document.querySelector(".theme-toggle i");
    if(html.getAttribute('data-theme') === 'light'){
        html.setAttribute('data-theme', 'dark');
        btn.classList.replace("fa-moon","fa-sun");
    } else {
        html.setAttribute('data-theme', 'light');
        btn.classList.replace("fa-sun","fa-moon");
    }
}
</script>
</body>
</html>
