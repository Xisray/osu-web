<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Справочник городов Киргизии</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Справочник городов Киргизии</h1>

    <div class="search-form">
        <form method="post">
            <input type="text" name="city" placeholder="Введите название города..."
                   value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : ''; ?>">
            <input type="submit" value="Найти">
        </form>
    </div>

    <?php
    // Подключаем файл с данными о городах
    require_once 'cities.php';

    // Обработка поиска города
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['city'])) {
        $searchCity = trim($_POST['city']);
        $found = false;

        // Поиск города (без учета регистра)
        foreach ($cities as $city => $info) {
            if (mb_strtolower($city) === mb_strtolower($searchCity)) {
                $found = true;
                echo '<div class="city-info">';
                echo '<h2>' . $city . '</h2>';
                echo '<p><strong>Население:</strong> ' . $info['population'] . '</p>';
                echo '<p><strong>Площадь:</strong> ' . $info['area'] . '</p>';
                echo '<p><strong>Год основания:</strong> ' . $info['founded'] . '</p>';
                echo '<p><strong>Описание:</strong> ' . $info['description'] . '</p>';
                echo '<p><strong>Достопримечательности:</strong> ' . $info['attractions'] . '</p>';
                echo '</div>';
                break;
            }
        }

        if (!$found) {
            echo '<p class="error">Город "' . htmlspecialchars($searchCity) . '" не найден в справочнике.</p>';
        }
    }
    ?>

    <div class="city-list">
        <h3>Города в справочнике:</h3>
        <ul>
            <?php foreach ($cities as $city => $info): ?>
                <li><?php echo $city; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
