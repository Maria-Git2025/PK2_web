<?php
session_start();
include 'database.php';

// Проверка авторизации
$is_logged_in = isset($_SESSION['user_id']);
$current_user = null;
if ($is_logged_in) {
    $stmt = $mysql->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $current_user = $result->fetch_assoc();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Магазин канцелярии</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- ШАПКА -->
    <div class="header">
        <div class="header-content">
            <div class="logo-section">
                <h1>📝 Магазин канцелярии</h1>
            </div>
            
            <nav class="navbar">
                <a href="index.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">Главная</a>
                <a href="shop.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'shop.php') ? 'active' : ''; ?>">Магазин</a>
                <a href="about.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'about.php') ? 'active' : ''; ?>">О нас</a>
                <?php if ($is_logged_in): ?>
                    <a href="cart.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'cart.php') ? 'active' : ''; ?>">Список покупок</a>
                    <a href="feedback.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'feedback.php') ? 'active' : ''; ?>">Обратная связь</a>
                <?php endif; ?>
            </nav>
            
            <div class="auth-section">
                <?php if ($is_logged_in): ?>
                    <span class="user-info">Привет, <?php echo htmlspecialchars($current_user['login']); ?>!</span>
                    <a href="logout.php" class="logout-btn">Выйти</a>
                <?php else: ?>
                    <a href="login.php" class="login-btn">Войти</a>
                <?php endif; ?>
            </div>
        </div>
    </div>