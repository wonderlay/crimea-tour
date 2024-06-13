<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'assets/PHP/config.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./assets/css/bd.css">
    <title>Каталог Туров</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">                     
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="header_line">
                <div class="nav">
                    <a class="nav_item" href="map.html">НАЗАД</a>
                </div>
            </div>
        </div>

        <div class="catalog">
            <div class="catalog_title">Каталог Туров</div>
            <form id="cityForm" class="cityForm">
                <div for="city" class="city">Выберите город:</div>
                <select id="city" name="city" onchange="fetchTours()">
                    <option value="" class='cityOption'>Все города</option>
                    <?php
                    $stmt = $pdo->query('SELECT * FROM `cities`');
                    while ($row = $stmt->fetch()) {
                        echo "<option value=\"" . $row['id'] . "\" class='cityOption'>" . $row['name'] . "</option>";
                    }
                    ?>
                </select>
            </form>

            <div id="tours">
                <?php
                $limit = 4;
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $offset = ($page - 1) * $limit;

                $stmt = $pdo->prepare('SELECT * FROM `tours` LIMIT :limit OFFSET :offset');
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                $stmt->execute();

                while ($row = $stmt->fetch()) {
                    echo "<div class='tour'>";
                    echo "<div class='tour_holder'>";
                    echo "<div class='tour_title'>" . $row['description'] . "</div>";
                    echo "<div class='tour_desc'>Описание: " . $row['description'] . "</div>";
                    echo "<div class='tour_price'>Цена: " . $row['price'] . " руб.</div>";
                    echo "<div class='tour_duration'>Длительность: " . $row['duration'] . "</div>";
                    echo "<div class='tour_highlights'>Основные достопримечательности: " . $row['highlights'] . "</div>";
                    echo "</div>";
                    echo "<div class='tour_buttons'>";
                    echo "<div class='tour_button'>";
                    echo "<div class='tour_btn'>+7 978 722 34 45</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }

                $totalStmt = $pdo->query('SELECT COUNT(*) FROM `tours`');
                $totalItems = $totalStmt->fetchColumn();
                $totalPages = ceil($totalItems / $limit);

                echo "<div class='pagination'>";
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo "<a class='pagination_button' href='#' onclick='fetchTours($i)'>$i</a> ";
                }
                echo "</div>";
                ?>
            </div>
        </div>
    </div>

    <script src="assets/JS/script.js"></script>
</body>
</html>
