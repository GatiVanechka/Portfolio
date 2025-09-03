<?php
session_start();
require 'db.php';
include 'header.php';

// Получаем список доступных годов отчетов
$years = $conn->query("SELECT DISTINCT year FROM financial_reports ORDER BY year DESC")->fetchAll(PDO::FETCH_COLUMN);

// Получаем выбранный год (по умолчанию - последний)
$selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : ($years[0] ?? null);
$currentReport = null;

if ($selectedYear) {
    $stmt = $conn->prepare("SELECT * FROM financial_reports WHERE year = ? ORDER BY uploaded_at DESC LIMIT 1");
    $stmt->execute([$selectedYear]);
    $currentReport = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<div class="container mt-5 mb-5">
    <h2 class="mb-4">Финансовая отчётность</h2>
    
    <div class="row">
        <!-- Выбор года -->
        <div class="col-md-3">
            <div class="list-group">
                <?php foreach ($years as $year): ?>
                    <a href="reports.php?year=<?= $year ?>" 
                       class="list-group-item list-group-item-action <?= $year == $selectedYear ? 'active' : '' ?>">
                        Отчёт за <?= $year ?> год
                    </a>
                <?php endforeach; ?>
            </div>
            
            <?php if(isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'admin'): ?>
                <a href="admin.php#reports" class="btn btn-primary mt-3 w-100">
                    <i class="bi bi-upload"></i> Загрузить отчёт
                </a>
            <?php endif; ?>
        </div>
        
        <!-- Отображение отчёта -->
        <div class="col-md-9">
            <?php if ($currentReport): ?>
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Финансовая отчётность за <?= $selectedYear ?> год</h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="<?= htmlspecialchars($currentReport['image_path']) ?>" 
                             class="img-fluid" 
                             alt="Финансовый отчёт за <?= $selectedYear ?> год"
                             style="max-height: 80vh;">
                    </div>
                    <div class="card-footer text-muted">
                        Дата загрузки: <?= date('d.m.Y H:i', strtotime($currentReport['uploaded_at'])) ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    Отчёт за выбранный год не найден.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- В конец файла перед footer.php -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Отчёт за <?= $selectedYear ?> год</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="" id="reportImage" class="img-fluid" style="max-height: 80vh;">
            </div>
        </div>
    </div>
</div>

<script>
// Для отчетов
document.addEventListener('DOMContentLoaded', function() {
    const reportImg = document.querySelector('#reports .card img');
    if (reportImg) {
        reportImg.style.cursor = 'zoom-in';
        reportImg.addEventListener('click', function() {
            document.getElementById('reportImage').src = this.src;
            new bootstrap.Modal(document.getElementById('reportModal')).show();
        });
    }
});
</script>

<?php include 'footer.php'; ?>