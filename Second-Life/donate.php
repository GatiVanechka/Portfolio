<?php
session_start();
require 'db.php';
include 'header.php';

// Инициализация переменных
$error = null;
$userId = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;

// Конфигурация ЮKassa
define('YKASSA_SHOP_ID', '1086288');
define('YKASSA_SECRET_KEY', 'test_zxf7SmztASo8p6zCZgDOuJO52PDynHuF6AX_1Tglp0Y');
define('PAYMENT_SUCCESS_URL', 'http://second-life/thank_you.php');
define('PAYMENT_FAIL_URL', 'https://ваш-сайт.ru/donate.php?error=payment');

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = (float)$_POST['amount'];
    $anonymous = isset($_POST['anonymous']) ? 1 : 0;
    $message = trim($_POST['message']);

    // Валидация суммы
    if ($amount < 100) {
        $error = "Минимальная сумма пожертвования - 100 рублей";
    } else {
        try {
            // Генерируем уникальный ID платежа
            $paymentId = uniqid('donate_', true);
            
            // Сохраняем в БД до оплаты
            $stmt = $conn->prepare("
                INSERT INTO donations (user_id, amount, anonymous, message, payment_id, status)
                VALUES (?, ?, ?, ?, ?, 'pending')
            ");
            $stmt->execute([
                $userId,
                $amount,
                $anonymous,
                $message,
                $paymentId
            ]);

            // Параметры для ЮKassa
            $paymentData = [
                'amount' => [
                    'value' => $amount,
                    'currency' => 'RUB',
                ],
                'confirmation' => [
                    'type' => 'redirect',
                    'return_url' => PAYMENT_SUCCESS_URL,
                ],
                'capture' => true,
                'description' => 'Пожертвование для приюта животных',
                'metadata' => [
                    'payment_id' => $paymentId,
                    'donation_id' => $conn->lastInsertId()
                ],
            ];

            // Отправка запроса в ЮKassa
            $ch = curl_init('https://api.yookassa.ru/v3/payments');
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Basic ' . base64_encode(YKASSA_SHOP_ID . ':' . YKASSA_SECRET_KEY),
                'Idempotence-Key: ' . $paymentId,
                'Content-Type: application/json'
            ]);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($paymentData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode == 200) {
                $responseData = json_decode($response, true);
                header('Location: ' . $responseData['confirmation']['confirmation_url']);
                exit;
            } else {
                throw new Exception('Ошибка при создании платежа');
            }
        } catch (Exception $e) {
            $error = "Ошибка при обработке платежа: " . $e->getMessage();
        }
    }
}
?>

<div class="container mt-5 mb-5" style="max-width: 600px;">
    <h2 class="text-center mb-4">Форма пожертвования</h2>
    
    <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success">Спасибо за ваше пожертвование!</div>
    <?php endif; ?>
    
    <?php if(isset($_GET['error']) && $_GET['error'] == 'payment'): ?>
        <div class="alert alert-danger">Произошла ошибка при обработке платежа</div>
    <?php elseif(isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" id="donationForm">
                <div class="mb-3">
                    <label for="amount" class="form-label">Сумма пожертвования (₽)</label>
                    <input type="number" class="form-control" id="amount" name="amount" 
                           min="100" step="100" value="500" required>
                    <div class="form-text">Минимальная сумма - 100 рублей</div>
                </div>
                
                <div class="mb-3">
                    <label for="message" class="form-label">Ваше сообщение (необязательно)</label>
                    <textarea class="form-control" id="message" name="message" rows="2"
                              placeholder="Напишите пожелание или комментарий"></textarea>
                </div>
                
                <?php if($userId): ?>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="anonymous" name="anonymous">
                        <label class="form-check-label" for="anonymous">
                            Сделать пожертвование анонимно
                        </label>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        Пожертвование будет отображено как анонимное. 
                        <a href="register.php">Зарегистрируйтесь</a>, чтобы вести историю своих пожертвований.
                    </div>
                <?php endif; ?>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="bi bi-heart-fill"></i> Подтвердить пожертвование
                    </button>
                </div>
            </form>
            
            <div class="mt-4">
                <h5>Способы оплаты:</h5>
                <div class="d-flex justify-content-between flex-wrap">
                    <img src="/images/icons/visa.png" alt="Visa" class="payment-method-img">
                    <img src="/images/icons/mcard.png" alt="Mastercard" class="payment-method-img">
                    <img src="/images/icons/mir.png" alt="МИР" class="payment-method-img">
                    <img src="/images/icons/sbp.png" alt="СБП" class="payment-method-img">
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .payment-method-img {
        height: 40px;
        margin: 5px;
    }
</style>

<script>
document.getElementById('donationForm').addEventListener('submit', function(e) {
    const amount = parseFloat(document.getElementById('amount').value);
    if (amount < 100) {
        e.preventDefault();
        alert('Минимальная сумма пожертвования - 100 рублей');
    }
});
</script>

<?php include 'footer.php'; ?>