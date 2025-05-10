<?php
require_once '../includes/header.php';
require_once '../includes/functions.php';

$inventory = getInventory();
?>

<h2>Остатки на складе</h2>
<a href="incoming.php" class="btn">Приход</a>
<a href="outgoing.php" class="btn">Расход</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Товар</th>
            <th>Количество</th>
            <th>Ед. изм.</th>
            <th>Последнее обновление</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($inventory as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['product_id']) ?></td>
            <td><?= htmlspecialchars($item['product_name']) ?></td>
            <td><?= htmlspecialchars($item['quantity']) ?></td>
            <td><?= htmlspecialchars($item['unit']) ?></td>
            <td><?= htmlspecialchars($item['last_update']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../includes/footer.php'; ?>
