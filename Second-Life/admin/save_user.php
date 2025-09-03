<?php
require_once '../db.php';
session_start();
header('Content-Type: application/json');

// Проверка прав администратора
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    echo json_encode(['success' => false, 'message' => 'Доступ запрещен']);
    exit;
}

// Получение данных из формы
$userId = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$role = $_POST['role'];
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

// Валидация данных
if(empty($name) || empty($email) || empty($role)) {
    echo json_encode(['success' => false, 'message' => 'Все обязательные поля должны быть заполнены']);
    exit;
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Некорректный email']);
    exit;
}

if(!in_array($role, ['user', 'admin'])) {
    echo json_encode(['success' => false, 'message' => 'Некорректная роль пользователя']);
    exit;
}

try {
    // Проверка, что email не занят другим пользователем
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $stmt->execute([$email, $userId]);
    if($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Этот email уже используется другим пользователем']);
        exit;
    }

    if($userId > 0) {
        // Обновление существующего пользователя
        if(!empty($password)) {
            // Если указан пароль - обновляем его
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ?, password = ? WHERE id = ?");
            $stmt->execute([$name, $email, $role, $hashedPassword, $userId]);
        } else {
            // Без изменения пароля
            $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
            $stmt->execute([$name, $email, $role, $userId]);
        }
        
        $action = 'USER_UPDATED';
        $message = 'Обновлен пользователь ID: ' . $userId;
    } else {
        // Создание нового пользователя
        if(empty($password)) {
            echo json_encode(['success' => false, 'message' => 'Для нового пользователя необходимо указать пароль']);
            exit;
        }
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$name, $email, $hashedPassword, $role]);
        $userId = $conn->lastInsertId();
        
        $action = 'USER_CREATED';
        $message = 'Создан новый пользователь ID: ' . $userId;
    }
    
    // Логируем действие
    logAction($conn, $action, $message);
    
    echo json_encode(['success' => true, 'userId' => $userId]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Ошибка базы данных: ' . $e->getMessage()]);
}