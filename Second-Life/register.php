<?php 
session_start();
include 'header.php';

// Проверка, если пользователь уже авторизован
if(isset($_SESSION['user'])) {
    header('Location: profile.php');
    exit;
}

// Обработка формы регистрации
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'db.php';
    
    // Очистка и валидация данных
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    $errors = [];
    
    // Валидация имени (2-50 символов, только буквы и пробелы)
    if(empty($name)) {
        $errors[] = "Имя обязательно для заполнения";
    } elseif(!preg_match('/^[a-zA-Zа-яА-ЯёЁ\s]{2,50}$/u', $name)) {
        $errors[] = "Имя должно содержать от 2 до 50 символов (только буквы и пробелы)";
    }
    
    // Валидация email
    if(empty($email)) {
        $errors[] = "Email обязателен для заполнения";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Некорректный формат email";
    } elseif(strlen($email) > 255) {
        $errors[] = "Email слишком длинный (максимум 255 символов)";
    }
    
    // Валидация пароля (минимум 8 символов, хотя бы 1 цифра и 1 буква)
    if(empty($password)) {
        $errors[] = "Пароль обязателен для заполнения";
    } elseif(strlen($password) < 8) {
        $errors[] = "Пароль должен содержать минимум 8 символов";
    } elseif(!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $errors[] = "Пароль должен содержать хотя бы одну букву и одну цифру";
    }
    
    // Если ошибок нет, продолжаем регистрацию
    if(empty($errors)) {
        // Проверка, существует ли email
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if($stmt->rowCount() > 0) {
            $errors[] = "Пользователь с таким email уже существует";
        } else {
            // Хеширование пароля
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            // Создание нового пользователя с защитой от SQL-инъекций
            try {
                $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')");
                $stmt->execute([$name, $email, $password_hash]);
                
                // Перенаправление с флагом успешной регистрации
                header('Location: login.php?registered=1');
                exit;
            } catch(PDOException $e) {
                $errors[] = "Ошибка при регистрации: " . $e->getMessage();
            }
        }
    }
}
?>

<div class="container mt-5 mb-5" style="max-width: 500px;">
    <h2 class="text-center mb-4">Регистрация</h2>
    
    <?php if(!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach($errors as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <?php if(isset($_GET['registered'])): ?>
        <div class="alert alert-success">Регистрация прошла успешно! Теперь вы можете войти.</div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Имя</label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" 
                   required minlength="2" maxlength="50" pattern="[a-zA-Zа-яА-ЯёЁ\s]+">
            <div class="form-text">От 2 до 50 символов (только буквы и пробелы)</div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" 
                   value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" 
                   required maxlength="255">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" class="form-control" id="password" name="password" 
                   required minlength="8">
            <div class="form-text">Минимум 8 символов, должна быть хотя бы одна буква и одна цифра</div>
        </div>
        <button type="submit" class="btn btn-orange w-100">Зарегистрироваться</button>
    </form>
    
    <div class="mt-3 text-center">
        <p>Уже есть аккаунт? <a href="login.php">Войдите</a></p>
    </div>
</div>

<?php include 'footer.php'; ?>