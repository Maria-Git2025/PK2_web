<?php
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?error=required');
    exit;
}

$user_id = $_SESSION['user_id'];

// Получаем товары из корзины
$stmt = $mysql->prepare("
    SELECT c.*, p.name, p.price, p.image, p.description, p.quantity as stock_quantity
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
    ORDER BY c.created_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_items = [];
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
}
$stmt->close();

$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!-- ОСНОВНОЙ КОНТЕНТ -->
<div class="main-content">
    <h2>Список покупок</h2>
    
    <?php if (empty($cart_items)): ?>
        <div class="empty-cart">
            <p>Ваш список покупок пуст</p>
            <a href="shop.php" class="back-btn">Перейти в магазин</a>
        </div>
    <?php else: ?>
        <div class="cart-container">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Товар</th>
                        <th>Название</th>
                        <th>Цена</th>
                        <th>Количество</th>
                        <th>Сумма</th>
                        <th>Действие</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr data-product-id="<?php echo $item['product_id']; ?>">
                            <td class="cart-image-cell">
                                <img src="images/<?php echo htmlspecialchars($item['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($item['name']); ?>"
                                     onerror="this.src='images/no-image.jpg'">
                            </td>
                            <td class="cart-name-cell">
                                <strong><?php echo htmlspecialchars($item['name']); ?></strong>
                            </td>
                            <td class="cart-price-cell">
                                <?php echo number_format($item['price'], 2, '.', ' '); ?> ₽
                            </td>
                            <td class="cart-quantity-cell">
                                <button onclick="changeQuantity(<?php echo $item['product_id']; ?>, -1)" class="qty-btn">-</button>
                                <span class="quantity-display"><?php echo $item['quantity']; ?></span>
                                <button onclick="changeQuantity(<?php echo $item['product_id']; ?>, 1)" class="qty-btn">+</button>
                            </td>
                            <td class="cart-total-cell">
                                <strong><?php echo number_format($item['price'] * $item['quantity'], 2, '.', ' '); ?> ₽</strong>
                            </td>
                            <td class="cart-action-cell">
                                <button onclick="removeFromCart(<?php echo $item['product_id']; ?>)" class="remove-btn">Удалить</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="total-label"><strong>Итого:</strong></td>
                        <td class="total-amount"><strong><?php echo number_format($total, 2, '.', ' '); ?> ₽</strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    <?php endif; ?>
</div>

<script>
function changeQuantity(productId, change) {
    fetch('update_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'product_id=' + productId + '&change=' + change
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Ошибка: ' + data.message);
        }
    });
}

function removeFromCart(productId) {
    if (confirm('Удалить товар из списка покупок?')) {
        fetch('remove_from_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'product_id=' + productId
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Ошибка: ' + data.message);
            }
        });
    }
}
</script>

<?php include 'footer.php'; ?>