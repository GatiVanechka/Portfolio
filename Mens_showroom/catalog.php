<?php 
include 'header.php';
require_once 'config/db.php';

// Получаем данные для фильтров из БД
$db = DB::getInstance();

// Получаем категории
$categories = $db->query("SELECT * FROM categories ORDER BY category_name")->fetchAll();

// Получаем сезоны
$seasons = $db->query("SELECT * FROM seasons ORDER BY season_name")->fetchAll();

// Получаем размеры
$sizes = $db->query("SELECT * FROM sizes ORDER BY size_name")->fetchAll();

// Получаем минимальную и максимальную цены
$price_range = $db->query("SELECT MIN(price) as min_price, MAX(price) as max_price FROM products")->fetch();
$min_price = $price_range['min_price'] ?? 0;
$max_price = $price_range['max_price'] ?? 10000;

// Обработка фильтров
$filter_conditions = [];
$params = [];

// Категории
if (!empty($_GET['categories'])) {
    $filter_conditions[] = "p.category_id IN (".implode(',', array_fill(0, count($_GET['categories']), '?')).")";
    $params = array_merge($params, $_GET['categories']);
}

// Сезоны
if (!empty($_GET['seasons'])) {
    $filter_conditions[] = "p.season_id IN (".implode(',', array_fill(0, count($_GET['seasons']), '?')).")";
    $params = array_merge($params, $_GET['seasons']);
}

// Размеры
if (!empty($_GET['sizes'])) {
    $filter_conditions[] = "ps.size_id IN (".implode(',', array_fill(0, count($_GET['sizes']), '?')).")";
    $params = array_merge($params, $_GET['sizes']);
}

// Цена
if (!empty($_GET['min_price']) && !empty($_GET['max_price'])) {
    $filter_conditions[] = "p.price BETWEEN ? AND ?";
    $params[] = $_GET['min_price'];
    $params[] = $_GET['max_price'];
}

// Сортировка
$order_by = "p.price ASC"; // по умолчанию
if (!empty($_GET['price_sort'])) {
    $order_by = $_GET['price_sort'] == 'asc' ? "p.price ASC" : "p.price DESC";
}

// В начале файла, где формируем SQL запрос для товаров:
$sql = "SELECT DISTINCT p.* FROM products p
        LEFT JOIN product_size ps ON p.product_id = ps.product_id AND ps.quantity > 0
        WHERE p.quantity > 0";

if (!empty($filter_conditions)) {
    $sql .= " AND " . implode(" AND ", $filter_conditions);
}

$sql .= " ORDER BY $order_by";

// Получаем товары
$products = $db->prepare($sql);
$products->execute($params);
$products = $products->fetchAll();

