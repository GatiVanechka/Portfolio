<?php 
include 'header.php';
require_once 'config/db.php';

// Проверка прав администратора
if ($_SESSION['user']['role'] !== 'admin') {
    header('Location: /');
    exit();
}
?>

<div class="container-fluid mt-4">
    <h2 class="mb-4"><i class="bi bi-shield-lock"></i> Админ-панель магазина одежды</h2>
    
    <div class="row g-0">
        <!-- Левое меню -->
        <div class="col-md-3">
            <div class="admin-menu p-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#products" data-bs-toggle="tab">
                            <i class="bi bi-tshirt"></i> Товары
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#categories" data-bs-toggle="tab">
                            <i class="bi bi-tags"></i> Категории
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sizes" data-bs-toggle="tab">
                            <i class="bi bi-grid"></i> Размеры
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#seasons" data-bs-toggle="tab">
                            <i class="bi bi-sun"></i> Сезоны
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#orders" data-bs-toggle="tab">
                            <i class="bi bi-cart"></i> Заказы
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Правая часть с контентом -->
        <div class="col-md-9">
            <div class="admin-content p-4">
                <div class="tab-content">
                    
                    <!-- Товары -->
                    <div class="tab-pane fade show active" id="products">
                        <?php include 'admin/products-content.php'; ?>
                    </div>

                    <!-- Категории -->
                    <div class="tab-pane fade" id="categories">
                        <?php include 'admin/categories-content.php'; ?>
                    </div>
                    
                    <!-- Размеры -->
                    <div class="tab-pane fade" id="sizes">
                        <?php include 'admin/sizes-content.php'; ?>
                    </div>
                    
                    <!-- Сезоны -->
                    <div class="tab-pane fade" id="seasons">
                        <?php include 'admin/seasons-content.php'; ?>
                    </div>
                    
                    <!-- Заказы -->
                    <div class="tab-pane fade" id="orders">
                        <?php include 'admin/orders-content.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>