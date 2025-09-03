<?php
session_start();
require 'db.php';

// Проверка авторизации
if(!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user']['id'];

// Получаем пожертвования пользователя
$donations = $conn->prepare("
    SELECT amount, message, donation_date, anonymous 
    FROM donations 
    WHERE user_id = ? 
    ORDER BY donation_date DESC
");
$donations->execute([$userId]);
$donations = $donations->fetchAll(PDO::FETCH_ASSOC);

// Получаем общую сумму пожертвований
$totalDonated = $conn->prepare("
    SELECT SUM(amount) as total 
    FROM donations 
    WHERE user_id = ?
");
$totalDonated->execute([$userId]);
$totalDonated = $totalDonated->fetch()['total'] ?? 0;

include 'header.php';
?>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Мои пожертвования</h2>
        <a href="donate.php" class="btn btn-orange">
            <i class="bi bi-plus-circle"></i> Сделать новое пожертвование
        </a>
    </div>

    <!-- Общая статистика -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    <h3 class="text-success"><?= number_format($totalDonated, 0, '', ' ') ?> ₽</h3>
                    <p class="text-muted">Всего пожертвовано</p>
                </div>
                <div class="col-md-4 text-center">
                    <h3><?= count($donations) ?></h3>
                    <p class="text-muted">Количество пожертвований</p>
                </div>
                <div class="col-md-4 text-center">
                    <h3>
                        <?= $totalDonated > 0 ? number_format($totalDonated / count($donations), 0, '', ' ') : 0 ?> ₽
                    </h3>
                    <p class="text-muted">Средний чек</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Список пожертвований -->
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">История пожертвований</h5>
        </div>
        <div class="card-body p-0">
            <?php if(empty($donations)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-emoji-frown" style="font-size: 3rem;"></i>
                    <h4 class="mt-3">У вас пока нет пожертвований</h4>
                    <p class="text-muted">Сделайте своё первое пожертвование прямо сейчас</p>
                    <a href="donate.php" class="btn btn-orange mt-3">Пожертвовать</a>
                </div>
            <?php else: ?>
                <div class="list-group list-group-flush">
                    <?php foreach($donations as $donation): ?>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <div>
                                    <h6 class="mb-1">
                                        <?= $donation['anonymous'] ? 'Анонимное пожертвование' : 'Пожертвование' ?>
                                    </h6>
                                    <?php if($donation['message']): ?>
                                        <p class="mb-1">"<?= htmlspecialchars($donation['message']) ?>"</p>
                                    <?php endif; ?>
                                </div>
                                <div class="text-end">
                                    <span class="text-success fw-bold d-block">
                                        +<?= number_format($donation['amount'], 0, '', ' ') ?> ₽
                                    </span>
                                    <small class="text-muted">
                                        <?= date('d.m.Y H:i', strtotime($donation['donation_date'])) ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>