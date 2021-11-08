<?php
require_once("../pdo_connect.php");
$sql = "UPDATE user SET password=?,name=?,phone=?,birthday=?,addr=?,level=? WHERE id=?";
$stmt = $db_host->prepare($sql);

$id = $_POST["id"];
// $password = $_POST["password"];
$name = $_POST["name"];
$phone = $_POST["phone"];
$birthday = $_POST["birthday"];
$addr = $_POST["addr"];
$level = $_POST["level"];
$password = password_hash($password, PASSWORD_DEFAULT);


try {
    $stmt->execute([$password, $name, $phone, $birthday, $addr, $level, $id]);
    $rows = $stmt->fetch();
    header("location:user-list.php");
} catch (PDOException $e) {
    echo "資料庫更新失敗<br>";
    echo "Error: " . $e->getMessage() . "<br>";
    exit;
}
$db_host = null;
