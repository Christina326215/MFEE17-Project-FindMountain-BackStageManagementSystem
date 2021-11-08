<?php
require_once("product_pdo_connect.php");

// $stmt=$db_host->prepare("SELECT * FROM users");
$stmt = $db_host->prepare("SELECT name, account, email, phone FROM users");


try {
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($rows);
} catch (PDOException $e) {
    echo "資料庫連結失敗<br>";
    echo "Eroor: " . $e->getMessage() . "<br>";
    exit;
}
