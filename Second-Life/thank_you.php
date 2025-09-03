<?php
session_start();
require 'db.php';
include 'header.php';

// Получаем информацию о последнем пожертвовании (если пользователь авторизован)
$lastDonation = null;
if (isset($_SESSION['user']['id'])) {
    $stmt = $conn->prepare("
        SELECT amount, donation_date 
        FROM donations 
        WHERE user_id = ? 
        ORDER BY id DESC 
        LIMIT 1
    ");
    $stmt->execute([$_SESSION['user']['id']]);
    $lastDonation = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<div class="container text-center my-5 py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <h1 class="display-4 fw-bold mb-4">Спасибо!</h1>
            
            <?php if ($lastDonation): ?>
                <p class="lead mb-4">
                    Ваше пожертвование в размере <span class="fw-bold"><?= number_format($lastDonation['amount'], 0, '', ' ') ?> ₽</span><br>
                    поможет нам заботиться о животных!
                </p>
                <?php if (!empty($lastDonation['donation_date'])): ?>
                    <p class="text-muted">
                        <small>Дата пожертвования: <?= date('d.m.Y H:i', strtotime($lastDonation['donation_date'])) ?></small>
                    </p>
                <?php endif; ?>
            <?php else: ?>
                <p class="lead mb-4">
                    Ваше пожертвование поможет нам заботиться о животных!<br>
                    Каждая копейка идет на благое дело.
                </p>
            <?php endif; ?>
            
            <div class="d-flex justify-content-center gap-3 mt-5">
                <a href="donations.php" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left"></i> Назад к пожертвованиям
                </a>
                <a href="index.php" class="btn btn-orange">
                    <i class="bi bi-house"></i> На главную
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    /* Анимация благодарности */
    .thank-you-emoji {
        font-size: 5rem;
        position: relative;
        height: 120px;
        margin-bottom: 2rem;
    }
    
    .emoji-face {
        position: absolute;
        animation: bounce 2s infinite;
    }
    
    .emoji-hands {
        position: absolute;
        animation: pulse 1.5s infinite;
        opacity: 0;
    }
    
    .btn-orange {
        background-color: #ff6b35;
        color: white;
        border: none;
    }
    
    .btn-orange:hover {
        background-color: #e05a2b;
        color: white;
    }
</style>

<?php include 'footer.php'; ?>