<?php
// Получаем всех забранных животных
$query = "
    SELECT a.*, 
           m.meeting_date as adoption_date,
           u.name as adopter_name, u.email as adopter_email
    FROM animals a
    JOIN meetings m ON a.id = m.animal_id
    JOIN users u ON m.user_id = u.id
    WHERE m.status = 'adopted' AND a.status = 'adopted'
    ORDER BY m.meeting_date DESC
";
$adoptedAnimals = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card shadow-sm">
    <div class="card-header bg-orange text-white" style="color:white">
        <h4 class="mb-0">Забранные животные</h4>
    </div>
    <div class="card-body">
        <?php if(empty($adoptedAnimals)): ?>
            <div class="alert alert-info">Нет данных о забранных животных</div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php foreach($adoptedAnimals as $animal): ?>
                    <div class="col">
                        <div class="card h-100">
                            <img src="/images/animals/<?= basename($animal['image']) ?: 'default.jpg' ?>" 
                                 class="card-img-top" 
                                 style="height: 250px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($animal['name']) ?></h5>
                                <p class="card-text">
                                    <strong>Тип:</strong> <?= $animal['type'] == 'cat' ? 'Кошка' : ($animal['type'] == 'dog' ? 'Собака' : 'Другое') ?><br>
                                    <strong>Порода:</strong> <?= $animal['breed'] ?: 'не указана' ?><br>
                                    <strong>Дата приюта:</strong> <?= date('d.m.Y', strtotime($animal['created_at'])) ?><br>
                                    <strong>Дата усыновления:</strong> <?= date('d.m.Y', strtotime($animal['adoption_date'])) ?>
                                </p>
                            </div>
                            <div class="card-footer bg-transparent">
                                <p class="mb-0">
                                    <strong>Новый хозяин:</strong> <?= htmlspecialchars($animal['adopter_name']) ?><br>
                                    <small class="text-muted"><?= htmlspecialchars($animal['adopter_email']) ?></small>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>