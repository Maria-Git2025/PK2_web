-- Создание базы данных
CREATE DATABASE IF NOT EXISTS stationery_shop CHARACTER SET utf8 COLLATE utf8_general_ci;
USE stationery_shop;

-- Создание таблицы пользователей
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Создание таблицы продукции
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    category VARCHAR(100),
    characteristics TEXT,
    quantity INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Создание таблицы списка покупок
CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Создание таблицы обратной связи
CREATE TABLE IF NOT EXISTS feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    fio VARCHAR(200) NOT NULL,
    email VARCHAR(100),
    message TEXT NOT NULL,
    topic VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Добавление тестового пользователя
INSERT IGNORE INTO users (login, password, email) VALUES 
('admin', 'admin', 'admin@mail.ru');

-- Добавление тестовой продукции
INSERT IGNORE INTO products (name, description, price, image, category, characteristics, quantity) VALUES
('Ручка шариковая синяя', 'Качественная шариковая ручка с синими чернилами. Удобная для письма.', 25.00, 'pen_blue.jpg', 'Ручки', 'Цвет: синий, Толщина линии: 0.7мм', 150),
('Ручка шариковая черная', 'Классическая черная ручка для ежедневного использования.', 25.00, 'pen_black.jpg', 'Ручки', 'Цвет: черный, Толщина линии: 0.7мм', 200),
('Карандаш простой HB', 'Стандартный простой карандаш твердостью HB. Подходит для письма и рисования.', 15.00, 'pencil_hb.jpg', 'Карандаши', 'Твердость: HB, Длина: 17.5см', 300),
('Тетрадь 48 листов', 'Тетрадь в клетку, 48 листов. Обложка плотная, листы белые.', 45.00, 'notebook_48.jpg', 'Тетради', 'Количество листов: 48, Разлиновка: клетка', 100),
('Тетрадь 96 листов', 'Тетрадь в линейку, 96 листов. Подходит для конспектов.', 80.00, 'notebook_96.jpg', 'Тетради', 'Количество листов: 96, Разлиновка: линейка', 80),
('Линейка 30 см', 'Пластиковая линейка длиной 30 сантиметров. Прозрачная.', 30.00, 'ruler_30.jpg', 'Канцтовары', 'Длина: 30см, Материал: пластик', 120),
('Ластик белый', 'Мягкий ластик для удаления карандашных пометок. Не оставляет следов.', 20.00, 'eraser_white.jpg', 'Канцтовары', 'Цвет: белый, Размер: средний', 180),
('Маркеры цветные набор 6 шт', 'Набор цветных маркеров для выделения текста. Яркие цвета.', 120.00, 'markers_set.jpg', 'Маркеры', 'Количество: 6 штук, Цвета: разные', 60),
('Папка-файл А4', 'Папка-файл для документов формата А4. Прозрачная.', 35.00, 'folder_a4.jpg', 'Папки', 'Формат: А4, Материал: пластик', 90),
('Степлер малый', 'Небольшой степлер для скрепления документов. Вмещает до 20 скоб.', 150.00, 'stapler_small.jpg', 'Канцтовары', 'Размер: малый, Вместимость: 20 скоб', 50);
