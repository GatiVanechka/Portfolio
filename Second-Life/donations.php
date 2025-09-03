<?php
session_start();
require 'db.php';
include 'header.php';

// Получаем топ 10 доноров
$topDonors = $conn->query("
    SELECT u.name, d.anonymous, SUM(d.amount) as total 
    FROM donations d
    LEFT JOIN users u ON d.user_id = u.id
    GROUP BY d.user_id, d.anonymous
    ORDER BY total DESC
    LIMIT 10
")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5 mb-5">
    <h2 class="text-center mb-4">Пожертвования для приюта</h2>
    
    <div class="row">
        <!-- Блок с топом доноров -->
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-orange text-white">
                    <h5 class="mb-0 text-white">Топ благотворителей</h5>
                </div>
                <div class="card-body">
                    <ol class="list-group list-group-numbered">
                        <?php foreach($topDonors as $donor): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">
                                        <?= $donor['anonymous'] ? 'Аноним' : htmlspecialchars($donor['name']) ?>
                                    </div>
                                </div>
                                <span class="badge rounded-pill">
                                    <?= number_format($donor['total'], 0, '', ' ') ?> ₽
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </div>
        </div>
        
        <!-- Блок с формой пожертвования -->
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header bg-orange text-white">
                    <h5 class="mb-0 text-white">Сделать пожертвование</h5>
                </div>
                <div class="card-body">
                    <p>Ваше пожертвование поможет нам содержать животных и улучшать условия приюта.</p>
                    
                    <div class="d-grid gap-2 mb-4">
                        <?php if(isset($_SESSION['user'])): ?>
                            <a href="donate.php" class="btn btn-orange btn-lg">
                                <i class="bi bi-heart-fill"></i> Сделать пожертвование
                            </a>
                        <?php else: ?>
                            <button class="btn btn-orange btn-lg" onclick="showAuthAlert()">
                                <i class="bi bi-heart-fill"></i> Сделать пожертвование
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Последние пожертвования -->
            <div class="card mt-4">
                <div class="card-header bg-orange text-white">
                    <h5 class="mb-0 text-white">Последние пожертвования</h5>
                </div>
                <div class="card-body">
                    <?php
                    $recentDonations = $conn->query("
                        SELECT u.name, d.amount, d.anonymous, d.donation_date, d.message
                        FROM donations d
                        LEFT JOIN users u ON d.user_id = u.id
                        ORDER BY d.donation_date DESC
                        LIMIT 5
                    ")->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    
                    <div class="list-group">
                        <?php foreach($recentDonations as $donation): ?>
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">
                                        <?= $donation['anonymous'] ? 'Аноним' : htmlspecialchars($donation['name']) ?>
                                    </h6>
                                    <small class="text-success fw-bold">
                                        +<?= number_format($donation['amount'], 0, '', ' ') ?> ₽
                                    </small>
                                </div>
                                <?php if($donation['message']): ?>
                                    <p class="mb-1">"<?= htmlspecialchars($donation['message']) ?>"</p>
                                <?php endif; ?>
                                <small class="text-muted">
                                    <?= date('d.m.Y H:i', strtotime($donation['donation_date'])) ?>
                                </small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showAuthAlert() {
    // Можно использовать alert, но лучше модальное окно
    alert('Пожалуйста, зарегистрируйтесь или войдите, чтобы сделать пожертвование');
    
    // Или перенаправление на страницу регистрации
    // window.location.href = 'register.php';
    
    // Или открытие модального окна Bootstrap
    // var authModal = new bootstrap.Modal(document.getElementById('authModal'));
    // authModal.show();
}
</script>

<?php include 'footer.php'; ?>