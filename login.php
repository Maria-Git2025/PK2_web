<?php
include 'header.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
?>

<!-- ОСНОВНОЙ КОНТЕНТ -->
<div class="main-content">
    <div class="auth-container">
        <div class="auth-form">
            <h2>Вход в систему</h2>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="error-message">
                    <?php 
                    if ($_GET['error'] == 'invalid') {
                        echo 'Неверный логин или пароль';
                    } elseif ($_GET['error'] == 'required') {
                        echo 'Необходимо войти в систему';
                    }
                    ?>
                </div>
            <?php endif; ?>
            
            <form action="auth.php" method="post">
                <div class="form-group">
                    <label for="login">Логин:</label>
                    <input type="text" id="login" name="login" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Пароль:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="submit-btn">Войти</button>
                </div>
            </form>
            
            <div class="register-link">
                <p>Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>