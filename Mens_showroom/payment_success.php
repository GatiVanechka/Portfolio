<?php
session_start();
require_once 'config/db.php';

$db = DB::getInstance();

if (empty($_SESSION['payment_id']) || empty($_SESSION['order_id'])) {
    header('Location: cart.php');
    exit();
}

// Получаем данные заказа из БД
$order_id = $_SESSION['order_id'];
$order_items = $db->prepare("
    SELECT product_id, size_id, quantity 
    FROM order_items 
    WHERE order_id = ?
");
$order_items->execute([$order_id]);
$items = $order_items->fetchAll();

// Обновляем количество товаров
foreach ($items as $item) {
    // Обновляем количество конкретного размера
    $db->prepare("
        UPDATE product_size 
        SET quantity = quantity - ? 
        WHERE product_id = ? AND size_id = ?
    ")->execute([$item['quantity'], $item['product_id'], $item['size_id']]);
    
    // Триггер автоматически обновит общее количество в таблице products
}

// Очищаем сессионные данные
unset($_SESSION['cart']);
unset($_SESSION['order_id']);
unset($_SESSION['payment_id']);

include 'header.php';
?>

<section class="success-section py-5">
    <div class="container text-center">
        <div class="card border-0 shadow-sm mx-auto" style="max-width: 600px;">
            <div class="card-body py-5">
                <div class="mb-4">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                </div>
                <h2 class="mb-3">Оплата прошла успешно!</h2>
                <p class="mb-4">Спасибо за ваш заказ. На ваш email отправлен чек.</p>
                <a href="catalog.php" class="btn btn-primary">Вернуться в каталог</a>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>