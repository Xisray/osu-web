<?php
require_once '../includes/header.php';
require_once '../includes/functions.php';

$inventory = getInventory();
?>

<h2>Отчет по остаткам на складе</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Товар</th>
            <th>Количество</th>
            <th>Ед. изм.</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($inventory as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['product_id']) ?></td>
            <td><?= htmlspecialchars($item['product_name']) ?></td>
            <td><?= htmlspecialchars($item['quantity']) ?></td>
            <td><?= htmlspecialchars($item['unit']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../includes/footer.php'; ?>
