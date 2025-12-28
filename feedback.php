<?php
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?error=required');
    exit;
}

$user_id = $_SESSION['user_id'];
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fio = $_POST['fio'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';
    $topic = $_POST['topic'] ?? '';
    
    if (!empty($fio) && !empty($message)) {
        $stmt = $mysql->prepare("INSERT INTO feedback (user_id, fio, email, message, topic) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $user_id, $fio, $email, $message, $topic);
        $stmt->execute();
        $stmt->close();
        $success_message = 'Ваше сообщение успешно отправлено!';
    }
}
?>

<!-- ОСНОВНОЙ КОНТЕНТ -->
<div class="main-content">
    <div class="form-container">
        <h2>Форма обратной связи</h2>
        
        <?php if ($success_message): ?>
            <div class="success-message">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        
        <form action="feedback.php" method="post">
            <div class="form-group">
                <label for="fio">ФИО:</label>
                <input type="text" id="fio" name="fio" required 
                       value="<?php echo isset($_SESSION['user_login']) ? htmlspecialchars($_SESSION['user_login']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="example@mail.com">
            </div>
            
            <div class="form-group">
                <label for="topic">Тема обращения:</label>
                <select id="topic" name="topic">
                    <option value="Вопрос">Вопрос</option>
                    <option value="Предложение">Предложение</option>
                    <option value="Жалоба">Жалоба</option>
                    <option value="Благодарность">Благодарность</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="message">Сообщение:</label>
                <textarea id="message" name="message" rows="6" required></textarea>
            </div>
            
            <div class="form-group">
                <button type="submit" class="submit-btn">Отправить</button>
            </div>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>