-- Создание таблиц
CREATE TABLE categories (
    category_id SERIAL PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL,
    description TEXT
);

CREATE TABLE suppliers (
    supplier_id SERIAL PRIMARY KEY,
    supplier_name VARCHAR(100) NOT NULL,
    contact_person VARCHAR(100),
    phone VARCHAR(20),
    email VARCHAR(100)
);

CREATE TABLE products (
    product_id SERIAL PRIMARY KEY,
    product_name VARCHAR(100) NOT NULL,
    category_id INT REFERENCES categories(category_id),
    supplier_id INT REFERENCES suppliers(supplier_id),
    unit VARCHAR(20) NOT NULL,
    price DECIMAL(10, 2) NOT NULL
);

CREATE TABLE warehouse (
    warehouse_id SERIAL PRIMARY KEY,
    product_id INT REFERENCES products(product_id),
    quantity DECIMAL(10, 3) NOT NULL,
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE movements (
    movement_id SERIAL PRIMARY KEY,
    product_id INT REFERENCES products(product_id),
    movement_type VARCHAR(10) CHECK (movement_type IN ('incoming', 'outgoing')),
    quantity DECIMAL(10, 3) NOT NULL,
    movement_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    notes TEXT
);

-- Заполнение таблиц данными
INSERT INTO categories (category_name, description) VALUES
('Электроника', 'Электронные устройства и компоненты'),
('Офисные принадлежности', 'Канцелярские товары для офиса'),
('Бытовая техника', 'Техника для дома'),
('Строительные материалы', 'Материалы для строительства и ремонта'),
('Продукты питания', 'Пищевые продукты');

INSERT INTO suppliers (supplier_name, contact_person, phone, email) VALUES
('ТехноПром', 'Иванов Иван', '+79161234567', 'tech@technoprom.ru'),
('ОфисМир', 'Петрова Мария', '+79169876543', 'sales@officemir.ru'),
('ДомТехника', 'Сидоров Алексей', '+79167778899', 'info@domteh.ru'),
('СтройГрад', 'Кузнецов Дмитрий', '+79165554433', 'supply@stroigrad.ru'),
('ПродуктТорг', 'Николаева Ольга', '+79163332211', 'order@productorg.ru');

INSERT INTO products (product_name, category_id, supplier_id, unit, price) VALUES
('Ноутбук Lenovo', 1, 1, 'шт', 45000.00),
('Принтер HP', 1, 1, 'шт', 12000.00),
('Бумага А4', 2, 2, 'пачка', 300.00),
('Ручка шариковая', 2, 2, 'шт', 25.00),
('Холодильник Samsung', 3, 3, 'шт', 35000.00),
('Цемент', 4, 4, 'мешок', 400.00),
('Молоко', 5, 5, 'литр', 80.00),
('Кирпич', 4, 4, 'шт', 30.00),
('Чайник электрический', 3, 3, 'шт', 2500.00),
('Карандаш', 2, 2, 'шт', 15.00);

INSERT INTO warehouse (product_id, quantity) VALUES
(1, 5), (2, 8), (3, 20), (4, 150), (5, 3),
(6, 50), (7, 30), (8, 1000), (9, 12), (10, 200);

INSERT INTO movements (product_id, movement_type, quantity, notes) VALUES
(1, 'incoming', 10, 'Первая поставка'),
(1, 'outgoing', 5, 'Продажи'),
(2, 'incoming', 10, 'Поставка принтеров'),
(2, 'outgoing', 2, 'Продажи'),
(3, 'incoming', 30, 'Закупка бумаги'),
(3, 'outgoing', 10, 'Расход в офисе'),
(4, 'incoming', 200, 'Закупка ручек'),
(4, 'outgoing', 50, 'Выдача сотрудникам'),
(5, 'incoming', 5, 'Поставка холодильников'),
(5, 'outgoing', 2, 'Продажи');
