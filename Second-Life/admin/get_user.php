<?php
require_once '../db.php';
header('Content-Type: application/json');

if(!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID пользователя не указан']);
    exit;
}

$userId = (int)$_GET['id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user) {
    echo json_encode(['success' => true, 'user' => $user]);
} else {
    echo json_encode(['success' => false, 'message' => 'Пользователь не найден']);
}