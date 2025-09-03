<?php
// Получаем все заявки на встречи с информацией о животных и пользователях
$query = "
    SELECT m.*, 
           a.name as animal_name, a.type as animal_type, a.image as animal_image, a.id as animal_id,
           u.name as user_name, u.email as user_email
    FROM meetings m
    JOIN animals a ON m.animal_id = a.id
    JOIN users u ON m.user_id = u.id
    WHERE m.status != 'adopted' AND a.status != 'adopted'
    ORDER BY m.meeting_date DESC
";
$meetings = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card shadow-sm">
    <div class="card-header bg-orange text-white">
        <h4 class="mb-0">Управление заявками на встречи</h4>
    </div>
    <div class="card-body">
        <?php if(empty($meetings)): ?>
            <div class="alert alert-info">Нет активных заявок на встречи</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
    <tr>
        <th>Дата</th>
        <th>Животное</th>
        <th>Пользователь</th>
        <th>Телефон</th> <!-- Новая колонка -->
        <th>Цель</th>
        <th>Статус</th>
        <th>Действия</th>
    </tr>
</thead>
<tbody>
    <?php foreach($meetings as $meeting): ?>
        <tr>
            <td><?= date('d.m.Y H:i', strtotime($meeting['meeting_date'])) ?></td>
            <td>
                <div class="d-flex align-items-center">
                    <img src="/images/animals/<?= basename($meeting['animal_image']) ?: 'default.jpg' ?>" 
                         class="rounded me-2" 
                         style="width: 50px; height: 50px; object-fit: cover;">
                    <?= htmlspecialchars($meeting['animal_name']) ?>
                </div>
            </td>
            <td>
                <?= htmlspecialchars($meeting['user_name']) ?><br>
                <small class="text-muted"><?= htmlspecialchars($meeting['user_email']) ?></small>
            </td>
            <td><?= htmlspecialchars($meeting['user_phone']) ?></td> <!-- Новая ячейка -->
            <td><?= htmlspecialchars(mb_substr($meeting['purpose'], 0, 50)) ?>...</td>
                                <td>
                                    <span class="badge 
                                        <?= $meeting['status'] == 'pending' ? 'bg-orange' : 
                                           ($meeting['status'] == 'confirmed' ? 'bg-orange' : 'bg-orange') ?>">
                                        <?= $meeting['status'] == 'pending' ? 'На рассмотрении' : 
                                           ($meeting['status'] == 'confirmed' ? 'Подтверждена' : 'Отклонена') ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <?php if($meeting['status'] != 'confirmed'): ?>
                                            <button class="btn btn-success approve-btn" data-id="<?= $meeting['id'] ?>">
                                                <i class="bi bi-check"></i> Одобрить
                                            </button>
                                        <?php endif; ?>
                                        
                                        <?php if($meeting['status'] != 'rejected'): ?>
                                            <button class="btn btn-danger reject-btn" data-id="<?= $meeting['id'] ?>">
                                                <i class="bi bi-x"></i> Отклонить
                                            </button>
                                        <?php endif; ?>
                                        
                                        <button class="btn btn-primary adopt-btn" 
                                                data-id="<?= $meeting['id'] ?>" 
                                                data-animal-id="<?= $meeting['animal_id'] ?>">
                                            <i class="bi bi-house-heart"></i> Забрали
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
$(document).ready(function() {
    // Одобрить заявку
    $('.approve-btn').click(function() {
        const meetingId = $(this).data('id');
        updateStatus(meetingId, 'confirmed');
    });
    
    // Отклонить заявку
    $('.reject-btn').click(function() {
        const meetingId = $(this).data('id');
        updateStatus(meetingId, 'rejected');
    });
    
    // Отметить как "Забрали"
    $('.adopt-btn').click(function() {
        const meetingId = $(this).data('id');
        const animalId = $(this).data('animal-id');
        
        if(confirm('Вы уверены, что животное забрали? Это действие нельзя отменить.')) {
            $.post('admin/update_meeting_status.php', {
                id: meetingId,
                status: 'adopted',
                animal_id: animalId
            }, function(response) {
                if(response.success) {
                    location.reload();
                } else {
                    alert('Ошибка: ' + response.error);
                }
            }, 'json');
        }
    });
    
    function updateStatus(meetingId, status) {
        $.post('admin/update_meeting_status.php', {
            id: meetingId,
            status: status
        }, function(response) {
            if(response.success) {
                location.reload();
            } else {
                alert('Ошибка: ' + response.error);
            }
        }, 'json');
    }
});
</script>