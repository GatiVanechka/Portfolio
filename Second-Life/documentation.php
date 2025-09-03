<?php
session_start();
require 'db.php';
include 'header.php';

// Получаем все документы
$documents = $conn->query("SELECT * FROM documentation ORDER BY uploaded_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5 mb-5">
    <h2 class="mb-4">Документация</h2>
    
    <?php if(empty($documents)): ?>
        <div class="alert alert-info">
            Документы пока не загружены.
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($documents as $doc): ?>
                <div class="col">
                    <div class="card shadow-sm h-100">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#docModal" 
                           data-img="<?= htmlspecialchars($doc['file_path']) ?>"
                           data-title="<?= htmlspecialchars($doc['title']) ?>">
                            <img src="<?= htmlspecialchars($doc['file_path']) ?>" 
                                 class="card-img-top" 
                                 alt="<?= htmlspecialchars($doc['title']) ?>"
                                 style="height: 200px; object-fit: contain;">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($doc['title']) ?></h5>
                            <p class="card-text text-muted">
                                <small>Загружено: <?= date('d.m.Y H:i', strtotime($doc['uploaded_at'])) ?></small>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Модальное окно для увеличения изображения -->
<div class="modal fade" id="docModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" style="max-height: 80vh;">
            </div>
        </div>
    </div>
</div>

<script>
// Инициализация модального окна
document.getElementById('docModal').addEventListener('show.bs.modal', function(event) {
    const button = event.relatedTarget;
    document.getElementById('modalTitle').textContent = button.getAttribute('data-title');
    document.getElementById('modalImage').src = button.getAttribute('data-img');
});
</script>

<?php include 'footer.php'; ?>