<?php
include 'header.php';

if (!isset($_GET['id'])) {
    header('Location: shop.php');
    exit;
}

$product_id = intval($_GET['id']);
$stmt = $mysql->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    header('Location: shop.php');
    exit;
}

// Берём характеристики
$characteristics = [];
if (!empty($product['characteristics'])) {
    $chars = explode(', ', $product['characteristics']);
    foreach ($chars as $char) {
        $parts = explode(': ', $char);
        if (count($parts) == 2) {
            $characteristics[$parts[0]] = $parts[1];
        }
    }
}
?>

<!-- ОСНОВНОЙ КОНТЕНТ -->
<div class="main-content">
    <div class="product-detail-container">
        <div class="product-detail-image">
            <img src="images/<?php echo htmlspecialchars($product['image']); ?>" 
                 alt="<?php echo htmlspecialchars($product['name']); ?>"
                 onerror="this.src='images/no-image.jpg'">
        </div>
        
        <div class="product-detail-info">
            <h1><?php echo htmlspecialchars($product['name']); ?></h1>
            
            <div class="product-price-large">
                <strong><?php echo number_format($product['price'], 2, '.', ' '); ?> ₽</strong>
            </div>
            
            <div class="product-description-full">
                <h3>Описание</h3>
                <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            </div>
            
            <div class="product-characteristics">
                <h3>Характеристики</h3>
                <table class="characteristics-table">
                    <?php if (!empty($characteristics)): ?>
                        <?php foreach ($characteristics as $key => $value): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($key); ?>:</strong></td>
                                <td><?php echo htmlspecialchars($value); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2">Характеристики не указаны</td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td><strong>Категория:</strong></td>
                        <td><?php echo htmlspecialchars($product['category']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>В наличии:</strong></td>
                        <td>
                            <?php if ($product['quantity'] > 0): ?>
                                <span class="in-stock"><?php echo $product['quantity']; ?> шт.</span>
                            <?php else: ?>
                                <span class="out-of-stock">Нет в наличии</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
            
            <?php if (isset($_SESSION['user_id']) && $product['quantity'] > 0): ?>
                <div class="add-to-cart-section">
                    <button onclick="addToCart(<?php echo $product['id']; ?>)" class="add-to-cart-btn">
                        Добавить в список покупок
                    </button>
                </div>
            <?php elseif (!isset($_SESSION['user_id'])): ?>
                <div class="login-required">
                    <p>Для добавления товара в список покупок необходимо <a href="login.php">войти</a> в систему</p>
                </div>
            <?php endif; ?>
            
            <div class="back-to-shop">
                <a href="shop.php" class="back-btn">← Вернуться в каталог</a>
            </div>
        </div>
    </div>
</div>

<script>
function addToCart(productId) {
    fetch('add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'product_id=' + productId
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Товар добавлен в список покупок!');
        } else {
            alert('Ошибка: ' + data.message);
        }
    })
    .catch(error => {
        alert('Произошла ошибка при добавлении товара');
    });
}
</script>

<?php include 'footer.php'; ?>