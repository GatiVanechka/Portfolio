<?php
/**
 * Подключение к MySQL для Open Server
 */

class DB {
    private static $instance = null;
    private $pdo;
    
    // Настройки Open Server по умолчанию
    private const DB_HOST = 'localhost';
    private const DB_NAME = 'mens_showroom'; // Ваша БД в phpMyAdmin
    private const DB_USER = 'root';          // Стандартный пользователь
    private const DB_PASS = '';              // Пароль по умолчанию пустой
    private const DB_CHARSET = 'utf8mb4';

    private function __construct() {
        try {
            $dsn = "mysql:host=" . self::DB_HOST . ";dbname=" . self::DB_NAME . ";charset=" . self::DB_CHARSET;
            $this->pdo = new PDO($dsn, self::DB_USER, self::DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
        } catch (PDOException $e) {
            error_log("DB Error: " . $e->getMessage());
            die("Ошибка подключения к базе данных. Попробуйте позже.");
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance->pdo;
    }
}