<?php
include '../header.php';
require_once '../config/db.php';

// Проверка прав администратора
if ($_SESSION['user']['role'] !== 'admin') {
    header('Location: /');
    exit();
}

// Проверка наличия ID товара
if (!isset($_GET['id'])) {
    header('Location: admin.php');
    exit();
}

$product_id = (int)$_GET['id'];
$db = DB::getInstance();

// Получаем данные товара
$stmt = $db->prepare("
    SELECT p.*, 
           GROUP_CONCAT(ps.size_id) AS size_ids,
           GROUP_CONCAT(ps.quantity) AS size_quantities
    FROM products p
    LEFT JOIN product_size ps ON p.product_id = ps.product_id
    WHERE p.product_id = ?
    GROUP BY p.product_id
");

// Проверяем, что подготовка запроса прошла успешно
if ($stmt === false) {
    die('Ошибка подготовки запроса: ' . $db->errorInfo()[2]);
}

// Выполняем запрос
$result = $stmt->execute([$product_id]);

// Проверяем успешность выполнения
if ($result === false) {
    die('Ошибка выполнения запроса: ' . $stmt->errorInfo()[2]);
}

$product = $stmt->fetch();

if (!$product) {
    header('Location: admin.php');
    exit();
}

// Получаем данные для форм
$categories = $db->query("SELECT * FROM categories ORDER BY category_name")->fetchAll();
$seasons = $db->query("SELECT * FROM seasons ORDER BY season_name")->fetchAll();
$sizes = $db->query("SELECT * FROM sizes ORDER BY size_name")->fetchAll();

// Подготовка данных о размерах
$product_sizes = [];
if ($product['size_ids']) {
    $size_ids = explode(',', $product['size_ids']);
    $size_quantities = explode(',', $product['size_quantities']);
    $product_sizes = array_combine($size_ids, $size_quantities);
}

// Обработка формы обновления товара
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    try {
        // Основные данные товара
        $product_name = trim($_POST['product_name']);
        $price = (float)$_POST['price'];
        $description = trim($_POST['description']);
        $quantity = (int)$_POST['quantity'];
        $color = trim($_POST['color']);
        $category_id = (int)$_POST['category_id'];
        $season_id = !empty($_POST['season_id']) ? (int)$_POST['season_id'] : null;
        
        // Обработка загрузки нового изображения
        $image_path = $product['image_path'];
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/mens_showroom/uploads/products/';
            
            // Удаляем старое изображение, если оно есть
            if ($image_path && file_exists($_SERVER['DOCUMENT_ROOT'] . $image_path)) {
                unlink($_SERVER['DOCUMENT_ROOT'] . $image_path);
            }
            
            // Создаем папку, если ее нет
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Генерация имени файла
            $file_ext = strtolower(pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION));
            $filename = 'product_' . time() . '.' . $file_ext;
            $destination = $upload_dir . $filename;

            if (move_uploaded_file($_FILES['product_image']['tmp_name'], $destination)) {
                $image_path = '/mens_showroom/uploads/products/' . $filename;
            } else {
                throw new Exception("Ошибка загрузки изображения");
            }
        }
        
        // Обновление товара в БД
        $stmt = $db->prepare("UPDATE products SET 
                            product_name = ?, 
                            price = ?, 
                            description = ?, 
                            quantity = ?, 
                            image_path = ?, 
                            season_id = ?, 
                            color = ?, 
                            category_id = ? 
                            WHERE product_id = ?");
        $stmt->execute([
            $product_name, $price, $description, $quantity, 
            $image_path, $season_id, $color, $category_id, 
            $product_id
        ]);
        
        // Обновление размеров
        $db->prepare("DELETE FROM product_size WHERE product_id = ?")->execute([$product_id]);
        
        if (!empty($_POST['sizes'])) {
            $stmt = $db->prepare("INSERT INTO product_size (product_id, size_id, quantity) VALUES (?, ?, ?)");
            
            foreach ($_POST['sizes'] as $size_id => $size_data) {
                if (!empty($size_data['active']) && $size_data['quantity'] > 0) {
                    $size_quantity = (int)$size_data['quantity'];
                    $stmt->execute([$product_id, $size_id, $size_quantity]);
                }
            }
        }
        
        $success = "Товар успешно обновлен!";
        // Обновляем данные товара после изменения
        $product = $db->prepare("SELECT * FROM products WHERE product_id = ?")->execute([$product_id])->fetch();
    } catch (Exception $e) {
        $error = "Ошибка при обновлении товара: " . $e->getMessage();
    }
}
?>

