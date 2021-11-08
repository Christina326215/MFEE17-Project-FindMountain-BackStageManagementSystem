<?php
require_once("../pdo_connect.php");
$sql = "INSERT INTO user (account,password,name,phone,birthday,addr,level,valid) VALUES (?,?,?,?,?,?,?,?)";
$stmt = $db_host->prepare($sql);

// $account = "mike@test.com";
// $password = "123";
// $name = "mike";
// $phone = 091111111;
// $birthday = 2019 - 03 - 01;
// $addr = "台北市";
// $level = "山神";
// $valid = 1;

$account = $_POST["account"];
// $password = $_POST["password"];
$name = $_POST["name"];
$phone = $_POST["phone"];
$birthday = $_POST["birthday"];
$addr = $_POST["addr"];
$level = $_POST["level"];
$valid = 1;
$password = password_hash($password, PASSWORD_DEFAULT);



try {
    $stmt->execute([$account, $password, $name, $phone, $birthday, $addr, $level, $valid]);
    echo json_encode($row);
    // echo "新資料已建立";
    header("location:user-list.php");
} catch (PDOException $e) {
    echo "資料庫連結失敗<br>";
    echo "Error: " . $e->getMessage() . "<br>";
    exit;
}
$db_host = null;
