<div class="card shadow-sm">
    <div class="card-header bg-orange text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-white"><i class="bi bi-people"></i> Управление пользователями</h5>
            <div class="input-group" style="width: 300px;">
                <input type="text" class="form-control form-control-sm" placeholder="Поиск пользователей...">
                <button class="btn btn-light btn-sm" type="button">
                    <i class="bi bi-search"></i>
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
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Роль</th>
                        <th>Дата регистрации</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $users = $conn->query("
                        SELECT * FROM users 
                        ORDER BY created_at DESC
                        LIMIT 20
                    ")->fetchAll();
                    
                    foreach($users as $user): 
                        $role_class = [
                            'admin' => 'danger',
                            'user' => 'orange'
                        ][$user['role']] ?? 'secondary';
                    ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <span class="badge bg-<?= $role_class ?>">
                                <?= $user['role'] == 'admin' ? 'Админ' : 'Пользователь' ?>
                            </span>
                        </td>
                        <td><?= date('d.m.Y', strtotime($user['created_at'])) ?></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary edit-user" 
                                    data-id="<?= $user['id'] ?>" title="Редактировать">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <?php if($user['id'] != $_SESSION['user']['id']): ?>
                                <button class="btn btn-sm btn-outline-danger delete-user" 
                                        data-id="<?= $user['id'] ?>" title="Удалить">
                                    <i class="bi bi-trash"></i>
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

<!-- Модальное окно пользователя -->
<div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавить пользователя</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="userForm" action="admin/save_user.php" method="POST">
                <input type="hidden" id="userId" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="userName" class="form-label">Имя</label>
                        <input type="text" class="form-control" id="userName" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="userEmail" name="email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="userRole" class="form-label">Роль</label>
                        <select class="form-select" id="userRole" name="role" required>
                            <option value="user">Пользователь</option>
                            <option value="admin">Администратор</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="userPassword" class="form-label">Пароль</label>
                        <input type="password" class="form-control" id="userPassword" name="password">
                        <small class="text-muted">Оставьте пустым, чтобы не изменять</small>
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
    // Редактирование пользователя
    $(document).on('click', '.edit-user', function() {
        const userId = $(this).data('id');
        $.ajax({
            url: 'admin/get_user.php',
            type: 'GET',
            data: { id: userId },
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    const user = response.user;
                    $('#userModal .modal-title').text('Редактировать пользователя');
                    $('#userId').val(user.id);
                    $('#userName').val(user.name);
                    $('#userEmail').val(user.email);
                    $('#userRole').val(user.role);
                    $('#userModal').modal('show');
                }
            }
        });
    });
    
    // Удаление пользователя
    $(document).on('click', '.delete-user', function() {
        const userId = $(this).data('id');
        if(confirm('Вы уверены, что хотите удалить этого пользователя?')) {
            $.ajax({
                url: 'admin/delete_user.php',
                type: 'POST',
                data: { id: userId },
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