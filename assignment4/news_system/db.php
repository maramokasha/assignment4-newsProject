<?php
$servername = "localhost";
$username = "root";
$password = ""; // إذا عندك باسورد في MySQL حطيه هنا
$dbname = "news_system";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");


?>