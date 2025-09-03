<?php 
session_start();
require 'db.php';

// Проверка авторизации
if(!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Проверка и добавление роли, если её нет
if(!isset($_SESSION['user']['role'])) {
    $stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user']['id']]);
    $user = $stmt->fetch();
    
    if($user) {
        $_SESSION['user']['role'] = $user['role'];
    } else {
        $_SESSION['user']['role'] = 'user';
    }
}

include 'header.php';

// Если пользователь - админ, показываем только ссылку на админ-панель
if($_SESSION['user']['role'] == 'admin'):
?>

<div class="container mt-5 mb-5">
    <h2 class="text-center mb-4">Административная панель</h2>
    
    <div class="card shadow-sm">
        <div class="card-body text-center">
            <h5 class="card-title">Вы вошли как администратор</h5>
            <p class="card-text">Email: <?= htmlspecialchars($_SESSION['user']['email']) ?></p>
            
            <div class="mt-4">
                <a href="admin.php" class="btn btn-orange btn-lg">Перейти в админ-панель</a>
                <a href="logout.php" class="btn btn-orange btn-lg ms-2">Выйти</a>
            </div>
        </div>
    </div>
</div>

<?php else: ?>
<!-- Обычный интерфейс для пользователей -->
<div class="container mt-5 mb-5">
    <h2 class="text-center mb-4">Личный кабинет</h2>
    
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Добро пожаловать, <?= htmlspecialchars($_SESSION['user']['name']) ?>!</h5>
            <p class="card-text">Email: <?= htmlspecialchars($_SESSION['user']['email']) ?></p>
            
            <div class="mt-4">
                <h5>Ваши действия:</h5>
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="my_donations.php" class="text-decoration-none">Мои пожертвования</a>
                    </li>
                    <li class="list-group-item">
                        <a href="my_meetings.php" class="text-decoration-none">Мои записи на встречи</a>
                    </li>
                    <li class="list-group-item"><a href="logout.php" class="text-decoration-none text-danger">Выйти</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php include 'footer.php'; ?>