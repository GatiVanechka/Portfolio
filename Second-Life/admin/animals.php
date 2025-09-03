<div class="card shadow-sm">
    <div class="card-header bg-orange text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-white"><i class="bi bi-paw"></i> Управление животными</h5>
            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#animalModal" id="addAnimalBtn">
                <i class="bi bi-plus"></i> Добавить
            </button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Фото</th>
                    <th>Имя</th>
                    <th>Тип</th>
                    <th>Порода</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $animals = $conn->query("SELECT * FROM animals ORDER BY created_at DESC")->fetchAll();
                
                foreach($animals as $animal):
                ?>
                    <tr>
                    <td>
                        <?php if($animal['image']): ?>
                            <img src="/<?= htmlspecialchars($animal['image']) ?>" 
                                style="width: 50px; height: 50px; object-fit: cover;" 
                                alt="<?= htmlspecialchars($animal['name']) ?>">
                        <?php else: ?>
                            <img src="/images/no-image.jpg" 
                                style="width: 50px; height: 50px; object-fit: cover;" 
                                alt="Нет изображения">
                        <?php endif; ?>
                    </td>
                        <td><?= htmlspecialchars($animal['name']) ?></td>
                        <td>
                            <?= $animal['type'] == 'cat' ? 'Кошка' : 
                               ($animal['type'] == 'dog' ? 'Собака' : 'Другое') ?>
                        </td>
                        <td><?= htmlspecialchars($animal['breed']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary edit-animal" 
                                    data-id="<?= $animal['id'] ?>">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger delete-animal" 
                                    data-id="<?= $animal['id'] ?>">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Модальное окно для добавления/редактирования животного -->
<div class="modal fade" id="animalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Добавить животное</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="animalForm" action="admin/save_animal.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="animalId" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Имя</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="type" class="form-label">Тип</label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="cat">Кошка</option>
                                    <option value="dog">Собака</option>
                                    <option value="other">Другое</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="breed" class="form-label">Порода</label>
                                <input type="text" class="form-control" id="breed" name="breed">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="age" class="form-label">Возраст (лет)</label>
                                <input type="number" class="form-control" id="age" name="age" min="0" max="30">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Пол</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" checked>
                                    <label class="form-check-label" for="male">Мальчик</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                                    <label class="form-check-label" for="female">Девочка</label>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="image" class="form-label">Фото</label>
                                <input class="form-control" type="file" id="image" name="image" accept="image/*">
                                <div id="currentImage" class="mt-2"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Описание</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Обработчик для кнопки добавления
    $('#addAnimalBtn').click(function() {
        $('#modalTitle').text('Добавить животное');
        $('#animalForm')[0].reset();
        $('#animalId').val('');
        $('#currentImage').html('');
    });
    
    // Делегирование события для кнопок редактирования
    $(document).on('click', '.edit-animal', function() {
        const animalId = $(this).data('id');
        console.log('Edit button clicked for ID:', animalId);
        
        $.ajax({
            url: 'admin/get_animal.php',
            type: 'GET',
            data: { id: animalId },
            dataType: 'json',
            success: function(response) {
                console.log('AJAX response:', response);
                if(response.success) {
                    const animal = response.animal;
                    
                    $('#modalTitle').text('Редактировать животное');
                    $('#animalId').val(animal.id);
                    $('#name').val(animal.name);
                    $('#type').val(animal.type);
                    $('#breed').val(animal.breed);
                    $('#age').val(animal.age);
                    $(`input[name="gender"][value="${animal.gender}"]`).prop('checked', true);
                    $('#description').val(animal.description);
                    
                    if(animal.image) {
                        $('#currentImage').html(`
                            <small>Текущее фото:</small><br>
                            <img src="/${animal.image}" style="max-height: 100px;" class="img-thumbnail mt-1">
                            <input type="hidden" name="current_image" value="${animal.image}">
                        `);
                    } else {
                        $('#currentImage').html('<small>Нет текущего фото</small>');
                    }
                    
                    $('#animalModal').modal('show');
                } else {
                    alert('Ошибка: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
                alert('Ошибка при загрузке данных животного: ' + error);
            }
        });
    });

    // Обработчик отправки формы
    $('#animalForm').submit(function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    alert(response.message);
                    $('#animalModal').modal('hide');
                    location.reload();
                } else {
                    alert('Ошибка: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Ошибка при сохранении: ' + error);
            }
        });
    });
    
    // Делегирование события для кнопок удаления
    $(document).on('click', '.delete-animal', function() {
        const animalId = $(this).data('id');
        console.log('Delete button clicked for ID:', animalId);
        
        if(confirm('Вы уверены, что хотите удалить это животное?')) {
            $.ajax({
                url: 'admin/delete_animal.php',
                type: 'POST',
                data: { id: animalId },
                dataType: 'json',
                success: function(response) {
                    console.log('Delete response:', response);
                    if(response.success) {
                        alert('Животное успешно удалено');
                        location.reload();
                    } else {
                        alert('Ошибка: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Delete error:', status, error);
                    alert('Ошибка при удалении животного: ' + error);
                }
            });
        }
    });
});
</script>