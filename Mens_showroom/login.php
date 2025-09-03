<?php
session_start();
require_once 'config/db.php';
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $password = $_POST['password'];
    
    try {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT * FROM users WHERE login = ? OR email = ?");
        $stmt->execute([$login, $login]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role']
            ];
            header('Location: index.php');
            exit();
        } else {
            $error = "Неверный логин или пароль";
        }
    } catch (PDOException $e) {
        $error = "Ошибка входа: " . $e->getMessage();
    }
}
?>

<div class="container mt-5" style="max-width: 500px;">
    <h2 class="mb-4">Вход</h2>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Регистрация успешна! Войдите в систему.</div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Логин или Email</label>
            <input type="text" name="login" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Пароль</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Войти</button>
    </form>
    <div class="mt-3 text-center mb-5">
        Нет аккаунта? <a href="register.php">Зарегистрироваться</a>
    </div>
</div>

<?php include 'footer.php'; ?>