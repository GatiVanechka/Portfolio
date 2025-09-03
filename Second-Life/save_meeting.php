<?php
session_start();
require 'db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;
    $animalId = $_POST['animal_id'];
    $meetingDate = $_POST['meeting_date'];
    $purpose = $_POST['purpose'];
    $userName = $_POST['user_name'];
    $userPhone = $_POST['user_phone'];
    
    try {
        $stmt = $conn->prepare("
            INSERT INTO meetings 
            (user_id, animal_id, meeting_date, purpose, user_name, user_phone)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$userId, $animalId, $meetingDate, $purpose, $userName, $userPhone]);
        
        header('Location: meetings.php?success=1');
        exit;
    } catch(PDOException $e) {
        header('Location: meetings.php?error=1');
        exit;
    }
}

header('Location: meetings.php');
?>