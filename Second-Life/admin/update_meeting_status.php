<?php
session_start();
require '../db.php';

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    echo json_encode(['success' => false, 'error' => 'Доступ запрещен']);
    exit;
}

$meetingId = $_POST['id'] ?? null;
$status = $_POST['status'] ?? null;
$animalId = $_POST['animal_id'] ?? null;

if(!$meetingId || !$status) {
    echo json_encode(['success' => false, 'error' => 'Неверные параметры']);
    exit;
}

try {
    $conn->beginTransaction();
    
    // Обновляем статус встречи
    $stmt = $conn->prepare("UPDATE meetings SET status = ? WHERE id = ?");
    $stmt->execute([$status, $meetingId]);
    
    // Если статус "adopted", помечаем животное как забранное
    if($status === 'adopted' && $animalId) {
        $stmt = $conn->prepare("UPDATE animals SET status = 'adopted' WHERE id = ?");
        $stmt->execute([$animalId]);
        
        // Логируем действие
        $userId = $_SESSION['user']['id'];
        $action = 'ANIMAL_ADOPTED';
        $details = "Animal ID: $animalId, Meeting ID: $meetingId";
        logAction($conn, $action, $details, $userId);
    }
    
    $conn->commit();
    echo json_encode(['success' => true]);
} catch(PDOException $e) {
    $conn->rollBack();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}