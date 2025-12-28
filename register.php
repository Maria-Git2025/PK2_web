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
            <h2>Регистрация</h2>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="error-message">
                    <?php 
                    if ($_GET['error'] == 'exists') {
                        echo 'Пользователь с таким логином уже существует';
                    } elseif ($_GET['error'] == 'empty') {
                        echo 'Все поля обязательны для заполнения';
                    }
                    ?>
                </div>
            <?php endif; ?>
            
            <form action="register_process.php" method="post">
                <div class="form-group">
                    <label for="login">Логин:</label>
                    <input type="text" id="login" name="login" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Пароль:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">
                </div>
                
                <div class="form-group">
                    <button type="submit" class="submit-btn">Зарегистрироваться</button>
                </div>
            </form>
            
            <div class="register-link">
                <p>Уже есть аккаунт? <a href="login.php">Войти</a></p>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>