<?php
require 'db.php';

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *"); // На случай CORS

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$id) {
    echo json_encode(['error' => 'Неверный ID']);
    exit;
}

try {
    $stmt = $conn->prepare("SELECT * FROM animals WHERE id = ?");
    $stmt->execute([$id]);
    $animal = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$animal) {
        echo json_encode(['error' => 'Животное не найдено']);
        exit;
    }

    // Обработка изображения
    $defaultImage = '/images/animals/default.jpg';
    $customImage = $animal['image'] ?? '';
    
    if ($customImage) {
        // Нормализация пути
        $imagePath = $customImage;
        
        // Если путь не начинается с /images/animals/, добавляем его
        if (strpos($imagePath, '/images/animals/') !== 0) {
            $imagePath = '/images/animals/' . ltrim($imagePath, '/');
        }
        
        // Проверяем существование файла
        $fullPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
        if (!file_exists($fullPath)) {
            // Пробуем найти только по имени файла
            $filename = basename($imagePath);
            $altPath = '/images/animals/' . $filename;
            $fullAltPath = $_SERVER['DOCUMENT_ROOT'] . $altPath;
            
            $imagePath = file_exists($fullAltPath) ? $altPath : $defaultImage;
        }
    } else {
        $imagePath = $defaultImage;
    }

    $animal['image_path'] = $imagePath;
    
    echo json_encode($animal);
    
} catch (PDOException $e) {
    echo json_encode(['error' => 'Ошибка базы данных: ' . $e->getMessage()]);
}