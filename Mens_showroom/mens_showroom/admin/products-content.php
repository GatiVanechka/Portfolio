<?php
function get_upload_error($error_code) {
    $errors = [
        UPLOAD_ERR_INI_SIZE => 'Файл слишком большой',
        UPLOAD_ERR_FORM_SIZE => 'Файл слишком большой',
        UPLOAD_ERR_PARTIAL => 'Файл загружен частично',
        UPLOAD_ERR_NO_FILE => 'Файл не был загружен',
        UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка',
        UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск',
        UPLOAD_ERR_EXTENSION => 'Загрузка остановлена расширением PHP'
    ];
    return $errors[$error_code] ?? 'Неизвестная ошибка';
}

// Получаем данные для форм
$db = DB::getInstance();
$categories = $db->query("SELECT * FROM categories ORDER BY category_name")->fetchAll();
$seasons = $db->query("SELECT * FROM seasons ORDER BY season_name")->fetchAll();
$sizes = $db->query("SELECT * FROM sizes ORDER BY size_name")->fetchAll();

// Обработка формы добавления товара
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    try {
        // Основные данные товара
        $product_name = trim($_POST['product_name']);
        $price = (float)$_POST['price'];
        $description = trim($_POST['description']);
        $color = trim($_POST['color']);
        $category_id = (int)$_POST['category_id'];
        $season_id = !empty($_POST['season_id']) ? (int)$_POST['season_id'] : null;
        
        // Валидация данных
        if (empty($product_name)) {
            throw new Exception("Название товара не может быть пустым");
        }
        if ($price <= 0) {
            throw new Exception("Цена должна быть больше нуля");
        }
        
        // Обработка изображения
        $image_path = null;
        if (!isset($_FILES['product_image']) || $_FILES['product_image']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Ошибка загрузки изображения: " . get_upload_error($_FILES['product_image']['error'] ?? UPLOAD_ERR_NO_FILE));
        }

        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/mens_showroom/uploads/products/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_ext = strtolower(pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($file_ext, $allowed_ext)) {
            throw new Exception("Допустимые форматы изображений: " . implode(', ', $allowed_ext));
        }

        $filename = 'product_' . time() . '.' . $file_ext;
        $destination = $upload_dir . $filename;

        if (!move_uploaded_file($_FILES['product_image']['tmp_name'], $destination)) {
            throw new Exception("Ошибка загрузки изображения: " . print_r(error_get_last(), true));
        }
        
        $image_path = '/mens_showroom/uploads/products/' . $filename;
        
        // Начинаем транзакцию
        $db->beginTransaction();
        
        // Добавляем товар
        $stmt = $db->prepare("INSERT INTO products 
                            (product_name, price, description, quantity, image_path, season_id, color, category_id) 
                            VALUES (?, ?, ?, 0, ?, ?, ?, ?)");
        $stmt->execute([$product_name, $price, $description, $image_path, $season_id, $color, $category_id]);
        
        $product_id = $db->lastInsertId();
        $total_quantity = 0;
        
        // Добавляем размеры
        if (empty($_POST['sizes'])) {
            throw new Exception("Необходимо указать размеры товара");
        }

        $stmt = $db->prepare("INSERT INTO product_size (product_id, size_id, quantity) VALUES (?, ?, ?)");
        $has_valid_size = false;
        
        foreach ($_POST['sizes'] as $size_id => $size_data) {
            if (!empty($size_data['active'])) {
                $size_quantity = max(0, (int)$size_data['quantity']);
                if ($size_quantity > 0) {
                    $stmt->execute([$product_id, $size_id, $size_quantity]);
                    $total_quantity += $size_quantity;
                    $has_valid_size = true;
                }
            }
        }
        
        if (!$has_valid_size) {
            throw new Exception("Необходимо указать количество хотя бы для одного размера");
        }
        
        // Обновляем общее количество
        $db->prepare("UPDATE products SET quantity = ? WHERE product_id = ?")
           ->execute([$total_quantity, $product_id]);
        
        // Фиксируем транзакцию
        $db->commit();
        
        $success = "Товар успешно добавлен! ID: " . $product_id;
    } catch (Exception $e) {
        // Откатываем транзакцию при ошибке
        if ($db->inTransaction()) {
            $db->rollBack();
        }
        
        // Удаляем загруженное изображение в случае ошибки
        if (isset($destination) && file_exists($destination)) {
            unlink($destination);
        }
        
        $error = "Ошибка при добавлении товара: " . $e->getMessage();
    }
}

