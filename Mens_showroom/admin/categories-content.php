<?php
// Обработка добавления категории
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $category_name = trim($_POST['category_name']);
    
    if (!empty($category_name)) {
        try {
            $db = DB::getInstance();
            $stmt = $db->prepare("INSERT INTO categories (category_name) VALUES (?)");
            $stmt->execute([$category_name]);
            $success = "Категория успешно добавлена!";
        } catch (PDOException $e) {
            $error = "Ошибка: " . (strpos($e->getMessage(), 'Duplicate entry') ? "Категория уже существует" : "Ошибка базы данных");
        }
    } else {
        $error = "Введите название категории";
    }
}

// Обработка удаления категории
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_category'])) {
    $category_id = (int)$_POST['category_id'];
    
    if ($category_id > 0) {
        try {
            $db = DB::getInstance();
            $stmt = $db->prepare("DELETE FROM categories WHERE category_id = ?");
            $stmt->execute([$category_id]);
            $success = "Категория успешно удалена!";
        } catch (PDOException $e) {
            $error = "Нельзя удалить категорию с привязанными товарами";
        }
    }
}

// Получаем список категорий
$db = DB::getInstance();
$categories = $db->query("SELECT * FROM categories ORDER BY category_name")->fetchAll();
?>

<div id="add-category" class="admin-section">
    <!-- Сообщения об ошибках/успехе -->
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <h3><i class="bi bi-tags"></i> Управление категориями</h3>
    
    <!-- Форма добавления -->
    <form method="POST" class="mb-4 border-bottom pb-4">
        <div class="row">
            <div class="col-md-8">
                <label class="form-label">Новая категория</label>
                <input type="text" name="category_name" class="form-control" required>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" name="add_category" class="btn btn-primary w-100">
                    <i class="bi bi-plus-lg"></i> Добавить
                </button>
            </div>
        </div>
    </form>
    
    <!-- Форма удаления -->
    <form method="POST">
        <h5 class="mb-3"><i class="bi bi-trash"></i> Удаление категории</h5>
        <div class="row">
            <div class="col-md-8">
                <select name="category_id" class="form-select" required>
                    <option value="">Выберите категорию</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['category_id'] ?>">
                            <?= htmlspecialchars($category['category_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" name="delete_category" class="btn btn-danger w-100">
                    <i class="bi bi-trash"></i> Удалить
                </button>
            </div>
        </div>
    </form>
</div>