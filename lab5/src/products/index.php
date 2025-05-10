<?php
require_once '../includes/header.php';
require_once '../includes/functions.php';

$products = getAllProducts();
?>

<h2>Список товаров</h2>
<a href="add.php" class="btn">Добавить товар</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Наименование</th>
            <th>Категория</th>
            <th>Поставщик</th>
            <th>Ед. изм.</th>
            <th>Цена</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
        <tr>
            <td><?= htmlspecialchars($product['product_id']) ?></td>
            <td><?= htmlspecialchars($product['product_name']) ?></td>
            <td><?= htmlspecialchars($product['category_name']) ?></td>
            <td><?= htmlspecialchars($product['supplier_name']) ?></td>
            <td><?= htmlspecialchars($product['unit']) ?></td>
            <td><?= htmlspecialchars($product['price']) ?></td>
            <td>
                <a href="edit.php?id=<?= $product['product_id'] ?>">Редактировать</a>
                <a href="delete.php?id=<?= $product['product_id'] ?>"
                   onclick="return confirm('Вы уверены?')">Удалить</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../includes/footer.php'; ?>
