<?php
// Обработка загрузки файла
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['doc_file'])) {
    $title = trim($_POST['title']);
    
    // Проверка файла
    $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
    if (empty($title)) {
        $error = "Введите название документа";
    } elseif (!in_array($_FILES['doc_file']['type'], $allowedTypes)) {
        $error = "Допустимы только JPG, PNG или PDF файлы";
    } elseif ($_FILES['doc_file']['size'] > 10 * 1024 * 1024) {
        $error = "Файл слишком большой (максимум 10MB)";
    } else {
        // Создаем папку для документов
        $uploadDir = 'uploads/docs/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Генерируем уникальное имя файла
        $extension = pathinfo($_FILES['doc_file']['name'], PATHINFO_EXTENSION);
        $filename = 'doc_' . uniqid() . '.' . $extension;
        $targetPath = $uploadDir . $filename;
        
        if (move_uploaded_file($_FILES['doc_file']['tmp_name'], $targetPath)) {
            // Сохраняем в БД
            $stmt = $conn->prepare("
                INSERT INTO documentation (title, file_path)
                VALUES (?, ?)
            ");
            $stmt->execute([$title, $targetPath]);
            
            $success = "Документ успешно загружен";
        } else {
            $error = "Ошибка при загрузке файла";
        }
    }
}

// Получаем список документов
$documents = $conn->query("SELECT * FROM documentation ORDER BY uploaded_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card shadow-sm">
    <div class="card-header bg-orange text-white">
        <h5 class="mb-0 text-white">Управление документацией</h5>
    </div>
    <div class="card-body">
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        
        <?php if(isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data" class="mb-4">
            <div class="row g-3">
                <div class="col-md-5">
                    <label for="title" class="form-label">Название документа</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                
                <div class="col-md-5">
                    <label for="doc_file" class="form-label">Файл документа (JPG, PNG, PDF)</label>
                    <input class="form-control" type="file" id="doc_file" name="doc_file" required>
                </div>
                
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-upload"></i> Загрузить
                    </button>
                </div>
            </div>
        </form>
        
        <h5>Загруженные документы</h5>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Название</th>
                        <th>Файл</th>
                        <th>Дата загрузки</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($documents as $doc): ?>
                        <tr>
                            <td><?= htmlspecialchars($doc['title']) ?></td>
                            <td>
                                <a href="<?= htmlspecialchars($doc['file_path']) ?>" target="_blank">
                                    <?= basename($doc['file_path']) ?>
                                </a>
                            </td>
                            <td><?= date('d.m.Y H:i', strtotime($doc['uploaded_at'])) ?></td>
                            <td>
                                <button class="btn btn-sm btn-danger"
                                        onclick="if(confirm('Удалить документ?')) window.location='admin/delete_doc.php?id=<?= $doc['id'] ?>'">
                                    <i class="bi bi-trash"></i> Удалить
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>