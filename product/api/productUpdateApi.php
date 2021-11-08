<?php
require_once("../../pdo_connect.php");
// $stmt = $db_host->prepare("SELECT * FROM product");
$id=$_POST["id"];
$stmt = $db_host->prepare("SELECT * FROM product WHERE id = ?
");
try {
    $stmt->execute([$id]);
    // $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $row=$stmt->fetch();
    echo json_encode($row);
    // print_r($row);

} catch (PDOException $e) {
    echo "資料庫連結失敗<br>";
    echo "Error" . $e->getMessage() . "<br>";
    exit;
}
?>