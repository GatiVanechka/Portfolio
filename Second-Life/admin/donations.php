<div class="card shadow-sm">
    <div class="card-header bg-orange text-white">
        <div class="d-flex justify-content-between align-items-center bg-orange">
            <h5 class="mb-0 text-white"><i class="bi bi-cash-stack text-white"></i class='text-white'> Управление пожертвованиями</h5>
            <div class="btn-group">
                <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <i class="bi bi-funnel"></i> Фильтр
                </button>
                <button class="btn btn-light btn-sm ms-2">
                    <i class="bi bi-download"></i> Экспорт
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Дата</th>
                        <th>Сумма</th>
                        <th>Пожертвователь</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $donations = $conn->query("
                        SELECT d.*, u.name as user_name 
                        FROM donations d
                        LEFT JOIN users u ON d.user_id = u.id
                        ORDER BY d.donation_date DESC
                        LIMIT 50
                    ")->fetchAll();
                    
                    foreach($donations as $donation): 
                        $status_class = [
                            'pending' => 'warning',
                            'completed' => 'orange',
                            'failed' => 'danger'
                        ][$donation['status']] ?? 'secondary';
                    ?>
                    <tr>
                        <td>#<?= $donation['id'] ?></td>
                        <td><?= date('d.m.Y H:i', strtotime($donation['donation_date'])) ?></td>
                        <td><?= number_format($donation['amount'], 2) ?> ₽</td>
                        <td>
                            <?= $donation['user_name'] ? htmlspecialchars($donation['user_name']) : 'Аноним' ?>
                            <?= $donation['user_id'] ? '(ID: '.$donation['user_id'].')' : '' ?>
                        </td>
                        <td>
                            <span class="badge bg-<?= $status_class ?>">
                                <?= $donation['status'] == 'pending' ? 'Ожидание' : 
                                   ($donation['status'] == 'completed' ? 'Завершено' : 'Ошибка') ?>
                            </span>
                        </td>
                        <td>
                            <?php if($donation['status'] == 'pending'): ?>
                                <button class="btn btn-sm btn-outline-success confirm-donation" 
                                        data-id="<?= $donation['id'] ?>" title="Подтвердить">
                                    <i class="bi bi-check-circle"></i>
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Подтверждение пожертвования
    $(document).on('click', '.confirm-donation', function() {
        const donationId = $(this).data('id');
        if(confirm('Подтвердить это пожертвование?')) {
            $.ajax({
                url: 'admin/confirm_donation.php',
                type: 'POST',
                data: { id: donationId },
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        location.reload();
                    } else {
                        alert('Ошибка: ' + response.message);
                    }
                }
            });
        }
    });
});
</script>