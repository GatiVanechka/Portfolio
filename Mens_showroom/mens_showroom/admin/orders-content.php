<?php
$db = DB::getInstance();

// Обработка изменения статуса
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];
    
    $stmt = $db->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
    $stmt->execute([$new_status, $order_id]);
    
    $_SESSION['admin_message'] = 'Статус заказа обновлен';
    header("Location: admin.php?tab=orders");
    exit();
}

// Получаем все заказы
$orders = $db->query("
    SELECT o.*, u.name as user_name, u.email as user_email 
    FROM orders o
    JOIN users u ON o.user_id = u.id
    ORDER BY o.created_at DESC
");
$orders = $orders->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bi bi-cart"></i> Управление заказами</h3>
</div>

<?php if (isset($_SESSION['admin_message'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['admin_message'] ?>
    </div>
    <?php unset($_SESSION['admin_message']); ?>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>№ заказа</th>
                <th>Пользователь</th>
                <th>Дата</th>
                <th>Сумма</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= substr($order['order_id'], 6) ?></td>
                    <td>
                        <div><?= htmlspecialchars($order['user_name']) ?></div>
                        <small class="text-muted"><?= htmlspecialchars($order['user_email']) ?></small>
                    </td>
                    <td><?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></td>
                    <td><?= number_format($order['total_amount'], 0, '', ' ') ?> ₽</td>
                    <td>
                        <form method="POST" class="d-flex">
                            <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                            <select name="status" class="form-select form-select-sm me-2">
                                <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Ожидает</option>
                                <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>В обработке</option>
                                <option value="shipped" <?= $order['status'] === 'shipped' ? 'selected' : '' ?>>Отправлен</option>
                                <option value="delivered" <?= $order['status'] === 'delivered' ? 'selected' : '' ?>>Доставлен</option>
                                <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Отменен</option>
                            </select>
                            <button type="submit" name="update_status" class="btn btn-sm btn-primary">
                                <i class="bi bi-check"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>