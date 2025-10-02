<?php
require '../db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id) {
    $stmt = $conn->prepare("UPDATE news SET deleted=1 WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: view_news.php");
exit;
