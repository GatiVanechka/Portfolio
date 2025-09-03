<?php
session_start();
// Определяем текущую страницу
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вторая жизнь</title>
    <!-- Подключаем Nunito с поддержкой кириллицы -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Остальные стили как были -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Добавляем только шрифт в стили -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            margin: 0; /* Убираем стандартные отступы */
            padding: 0; /* Убираем стандартные отступы */
        }
        .nav-item .nav-link.active {
            border-bottom: 2px solid #000;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <!-- Навигация (оставляем как было) -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <!-- Логотип -->
            <a class="navbar-brand" href="index.php">
                <img src="images/logo.png" alt="Логотип">
            </a>

            <!-- Центр: навигация -->
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page == 'index.php') ? 'active' : '' ?>" href="index.php">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page == 'donations.php') ? 'active' : '' ?>" href="donations.php">Пожертвование</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page == 'meetings.php') ? 'active' : '' ?>" href="meetings.php">Записаться на встречу</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page == 'news.php') ? 'active' : '' ?>" href="news.php">Новости</a>
                    </li>
                </ul>
            </div>

            <!-- Вход/Личный кабинет (оставляем как было) -->
            <?php if(isset($_SESSION['user'])): ?>
                <a class="navbar-brand" href="profile.php">
                    <img src="images/use.png" alt="Личный кабинет">
                </a>
            <?php else: ?>
                <a class="navbar-brand" href="login.php">
                    <img src="images/use.png" alt="Вход">
                </a>
            <?php endif; ?>
        </div>
    </nav>

      <div style="background-color: rgb(218,118,67); height:20px" class="text-center text-white py-1 mb-1 shadow p-3">
  </div>
  
    <!-- Скрипты оставляем как были -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>