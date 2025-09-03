<?php
session_start();
require 'db.php';

// Проверка авторизации
if(!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user']['id'];

// Получаем записи на встречи пользователя с информацией о животных
$meetings = $conn->prepare("
    SELECT m.*, a.name as animal_name, a.type as animal_type, a.image as animal_image
    FROM meetings m
    JOIN animals a ON m.animal_id = a.id
    WHERE m.user_id = ?
    ORDER BY m.meeting_date DESC
");
$meetings->execute([$userId]);
$meetings = $meetings->fetchAll(PDO::FETCH_ASSOC);

include 'header.php';
?>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Мои записи на встречи</h2>
        <a href="meetings.php" class="btn btn-orange">
            <i class="bi bi-plus-circle"></i> Записаться на новую встречу
        </a>
    </div>

    <!-- Статистика -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    <h3><?= count($meetings) ?></h3>
                    <p class="text-muted">Всего записей</p>
                </div>
                <div class="col-md-4 text-center">
                    <h3>
                        <?= count(array_filter($meetings, function($m) { 
                            return strtotime($m['meeting_date']) > time(); 
                        })) ?>
                    </h3>
                    <p class="text-muted">Предстоящих встреч</p>
                </div>
                <div class="col-md-4 text-center">
                    <h3>
                        <?= count(array_filter($meetings, function($m) { 
                            return strtotime($m['meeting_date']) <= time(); 
                        })) ?>
                    </h3>
                    <p class="text-muted">Прошедших встреч</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Список встреч -->
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">История записей</h5>
        </div>
        <div class="card-body p-0">
            <?php if(empty($meetings)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-calendar-x" style="font-size: 3rem;"></i>
                    <h4 class="mt-3">У вас пока нет записей на встречи</h4>
                    <p class="text-muted">Запишитесь на встречу с понравившимся питомцем</p>
                    <a href="meetings.php" class="btn btn-orange mt-3">Записаться</a>
                </div>
            <?php else: ?>
                <div class="list-group list-group-flush">
                    <?php foreach($meetings as $meeting): 
                        $imagePath = !empty($meeting['animal_image']) ? 
                            '/images/animals/' . basename($meeting['animal_image']) : 
                            '/images/animals/default.jpg';
                        $isPast = strtotime($meeting['meeting_date']) <= time();
                    ?>
                        <div class="list-group-item <?= $isPast ? 'bg-light' : '' ?>">
                            <div class="d-flex align-items-center">
                                <img src="<?= $imagePath ?>" 
                                     class="rounded me-3" 
                                     style="width: 80px; height: 80px; object-fit: cover;" 
                                     alt="<?= htmlspecialchars($meeting['animal_name']) ?>">
                                
                                <div class="flex-grow-1 text white">
                                    <div class="d-flex justify-content-between text white">
                                        <h5 class="mb-1">
                                            <?= htmlspecialchars($meeting['animal_name']) ?>
                                            <span class="badge bg-<?= $meeting['animal_type'] == 'cat' ? 'info' : 'orange' ?> text-white">
                                                <?= $meeting['animal_type'] == 'cat' ? 'Кошка' : 'Собака' ?>
                                            </span>
                                        </h5>
                                        <span class="text-<?= $isPast ? 'muted' : 'orange' ?>">
                                            <?= date('d.m.Y H:i', strtotime($meeting['meeting_date'])) ?>
                                        </span>
                                    </div>
                                    
                                    <p class="mb-1">
                                        <strong>Цель:</strong> <?= htmlspecialchars($meeting['purpose']) ?>
                                    </p>
                                    
                                    <?php if($isPast): ?>
                                        <span class="badge bg-orange text-white">Завершена</span>
                                    <?php else: ?>
                                        <span class="badge bg-orange text-white">Запланирована</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .badge {
        color: white;
    }
</style>

<?php include 'footer.php'; ?>