// Получаем доступные размеры для каждого товара
foreach ($products as &$product) {
    $sizes_stmt = $db->prepare("SELECT s.size_name 
                               FROM product_size ps
                               JOIN sizes s ON ps.size_id = s.size_id
                               WHERE ps.product_id = ? AND ps.quantity > 0");
    $sizes_stmt->execute([$product['product_id']]);
    $product['sizes'] = $sizes_stmt->fetchAll(PDO::FETCH_COLUMN);
}
unset($product);
?>

<section class="catalog-section py-5">
    <div class="container">
        <div class="row">
            <!-- Фильтры (левая колонка) -->
            <div class="col-lg-3 mb-4 mb-lg-0">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form id="filter-form" method="GET">
                            <!-- Категории -->
                            <div class="filter-group mb-4">
                                <button class="filter-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#categoriesCollapse">
                                    <h5>Категория</h5>
                                    <i class="bi bi-chevron-down"></i>
                                </button>
                                <div class="collapse show" id="categoriesCollapse">
                                    <div class="filter-options">
                                        <?php foreach ($categories as $category): ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="categories[]" 
                                                   id="cat-<?= $category['category_id'] ?>" 
                                                   value="<?= $category['category_id'] ?>"
                                                   <?= (!empty($_GET['categories']) && in_array($category['category_id'], $_GET['categories'])) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="cat-<?= $category['category_id'] ?>">
                                                <?= htmlspecialchars($category['category_name']) ?>
                                            </label>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Сезон -->
                            <div class="filter-group mb-4">
                                <button class="filter-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#seasonCollapse">
                                    <h5>Сезон</h5>
                                    <i class="bi bi-chevron-down"></i>
                                </button>
                                <div class="collapse show" id="seasonCollapse">
                                    <div class="filter-options">
                                        <?php foreach ($seasons as $season): ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="seasons[]" 
                                                   id="season-<?= $season['season_id'] ?>" 
                                                   value="<?= $season['season_id'] ?>"
                                                   <?= (!empty($_GET['seasons']) && in_array($season['season_id'], $_GET['seasons'])) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="season-<?= $season['season_id'] ?>">
                                                <?= htmlspecialchars($season['season_name']) ?>
                                            </label>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Размеры -->
                            <div class="filter-group mb-4">
                                <button class="filter-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#sizesCollapse">
                                    <h5>Размер</h5>
                                    <i class="bi bi-chevron-down"></i>
                                </button>
                                <div class="collapse show" id="sizesCollapse">
                                    <div class="filter-options">
                                        <?php foreach ($sizes as $size): ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="sizes[]" 
                                                   id="size-<?= $size['size_id'] ?>" 
                                                   value="<?= $size['size_id'] ?>"
                                                   <?= (!empty($_GET['sizes']) && in_array($size['size_id'], $_GET['sizes'])) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="size-<?= $size['size_id'] ?>">
                                                <?= htmlspecialchars($size['size_name']) ?>
                                            </label>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Фильтр цены -->
                            <div class="filter-group mb-4">
                                <button class="filter-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#priceCollapse">
                                    <h5>Цена, ₽</h5>
                                    <i class="bi bi-chevron-down"></i>
                                </button>
                                <div class="collapse show" id="priceCollapse">
                                    <div class="price-range mb-3 px-2">
                                        <div class="d-flex justify-content-between mb-2">
                                            <input type="number" class="form-control form-control-sm" name="min_price" 
                                                   id="minPriceInput" value="<?= $_GET['min_price'] ?? $min_price ?>" style="width: 80px;">
                                            <input type="number" class="form-control form-control-sm" name="max_price" 
                                                   id="maxPriceInput" value="<?= $_GET['max_price'] ?? $max_price ?>" style="width: 80px;">
                                        </div>
                                        <input type="range" class="form-range" min="<?= $min_price ?>" max="<?= $max_price ?>" 
                                               step="100" id="priceRange" value="<?= $_GET['max_price'] ?? $max_price ?>">
                                    </div>
                                    
                                    <!-- Чекбоксы сортировки -->
                                    <div class="price-sort-options">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="price_sort" id="priceDefault" 
                                                   value="" <?= empty($_GET['price_sort']) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="priceDefault">По умолчанию</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="price_sort" id="priceAsc" 
                                                value="asc" <?= (!empty($_GET['price_sort']) && $_GET['price_sort'] == 'asc') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="priceAsc">Сначала дешевле</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="price_sort" id="priceDesc" 
                                                value="desc" <?= (!empty($_GET['price_sort']) && $_GET['price_sort'] == 'desc') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="priceDesc">Сначала дороже</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Кнопки -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-dark">Применить</button>
                                <a href="catalog.php" class="btn btn-outline-secondary">Сбросить всё</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Каталог товаров -->
            <div class="col-lg-9">
                <!-- В разделе вывода карточек товаров замените текущий код на этот: -->
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <?php foreach ($products as $product): ?>
    <div class="col">
        <a href="product.php?id=<?= $product['product_id'] ?>" class="text-decoration-none">
            <div class="card h-100 border-0 shadow-sm product-card" style="max-width: 280px;">
                <div class="product-image" style="height: 320px;">
                    <img src="<?= htmlspecialchars($product['image_path']) ?>" class="card-img-top h-100 object-fit-cover" alt="<?= htmlspecialchars($product['product_name']) ?>">
                </div>
                <div class="card-body d-flex flex-column" style="height: 200px;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-0 text-dark"><?= htmlspecialchars($product['product_name']) ?></h5>
                    </div>
                    <span class="text-primary fw-bold mb-2"><?= number_format($product['price'], 0, '', ' ') ?> ₽</span>
                    <p class="small text-muted mb-2"><?= htmlspecialchars($product['description']) ?></p>
                    <div class="sizes mt-auto">
                        <?php foreach ($product['sizes'] as $size): ?>
                        <span class="badge bg-dark me-1 mb-1 fs-6"><?= htmlspecialchars($size) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>
            </div>
        </div>
    </div>
</section>

<script>
// Обновление полей цены при изменении ползунка
document.getElementById('priceRange').addEventListener('input', function() {
    document.getElementById('maxPriceInput').value = this.value;
});

// Обновление ползунка при изменении поля ввода
document.getElementById('maxPriceInput').addEventListener('input', function() {
    document.getElementById('priceRange').value = this.value;
});
</script>

<?php include 'footer.php'; ?>