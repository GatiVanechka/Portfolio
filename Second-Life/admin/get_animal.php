<?php
require_once '../db.php';
header('Content-Type: application/json');

if(!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID животного не указан']);
    exit;
}

$animalId = (int)$_GET['id'];
$stmt = $conn->prepare("SELECT * FROM animals WHERE id = ?");
$stmt->execute([$animalId]);
$animal = $stmt->fetch(PDO::FETCH_ASSOC);

if($animal) {
    echo json_encode(['success' => true, 'animal' => $animal]);
} else {
    echo json_encode(['success' => false, 'message' => 'Животное не найдено']);
}