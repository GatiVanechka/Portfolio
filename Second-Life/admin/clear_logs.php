<?php
require_once '../db.php';
session_start();

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    echo json_encode(['success' => false, 'message' => 'Доступ запрещен']);
    exit;
}

try {
    $conn->exec("TRUNCATE TABLE action_logs");
    logAction($conn, 'LOGS_CLEARED', 'All logs cleared by admin');
    echo json_encode(['success' => true]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}