<?php
session_start();
require 'db.php';

if(isset($_GET['animal_id']) && is_numeric($_GET['animal_id'])) {
    $animalId = (int)$_GET['animal_id'];
    
    try {
        // Логируем просмотр в статистике
        $stmt = $conn->prepare("
            INSERT INTO animal_views (animal_id, views) 
            VALUES (?, 1)
            ON DUPLICATE KEY UPDATE views = views + 1
        ");
        $stmt->execute([$animalId]);
        
        // Логируем действие пользователя
        $userId = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;
        logAction($conn, 'ANIMAL_VIEW', 'Viewed animal ID: ' . $animalId);
        
        echo 'View logged';
    } catch(PDOException $e) {
        http_response_code(500);
        echo 'Error logging view';
    }
} else {
    http_response_code(400);
    echo 'Invalid animal ID';
}
?>