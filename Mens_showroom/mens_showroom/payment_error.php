<?php
session_start();
include 'header.php';
?>

<section class="error-section py-5">
    <div class="container text-center">
        <div class="card border-0 shadow-sm mx-auto" style="max-width: 600px;">
            <div class="card-body py-5">
                <div class="mb-4">
                    <i class="bi bi-x-circle-fill text-danger" style="font-size: 5rem;"></i>
                </div>
                <h2 class="mb-3">Ошибка оплаты</h2>
                <p class="mb-4"><?= $_SESSION['payment_error'] ?? 'Произошла ошибка при обработке платежа' ?></p>
                <a href="cart.php" class="btn btn-primary">Вернуться в корзину</a>
            </div>
        </div>
    </div>
</section>

<?php 
unset($_SESSION['payment_error']);
include 'footer.php'; 
?>