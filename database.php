<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'stationery_shop');

try {
    $mysql = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    if ($mysql->connect_errno) {
        throw new Exception("Не удалось подключиться к MySQL: " . $mysql->connect_error);
    }
    
    $mysql->set_charset("utf8");
    
} catch (Exception $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}
?>