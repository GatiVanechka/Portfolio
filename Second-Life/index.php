<?php 
session_start();
require 'db.php';
include 'header.php'; 

// Получаем 3 последние новости из базы данных
$latestNews = $conn->query("
    SELECT id, title, content, image_path, created_at 
    FROM news 
    ORDER BY created_at DESC 
    LIMIT 3
")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5 text-center">
    <!-- Картинка и надпись -->
    <div class="container-fluid my-5 px-0">
        <img src="images/house.png" class="img-fluid w-100" style="max-height: 500px; object-fit: cover;" alt="Наш приют">
    </div>

    <h1 class="display-4 fw-bold">Вторая жизнь</h1>

    <!-- Описание приюта -->
    <p class="lead mt-4">
        Наш приют — это тёплый дом для бездомных и потерянных животных.  
        Мы даём им второй шанс на счастливую жизнь. Присоединяйтесь к нам и сделайте доброе дело!
    </p>

    <!-- Кнопка "Помочь нам" -->
    <a href="donations.php" class="btn btn-orange btn-lg mt-3">Помочь нам</a>
</div>

      <div style="background-color: rgb(218,118,67); height:20px" class="text-center text-white py-1 mt-5 shadow p-3">
  </div>

<div class="container mt-5 text-center mb-5">
</div>

<!-- Новости -->
<div class="container mb-5">
    <h2 class="text-center mb-4" id="news">Новости</h2>
    <!-- В index.php заменим блок с карточками новостей на следующий код: -->
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if (!empty($latestNews)): ?>
            <?php foreach ($latestNews as $newsItem): ?>
                <div class="col">
                    <a href="news.php?id=<?= $newsItem['id'] ?>" class="text-decoration-none">
                        <div class="card h-100 shadow-sm">
                            <?php if (!empty($newsItem['image_path'])): ?>
                                <img src="<?= htmlspecialchars($newsItem['image_path']) ?>" 
                                    class="card-img-top fixed-image" 
                                    alt="<?= htmlspecialchars($newsItem['title']) ?>"
                                    style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <img src="images/default-news.jpg" 
                                    class="card-img-top fixed-image" 
                                    alt="Новость"
                                    style="height: 200px; object-fit: cover;">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($newsItem['title']) ?></h5>
                                <p class="card-text">
                                    <?= htmlspecialchars(mb_substr($newsItem['content'], 0, 100)) ?>
                                    <?= mb_strlen($newsItem['content']) > 100 ? '...' : '' ?>
                                </p>
                            </div>
                            <div class="card-footer bg-transparent">
                                <small class="text-muted">
                                    <?= date('d.m.Y', strtotime($newsItem['created_at'])) ?>
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Оставляем запасной вариант без ссылок, так как это статический контент -->
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="images/n1.png" class="card-img-top fixed-image" alt="Новость 1">
                    <div class="card-body">
                        <h5 class="card-title">Мы спасли 10 щенков!</h5>
                        <p class="card-text">Недавно наш приют приютил десяток брошенных щенков. Спасибо всем, кто помогает!</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="images/n2.png" class="card-img-top fixed-image" alt="Новость 2">
                    <div class="card-body">
                        <h5 class="card-title">Открыт волонтёрский сезон</h5>
                        <p class="card-text">Теперь вы можете стать волонтёром приюта! Подробности внутри.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="images/n3.png" class="card-img-top fixed-image" alt="Новость 3">
                    <div class="card-body">
                        <h5 class="card-title">Нам подарили корм!</h5>
                        <p class="card-text">Огромное спасибо компании, которая обеспечила наш приют кормом на месяц вперёд.</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Кнопка "Все новости" -->
    <div class="text-end mt-4">
        <a href="news.php" class="btn btn-orange">
            <i class="bi bi-arrow-right"></i> Все новости
        </a>
    </div>
</div>

<style>
    .fixed-image {
        height: 200px;
        object-fit: cover;
        width: 100%;
    }
</style>

<?php include 'footer.php'; ?>