<?php
require_once '../includes/header.php';
require_once '../includes/functions.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$product = getProductById($id);

if (!$product) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'product_name' => $_POST['product_name'],
        'category_id' => $_POST['category_id'],
        'supplier_id' => $_POST['supplier_id'],
        'unit' => $_POST['unit'],
        'price' => $_POST['price']
    ];

    if (updateProduct($id, $data)) {
        echo '<div class="alert alert-success">Товар успешно обновлен!</div>';
    } else {
        echo '<div class="alert alert-error">Ошибка при обновлении товара</div>';
    }

    // Обновляем данные продукта после изменения
    $product = getProductById($id);
}

$categories = getAllCategories();
$suppliers = getAllSuppliers();
?>

<h2>Редактировать товар</h2>

<form method="post">
    <div class="form-group">
        <label for="product_name">Наименование товара:</label>
        <input type="text" id="product_name" name="product_name"
               value="<?= htmlspecialchars($product['product_name']) ?>" required>
    </div>

    <div class="form-group">
        <label for="category_id">Категория:</label>
        <select id="category_id" name="category_id" required>
            <option value="">Выберите категорию</option>
            <?php foreach ($categories as $category): ?>
            <option value="<?= $category['category_id'] ?>"
                <?= $category['category_id'] == $product['category_id'] ? 'selected' : '' ?>>
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
            <option value="<?= $supplier['supplier_id'] ?>"
                <?= $supplier['supplier_id'] == $product['supplier_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($supplier['supplier_name']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="unit">Единица измерения:</label>
        <input type="text" id="unit" name="unit"
               value="<?= htmlspecialchars($product['unit']) ?>" required>
    </div>

    <div class="form-group">
        <label for="price">Цена:</label>
        <input type="number" id="price" name="price" step="0.01" min="0"
               value="<?= htmlspecialchars($product['price']) ?>" required>
    </div>

    <button type="submit">Сохранить изменения</button>
</form>

<a href="index.php">Назад к списку</a>

<?php require_once '../includes/footer.php'; ?>