// Обработка формы редактирования товара
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product'])) {
    $product_id = (int)$_POST['product_id'];
    
    try {
        // Проверяем существование товара
        $stmt = $db->prepare("SELECT product_id, image_path FROM products WHERE product_id = ?");
        $stmt->execute([$product_id]);
        $current_product = $stmt->fetch();
        
        if (!$current_product) {
            throw new Exception("Товар не найден");
        }

        // Валидация данных
        $product_name = trim($_POST['product_name']);
        if (empty($product_name)) {
            throw new Exception("Название товара не может быть пустым");
        }
        
        $price = (float)$_POST['price'];
        if ($price <= 0) {
            throw new Exception("Цена должна быть больше нуля");
        }
        
        $description = trim($_POST['description']);
        $color = trim($_POST['color']);
        $category_id = (int)$_POST['category_id'];
        $season_id = !empty($_POST['season_id']) ? (int)$_POST['season_id'] : null;
        
        // Обработка изображения
        $image_path = $current_product['image_path'];
        $should_delete_image = isset($_POST['delete_image']) && $_POST['delete_image'] == '1';
        
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/mens_showroom/uploads/products/';
            
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Удаляем старое изображение если оно есть
            if ($image_path && file_exists($_SERVER['DOCUMENT_ROOT'] . $image_path)) {
                unlink($_SERVER['DOCUMENT_ROOT'] . $image_path);
            }

            $file_ext = strtolower(pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION));
            $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
            if (!in_array($file_ext, $allowed_ext)) {
                throw new Exception("Допустимые форматы изображений: " . implode(', ', $allowed_ext));
            }

            $filename = 'product_' . time() . '.' . $file_ext;
            $destination = $upload_dir . $filename;

            if (!move_uploaded_file($_FILES['product_image']['tmp_name'], $destination)) {
                throw new Exception("Ошибка загрузки изображения: " . print_r(error_get_last(), true));
            }
            
            $image_path = '/mens_showroom/uploads/products/' . $filename;
        } elseif ($should_delete_image && $image_path) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $image_path)) {
                unlink($_SERVER['DOCUMENT_ROOT'] . $image_path);
            }
            $image_path = null;
        }
        
        // Начинаем транзакцию
        $db->beginTransaction();
        
        try {
            // Обновляем основные данные товара
            $stmt = $db->prepare("UPDATE products 
                                SET product_name = ?, price = ?, description = ?, 
                                    image_path = ?, season_id = ?, color = ?, category_id = ?
                                WHERE product_id = ?");
            $stmt->execute([
                $product_name, $price, $description, 
                $image_path, $season_id, $color, $category_id, 
                $product_id
            ]);
            
            // Удаляем старые размеры
            $db->prepare("DELETE FROM product_size WHERE product_id = ?")->execute([$product_id]);
            
            // Добавляем новые размеры
            $total_quantity = 0;
            if (!empty($_POST['sizes'])) {
                $stmt = $db->prepare("INSERT INTO product_size (product_id, size_id, quantity) VALUES (?, ?, ?)");
                
                foreach ($_POST['sizes'] as $size_id => $size_data) {
                    if (!empty($size_data['active'])) {
                        $size_quantity = max(0, (int)$size_data['quantity']);
                        if ($size_quantity > 0) {
                            $stmt->execute([$product_id, $size_id, $size_quantity]);
                            $total_quantity += $size_quantity;
                        }
                    }
                }
            }
            
            // Обновляем общее количество
            $db->prepare("UPDATE products SET quantity = ? WHERE product_id = ?")
               ->execute([$total_quantity, $product_id]);
            
            // Фиксируем транзакцию
            $db->commit();
            
            $success = "Товар успешно обновлен!";
            // Обновляем список товаров
            $products = $db->query("
                SELECT p.*, c.category_name, s.season_name 
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.category_id
                LEFT JOIN seasons s ON p.season_id = s.season_id
                ORDER BY p.product_id DESC
            ")->fetchAll();
            
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
        
    } catch (Exception $e) {
        $error = "Ошибка при обновлении товара: " . $e->getMessage();
    }
}

// Обработка удаления товара
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $product_id = (int)$_POST['product_id'];
    
    try {
        // Получаем данные товара
        $stmt = $db->prepare("SELECT image_path FROM products WHERE product_id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();
        
        if (!$product) {
            throw new Exception("Товар не найден");
        }

        // Начинаем транзакцию
        $db->beginTransaction();
        
        try {
            // Удаляем связи с размерами
            $db->prepare("DELETE FROM product_size WHERE product_id = ?")->execute([$product_id]);
            
            // Удаляем сам товар
            $db->prepare("DELETE FROM products WHERE product_id = ?")->execute([$product_id]);
            
            // Удаляем изображение
            if ($product['image_path'] && file_exists($_SERVER['DOCUMENT_ROOT'] . $product['image_path'])) {
                unlink($_SERVER['DOCUMENT_ROOT'] . $product['image_path']);
            }
            
            // Фиксируем транзакцию
            $db->commit();
            
            $success = "Товар успешно удален!";
            // Обновляем список товаров
            $products = $db->query("
                SELECT p.*, c.category_name, s.season_name 
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.category_id
                LEFT JOIN seasons s ON p.season_id = s.season_id
                ORDER BY p.product_id DESC
            ")->fetchAll();
            
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
        
    } catch (Exception $e) {
        $error = "Ошибка при удалении товара: " . $e->getMessage();
    }
}

// Получаем список всех товаров
$products = $db->query("
    SELECT p.*, c.category_name, s.season_name 
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.category_id
    LEFT JOIN seasons s ON p.season_id = s.season_id
    ORDER BY p.product_id DESC
")->fetchAll();

// Получаем данные товара для редактирования (если передан ID)
$edit_product = null;
$edit_product_sizes = [];
if (isset($_GET['edit_id'])) {
    $edit_id = (int)$_GET['edit_id'];
    
    try {
        // Получаем данные товара
        $stmt = $db->prepare("SELECT * FROM products WHERE product_id = ?");
        $stmt->execute([$edit_id]);
        $edit_product = $stmt->fetch();
        
        if ($edit_product) {
            // Получаем размеры товара
            $stmt = $db->prepare("SELECT size_id, quantity FROM product_size WHERE product_id = ?");
            $stmt->execute([$edit_id]);
            $edit_product_sizes = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        }
    } catch (Exception $e) {
        $error = "Ошибка при загрузке данных товара: " . $e->getMessage();
    }
}
?>

<div id="add-product" class="admin-section">
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <h3><i class="bi bi-plus-circle"></i> Добавление товара</h3>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="row">
            <!-- Основная информация -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Название товара</label>
                    <input type="text" name="product_name" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Цена (₽)</label>
                    <input type="number" name="price" class="form-control" step="0.01" min="0" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Описание</label>
                    <textarea name="description" class="form-control" rows="3" required></textarea>
                </div>
            </div>
            
            <!-- Дополнительные атрибуты -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Категория</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">Выберите категорию</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['category_id'] ?>">
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
                            <option value="<?= $season['season_id'] ?>">
                                <?= htmlspecialchars($season['season_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Цвет</label>
                    <input type="text" name="color" class="form-control">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Изображение товара</label>
                    <input type="file" name="product_image" class="form-control" accept="image/jpeg, image/png, image/webp" required>
                    <div class="form-text">Рекомендуемый размер: 800x1000px, форматы: JPG, PNG, WEBP</div>
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
                                       value="1">
                            </div>
                            <span class="input-group-text"><?= htmlspecialchars($size['size_name']) ?></span>
                            <input type="number" name="sizes[<?= $size['size_id'] ?>][quantity]" 
                                   class="form-control" min="0" value="0" placeholder="Кол-во">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <button type="submit" name="add_product" class="btn btn-primary mt-4">
            <i class="bi bi-save"></i> Сохранить товар
        </button>
    </form>
</div>

<!-- Список товаров -->
<div id="products-list" class="admin-section mt-5">
    <h3><i class="bi bi-list-ul"></i> Список товаров</h3>
    
    <?php if (empty($products)): ?>
        <div class="alert alert-info">Нет товаров для отображения</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Изображение</th>
                        <th>Название</th>
                        <th>Цена</th>
                        <th>Категория</th>
                        <th>Количество</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= $product['product_id'] ?></td>
                            <td>
                                <?php if ($product['image_path']): ?>
                                    <img src="<?= htmlspecialchars($product['image_path']) ?>" 
                                         alt="<?= htmlspecialchars($product['product_name']) ?>" 
                                         style="max-width: 60px; max-height: 60px;">
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($product['product_name']) ?></td>
                            <td><?= number_format($product['price'], 2, '.', ' ') ?> ₽</td>
                            <td><?= htmlspecialchars($product['category_name'] ?? '') ?></td>
                            <td><?= $product['quantity'] ?></td>
                            <td>
                                <a href="?edit_id=<?= $product['product_id'] ?>" class="btn btn-sm btn-dark ">
                                    <i class="bi bi-pencil"></i> Редактировать
                                </a>
                                <form method="POST" style="display: inline-block;">
                                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                    <button type="submit" name="delete_product" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Вы уверены, что хотите удалить этот товар?')">
                                        <i class="bi bi-trash"></i> Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- Модальное окно редактирования -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Редактирование товара</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="product_id" value="<?= $edit_product['product_id'] ?? '' ?>">
                    
                    <div class="row">
                        <!-- Основная информация -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Название товара</label>
                                <input type="text" name="product_name" class="form-control" required 
                                       value="<?= htmlspecialchars($edit_product['product_name'] ?? '') ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Цена (₽)</label>
                                <input type="number" name="price" class="form-control" step="0.01" min="0" required 
                                       value="<?= htmlspecialchars($edit_product['price'] ?? '') ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Описание</label>
                                <textarea name="description" class="form-control" rows="3" required><?= 
                                    htmlspecialchars($edit_product['description'] ?? '') ?></textarea>
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
                                            <?= ($edit_product['category_id'] ?? '') == $category['category_id'] ? 'selected' : '' ?>>
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
                                            <?= ($edit_product['season_id'] ?? '') == $season['season_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($season['season_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Цвет</label>
                                <input type="text" name="color" class="form-control" 
                                       value="<?= htmlspecialchars($edit_product['color'] ?? '') ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Изображение товара</label>
                                <?php if (!empty($edit_product['image_path'])): ?>
                                    <div class="mb-2">
                                        <img src="<?= htmlspecialchars($edit_product['image_path']) ?>" 
                                             style="max-width: 100px;" class="img-thumbnail mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="delete_image" value="1" id="deleteImageCheck">
                                            <label class="form-check-label" for="deleteImageCheck">
                                                Удалить изображение
                                            </label>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="product_image" class="form-control" accept="image/jpeg, image/png, image/webp">
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
                                                   value="1" <?= isset($edit_product_sizes[$size['size_id']]) ? 'checked' : '' ?>>
                                        </div>
                                        <span class="input-group-text"><?= htmlspecialchars($size['size_name']) ?></span>
                                        <input type="number" name="sizes[<?= $size['size_id'] ?>][quantity]" 
                                               class="form-control" min="0" 
                                               value="<?= $edit_product_sizes[$size['size_id']] ?? 0 ?>" 
                                               placeholder="Кол-во">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" name="edit_product" class="btn btn-primary">Сохранить изменения</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Автоматически открываем модальное окно при наличии параметра edit_id
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('edit_id')) {
        const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
        editModal.show();
    }
    
    // Очищаем параметр edit_id при закрытии модального окна
    document.getElementById('editProductModal').addEventListener('hidden.bs.modal', function () {
        const url = new URL(window.location);
        url.searchParams.delete('edit_id');
        window.history.replaceState({}, '', url);
    });
});
</script>