<?php
// Обработка добавления новости
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['news_image'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    
    // Валидация
    if (empty($title) || empty($content)) {
        $error = "Заполните все поля";
    } elseif (!in_array($_FILES['news_image']['type'], ['image/jpeg', 'image/png'])) {
        $error = "Допустимы только JPG и PNG изображения";
    } elseif ($_FILES['news_image']['size'] > 5 * 1024 * 1024) {
        $error = "Изображение слишком большое (максимум 5MB)";
    } else {
        // Загрузка изображения
        $uploadDir = 'uploads/news/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $filename = 'news_' . uniqid() . '.' . pathinfo($_FILES['news_image']['name'], PATHINFO_EXTENSION);
        $targetPath = $uploadDir . $filename;
        
        if (move_uploaded_file($_FILES['news_image']['tmp_name'], $targetPath)) {
            // Сохранение в БД
            $stmt = $conn->prepare("
                INSERT INTO news (title, content, image_path)
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$title, $content, $targetPath]);
            
            $success = "Новость успешно добавлена";
        } else {
            $error = "Ошибка при загрузке изображения";
        }
    }
}

// Получаем список новостей
$newsList = $conn->query("SELECT * FROM news ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card shadow-sm">
    <div class="card-header bg-orange">
        <h5 class="mb-0 text-white">Управление новостями</h5>
    </div>
    <div class="card-body">
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        
        <?php if(isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data" class="mb-4">
            <div class="mb-3">
                <label for="title" class="form-label">Заголовок новости</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            
            <div class="mb-3">
                <label for="content" class="form-label">Содержание новости</label>
                <textarea class="form-control" id="content" name="content" rows="6" required></textarea>
            </div>
            
            <div class="mb-3">
                <label for="news_image" class="form-label">Изображение (JPG/PNG, макс. 5MB)</label>
                <input class="form-control" type="file" id="news_image" name="news_image" required>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Опубликовать новость
            </button>
        </form>
        
        <h5>Список новостей</h5>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Заголовок</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($newsList as $newsItem): ?>
                        <tr>
                            <td><?= date('d.m.Y', strtotime($newsItem['created_at'])) ?></td>
                            <td><?= htmlspecialchars(mb_substr($newsItem['title'], 0, 50)) ?><?= mb_strlen($newsItem['title']) > 50 ? '...' : '' ?></td>
                            <td>
                                <a href="../news.php?id=<?= $newsItem['id'] ?>" 
                                   class="btn btn-sm btn-outline-primary"
                                   target="_blank">
                                    <i class="bi bi-eye"></i> Просмотр
                                </a>
                                <button class="btn btn-sm btn-danger"
                                        onclick="if(confirm('Удалить новость?')) window.location='/admin/delete_news.php?id=<?= $newsItem['id'] ?>'">
                                    <i class="bi bi-trash"></i> Удалить
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>