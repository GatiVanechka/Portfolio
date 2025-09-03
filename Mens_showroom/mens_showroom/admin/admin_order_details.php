<?php
include '../header.php';
require_once '../config/db.php';

// Проверка прав администратора
if ($_SESSION['user']['role'] !== 'admin') {
    header('Location: /');
    exit();
}

if (empty($_GET['id'])) {
    header('Location: admin.php?tab=orders');
    exit();
}

$db = DB::getInstance();
$order_id = $_GET['id'];

// Получаем информацию о заказе
$order = $db->prepare("
    SELECT o.*, u.name as user_name, u.email as user_email, u.login as user_login 
    FROM orders o
    JOIN users u ON o.user_id = u.id
    WHERE o.order_id = ?
");
$order->execute([$order_id]);
$order = $order->fetch();

if (!$order) {
    header('Location: admin.php?tab=orders');
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

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <a href="admin.php?tab=orders" class="btn btn-outline-secondary btn-sm me-2">
                <i class="bi bi-arrow-left"></i>
            </a>
            Заказ #<?= substr($order['order_id'], 6) ?>
        </h2>
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
                    
                    <form method="POST" action="orders-content.php">
                        <div class="mb-3">
                            <label class="form-label">Статус заказа</label>
                            <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                            <select name="status" class="form-select">
                                <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Ожидает обработки</option>
                                <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>В обработке</option>
                                <option value="shipped" <?= $order['status'] === 'shipped' ? 'selected' : '' ?>>Отправлен</option>
                                <option value="delivered" <?= $order['status'] === 'delivered' ? 'selected' : '' ?>>Доставлен</option>
                                <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Отменен</option>
                            </select>
                        </div>
                        
                        <button type="submit" name="update_status" class="btn btn-primary w-100 mb-3">
                            Обновить статус
                        </button>
                    </form>
                    
                    <div class="mb-3">
                        <h6>Покупатель</h6>
                        <p>
                            <?= htmlspecialchars($order['user_name']) ?><br>
                            Логин: <?= htmlspecialchars($order['user_login']) ?><br>
                            Email: <?= htmlspecialchars($order['user_email']) ?>
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

<?php include '../footer.php'; ?>