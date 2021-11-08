<?php
require_once("../../pdo_connect.php");
$id = $_POST["id"];

// $stmt=$db_host->prepare("SELECT * FROM users");
$stmt = $db_host->prepare("SELECT user_level.name AS level_name, user.* 
FROM user
JOIN user_level ON user.level = user_level.id
WHERE user.id = ?
");

$stmt->execute([$id]);

try {
    // $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $row = $stmt->fetch();
    echo json_encode($row);
} catch (PDOException $e) {
    echo "資料庫連結失敗<br>";
    echo "Error: " . $e->getMessage() . "<br>";
    exit;
}
