<?php
session_start();
require 'db.php';

// Проверка прав администратора
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

include 'header.php';
logAction($conn, 'ADMIN_ACCESS', 'Accessed admin panel');
?>

<div class="container mt-4">
    <h2 class="mb-4"><i class="bi bi-shield-lock"></i> Админ-панель</h2>
    
    <div class="row">
        <!-- Меню админки -->
        <div class="col-md-3">
            <div class="list-group">
                <a href="#stats" class="list-group-item list-group-item-action bg-orange text-white active" data-bs-toggle="tab">
                    <i class="bi bi-graph-up"></i> Статистика
                </a>
                <a href="#animals" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="bi bi-paw"></i> Управление животными
                </a>
                <a href="#meetings" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="bi bi-calendar-check"></i> Заявки на встречи
                </a>
                <a href="#adopted" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="bi bi-house-heart"></i> Забранные животные
                </a>
                <a href="#news" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="bi bi-newspaper"></i> Управление новостями
                </a>
                <a href="#donations" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="bi bi-cash-stack"></i> Пожертвования
                </a>
                <a href="#users" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="bi bi-people"></i> Пользователи
                </a>
                <a href="#logs" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="bi bi-journal-text"></i> Логи действий
                </a>
                <a href="#reports" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="bi bi-file-earmark-bar-graph"></i> Финансовые отчёты
                </a>
                <a href="#docs" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="bi bi-file-earmark-text"></i> Документация
                </a>
            </div>
        </div>
        
        <!-- Контент админки -->
        <div class="col-md-9">
            <div class="tab-content">
                <!-- Статистика -->
                <div class="tab-pane fade show active" id="stats">
                    <?php include 'admin/stats.php'; ?>
                </div>
                
                <!-- Животные -->
                <div class="tab-pane fade" id="animals">
                    <?php include 'admin/animals.php'; ?>
                </div>

                <div class="tab-pane fade" id="meetings">
                    <?php include 'admin/meetings.php'; ?>
                </div>
                
                <div class="tab-pane fade" id="adopted">
                    <?php include 'admin/adopted.php'; ?>
                </div>

                <!-- Новости -->
                <div class="tab-pane fade" id="news">
                    <?php include 'admin/news.php'; ?>
                </div>
                
                <!-- Пожертвования -->
                <div class="tab-pane fade" id="donations">
                    <?php include 'admin/donations.php'; ?>
                </div>
                
                <!-- Пользователи -->
                <div class="tab-pane fade" id="users">
                    <?php include 'admin/users.php'; ?>
                </div>
                
                <!-- Логи -->
                <div class="tab-pane fade" id="logs">
                    <?php include 'admin/logs.php'; ?>
                </div>
                <!-- Финансовые отчеты -->
                <div class="tab-pane fade" id="reports">
                    <?php include 'admin/reports.php'; ?>
                </div>
                <!-- Документация -->
                <div class="tab-pane fade" id="docs">
                    <?php include 'admin/docs.php'; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Стиль для активного пункта меню */
    .list-group-item.active {
        background-color: #fd7e14 !important;
        border-color: #fd7e14 !important;
        color: white !important;
    }
    
    /* Стиль при наведении на пункт меню */
    .list-group-item-action:hover {
        background-color: rgba(253, 126, 20, 0.1);
    }
</style>

<?php include 'footer.php'; ?>