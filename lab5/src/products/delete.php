<?php
require_once '../includes/functions.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Проверяем, есть ли товар на складе
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("SELECT quantity FROM warehouse WHERE product_id = ?");
    $stmt->execute([$id]);
    $quantity = $stmt->fetchColumn();

    if ($quantity > 0) {
        session_start();
        $_SESSION['error'] = "Нельзя удалить товар, который есть на складе";
        header("Location: index.php");
        exit;
    }

    if (deleteProduct($id)) {
        session_start();
        $_SESSION['success'] = "Товар успешно удален";
    }
}

header("Location: index.php");
exit;
?>