<div class="container-fluid mt-4">
    <h2><i class="bi bi-pencil-square"></i> Редактирование товара</h2>
    
    <div class="row">
        <div class="col-md-12">
            <a href="admin.php" class="btn btn-outline-secondary mb-4">
                <i class="bi bi-arrow-left"></i> Назад к списку товаров
            </a>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <!-- Основная информация -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Название товара</label>
                            <input type="text" name="product_name" class="form-control" 
                                   value="<?= htmlspecialchars($product['product_name']) ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Цена (₽)</label>
                            <input type="number" name="price" class="form-control" step="0.01" min="0" 
                                   value="<?= htmlspecialchars($product['price']) ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Описание</label>
                            <textarea name="description" class="form-control" rows="3" required><?= 
                                htmlspecialchars($product['description']) 
                            ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Общее количество</label>
                            <input type="number" name="quantity" class="form-control" min="0" 
                                   value="<?= htmlspecialchars($product['quantity']) ?>" required>
                        </div>
                    </div>
                    
                    <!-- Дополнительные атрибуты -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Категория</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Выберите категорию</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['category_id'] ?>" 
                                        <?= $category['category_id'] == $product['category_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category['category_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Сезон</label>
                            <select name="season_id" class="form-select">
                                <option value="">Не указан</option>
                                <?php foreach ($seasons as $season): ?>
                                    <option value="<?= $season['season_id'] ?>" 
                                        <?= $season['season_id'] == $product['season_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($season['season_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Цвет</label>
                            <input type="text" name="color" class="form-control" 
                                   value="<?= htmlspecialchars($product['color']) ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Изображение товара</label>
                            <?php if ($product['image_path']): ?>
                                <div class="mb-2">
                                    <img src="<?= htmlspecialchars($product['image_path']) ?>" 
                                         alt="Текущее изображение" 
                                         style="max-width: 200px; max-height: 200px;" 
                                         class="img-thumbnail">
                                    <div class="form-text">Текущее изображение</div>
                                </div>
                            <?php endif; ?>
                            <input type="file" name="product_image" class="form-control" 
                                   accept="image/jpeg, image/png, image/webp">
                            <div class="form-text">Оставьте пустым, чтобы сохранить текущее изображение</div>
                        </div>
                    </div>
                </div>
                
                <!-- Размеры и количество -->
                <div class="border-top mt-4 pt-4">
                    <h5><i class="bi bi-grid"></i> Доступные размеры</h5>
                    <div class="row">
                        <?php foreach ($sizes as $size): ?>
                            <div class="col-md-3 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0" type="checkbox" 
                                               name="sizes[<?= $size['size_id'] ?>][active]" 
                                               value="1" 
                                               <?= isset($product_sizes[$size['size_id']]) ? 'checked' : '' ?>>
                                    </div>
                                    <span class="input-group-text"><?= htmlspecialchars($size['size_name']) ?></span>
                                    <input type="number" name="sizes[<?= $size['size_id'] ?>][quantity]" 
                                           class="form-control" min="0" 
                                           value="<?= isset($product_sizes[$size['size_id']]) ? $product_sizes[$size['size_id']] : 0 ?>" 
                                           placeholder="Кол-во">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <button type="submit" name="update_product" class="btn btn-primary mt-4">
                    <i class="bi bi-save"></i> Сохранить изменения
                </button>
            </form>
        </div>
    </div>
</div>

<?php include '../footer.php'; ?>