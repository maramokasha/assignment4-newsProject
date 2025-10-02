<?php
session_start();
if(!isset($_SESSION['user_id'])){ 
    header('Location: login.php'); 
    exit; 
}
?>
<!doctype html>
<html lang="ar" data-bs-theme="light">
<head>
<meta charset="utf-8">
<title>لوحة التحكم</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { transition: background-color 0.3s, color 0.3s; }
.card:hover { transform: translateY(-5px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); transition: 0.3s; }
.mode-toggle { position: fixed; top: 10px; right: 10px; z-index: 1000; }
</style>
</head>
<body class="bg-light text-dark">

<div class="mode-toggle">
    <button id="toggleMode" class="btn btn-secondary btn-sm">تغيير الوضع</button>
</div>

<div class="container mt-5">
    <h1 class="mb-4">أهلاً <?= htmlspecialchars($_SESSION['user_name']) ?></h1>
    <div class="row g-4">

        <div class="col-md-4">
            <div class="card p-3 text-center">
                <h5>إضافة فئة</h5>
                <p>أنشئ فئة جديدة لتصنيف الأخبار</p>
                <a href="categories/add_category.php" class="btn btn-primary">إضافة فئة</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 text-center">
                <h5>عرض الفئات</h5>
                <p>شاهد جميع الفئات المضافة</p>
                <a href="categories/view_categories.php" class="btn btn-primary">عرض الفئات</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 text-center">
                <h5>إضافة خبر</h5>
                <p>أنشئ خبر جديد</p>
                <a href="news/add_news.php" class="btn btn-primary">إضافة خبر</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 text-center">
                <h5>عرض جميع الأخبار</h5>
                <p>شاهد الأخبار التي أضفتها</p>
                <a href="news/view_news.php" class="btn btn-primary">عرض الأخبار</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 text-center">
                <h5>عرض الأخبار المحذوفة</h5>
                <p>يمكنك استعادة الأخبار المحذوفة</p>
                <a href="news/deleted_news.php" class="btn btn-danger">الأخبار المحذوفة</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 text-center">
                <h5>تسجيل الخروج</h5>
                <p>خروج من حسابك بأمان</p>
                <a href="logout.php" class="btn btn-warning">تسجيل الخروج</a>
            </div>
        </div>

    </div>
</div>

<script>
const toggleBtn = document.getElementById('toggleMode');
toggleBtn.addEventListener('click', () => {
    const html = document.documentElement;
    if(html.getAttribute('data-bs-theme') === 'light'){
        html.setAttribute('data-bs-theme', 'dark');
        document.body.classList.remove('bg-light','text-dark');
        document.body.classList.add('bg-dark','text-light');
    } else {
        html.setAttribute('data-bs-theme', 'light');
        document.body.classList.remove('bg-dark','text-light');
        document.body.classList.add('bg-light','text-dark');
    }
});
</script>

</body>
</html>
