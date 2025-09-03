<?php 
session_start();
include 'header.php';

// Проверка, если пользователь уже авторизован
if(isset($_SESSION['user'])) {
    header('Location: profile.php');
    exit;
}

// Обработка формы входа
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'db.php';
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Поиск пользователя в базе
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'name' => $user['name'],
            'role' => $user['role']
        ];
        header('Location: profile.php');
        exit;
    } else {
        $error = "Неверный email или пароль";
    }
}
?>

<div class="container mt-5 mb-5" style="max-width: 500px;">
    <h2 class="text-center mb-4">Вход в личный кабинет</h2>
    
    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-orange w-100">Войти</button>
    </form>
    
    <div class="mt-3 text-center">
        <p>Ещё нет аккаунта? <a href="register.php">Зарегистрируйтесь</a></p>
    </div>
</div>

<?php include 'footer.php'; ?>