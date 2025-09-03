<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEN'S SHOWROOM</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Наши стили -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,700;1,400;1,700&display=swap&subset=cyrillic-ext" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Favicon (стандартный вариант) -->
<link rel="icon" href="/favicon.ico" type="image/x-icon">

<!-- Альтернативные варианты для разных устройств -->
<link rel="shortcut icon" href="images/favicon/favicon.ico" type="image/favicon/x-icon">
<link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
<link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png">
<link rel="manifest" href="/site.webmanifest">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <img src="images/logo/logo.png" alt="Логотип">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarContent">
    <ul class="navbar-nav me-auto">  <!-- Изменено с centered-menu на me-auto -->
        <li class="nav-item">
            <a class="nav-link main-header-nav" href="delivery.php">Доставка и оплата</a>
        </li>
        <li class="nav-item mx-4">
            <a class="nav-link main-header-nav" href="catalog.php">Каталог</a>
        </li>
    </ul>
    <div class="auth-buttons d-flex align-items-center flex-nowrap">  <!-- Добавлен flex-nowrap -->
        <?php if (isset($_SESSION['user'])): ?>
            <!-- Для авторизованных пользователей -->
            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <a href="admin.php" class="btn btn-outline-danger me-2">
                    <i class="bi bi-shield-lock"></i> Админка
                </a>
            <?php endif; ?>
            
            <a href="cart.php" class="btn btn-outline-primary me-2">
                <i class="bi bi-cart"></i> Корзина
            </a>
            
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle"></i> <?= htmlspecialchars($_SESSION['user']['name']) ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="profile.php">Профиль</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="logout.php">Выйти</a></li>
                </ul>
            </div>
            
        <?php else: ?>
            <!-- Для гостей -->
            <a href="login.php" class="btn btn-outline-primary me-2">Вход</a>
            <a href="register.php" class="btn btn-primary">Регистрация</a>
        <?php endif; ?>
    </div>
</div>
            </div>
        </nav>
    </header>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>