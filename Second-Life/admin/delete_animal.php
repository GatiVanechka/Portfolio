<?php
require_once '../db.php';
header('Content-Type: application/json');

if(!isset($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID животного не указан']);
    exit;
}

$animalId = (int)$_POST['id'];

try {
    // Удаляем животное
    $stmt = $conn->prepare("DELETE FROM animals WHERE id = ?");
    $stmt->execute([$animalId]);
    
    echo json_encode(['success' => true]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Ошибка базы данных: ' . $e->getMessage()]);
}