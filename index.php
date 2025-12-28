<?php
include 'header.php';

// Получаем несколько товаров для обзора
$result = $mysql->query("SELECT * FROM products ORDER BY id LIMIT 6");
$featured_products = [];
while ($row = $result->fetch_assoc()) {
    $featured_products[] = $row;
}
$result->close();
?>

<!-- ОСНОВНОЙ КОНТЕНТ -->
<div class="main-content">
    <!-- Слайд-шоу -->
    <div class="slideshow-container">
        <div class="slideshow">
            <img src="images/notebook_96.jpg" alt="Тетради" style="width:100%">
        </div>
        <div class="slideshow">
            <img src="images/pen_blue.jpg" alt="Ручки" style="width:100%">
        </div>
        <div class="slideshow">
            <img src="images/markers_set.jpg" alt="Маркеры" style="width:100%">
        </div>
        <div class="slideshow">
            <img src="images/eraser_white.jpg" alt="Ластик" style="width:100%">
        </div>
        <div class="slideshow">
            <img src="images/folder_a4.jpg" alt="Папка" style="width:100%">
        </div>
        <div class="slideshow">
            <img src="images/notebook_48.jpg" alt="Тетрадь" style="width:100%">
        </div>
        <div class="slideshow">
            <img src="images/pen_black.jpg" alt="Ручка" style="width:100%">
        </div>
        <div class="slideshow">
            <img src="images/pencil_hb.jpg" alt="Карандаш" style="width:100%">
        </div>
        <div class="slideshow">
            <img src="images/ruler_30.jpg" alt="Линейка" style="width:100%">
        </div>
        <div class="slideshow">
            <img src="images/stapler_small.jpg" alt="Степлер" style="width:100%">
        </div>
    </div>
<script>
let slideIndex = 0;
showSlides();

function showSlides() {
    let i;
    const slides = document.getElementsByClassName("slideshow");
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}
    slides[slideIndex-1].style.display = "block";
    setTimeout(showSlides, 3000);
}
</script>
    
    <div class="welcome-section">
        <h2>Добро пожаловать в наш магазин канцелярии!</h2>
        <div class="text-block">
            <p>
                Мы рады приветствовать вас в нашем интернет-магазине канцелярских товаров!
                У нас вы найдете все необходимое для учебы, работы и творчества.
                Мы предлагаем широкий ассортимент качественной канцелярии по доступным ценам.
            </p>
            <p>
                В нашем магазине представлены ручки, карандаши, тетради, папки, маркеры
                и многие другие товары для офиса и школы. Все товары проходят строгий
                контроль качества, поэтому мы гарантируем их надежность и долговечность.
            </p>
            <p>
                Мы работаем для вашего удобства и стараемся сделать покупки максимально
                простыми и приятными. Оформите заказ прямо сейчас и получите все необходимое
                для продуктивной работы и учебы!
            </p>
        </div>
    </div>

    <div class="products-overview">
        <h2>Обзор продукции</h2>
        <div class="products-grid">
            <?php foreach ($featured_products as $product): ?>
                <div class="product-card">
                    <div class="product-image">
                        <img src="images/<?php echo htmlspecialchars($product['image']); ?>" 
                             alt="<?php echo htmlspecialchars($product['name']); ?>"
                             onerror="this.src='images/no-image.jpg'">
                    </div>
                    <div class="product-info">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="product-price"><?php echo number_format($product['price'], 2, '.', ' '); ?> ₽</p>
                        <p class="product-description"><?php echo htmlspecialchars(mb_substr($product['description'], 0, 80)) . '...'; ?></p>
                        <a href="product.php?id=<?php echo $product['id']; ?>" class="view-product-btn">Подробнее</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="view-all-section">
            <a href="shop.php" class="view-all-btn">Посмотреть весь каталог</a>
        </div>
    </div>

    <div class="features-section">
        <h2>Почему выбирают нас:</h2>
        <div class="features-list">
            <div class="feature-item">
                <h3>✅ Широкий ассортимент</h3>
                <p>Более 1000 наименований товаров для учебы и офиса</p>
            </div>
            <div class="feature-item">
                <h3>💰 Доступные цены</h3>
                <p>Конкурентные цены на все товары без переплат</p>
            </div>
            <div class="feature-item">
                <h3>🚚 Быстрая доставка</h3>
                <p>Доставка по Москве в течение 1-2 дней</p>
            </div>
            <div class="feature-item">
                <h3>⭐ Качество товаров</h3>
                <p>Только проверенные производители и качественные товары</p>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>