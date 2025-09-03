<?php
require_once '../db.php';
session_start();
header('Content-Type: application/json');

// Проверка прав администратора
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    echo json_encode(['success' => false, 'message' => 'Доступ запрещен']);
    exit;
}

// Проверка ID пользователя
if(!isset($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID пользователя не указан']);
    exit;
}

$userId = (int)$_POST['id'];

// Нельзя удалить самого себя
if($userId == $_SESSION['user']['id']) {
    echo json_encode(['success' => false, 'message' => 'Вы не можете удалить самого себя']);
    exit;
}

try {
    // Удаление пользователя
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    
    if($stmt->rowCount() > 0) {
        // Логируем действие
        logAction($conn, 'USER_DELETED', 'Удален пользователь ID: ' . $userId);
        
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Пользователь не найден']);
    }
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Ошибка базы данных: ' . $e->getMessage()]);
}