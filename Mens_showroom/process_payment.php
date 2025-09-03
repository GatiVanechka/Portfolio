<?php
session_start();
require_once 'config/db.php';

$db = DB::getInstance();

// Проверка данных
if (empty($_SESSION['order']) || empty($_POST['email'])) {
    header('Location: cart.php');
    exit();
}

// Проверка авторизации пользователя
if (!isset($_SESSION['user']['id'])) {
    header('Location: login.php');
    exit();
}

// Ваши данные ЮKassa
$shop_id = '1086288';
$secret_key = 'test_zxf7SmztASo8p6zCZgDOuJO52PDynHuF6AX_1Tglp0Y';

// Данные для платежа
$order_id = $_SESSION['order']['id'];
$amount = $_SESSION['order']['amount'];
$email = $_POST['email'];
$user_id = $_SESSION['user']['id'];

// Формируем данные для запроса
$data = [
    'amount' => [
        'value' => number_format($amount, 2, '.', ''),
        'currency' => 'RUB'
    ],
    'confirmation' => [
        'type' => 'redirect',
        'return_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/mens_showroom/payment_success.php'
    ],
    'capture' => true,
    'description' => 'Заказ №' . $order_id,
    'metadata' => [
        'order_id' => $order_id,
        'email' => $email,
        'user_id' => $user_id
    ],
    'receipt' => [
        'customer' => [
            'email' => $email
        ],
        'items' => []
    ]
];

// Добавляем товары в чек
foreach ($_SESSION['order']['items'] as $product_id => $sizes) {
    $product = $db->prepare("SELECT product_name, price FROM products WHERE product_id = ?");
    $product->execute([$product_id]);
    $product = $product->fetch();
    
    foreach ($sizes as $size_id => $item) {
        $size = $db->prepare("SELECT size_name FROM sizes WHERE size_id = ?");
        $size->execute([$size_id]);
        $size_name = $size->fetchColumn();
        
        $data['receipt']['items'][] = [
            'description' => $product['product_name'] . ' (Размер: ' . $size_name . ')',
            'quantity' => $item['quantity'],
            'amount' => [
                'value' => number_format($product['price'], 2, '.', ''),
                'currency' => 'RUB'
            ],
            'vat_code' => '1',
            'payment_mode' => 'full_payment',
            'payment_subject' => 'commodity'
        ];
    }
}

// Отправляем запрос в ЮKassa
$ch = curl_init('https://api.yookassa.ru/v3/payments');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Idempotence-Key: ' . uniqid(),
    'Authorization: Basic ' . base64_encode($shop_id . ':' . $secret_key)
]);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Обработка ответа
if ($http_code === 200) {
    $response_data = json_decode($response, true);
    $_SESSION['payment_id'] = $response_data['id'];
    
    // Сохраняем заказ в БД
    try {
        $db->beginTransaction();
        
        // Сохраняем основной заказ
        $order_stmt = $db->prepare("
            INSERT INTO orders (order_id, user_id, total_amount, payment_id, email, status)
            VALUES (?, ?, ?, ?, ?, 'pending')
        ");
        $order_stmt->execute([
            $order_id,
            $user_id,
            $amount,
            $response_data['id'],
            $email
        ]);
        
        // Сохраняем товары в заказе
        $item_stmt = $db->prepare("
            INSERT INTO order_items (order_id, product_id, size_id, quantity, price)
            VALUES (?, ?, ?, ?, ?)
        ");
        
        foreach ($_SESSION['order']['items'] as $product_id => $sizes) {
            $product = $db->prepare("SELECT price FROM products WHERE product_id = ?");
            $product->execute([$product_id]);
            $product_price = $product->fetchColumn();
            
            foreach ($sizes as $size_id => $item) {
                $item_stmt->execute([
                    $order_id,
                    $product_id,
                    $size_id,
                    $item['quantity'],
                    $product_price
                ]);
                
                // Уменьшаем количество товара на складе
                $update_stmt = $db->prepare("
                    UPDATE product_size 
                    SET quantity = quantity - ? 
                    WHERE product_id = ? AND size_id = ?
                ");
                $update_stmt->execute([
                    $item['quantity'],
                    $product_id,
                    $size_id
                ]);
            }
        }
        
        $db->commit();
    } catch (Exception $e) {
        $db->rollBack();
        // Логируем ошибку
        error_log("Order save error: " . $e->getMessage());
        $_SESSION['payment_error'] = 'Ошибка при сохранении заказа';
        header('Location: payment_error.php');
        exit();
    }
    
    // Перенаправляем на страницу оплаты ЮKassa
    header('Location: ' . $response_data['confirmation']['confirmation_url']);
    exit();
} else {
    // Ошибка оплаты
    $_SESSION['payment_error'] = 'Ошибка при создании платежа: ' . $response;
    header('Location: payment_error.php');
    exit();
}