<?php
require_once '../db.php';
session_start();

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    echo json_encode(['success' => false, 'message' => 'Доступ запрещен']);
    exit;
}

$donationId = (int)$_POST['id'];

try {
    $stmt = $conn->prepare("UPDATE donations SET status = 'completed' WHERE id = ?");
    $stmt->execute([$donationId]);
    
    // Логируем действие
    logAction($conn, 'DONATION_CONFIRMED', 'Confirmed donation ID: ' . $donationId);
    
    echo json_encode(['success' => true]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}