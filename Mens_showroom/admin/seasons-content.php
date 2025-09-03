<?php
// Обработка добавления сезона
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_season'])) {
    $season_name = trim($_POST['season_name']);
    
    if (!empty($season_name)) {
        try {
            $db = DB::getInstance();
            $stmt = $db->prepare("INSERT INTO seasons (season_name) VALUES (?)");
            $stmt->execute([$season_name]);
            $success = "Сезон успешно добавлен!";
        } catch (PDOException $e) {
            $error = "Ошибка: " . (strpos($e->getMessage(), 'Duplicate entry') ? "Сезон уже существует" : "Ошибка базы данных");
        }
    } else {
        $error = "Введите название сезона";
    }
}

// Обработка удаления сезона
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_season'])) {
    $season_id = (int)$_POST['season_id'];
    
    if ($season_id > 0) {
        try {
            $db = DB::getInstance();
            $stmt = $db->prepare("DELETE FROM seasons WHERE season_id = ?");
            $stmt->execute([$season_id]);
            $success = "Сезон успешно удален!";
        } catch (PDOException $e) {
            $error = "Нельзя удалить сезон с привязанными товарами";
        }
    }
}

// Получаем список сезонов
$db = DB::getInstance();
$seasons = $db->query("SELECT * FROM seasons ORDER BY season_name")->fetchAll();
?>

<div id="add-season" class="admin-section">
    <!-- Сообщения об ошибках/успехе -->
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <h3><i class="bi bi-sun"></i> Управление сезонами</h3>
    
    <!-- Форма добавления -->
    <form method="POST" class="mb-4 border-bottom pb-4">
        <div class="row">
            <div class="col-md-8">
                <label class="form-label">Новый сезон</label>
                <input type="text" name="season_name" class="form-control" required>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" name="add_season" class="btn btn-primary w-100">
                    <i class="bi bi-plus-lg"></i> Добавить
                </button>
            </div>
        </div>
    </form>
    
    <!-- Форма удаления -->
    <form method="POST">
        <h5 class="mb-3"><i class="bi bi-trash"></i> Удаление сезона</h5>
        <div class="row">
            <div class="col-md-8">
                <select name="season_id" class="form-select" required>
                    <option value="">Выберите сезон</option>
                    <?php foreach ($seasons as $season): ?>
                        <option value="<?= $season['season_id'] ?>">
                            <?= htmlspecialchars($season['season_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" name="delete_season" class="btn btn-danger w-100">
                    <i class="bi bi-trash"></i> Удалить
                </button>
            </div>
        </div>
    </form>
</div>