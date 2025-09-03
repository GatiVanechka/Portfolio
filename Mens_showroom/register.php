<?php
require_once 'config/db.php';
include 'header.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Очистка и валидация данных
    $name = trim($_POST['name'] ?? '');
    $login = trim($_POST['login'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Валидация имени (только русские буквы и пробелы)
    if (!preg_match('/^[а-яёА-ЯЁ\s]+$/u', $name)) {
        $errors['name'] = 'Имя должно содержать только русские буквы';
    } elseif (mb_strlen($name) < 2) {
        $errors['name'] = 'Имя должно быть не менее 2 символов';
    }

    // Валидация логина (латинские буквы, цифры, подчеркивания)
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $login)) {
        $errors['login'] = 'Логин может содержать только латинские буквы, цифры и подчеркивания';
    } elseif (strlen($login) < 4) {
        $errors['login'] = 'Логин должен быть не менее 4 символов';
    }

    // Валидация email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Введите корректный email';
    }

    // Валидация пароля
    if (strlen($password) < 6) {
        $errors['password'] = 'Пароль должен быть не менее 6 символов';
    }

    // Если ошибок нет - регистрируем пользователя
    if (empty($errors)) {
        try {
            $db = DB::getInstance();
            
            // Проверка на существующий логин/email
            $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE login = ? OR email = ?");
            $stmt->execute([$login, $email]);
            
            if ($stmt->fetchColumn() > 0) {
                $errors['general'] = 'Пользователь с таким логином или email уже существует';
            } else {
                // Хеширование пароля
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                
                // Подготовленный запрос для защиты от SQL-инъекций
                $stmt = $db->prepare("INSERT INTO users (name, login, email, password) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $login, $email, $passwordHash]);
                
                // Редирект с успешным статусом
                header('Location: login.php?registered=1');
                exit();
            }
        } catch (PDOException $e) {
            error_log("Registration error: " . $e->getMessage());
            $errors['general'] = 'Произошла ошибка при регистрации. Пожалуйста, попробуйте позже.';
        }
    }
}
?>

<div class="container mt-5" style="max-width: 500px;">
    <h2 class="mb-4">Регистрация</h2>
    
    <?php if (!empty($errors['general'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errors['general']) ?></div>
    <?php endif; ?>
    
    <form method="POST" novalidate>
        <div class="mb-3">
            <label for="name" class="form-label">Имя</label>
            <input type="text" name="name" id="name" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" 
                   value="<?= htmlspecialchars($name ?? '') ?>" required>
            <?php if (isset($errors['name'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['name']) ?></div>
            <?php endif; ?>
        </div>
        
        <div class="mb-3">
            <label for="login" class="form-label">Логин</label>
            <input type="text" name="login" id="login" class="form-control <?= isset($errors['login']) ? 'is-invalid' : '' ?>" 
                   value="<?= htmlspecialchars($login ?? '') ?>" required>
            <?php if (isset($errors['login'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['login']) ?></div>
            <?php endif; ?>
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                   value="<?= htmlspecialchars($email ?? '') ?>" required>
            <?php if (isset($errors['email'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['email']) ?></div>
            <?php endif; ?>
        </div>
        
        <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" name="password" id="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                   minlength="6" required>
            <?php if (isset($errors['password'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['password']) ?></div>
            <?php endif; ?>
            <small class="text-muted">Минимум 6 символов</small>
        </div>
        
        <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
    </form>
    
    <div class="mt-3 text-center mb-5">
        Уже есть аккаунт? <a href="login.php">Войти</a>
    </div>
</div>

<?php include 'footer.php'; ?>