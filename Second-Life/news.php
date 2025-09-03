<?php
session_start();
require 'db.php';
include 'header.php';

// Получаем список всех новостей
$news = $conn->query("SELECT id, title, created_at FROM news ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

// Получаем выбранную новость
$selectedNews = null;
if (isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $selectedNews = $stmt->fetch(PDO::FETCH_ASSOC);
} elseif (!empty($news)) {
    // По умолчанию показываем первую новость
    $stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
    $stmt->execute([$news[0]['id']]);
    $selectedNews = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<div class="container mt-5 mb-5">
    <h2 class="mb-4">Новости приюта</h2>
    
    <div class="row">
        <!-- Список новостей (20%) -->
        <div class="col-md-3">
            <div class="list-group">
                <?php foreach ($news as $item): ?>
                    <a href="news.php?id=<?= $item['id'] ?>" 
                    class="list-group-item list-group-item-action 
                            <?= $selectedNews && $selectedNews['id'] == $item['id'] ? 'active-news' : '' ?>"
                    title="<?= htmlspecialchars($item['title']) ?>">
                        <span class="<?= $selectedNews && $selectedNews['id'] == $item['id'] ? 'text-white' : '' ?> news-title-truncate">
                            <?= htmlspecialchars($item['title']) ?>
                        </span>
                        <?php if (!empty($item['created_at'])): ?>
                            <small class="d-block <?= $selectedNews && $selectedNews['id'] == $item['id'] ? 'text-white' : 'text-muted' ?>">
                                <?= date('d.m.Y', strtotime($item['created_at'])) ?>
                            </small>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
            
            <?php if(isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'admin'): ?>
                <a href="admin.php#news" class="btn btn-orange mt-3 w-100">
                    <i class="bi bi-plus-circle"></i> Добавить новость
                </a>
            <?php endif; ?>
        </div>
                
        <!-- Контент новости (80%) -->
        <div class="col-md-9">
            <?php if ($selectedNews): ?>
                <div class="card shadow-sm">
                    <?php if (!empty($selectedNews['image_path'])): ?>
                        <img src="<?= htmlspecialchars($selectedNews['image_path']) ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($selectedNews['title']) ?>"
                             style="max-height: 400px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="card-body">
                        <h3><?= htmlspecialchars($selectedNews['title']) ?></h3>
                        <?php if (!empty($selectedNews['created_at'])): ?>
                            <p class="text-muted">
                                <small>Опубликовано: <?= date('d.m.Y H:i', strtotime($selectedNews['created_at'])) ?></small>
                            </p>
                        <?php endif; ?>
                        <div class="news-content">
                            <?= nl2br(htmlspecialchars($selectedNews['content'])) ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    Новости пока не добавлены.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .news-title-truncate {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .list-group-item:hover .news-title-truncate {
        -webkit-line-clamp: unset;
    }
    
    .news-content {
        line-height: 1.8;
        font-size: 1.1rem;
    }
</style>

<?php include 'footer.php'; ?>