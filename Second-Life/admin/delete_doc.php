<?php
require '../../db.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: ../../login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Получаем информацию о файле
    $stmt = $conn->prepare("SELECT file_path FROM documentation WHERE id = ?");
    $stmt->execute([$id]);
    $doc = $stmt->fetch();
    
    if ($doc) {
        // Удаляем файл
        if (file_exists($doc['file_path'])) {
            unlink($doc['file_path']);
        }
        
        // Удаляем запись из БД
        $conn->prepare("DELETE FROM documentation WHERE id = ?")->execute([$id]);
    }
}

header('Location: ../../admin.php#docs');