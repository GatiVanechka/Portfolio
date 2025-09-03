<div class="card shadow-sm">
    <div class="card-header bg-orange text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-white"><i class="bi bi-journal-text"></i> Логи действий</h5>
            <div class="btn-group">
                <button class="btn btn-light btn-sm" id="refreshLogs">
                    <i class="bi bi-arrow-clockwise"></i> Обновить
                </button>
                <button class="btn btn-light btn-sm ms-2" id="clearLogs">
                    <i class="bi bi-trash"></i> Очистить
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" id="logSearch" placeholder="Поиск по логам...">
                <button class="btn btn-outline-secondary" type="button">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Дата</th>
                        <th>Пользователь</th>
                        <th>Действие</th>
                        <th>Детали</th>
                        <th>IP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $logs = $conn->query("
                        SELECT l.*, u.name as user_name 
                        FROM user_logs l
                        LEFT JOIN users u ON l.user_id = u.id
                        ORDER BY l.created_at DESC
                        LIMIT 100
                    ")->fetchAll();
                    
                    foreach($logs as $log): 
                        $action_class = [
                            'LOGIN' => 'success',
                            'LOGOUT' => 'secondary',
                            'CREATE' => 'primary',
                            'UPDATE' => 'warning',
                            'DELETE' => 'danger',
                            'ERROR' => 'danger',
                            'ADMIN_ACCESS' => 'info',
                            'PAGE_VISIT' => 'info',
                            'ANIMAL_VIEW' => 'info',
                            'ANIMAL_ADDED' => 'success'
                        ][$log['action']] ?? 'info';
                    ?>
                    <tr>
                        <td><?= $log['id'] ?></td>
                        <td><?= date('d.m.Y H:i:s', strtotime($log['created_at'])) ?></td>
                        <td>
                            <?= $log['user_name'] ? htmlspecialchars($log['user_name']) : 'Система' ?>
                            <?= $log['user_id'] ? '(ID: '.$log['user_id'].')' : '' ?>
                        </td>
                        <td>
                            <span class="badge bg-<?= $action_class ?>">
                                <?= $log['action'] ?>
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-info view-details" 
                                    data-details="<?= htmlspecialchars($log['details']) ?>">
                                <i class="bi bi-info-circle"></i>
                            </button>
                        </td>
                        <td><?= $log['ip_address'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Модальное окно деталей лога -->
<div class="modal fade" id="logDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Детали действия</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <pre id="logDetailsContent" class="p-3 bg-light rounded"></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" id="copyLogDetails">
                    <i class="bi bi-clipboard"></i> Копировать
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Просмотр деталей лога
    $(document).on('click', '.view-details', function() {
        const details = $(this).data('details');
        $('#logDetailsContent').text(details);
        $('#logDetailsModal').modal('show');
    });
    
    // Копирование деталей
    $('#copyLogDetails').click(function() {
        const content = $('#logDetailsContent').text();
        navigator.clipboard.writeText(content);
        $(this).html('<i class="bi bi-check"></i> Скопировано');
        setTimeout(() => {
            $(this).html('<i class="bi bi-clipboard"></i> Копировать');
        }, 2000);
    });
    
    // Обновление логов
    $('#refreshLogs').click(function() {
        location.reload();
    });
    
    // Очистка логов
    $('#clearLogs').click(function() {
        if(confirm('Очистить все логи? Это действие нельзя отменить.')) {
            $.ajax({
                url: 'admin/clear_logs.php',
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        location.reload();
                    }
                }
            });
        }
    });
});
</script>