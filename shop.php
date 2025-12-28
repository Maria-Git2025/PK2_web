<?php
include 'header.php';

// Получаем все товары
$result = $mysql->query("SELECT * FROM products ORDER BY name");
$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}
$result->close();
?>

<!-- ОСНОВНОЙ КОНТЕНТ -->
<div class="main-content">
    <h2>Каталог продукции</h2>
    
    <div class="products-table-container">
        <table class="products-table">
            <thead>
                <tr>
                    <th>Изображение</th>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Цена</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td class="product-image-cell">
                            <img src="images/<?php echo htmlspecialchars($product['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>"
                                 onerror="this.src='images/no-image.jpg'"
                                 class="table-product-image">
                        </td>
                        <td class="product-name-cell">
                            <strong><?php echo htmlspecialchars($product['name']); ?></strong>
                        </td>
                        <td class="product-description-cell">
                            <?php echo htmlspecialchars(mb_substr($product['description'], 0, 100)); ?>
                            <?php if (mb_strlen($product['description']) > 100) echo '...'; ?>
                        </td>
                        <td class="product-price-cell">
                            <strong><?php echo number_format($product['price'], 2, '.', ' '); ?> ₽</strong>
                        </td>
                        <td class="product-action-cell">
                            <a href="product.php?id=<?php echo $product['id']; ?>" class="view-details-btn">
                                Подробнее
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>