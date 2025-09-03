<?php
include 'header.php';
require_once 'config/db.php';

$db = DB::getInstance();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $size_id = isset($_POST['size_id']) ? (int)$_POST['size_id'] : 0;
    
    if ($product_id <= 0 || $size_id <= 0) {
        die("Неверные параметры товара");
    }
    
    if (isset($_POST['add_to_cart'])) {
        // Проверяем доступное количество перед добавлением
        $available = $db->prepare("SELECT quantity FROM product_size WHERE product_id = ? AND size_id = ?");
        $available->execute([$product_id, $size_id]);
        $available_quantity = $available->fetchColumn();
        
        if ($available_quantity > 0) {
            if (isset($_SESSION['cart'][$product_id][$size_id])) {
                if ($_SESSION['cart'][$product_id][$size_id]['quantity'] < $available_quantity) {
                    $_SESSION['cart'][$product_id][$size_id]['quantity']++;
                }
            } else {
                $_SESSION['cart'][$product_id][$size_id] = [
                    'quantity' => 1,
                    'size_id' => $size_id
                ];
            }
        }
    }
    
    if (isset($_POST['remove_from_cart'])) {
        unset($_SESSION['cart'][$product_id][$size_id]);
        if (empty($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
    }
    
    if (isset($_POST['update_quantity'])) {
        $new_quantity = (int)$_POST['quantity'];
        if ($new_quantity >= 1) {
            $_SESSION['cart'][$product_id][$size_id]['quantity'] = $new_quantity;
        }
    }
}

$cart_items = [];
$total_price = 0;

try {
    foreach ($_SESSION['cart'] as $product_id => $sizes) {
        $product = $db->prepare("SELECT * FROM products WHERE product_id = ?");
        $product->execute([$product_id]);
        $product = $product->fetch();
        
        if ($product) {
            foreach ($sizes as $size_id => $item) {
                // Получаем название размера и доступное количество
                $size_info = $db->prepare("
                    SELECT s.size_name, ps.quantity 
                    FROM sizes s
                    JOIN product_size ps ON s.size_id = ps.size_id
                    WHERE s.size_id = ? AND ps.product_id = ?
                ");
                $size_info->execute([$size_id, $product_id]);
                $size_data = $size_info->fetch();
                
                if ($size_data) {
                    $item_total = $product['price'] * $item['quantity'];
                    $total_price += $item_total;
                    
                    $cart_items[] = [
                        'product' => $product,
                        'size_id' => $size_id,
                        'size_name' => $size_data['size_name'],
                        'size_quantity' => $size_data['quantity'], // Количество конкретного размера
                        'quantity' => $item['quantity'],
                        'item_total' => $item_total
                    ];
                }
            }
        }
    }
} catch (PDOException $e) {
    die("Ошибка при загрузке данных корзины: " . $e->getMessage());
}
?>

<section class="cart-section py-5">
    <div class="container">
        <h1 class="mb-5"><i class="bi bi-cart"></i> Корзина</h1>
        
        <?php if (empty($cart_items)): ?>
            <div class="alert alert-info">
                Ваша корзина пуста. <a href="catalog.php" class="alert-link">Перейти в каталог</a>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <?php foreach ($cart_items as $item): ?>
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-3">
                                <img src="<?= htmlspecialchars($item['product']['image_path']) ?>" 
                                     class="img-fluid rounded-start h-100 object-fit-cover" 
                                     alt="<?= htmlspecialchars($item['product']['product_name']) ?>">
                            </div>
                            
                            <div class="col-md-9">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h5 class="card-title mb-2"><?= htmlspecialchars($item['product']['product_name']) ?></h5>
                                        <span class="text-primary fw-bold"><?= number_format($item['product']['price'], 0, '', ' ') ?> ₽</span>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-muted">Размер: <?= htmlspecialchars($item['size_name']) ?></span>
                                        <!-- Изменено: теперь показываем количество конкретного размера -->
                                        <span class="badge bg-secondary">В наличии: <?= $item['size_quantity'] ?></span>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <form method="POST" class="d-flex align-items-center quantity-form">
                                            <input type="hidden" name="product_id" value="<?= $item['product']['product_id'] ?>">
                                            <input type="hidden" name="size_id" value="<?= $item['size_id'] ?>">
                                            
                                            <button type="button" class="btn btn-outline-secondary px-3 minus-btn" 
                                                    <?= $item['quantity'] <= 1 ? 'disabled' : '' ?>>
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            
                                            <input type="number" name="quantity" 
                                                   class="form-control mx-2 text-center quantity-input" 
                                                   style="width: 60px;" 
                                                   value="<?= $item['quantity'] ?>" 
                                                   min="1" max="<?= $item['size_quantity'] ?>"
                                                   oninput="this.value = Math.max(1, Math.min(<?= $item['size_quantity'] ?>, parseInt(this.value)))"
                                                   readonly>
                                                   
                                            <button type="button" class="btn btn-outline-secondary px-3 plus-btn" 
                                                    <?= $item['quantity'] >= $item['size_quantity'] ? 'disabled' : '' ?>>
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </form>
                                        
                                        <form method="POST" class="remove-form">
                                            <input type="hidden" name="product_id" value="<?= $item['product']['product_id'] ?>">
                                            <input type="hidden" name="size_id" value="<?= $item['size_id'] ?>">
                                            <button type="submit" name="remove_from_cart" class="btn btn-outline-danger">
                                                <i class="bi bi-trash"></i> Удалить
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Ваш заказ</h5>
                            
                            <div class="d-flex justify-content-between mb-3">
                                <span>Товары (<?= count($cart_items) ?>)</span>
                                <span><?= number_format($total_price, 0, '', ' ') ?> ₽</span>
                            </div>
                            
                            <hr>
                            
                            <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                                <span>Итого</span>
                                <span><?= number_format($total_price, 0, '', ' ') ?> ₽</span>
                            </div>
                            
                            <a href="checkout.php" class="btn btn-primary w-100 py-3">
                                Перейти к оплате
                            </a>
                            
                            <div class="mt-3 text-center">
                                <a href="catalog.php" class="text-muted">
                                    <i class="bi bi-arrow-left"></i> Вернуться в каталог
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
document.querySelectorAll('.quantity-input').forEach(input => {
    input.addEventListener('wheel', e => e.preventDefault());
    input.style.appearance = 'textfield';
});

document.querySelectorAll('.minus-btn, .plus-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const form = this.closest('.quantity-form');
        const input = form.querySelector('.quantity-input');
        let quantity = parseInt(input.value);
        const max = parseInt(input.max);
        
        if (this.classList.contains('minus-btn')) {
            quantity = Math.max(1, quantity - 1);
        } else {
            quantity = Math.min(max, quantity + 1);
        }
        
        input.value = quantity;
        
        fetch('update_cart.php', {
            method: 'POST',
            body: new FormData(form)
        }).then(response => {
            if (!response.ok) throw new Error('Ошибка обновления');
            location.reload();
        }).catch(error => {
            console.error('Error:', error);
            alert('Ошибка при обновлении корзины');
        });
    });
});

document.querySelectorAll('.quantity-form').forEach(form => {
    form.addEventListener('submit', e => e.preventDefault());
});
</script>

<?php include 'footer.php'; ?>