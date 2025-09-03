<?php 
include 'header.php';
require_once 'config/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: catalog.php');
    exit();
}

$db = DB::getInstance();
$product_id = (int)$_GET['id'];

// Получаем данные товара
$product = $db->prepare("SELECT p.*, c.category_name, s.season_name 
                        FROM products p
                        LEFT JOIN categories c ON p.category_id = c.category_id
                        LEFT JOIN seasons s ON p.season_id = s.season_id
                        WHERE p.product_id = ?");
$product->execute([$product_id]);
$product = $product->fetch();

if (!$product) {
    header('Location: catalog.php');
    exit();
}

// Получаем доступные размеры с количеством
$sizes = $db->prepare("SELECT s.size_id, s.size_name, ps.quantity 
                      FROM product_size ps
                      JOIN sizes s ON ps.size_id = s.size_id
                      WHERE ps.product_id = ? AND ps.quantity > 0");
$sizes->execute([$product_id]);
$available_sizes = $sizes->fetchAll();

// Обработка выбора размера
$selected_size = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['size_id'])) {
    $selected_size = (int)$_POST['size_id'];
}
// Обработка добавления в корзину
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = (int)$_POST['product_id'];
    $size_id = (int)$_POST['size_id'];
    
    // Инициализация корзины в сессии
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Добавление товара в корзину
    if (isset($_SESSION['cart'][$product_id][$size_id])) {
        $_SESSION['cart'][$product_id][$size_id]['quantity']++;
    } else {
        $_SESSION['cart'][$product_id][$size_id] = [
            'quantity' => 1,
            'size_id' => $size_id
        ];
    }
    
    // Редирект для предотвращения повторной отправки формы
    header("Location: product.php?id=$product_id");
    exit();
}
?>

<section class="product-section py-5">
    <div class="container">
        <div class="row">
            <!-- Левая часть - изображение -->
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="product-image-container">
                    <img src="<?= htmlspecialchars($product['image_path']) ?>" 
                         class="img-fluid rounded-3 shadow" 
                         alt="<?= htmlspecialchars($product['product_name']) ?>">
                </div>
            </div>

            <!-- Правая часть - информация -->
            <div class="col-lg-6">
                <form method="POST">
                    <!-- Название -->
                    <h1 class="product-title mb-3"><?= htmlspecialchars($product['product_name']) ?></h1>
                    
                    <!-- Категория -->
                    <div class="product-meta mb-2">
                        <span class="text-muted">Категория:</span>
                        <span class="ms-2"><?= htmlspecialchars($product['category_name']) ?></span>
                    </div>
                    
                    <!-- Цвет -->
                    <div class="product-meta mb-2">
                        <span class="text-muted">Цвет:</span>
                        <span class="ms-2"><?= htmlspecialchars($product['color']) ?></span>
                    </div>
                    
                    <!-- Цена -->
                    <div class="product-price mb-4">
                        <span class="fs-3 fw-bold text-primary"><?= number_format($product['price'], 0, '', ' ') ?> ₽</span>
                    </div>
                    
                    <!-- Размеры -->
                    <div class="product-sizes mb-4">
                        <h5 class="mb-3">Доступные размеры</h5>
                        <div class="size-options">
                            <?php foreach ($available_sizes as $size): ?>
                            <button type="submit" name="size_id" value="<?= $size['size_id'] ?>" 
                                    class="btn <?= $selected_size == $size['size_id'] ? 'btn-dark' : 'btn-outline-dark' ?> me-2 mb-2 size-btn">
                                <?= htmlspecialchars($size['size_name']) ?>
                                <span class="badge bg-secondary ms-1"><?= $size['quantity'] ?></span>
                            </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Описание -->
                    <div class="product-description mb-5">
                        <h5 class="mb-3">Описание</h5>
                        <p><?= htmlspecialchars($product['description']) ?></p>
                    </div>
                    
<!-- Кнопка корзины -->
<div class="d-grid">
    <?php if (!empty($available_sizes)): ?>
        <?php if ($selected_size): ?>
            <form method="POST">
                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                <input type="hidden" name="size_id" value="<?= $selected_size ?>">
                <button class="btn btn-dark btn-lg py-3" type="submit" name="add_to_cart">
                    <i class="bi bi-cart-plus"></i> Добавить в корзину
                </button>
            </form>
        <?php else: ?>
            <button class="btn btn-dark btn-lg py-3" disabled>
                <i class="bi bi-cart-plus"></i> Выберите размер
            </button>
        <?php endif; ?>
    <?php else: ?>
        <button class="btn btn-secondary btn-lg py-3" disabled>
            <i class="bi bi-cart-x"></i> Нет в наличии
        </button>
    <?php endif; ?>
</div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
// Добавляем обработку клика по размеру без перезагрузки страницы
document.querySelectorAll('.size-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        if (this.getAttribute('type') === 'submit') return;
        
        e.preventDefault();
        this.form.querySelector('[name="size_id"]').value = this.value;
        this.form.submit();
    });
});
</script>

<?php include 'footer.php'; ?>