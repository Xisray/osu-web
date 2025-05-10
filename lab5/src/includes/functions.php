<?php
require_once 'config.php';

// Функция для получения всех продуктов
function getAllProducts() {
    $pdo = getDBConnection();
    $stmt = $pdo->query("SELECT p.*, c.category_name, s.supplier_name
                         FROM products p
                         JOIN categories c ON p.category_id = c.category_id
                         JOIN suppliers s ON p.supplier_id = s.supplier_id
                         ORDER BY p.product_name");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Функция для получения информации о продукте
function getProductById($id) {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Функция для добавления продукта
function addProduct($data) {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("INSERT INTO products (product_name, category_id, supplier_id, unit, price)
                           VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([
        $data['product_name'],
        $data['category_id'],
        $data['supplier_id'],
        $data['unit'],
        $data['price']
    ]);
}

// Функция для обновления продукта
function updateProduct($id, $data) {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("UPDATE products SET
                          product_name = ?,
                          category_id = ?,
                          supplier_id = ?,
                          unit = ?,
                          price = ?
                          WHERE product_id = ?");
    return $stmt->execute([
        $data['product_name'],
        $data['category_id'],
        $data['supplier_id'],
        $data['unit'],
        $data['price'],
        $id
    ]);
}

// Функция для удаления продукта
function deleteProduct($id) {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("DELETE FROM products WHERE product_id = ?");
    return $stmt->execute([$id]);
}

// Функция для получения остатков на складе
function getInventory() {
    $pdo = getDBConnection();
    $stmt = $pdo->query("SELECT w.*, p.product_name, p.unit
                         FROM warehouse w
                         JOIN products p ON w.product_id = p.product_id
                         ORDER BY p.product_name");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Функция для добавления прихода
function addIncoming($product_id, $quantity, $notes) {
    $pdo = getDBConnection();

    // Начинаем транзакцию
    $pdo->beginTransaction();

    try {
        // Добавляем движение
        $stmt = $pdo->prepare("INSERT INTO movements (product_id, movement_type, quantity, notes)
                              VALUES (?, 'incoming', ?, ?)");
        $stmt->execute([$product_id, $quantity, $notes]);

        // Обновляем остатки на складе
        $stmt = $pdo->prepare("UPDATE warehouse SET quantity = quantity + ?
                              WHERE product_id = ?");
        $stmt->execute([$quantity, $product_id]);

        // Если продукта нет на складе, добавляем запись
        if ($stmt->rowCount() == 0) {
            $stmt = $pdo->prepare("INSERT INTO warehouse (product_id, quantity)
                                  VALUES (?, ?)");
            $stmt->execute([$product_id, $quantity]);
        }

        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}

// Функция для добавления расхода
function addOutgoing($product_id, $quantity, $notes) {
    $pdo = getDBConnection();

    // Начинаем транзакцию
    $pdo->beginTransaction();

    try {
        // Проверяем, есть ли достаточное количество
        $stmt = $pdo->prepare("SELECT quantity FROM warehouse WHERE product_id = ?");
        $stmt->execute([$product_id]);
        $current = $stmt->fetchColumn();

        if ($current < $quantity) {
            throw new Exception("Недостаточно товара на складе");
        }

        // Добавляем движение
        $stmt = $pdo->prepare("INSERT INTO movements (product_id, movement_type, quantity, notes)
                              VALUES (?, 'outgoing', ?, ?)");
        $stmt->execute([$product_id, $quantity, $notes]);

        // Обновляем остатки
        $stmt = $pdo->prepare("UPDATE warehouse SET quantity = quantity - ?
                              WHERE product_id = ?");
        $stmt->execute([$quantity, $product_id]);

        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        return $e->getMessage();
    }
}

// Функции для получения справочников
function getAllCategories() {
    $pdo = getDBConnection();
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY category_name");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllSuppliers() {
    $pdo = getDBConnection();
    $stmt = $pdo->query("SELECT * FROM suppliers ORDER BY supplier_name");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
