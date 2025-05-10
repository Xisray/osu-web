<?php
require_once '../includes/header.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $notes = $_POST['notes'];

    if (addIncoming($product_id, $quantity, $notes)) {
        echo '<div class="alert alert-success">Приход успешно оформлен!</div>';
    } else {
        echo '<div class="alert alert-error">Ошибка при оформлении прихода</div>';
    }
}

$products = getAllProducts();
?>

<h2>Оформление прихода товара</h2>

<form method="post">
    <div class="form-group">
        <label for="product_id">Товар:</label>
        <select id="product_id" name="product_id" required>
            <option value="">Выберите товар</option>
            <?php foreach ($products as $product): ?>
            <option value="<?= $product['product_id'] ?>">
                <?= htmlspecialchars($product['product_name']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="quantity">Количество:</label>
        <input type="number" id="quantity" name="quantity" step="0.001" min="0.001" required>
    </div>

    <div class="form-group">
        <label for="notes">Примечание:</label>
        <textarea id="notes" name="notes" rows="3"></textarea>
    </div>

    <button type="submit">Оформить приход</button>
</form>

<a href="index.php">Назад к остаткам</a>

<?php require_once '../includes/footer.php'; ?>
