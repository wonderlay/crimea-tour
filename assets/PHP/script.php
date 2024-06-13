<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'config.php';

if (isset($_GET['city']) && isset($_GET['page'])) {
    $cityId = $_GET['city'];
    $limit = 4;
    $page = (int)$_GET['page'];
    $offset = ($page - 1) * $limit;

    if ($cityId == '') {
        $stmt = $pdo->prepare('SELECT * FROM `tours` LIMIT :limit OFFSET :offset');
    } else {
        $stmt = $pdo->prepare('SELECT * FROM `tours` WHERE `city_id` = :cityId LIMIT :limit OFFSET :offset');
        $stmt->bindParam(':cityId', $cityId, PDO::PARAM_INT);
    }
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

    if ($cityId == '') {
        $totalStmt = $pdo->query('SELECT COUNT(*) FROM `tours`');
    } else {
        $totalStmt = $pdo->prepare('SELECT COUNT(*) FROM `tours` WHERE `city_id` = :cityId');
        $totalStmt->bindParam(':cityId', $cityId, PDO::PARAM_INT);
        $totalStmt->execute();
    }

    $totalItems = $totalStmt->fetchColumn();
    $totalPages = ceil($totalItems / $limit);

    echo "<div class='pagination'>";
    for ($i = 1; $i <= $totalPages; $i++) {
        echo "<a class='pagination_button' href='#' onclick='fetchTours($i)'>$i</a> ";
    }
    echo "</div>";
}
?>

