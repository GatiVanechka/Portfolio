<?php
include 'header.php';
require_once 'config/db.php';

// Инициализация подключения к БД
$db = DB::getInstance(); // Добавьте эту строку

// Проверка корзины
if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

// Подсчет общей суммы
$total_amount = 0;
foreach ($_SESSION['cart'] as $product_id => $sizes) {
    $product = $db->prepare("SELECT price FROM products WHERE product_id = ?");
    $product->execute([$product_id]);
    $product = $product->fetch();
    
    foreach ($sizes as $item) {
        $total_amount += $product['price'] * $item['quantity'];
    }
}

// Генерация уникального ID заказа
$order_id = uniqid('order_');

// Сохранение заказа в сессии
$_SESSION['order'] = [
    'id' => $order_id,
    'amount' => $total_amount,
    'items' => $_SESSION['cart']
];
?>

<section class="checkout-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <h2 class="mb-4">Оформление заказа</h2>
                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Ваш заказ</h5>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($_SESSION['cart'] as $product_id => $sizes): 
                                $product = $db->prepare("SELECT product_name, price FROM products WHERE product_id = ?");
                                $product->execute([$product_id]);
                                $product = $product->fetch();
                            ?>
                                <?php foreach ($sizes as $size_id => $item): 
                                    $size = $db->prepare("SELECT size_name FROM sizes WHERE size_id = ?");
                                    $size->execute([$size_id]);
                                    $size_name = $size->fetchColumn();
                                ?>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>
                                            <?= htmlspecialchars($product['product_name']) ?> 
                                            (Размер: <?= htmlspecialchars($size_name) ?>, 
                                            Количество: <?= $item['quantity'] ?>)
                                        </span>
                                        <span><?= number_format($product['price'] * $item['quantity'], 0, '', ' ') ?> ₽</span>
                                    </li>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Итого к оплате</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Сумма заказа:</span>
                            <span><?= number_format($total_amount, 0, '', ' ') ?> ₽</span>
                        </div>
                        
                        <form id="payment-form" method="POST" action="process_payment.php">
                            <input type="hidden" name="order_id" value="<?= $order_id ?>">
                            <input type="hidden" name="amount" value="<?= $total_amount ?>">
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email для получения чека</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 py-3">
                                Перейти к оплате
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>