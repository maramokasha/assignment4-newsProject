<?php
require '../db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id) {
    $stmt = $conn->prepare("UPDATE news SET deleted=0 WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: deleted_news.php");
exit;
