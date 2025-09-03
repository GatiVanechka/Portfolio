<?php
require __DIR__ . '/../db.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: /login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    try {
        $stmt = $conn->prepare("SELECT image_path FROM news WHERE id = ?");
        $stmt->execute([$id]);
        $news = $stmt->fetch();
        
        if ($news) {
            if (!empty($news['image_path']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $news['image_path'])) {
                unlink($_SERVER['DOCUMENT_ROOT'] . $news['image_path']);
            }
            
            $conn->prepare("DELETE FROM news WHERE id = ?")->execute([$id]);
            $_SESSION['success'] = "Новость успешно удалена";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Ошибка при удалении: " . $e->getMessage();
    }
}

header('Location: /admin.php#news');  // Убрали повторное указание папки admin
exit;