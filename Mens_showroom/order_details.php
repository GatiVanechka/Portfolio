<?php
include 'header.php';
require_once 'config/db.php';

// Проверка авторизации
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if (empty($_GET['id'])) {
    header('Location: profile.php');
    exit();
}

$db = DB::getInstance();
$order_id = $_GET['id'];
$user_id = $_SESSION['user']['id'];

// Получаем информацию о заказе
$order = $db->prepare("
    SELECT * FROM orders 
    WHERE order_id = ? AND user_id = ?
");
$order->execute([$order_id, $user_id]);
$order = $order->fetch();

if (!$order) {
    header('Location: profile.php');
    exit();
}

// Получаем товары в заказе
$items = $db->prepare("
    SELECT oi.*, p.product_name, p.image_path, s.size_name 
    FROM order_items oi
    JOIN products p ON oi.product_id = p.product_id
    JOIN sizes s ON oi.size_id = s.size_id
    WHERE oi.order_id = ?
");
$items->execute([$order_id]);
$items = $items->fetchAll();
?>

<section class="order-section py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Заказ #<?= substr($order['order_id'], 6) ?></h2>
            <a href="profile.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Назад
            </a>
        </div>
        
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Товары в заказе</h5>
                        
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Товар</th>
                                        <th>Размер</th>
                                        <th>Количество</th>
                                        <th>Цена</th>
                                        <th>Сумма</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if ($item['image_path']): ?>
                                                        <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" class="me-3" style="width: 50px;">
                                                    <?php endif; ?>
                                                    <?= htmlspecialchars($item['product_name']) ?>
                                                </div>
                                            </td>
                                            <td><?= htmlspecialchars($item['size_name']) ?></td>
                                            <td><?= $item['quantity'] ?></td>
                                            <td><?= number_format($item['price'], 0, '', ' ') ?> ₽</td>
                                            <td><?= number_format($item['price'] * $item['quantity'], 0, '', ' ') ?> ₽</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-end">Итого:</th>
                                        <th><?= number_format($order['total_amount'], 0, '', ' ') ?> ₽</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Информация о заказе</h5>
                        
                        <div class="mb-3">
                            <h6>Статус заказа</h6>
                            <?php 
                            $status_class = '';
                            switch ($order['status']) {
                                case 'processing': $status_class = 'text-primary'; break;
                                case 'shipped': $status_class = 'text-warning'; break;
                                case 'delivered': $status_class = 'text-success'; break;
                                case 'cancelled': $status_class = 'text-danger'; break;
                                default: $status_class = 'text-secondary';
                            }
                            ?>
                            <p class="<?= $status_class ?>">
                                <strong>
                                    <?php 
                                    $statuses = [
                                        'pending' => 'Ожидает обработки',
                                        'processing' => 'В обработке',
                                        'shipped' => 'Отправлен',
                                        'delivered' => 'Доставлен',
                                        'cancelled' => 'Отменен'
                                    ];
                                    echo $statuses[$order['status']];
                                    ?>
                                </strong>
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <h6>Дата заказа</h6>
                            <p><?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></p>
                        </div>
                        
                        <div class="mb-3">
                            <h6>Email для уведомлений</h6>
                            <p><?= htmlspecialchars($order['email']) ?></p>
                        </div>
                        
                        <?php if ($order['payment_id']): ?>
                            <div class="mb-3">
                                <h6>ID платежа</h6>
                                <p><?= htmlspecialchars($order['payment_id']) ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>