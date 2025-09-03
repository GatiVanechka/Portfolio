<?php
// Проверка на POST-запрос для загрузки файла
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['report_file'])) {
    $year = (int)$_POST['year'];
    
    // Проверяем файл
    $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
    if (!in_array($_FILES['report_file']['type'], $allowedTypes)) {
        $error = "Допустимы только JPG, PNG или PDF файлы";
    } elseif ($_FILES['report_file']['size'] > 5 * 1024 * 1024) {
        $error = "Файл слишком большой (максимум 5MB)";
    } else {
        // Создаем папку для отчетов, если её нет
        $uploadDir = 'uploads/reports/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Генерируем уникальное имя файла
        $extension = pathinfo($_FILES['report_file']['name'], PATHINFO_EXTENSION);
        $filename = 'report_' . $year . '_' . uniqid() . '.' . $extension;
        $targetPath = $uploadDir . $filename;
        
        if (move_uploaded_file($_FILES['report_file']['tmp_name'], $targetPath)) {
            // Сохраняем в БД
            $stmt = $conn->prepare("
                INSERT INTO financial_reports (year, image_path)
                VALUES (?, ?)
            ");
            $stmt->execute([$year, $targetPath]);
            
            $success = "Отчёт за $year год успешно загружен";
        } else {
            $error = "Ошибка при загрузке файла";
        }
    }
}

// Получаем список загруженных отчетов
$reports = $conn->query("
    SELECT year, MAX(uploaded_at) as last_upload, COUNT(*) as count 
    FROM financial_reports 
    GROUP BY year 
    ORDER BY year DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card shadow-sm">
    <div class="card-header bg-orange">
        <h5 class="mb-0 text-white">Управление финансовыми отчётами</h5>
    </div>
    <div class="card-body">
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        
        <?php if(isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="year" class="form-label">Год отчёта</label>
                    <select class="form-select" id="year" name="year" required>
                        <?php for($y = date('Y'); $y >= 2020; $y--): ?>
                            <option value="<?= $y ?>"><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                
                <div class="col-md-6">
                    <label for="report_file" class="form-label">Файл отчёта (JPG, PNG, PDF)</label>
                    <input class="form-control" type="file" id="report_file" name="report_file" required>
                </div>
                
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-upload"></i> Загрузить
                    </button>
                </div>
            </div>
        </form>
        
        <h5 class="mt-4">Загруженные отчёты</h5>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Год</th>
                        <th>Количество версий</th>
                        <th>Последнее обновление</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reports as $report): ?>
                        <tr>
                            <td><?= $report['year'] ?></td>
                            <td><?= $report['count'] ?></td>
                            <td><?= date('d.m.Y H:i', strtotime($report['last_upload'])) ?></td>
                            <td>
                                <a href="reports.php?year=<?= $report['year'] ?>" 
                                   class="btn btn-sm btn-outline-primary"
                                   target="_blank">
                                    <i class="bi bi-eye"></i> Просмотреть
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>