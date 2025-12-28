<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';
    
    if (empty($login) || empty($password)) {
        header('Location: register.php?error=empty');
        exit;
    }
    
    // Проверка существования пользователя
    $stmt = $mysql->prepare("SELECT id FROM users WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->fetch_assoc()) {
        $stmt->close();
        header('Location: register.php?error=exists');
        exit;
    }
    $stmt->close();
    
    // Создание нового пользователя
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $mysql->prepare("INSERT INTO users (login, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $login, $hashed_password, $email);
    $stmt->execute();
    
    // Автоматический вход
    $user_id = $mysql->insert_id;
    $stmt->close();
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_login'] = $login;
    
    header('Location: index.php');
    exit;
} else {
    header('Location: register.php');
    exit;
}
?>