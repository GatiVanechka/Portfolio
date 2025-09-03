<?php
session_start();
require 'db.php';
include 'header.php';

// Проверка авторизации
$isAuthenticated = isset($_SESSION['user']);

// Проверка наличия таблицы животных
if ($conn->query("SHOW TABLES LIKE 'animals'")->rowCount() == 0) {
    die("Таблица животных не существует");
}

// Получение животных
$animalsByType = [
    'dog' => $conn->query("SELECT * FROM animals WHERE type = 'dog' AND status != 'adopted' ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC),
    'cat' => $conn->query("SELECT * FROM animals WHERE type = 'cat' AND status != 'adopted' ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC),
    'other' => $conn->query("SELECT * FROM animals WHERE type NOT IN ('dog', 'cat') AND status != 'adopted' ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC)
];

// Лог посещения
logAction($conn, 'PAGE_VISIT', 'Visited meetings page');
?>

<style>
    /* Кастомные стили для табов */
    .nav-tabs {
        border-bottom: none;
        justify-content: center;
        margin-bottom: 2rem;
    }
    
    .nav-tabs .nav-link {
        color: #495057;
        border: none;
        padding: 10px 20px;
        margin: 0 10px;
        position: relative;
        font-weight: 600;
        font-size: 1.1rem;
        background: transparent;
    }
    
    .nav-tabs .nav-link.active {
        color: #000;
        background-color: transparent;
    }
    
    .nav-tabs .nav-link.active::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 2px;
        background-color: #ff6b00;
    }
    
    .nav-tabs .nav-link:hover {
        color: #ff6b00;
    }
    
    .animal-count {
        font-weight: normal;
        margin-left: 5px;
    }
    
    /* Стили для карточек животных */
    .animal-card {
        border: none;
        border-radius: 8px;
        transition: transform 0.2s;
        cursor: pointer;
    }
    
    .animal-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .card-img-top {
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }
    
    .bg-orange {
        background-color: #ff6b00 !important;
    }
    
    /* Стиль для неавторизованных пользователей */
    .not-authenticated {
        position: relative;
    }
    
    .not-authenticated::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(255,255,255,0.7);
        z-index: 1;
        border-radius: 8px;
    }
</style>

<div class="container mt-4 mb-5">
    <h2 class="text-center mb-4">Записаться на встречу с питомцем</h2>

    <!-- Табы для переключения категорий -->
    <ul class="nav nav-tabs" id="animalTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="dogs-tab" data-bs-toggle="tab" data-bs-target="#dogs" type="button" role="tab">
                Собаки<span class="animal-count"><?= count($animalsByType['dog']) ?></span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="cats-tab" data-bs-toggle="tab" data-bs-target="#cats" type="button" role="tab">
                Кошки<span class="animal-count"><?= count($animalsByType['cat']) ?></span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="others-tab" data-bs-toggle="tab" data-bs-target="#others" type="button" role="tab">
                Другие<span class="animal-count"><?= count($animalsByType['other']) ?></span>
            </button>
        </li>
    </ul>

    <!-- Контент табов -->
    <div class="tab-content" id="animalTabsContent">
        <!-- Собаки -->
        <div class="tab-pane fade show active" id="dogs" role="tabpanel">
            <?php if (!empty($animalsByType['dog'])): ?>
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    <?php foreach ($animalsByType['dog'] as $animal): ?>
                        <div class="col">
                            <div class="card h-100 animal-card <?= !$isAuthenticated ? 'not-authenticated' : '' ?>" 
                                 data-animal-id="<?= $animal['id'] ?>" 
                                 <?= $isAuthenticated ? 'data-bs-toggle="modal" data-bs-target="#meetingModal"' : '' ?>>
                                <img src="/images/animals/<?= !empty($animal['image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/images/animals/' . basename($animal['image'])) ? htmlspecialchars(basename($animal['image'])) : 'default.jpg' ?>" 
                                     class="card-img-top" 
                                     alt="<?= htmlspecialchars($animal['name']) ?>" 
                                     style="height: 300px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title fs-5"><?= htmlspecialchars($animal['name']) ?></h5>
                                    <p class="card-text">
                                        <small class="text-muted">
                                            Собака<?= $animal['breed'] ? ', ' . htmlspecialchars($animal['breed']) : '' ?>
                                        </small>
                                    </p>
                                    <p class="card-text"><?= htmlspecialchars(mb_substr($animal['description'], 0, 80)) ?>...</p>
                                </div>
                                <div class="card-footer bg-transparent border-0">
                                    <?php
                                    $age = $animal['age'];
                                    $ageSuffix = 'лет';
                                    if ($age % 100 >= 11 && $age % 100 <= 14) {
                                        $ageSuffix = 'лет';
                                    } else {
                                        switch($age % 10) {
                                            case 1: $ageSuffix = 'год'; break;
                                            case 2: case 3: case 4: $ageSuffix = 'года'; break;
                                        }
                                    }
                                    ?>
                                    <span class="badge bg-orange text-white fs-6 me-1">
                                        <?= $age ?> <?= $ageSuffix ?>
                                    </span>
                                    <span class="badge bg-orange text-white fs-6">
                                        <?= $animal['gender'] == 'male' ? 'Мальчик' : 'Девочка' ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center py-4">Пока нет собак для встречи</div>
            <?php endif; ?>
        </div>

        <!-- Кошки -->
        <div class="tab-pane fade" id="cats" role="tabpanel">
            <?php if (!empty($animalsByType['cat'])): ?>
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    <?php foreach ($animalsByType['cat'] as $animal): ?>
                        <div class="col">
                            <div class="card h-100 animal-card <?= !$isAuthenticated ? 'not-authenticated' : '' ?>" 
                                 data-animal-id="<?= $animal['id'] ?>" 
                                 <?= $isAuthenticated ? 'data-bs-toggle="modal" data-bs-target="#meetingModal"' : '' ?>>
                                <img src="/images/animals/<?= !empty($animal['image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/images/animals/' . basename($animal['image'])) ? htmlspecialchars(basename($animal['image'])) : 'default.jpg' ?>" 
                                     class="card-img-top" 
                                     alt="<?= htmlspecialchars($animal['name']) ?>" 
                                     style="height: 300px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title fs-5"><?= htmlspecialchars($animal['name']) ?></h5>
                                    <p class="card-text">
                                        <small class="text-muted">
                                            Кошка<?= $animal['breed'] ? ', ' . htmlspecialchars($animal['breed']) : '' ?>
                                        </small>
                                    </p>
                                    <p class="card-text"><?= htmlspecialchars(mb_substr($animal['description'], 0, 80)) ?>...</p>
                                </div>
                                <div class="card-footer bg-transparent border-0">
                                    <?php
                                    $age = $animal['age'];
                                    $ageSuffix = 'лет';
                                    if ($age % 100 >= 11 && $age % 100 <= 14) {
                                        $ageSuffix = 'лет';
                                    } else {
                                        switch($age % 10) {
                                            case 1: $ageSuffix = 'год'; break;
                                            case 2: case 3: case 4: $ageSuffix = 'года'; break;
                                        }
                                    }
                                    ?>
                                    <span class="badge bg-orange text-white fs-6 me-1">
                                        <?= $age ?> <?= $ageSuffix ?>
                                    </span>
                                    <span class="badge bg-orange text-white fs-6">
                                        <?= $animal['gender'] == 'male' ? 'Мальчик' : 'Девочка' ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center py-4">Пока нет кошек для встречи</div>
            <?php endif; ?>
        </div>

        <!-- Другие животные -->
        <div class="tab-pane fade" id="others" role="tabpanel">
            <?php if (!empty($animalsByType['other'])): ?>
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    <?php foreach ($animalsByType['other'] as $animal): ?>
                        <div class="col">
                            <div class="card h-100 animal-card <?= !$isAuthenticated ? 'not-authenticated' : '' ?>" 
                                 data-animal-id="<?= $animal['id'] ?>" 
                                 <?= $isAuthenticated ? 'data-bs-toggle="modal" data-bs-target="#meetingModal"' : '' ?>>
                                <img src="/images/animals/<?= !empty($animal['image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/images/animals/' . basename($animal['image'])) ? htmlspecialchars(basename($animal['image'])) : 'default.jpg' ?>" 
                                     class="card-img-top" 
                                     alt="<?= htmlspecialchars($animal['name']) ?>" 
                                     style="height: 300px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title fs-5"><?= htmlspecialchars($animal['name']) ?></h5>
                                    <p class="card-text">
                                        <small class="text-muted">
                                            Другое<?= $animal['breed'] ? ', ' . htmlspecialchars($animal['breed']) : '' ?>
                                        </small>
                                    </p>
                                    <p class="card-text"><?= htmlspecialchars(mb_substr($animal['description'], 0, 80)) ?>...</p>
                                </div>
                                <div class="card-footer bg-transparent border-0">
                                    <?php
                                    $age = $animal['age'];
                                    $ageSuffix = 'лет';
                                    if ($age % 100 >= 11 && $age % 100 <= 14) {
                                        $ageSuffix = 'лет';
                                    } else {
                                        switch($age % 10) {
                                            case 1: $ageSuffix = 'год'; break;
                                            case 2: case 3: case 4: $ageSuffix = 'года'; break;
                                        }
                                    }
                                    ?>
                                    <span class="badge bg-orange text-white fs-6 me-1">
                                        <?= $age ?> <?= $ageSuffix ?>
                                    </span>
                                    <span class="badge bg-orange text-white fs-6">
                                        <?= $animal['gender'] == 'male' ? 'Мальчик' : 'Девочка' ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center py-4">Пока нет других животных для встречи</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Модальное окно для записи -->
<div class="modal fade" id="meetingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Запись на встречу</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div id="animalDetails" class="fs-5"></div>
                    </div>
                    <div class="col-md-6">
                        <form id="meetingForm" method="POST" action="save_meeting.php" class="fs-5">
                            <input type="hidden" name="animal_id" id="animal_id">

                            <div class="mb-3">
                                <label for="meeting_date" class="form-label">Дата и время встречи (с 9:00 до 18:00, кроме воскресений)</label>
                                <input type="datetime-local" class="form-control form-control-lg" id="meeting_date" name="meeting_date" required>
                            </div>

                            <div class="mb-3">
                                <label for="purpose" class="form-label">Зачем вам питомец?</label>
                                <textarea class="form-control form-control-lg" id="purpose" name="purpose" rows="4" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="user_name" class="form-label">Ваше имя</label>
                                <input type="text" class="form-control form-control-lg" id="user_name" name="user_name"
                                    value="<?= isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : '' ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="user_phone" class="form-label">Ваш телефон</label>
                                <input type="tel" class="form-control form-control-lg" id="user_phone" name="user_phone" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-orange btn-lg py-3">Записаться на встречу</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Обработчик клика по карточкам животных
    document.querySelectorAll('.animal-card').forEach(card => {
        card.addEventListener('click', function() {
            <?php if(!$isAuthenticated): ?>
                // Для неавторизованных пользователей
                alert('Пожалуйста, зарегистрируйтесь или войдите, чтобы записаться на встречу');
                window.location.href = 'register.php';
                return;
            <?php endif; ?>
            
            const animalId = this.dataset.animalId;
            
            // Логируем просмотр
            fetch('log_animal_view.php?animal_id=' + animalId).catch(console.error);

            // Получаем данные о животном
            fetch('get_animal.php?id=' + animalId)
                .then(response => {
                    if (!response.ok) throw new Error('Network error');
                    return response.json();
                })
                .then(animal => {
                    if (animal.error) {
                        throw new Error(animal.error);
                    }

                    document.getElementById('animal_id').value = animal.id;

                    // Исправленное склонение возраста
                    const ageSuffix = (age) => {
                        if (age % 100 >= 11 && age % 100 <= 14) return 'лет';
                        switch(age % 10) {
                            case 1: return 'год';
                            case 2:
                            case 3:
                            case 4: return 'года';
                            default: return 'лет';
                        }
                    };

                    // Формируем HTML для отображения информации о животном
                    const animalDetails = document.getElementById('animalDetails');
                    animalDetails.innerHTML = `
                        <div class="card shadow-sm">
                            <img src="${animal.image_path}" class="card-img-top" alt="${animal.name}" 
                                style="height: 350px; object-fit: cover;">
                            <div class="card-body">
                                <h3 class="card-title">${animal.name}</h3>
                                <p class="card-text">
                                    <strong>Тип:</strong> ${animal.type === 'cat' ? 'Кошка' : animal.type === 'dog' ? 'Собака' : 'Другое'}<br>
                                    <strong>Порода:</strong> ${animal.breed || 'не указана'}<br>
                                    <strong>Возраст:</strong> ${animal.age} ${ageSuffix(animal.age)}<br>
                                    <strong>Пол:</strong> ${animal.gender === 'male' ? 'Мальчик' : 'Девочка'}
                                </p>
                                <p class="card-text">${animal.description || 'Описание отсутствует'}</p>
                            </div>
                        </div>
                    `;

                    // Настройка поля выбора даты и времени
                    const meetingDateInput = document.getElementById('meeting_date');
                    const now = new Date();
                    
                    // Минимальная дата - завтра
                    const tomorrow = new Date(now);
                    tomorrow.setDate(now.getDate() + 1);
                    tomorrow.setHours(0, 0, 0, 0);
                    
                    // Устанавливаем минимальную дату (завтра)
                    meetingDateInput.min = tomorrow.toISOString().slice(0, 16);
                    
                    // Функция для проверки доступности даты
                    const isDateAvailable = (date) => {
                        const day = date.getDay(); // 0 - воскресенье
                        const hours = date.getHours();
                        return day !== 0 && hours >= 9 && hours < 18;
                    };
                    
                    // Функция для поиска следующей доступной даты
                    const findNextAvailableDate = (date) => {
                        let newDate = new Date(date);
                        
                        // Если воскресенье - переходим на понедельник 9:00
                        if (newDate.getDay() === 0) {
                            newDate.setDate(newDate.getDate() + 1);
                            newDate.setHours(9, 0, 0, 0);
                        } 
                        // Если время раньше 9:00
                        else if (newDate.getHours() < 9) {
                            newDate.setHours(9, 0, 0, 0);
                        } 
                        // Если время 18:00 или позже
                        else if (newDate.getHours() >= 18) {
                            newDate.setDate(newDate.getDate() + 1);
                            newDate.setHours(9, 0, 0, 0);
                            // Если попали на воскресенье - переходим на понедельник
                            if (newDate.getDay() === 0) {
                                newDate.setDate(newDate.getDate() + 1);
                            }
                        }
                        
                        return newDate;
                    };
                    
                    // Обработчик открытия datepicker'а
                    meetingDateInput.addEventListener('focus', function() {
                        // Устанавливаем начальное значение - ближайшая доступная дата
                        const initialDate = findNextAvailableDate(new Date());
                        this.value = initialDate.toISOString().slice(0, 16);
                    });
                    
                    // Обработчик изменения даты
                    meetingDateInput.addEventListener('change', function() {
                        const selectedDate = new Date(this.value);
                        
                        if (!isDateAvailable(selectedDate)) {
                            const nextAvailable = findNextAvailableDate(selectedDate);
                            this.value = nextAvailable.toISOString().slice(0, 16);
                        }
                        
                        // Закрываем datepicker после выбора
                        setTimeout(() => this.blur(), 100);
                    });
                    
                    // Дополнительная проверка при отправке формы
                    document.getElementById('meetingForm').addEventListener('submit', function(e) {
                        const selectedDate = new Date(meetingDateInput.value);
                        
                        if (!isDateAvailable(selectedDate)) {
                            e.preventDefault();
                            alert('Пожалуйста, выберите доступную дату и время (будни, 9:00-18:00)');
                            meetingDateInput.focus();
                        }
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ошибка загрузки информации о животном: ' + error.message);
                });
        });
    });

    // Маска для телефона
    const phoneInput = document.getElementById('user_phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, '');
            let formattedValue = '';
            
            if (value.length > 0) {
                formattedValue = '+7(' + value.substring(1, 4);
            }
            if (value.length >= 4) {
                formattedValue += ')-' + value.substring(4, 7);
            }
            if (value.length >= 7) {
                formattedValue += '-' + value.substring(7, 9);
            }
            if (value.length >= 9) {
                formattedValue += '-' + value.substring(9, 11);
            }
            
            this.value = formattedValue;
        });

        // Запрет ввода нецифровых символов
        phoneInput.addEventListener('keydown', function(e) {
            // Разрешаем: backspace, delete, tab, escape, enter
            if ([46, 8, 9, 27, 13].indexOf(e.keyCode) !== -1 || 
                // Разрешаем: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                (e.keyCode === 65 && e.ctrlKey === true) || 
                (e.keyCode === 67 && e.ctrlKey === true) ||
                (e.keyCode === 86 && e.ctrlKey === true) ||
                (e.keyCode === 88 && e.ctrlKey === true) ||
                // Разрешаем: цифры на основной клавиатуре и numpad
                (e.keyCode >= 48 && e.keyCode <= 57) || 
                (e.keyCode >= 96 && e.keyCode <= 105)) {
                return;
            }
            e.preventDefault();
        });
    }
});
</script>

<?php include 'footer.php'; ?>