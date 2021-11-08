<?php
require_once("../pdo_connect.php");
$id = $_GET["id"];
// echo $id;
$stmt = $db_host->prepare("DELETE FROM user WHERE id = $id");
try {
    $stmt->execute();
    echo "資料已刪除";
    header("location:user-list.php");
} catch (PDOException $e) {
    echo "資料庫連結失敗<br>";
    echo "Error" . $e->getMessage() . "<br>";
    exit;
}
