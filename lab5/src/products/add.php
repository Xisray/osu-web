<?php
require_once '../includes/header.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'product_name' => $_POST['product_name'],
        'category_id' => $_POST['category_id'],
        'supplier_id' => $_POST['supplier_id'],
        'unit' => $_POST['unit'],
        'price' => $_POST['price']
    ];

    if (addProduct($data)) {
        echo '<div class="alert alert-success">Товар успешно добавлен!</div>';
    } else {
        echo '<div class="alert alert-error">Ошибка при добавлении товара</div>';
    }
}

$categories = getAllCategories();
$suppliers = getAllSuppliers();
?>

<h2>Добавить новый товар</h2>

<form method="post">
    <div class="form-group">
        <label for="product_name">Наименование товара:</label>
        <input type="text" id="product_name" name="product_name" required>
    </div>

    <div class="form-group">
        <label for="category_id">Категория:</label>
        <select id="category_id" name="category_id" required>
            <option value="">Выберите категорию</option>
            <?php foreach ($categories as $category): ?>
            <option value="<?= $category['category_id'] ?>">
                <?= htmlspecialchars($category['category_name']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="supplier_id">Поставщик:</label>
        <select id="supplier_id" name="supplier_id" required>
            <option value="">Выберите поставщика</option>
            <?php foreach ($suppliers as $supplier): ?>
            <option value="<?= $supplier['supplier_id'] ?>">
                <?= htmlspecialchars($supplier['supplier_name']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="unit">Единица измерения:</label>
        <input type="text" id="unit" name="unit" required>
    </div>

    <div class="form-group">
        <label for="price">Цена:</label>
        <input type="number" id="price" name="price" step="0.01" min="0" required>
    </div>

    <button type="submit">Добавить товар</button>
</form>

<a href="index.php">Назад к списку</a>

<?php require_once '../includes/footer.php'; ?>
