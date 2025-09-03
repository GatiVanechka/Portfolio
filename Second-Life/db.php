<?php
try {
    $host = 'localhost';
    $dbname = 'second_life';
    $username = 'root';
    $password = '';
    
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Создание таблицы users, если её нет
    $conn->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Добавим после создания таблицы users
    $conn->exec("
        CREATE TABLE IF NOT EXISTS donations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NULL,
            amount DECIMAL(10,2) NOT NULL,
            anonymous BOOLEAN DEFAULT FALSE,
            donation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            message TEXT NULL,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
        )
    ");

    // Добавим после создания таблицы donations
    $conn->exec("
    CREATE TABLE IF NOT EXISTS animals (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        type ENUM('cat', 'dog', 'other') NOT NULL,
        breed VARCHAR(100),
        age INT,
        gender ENUM('male', 'female'),
        description TEXT,
        image VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
    ");

    $conn->exec("
    CREATE TABLE IF NOT EXISTS meetings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NULL,
        animal_id INT NOT NULL,
        meeting_date DATETIME NOT NULL,
        purpose TEXT NOT NULL,
        user_name VARCHAR(100) NOT NULL,
        user_phone VARCHAR(20) NOT NULL,
        status ENUM('pending', 'confirmed', 'rejected') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
        FOREIGN KEY (animal_id) REFERENCES animals(id) ON DELETE CASCADE
    )
    ");

    // Таблица для логов
    $conn->exec("
        CREATE TABLE IF NOT EXISTS user_logs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NULL,
            action VARCHAR(50) NOT NULL,
            details TEXT,
            ip_address VARCHAR(45),
            user_agent TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
        )
    ");

    // Таблица для статистики просмотров животных
    $conn->exec("
        CREATE TABLE IF NOT EXISTS animal_views (
            id INT AUTO_INCREMENT PRIMARY KEY,
            animal_id INT NOT NULL,
            views INT DEFAULT 0,
            FOREIGN KEY (animal_id) REFERENCES animals(id) ON DELETE CASCADE
        )
    ");

    // Назначаем первого пользователя админом (если нужно)
    $conn->exec("UPDATE users SET role = 'admin' WHERE id = 1 LIMIT 1");

    // Добавим тестовых животных, если таблица пуста
    $stmt = $conn->query("SELECT COUNT(*) FROM animals");
    if($stmt->fetchColumn() == 0) {
    $animals = [
        ['Барсик', 'cat', 'Британский', 2, 'male', 'Ласковый и игривый кот', 'cat1.jpg'],
        ['Шарик', 'dog', 'Дворняга', 3, 'male', 'Добрый и верный пёс', 'dog1.jpg'],
        ['Мурка', 'cat', 'Сиамская', 1, 'female', 'Тихая и спокойная кошка', 'cat2.jpg']
    ];

    $stmt = $conn->prepare("
        INSERT INTO animals (name, type, breed, age, gender, description, image)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    foreach($animals as $animal) {
        $stmt->execute($animal);
    }
    }
    
    function logAction($conn, $action, $details = null) {
        $userId = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;
        $ip = $_SERVER['REMOTE_ADDR'];
        $agent = $_SERVER['HTTP_USER_AGENT'];
        
        $stmt = $conn->prepare("
            INSERT INTO user_logs (user_id, action, details, ip_address, user_agent)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$userId, $action, $details, $ip, $agent]);
    }

} catch(PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}
?>