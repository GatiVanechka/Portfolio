<?php
// Обработка добавления размера
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_size'])) {
    $size_name = trim($_POST['size_name']);
    
    if (!empty($size_name)) {
        try {
            $db = DB::getInstance();
            $stmt = $db->prepare("INSERT INTO sizes (size_name) VALUES (?)");
            $stmt->execute([$size_name]);
            $success = "Размер успешно добавлен!";
        } catch (PDOException $e) {
            $error = "Ошибка: " . (strpos($e->getMessage(), 'Duplicate entry') ? "Размер уже существует" : "Ошибка базы данных");
        }
    } else {
        $error = "Введите значение размера";
    }
}

// Обработка удаления с проверкой
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_size'])) {
    $size_id = (int)$_POST['size_id'];
    
    if ($size_id > 0) {
        try {
            $db = DB::getInstance();
            
            // Проверяем использование размера
            $stmt = $db->prepare("SELECT COUNT(*) FROM product_size WHERE size_id = ?");
            $stmt->execute([$size_id]);
            $count = $stmt->fetchColumn();
            
            if ($count > 0) {
                $error = "Этот размер используется в " . $count . " товарах. Сначала удалите связи.";
            } else {
                $stmt = $db->prepare("DELETE FROM sizes WHERE size_id = ?");
                $stmt->execute([$size_id]);
                $success = "Размер успешно удален!";
            }
        } catch (PDOException $e) {
            $error = "Ошибка базы данных: " . $e->getMessage();
        }
    }
}

// Получаем список размеров
$db = DB::getInstance();
$sizes = $db->query("SELECT * FROM sizes ORDER BY size_name")->fetchAll();
?>

<div id="add-size" class="admin-section">
    <!-- Сообщения об ошибках/успехе -->
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <h3><i class="bi bi-grid"></i> Управление размерами</h3>
    
    <!-- Форма добавления -->
    <form method="POST" class="mb-4 border-bottom pb-4">
        <div class="row">
            <div class="col-md-8">
                <label class="form-label">Новый размер</label>
                <input type="text" name="size_name" class="form-control" 
                       placeholder="Например: S, M, 42, 44-46" required>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" name="add_size" class="btn btn-primary w-100">
                    <i class="bi bi-plus-lg"></i> Добавить
                </button>
            </div>
        </div>
    </form>
    
    <!-- Форма удаления -->
    <form method="POST">
        <h5 class="mb-3"><i class="bi bi-trash"></i> Удаление размера</h5>
        <div class="row">
            <div class="col-md-8">
                <select name="size_id" class="form-select" required>
                    <option value="">Выберите размер</option>
                    <?php foreach ($sizes as $size): ?>
                        <option value="<?= $size['size_id'] ?>">
                            <?= htmlspecialchars($size['size_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" name="delete_size" class="btn btn-danger w-100">
                    <i class="bi bi-trash"></i> Удалить
                </button>
            </div>
        </div>
    </form>
</div>