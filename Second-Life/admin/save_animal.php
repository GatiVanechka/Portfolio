<?php
session_start();
require_once '../db.php';
header('Content-Type: application/json');

// Проверяем авторизацию администратора
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    echo json_encode(['success' => false, 'message' => 'Доступ запрещен']);
    exit;
}

// Получаем данные из формы
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$name = trim($_POST['name']);
$type = $_POST['type'];
$breed = trim($_POST['breed']);
$age = (int)$_POST['age'];
$gender = $_POST['gender'];
$description = trim($_POST['description']);
$current_image = $_POST['current_image'] ?? '';

try {
    // Обработка загрузки изображения
    $image_path = $current_image;
    if(isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = '../images/animals/';
        $file_name = uniqid() . '_' . basename($_FILES['image']['name']);
        $target_path = $upload_dir . $file_name;
        
        if(move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            $image_path = 'images/animals/' . $file_name;
            // Удаляем старое изображение, если оно есть и это обновление
            if($id > 0 && !empty($current_image)) {
                @unlink('../' . $current_image);
            }
        }
    }

    if($id > 0) {
        // Редактирование существующего животного
        $stmt = $conn->prepare("UPDATE animals SET 
            name = ?, type = ?, breed = ?, age = ?, gender = ?, 
            description = ?, image = COALESCE(?, image)
            WHERE id = ?");
        $stmt->execute([$name, $type, $breed, $age, $gender, $description, $image_path, $id]);
        
        echo json_encode(['success' => true, 'message' => 'Животное успешно обновлено']);
    } else {
        // Добавление нового животного
        $stmt = $conn->prepare("INSERT INTO animals 
            (name, type, breed, age, gender, description, image) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $type, $breed, $age, $gender, $description, $image_path]);
        
        echo json_encode(['success' => true, 'message' => 'Животное успешно добавлено']);
    }
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Ошибка базы данных: ' . $e->getMessage()]);
}