<?php
require_once("../../pdo_connect.php");

if (!isset($_SESSION["user"])) {
    echo "您沒有登入";
    header("location:../../login.php");
    exit();
}

$img_id=$_POST["img_id"];


$sql = "SELECT product.name AS product_name, tag.*
FROM tag
JOIN product ON tag.product_id = product.id
WHERE img_id = ?";
$stmt = $db_host->prepare($sql);
$stmt->execute([$img_id]);
$rows=$stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($rows);



?>