<?php
include 'header.php';
require_once 'config/db.php';

// Проверка авторизации
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$db = DB::getInstance();
$user_id = $_SESSION['user']['id'];

// Получаем данные пользователя из БД для гарантии актуальности
$user = $db->prepare("SELECT name, login, email FROM users WHERE id = ?");
$user->execute([$user_id]);
$user_data = $user->fetch();

if (!$user_data) {
    // Если пользователь не найден в БД (возможно удален)
    session_destroy();
    header('Location: login.php');
    exit();
}

// Обновляем данные в сессии на случай, если они изменились
$_SESSION['user']['name'] = $user_data['name'];
$_SESSION['user']['login'] = $user_data['login'];
$_SESSION['user']['email'] = $user_data['email'];

// Получаем заказы пользователя
$orders = $db->prepare("
    SELECT * FROM orders 
    WHERE user_id = ? 
    ORDER BY created_at DESC
");
$orders->execute([$user_id]);
$orders = $orders->fetchAll();
?>

<section class="profile-section py-5">
    <div class="container">
        <h2 class="mb-4">Личный кабинет</h2>
        
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="bi bi-person-circle" style="font-size: 5rem;"></i>
                        </div>
                        <h4><?= htmlspecialchars($_SESSION['user']['name'] ?? '') ?></h4>
                        <p class="text-muted"><?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?></p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">История заказов</h5>
                        
                        <?php if (empty($orders)): ?>
                            <div class="alert alert-info">
                                У вас пока нет заказов.
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>№ заказа</th>
                                            <th>Дата</th>
                                            <th>Сумма</th>
                                            <th>Статус</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orders as $order): ?>
                                            <tr>
                                                <td><?= htmlspecialchars(substr($order['order_id'], 6)) ?></td>
                                                <td><?= htmlspecialchars(date('d.m.Y H:i', strtotime($order['created_at']))) ?></td>
                                                <td><?= htmlspecialchars(number_format($order['total_amount'], 0, '', ' ')) ?> ₽</td>
                                                <td>
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
                                                    <span class="<?= $status_class ?>">
                                                        <?php 
                                                        $statuses = [
                                                            'pending' => 'Ожидает обработки',
                                                            'processing' => 'В обработке',
                                                            'shipped' => 'Отправлен',
                                                            'delivered' => 'Доставлен',
                                                            'cancelled' => 'Отменен'
                                                        ];
                                                        echo htmlspecialchars($statuses[$order['status']] ?? 'Неизвестный статус');
                                                        ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="order_details.php?id=<?= htmlspecialchars($order['order_id']) ?>" class="btn btn-sm btn-outline-primary">
                                                        Подробнее
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>