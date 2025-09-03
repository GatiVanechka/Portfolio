<?php
require 'db.php';

// Проверка подписи (для ЮKassa)
$requestBody = file_get_contents('php://input');
$webhookSecret = 'ваш_секрет_для_вебхука';
$signature = $_SERVER['HTTP_YOOKASSA_SIGNATURE'];

if (!hash_equals($signature, hash('sha256', $requestBody . $webhookSecret))) {
    http_response_code(401);
    exit;
}

$data = json_decode($requestBody, true);
$paymentId = $data['object']['metadata']['payment_id'];
$status = $data['object']['status'];

// Обновляем статус в БД
if (in_array($status, ['succeeded', 'canceled'])) {
    $stmt = $conn->prepare("
        UPDATE donations 
        SET status = ?, 
            payment_data = ?
        WHERE payment_id = ?
    ");
    $stmt->execute([
        $status,
        $requestBody,
        $paymentId
    ]);
}

http_response_code(200);