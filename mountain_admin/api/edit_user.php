<?php
// require_once("../../pdo_connect.php");
// $id = $_POST["id"];

// // $stmt=$db_host->prepare("SELECT * FROM users");
// $stmt = $db_host->prepare("SELECT * FROM user WHERE id = ?");

// $stmt->execute([$id]);

// try {
//     // $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     $row = $stmt->fetch();
//     echo json_encode($row);
//     print_r($row);
// } catch (PDOException $e) {
//     echo "資料庫連結失敗<br>";
//     echo "Error: " . $e->getMessage() . "<br>";
//     exit;
// }
?>
<?php
require_once("../../pdo_connect.php");
// $stmt = $db_host->prepare("SELECT * FROM product");
$id = $_POST["id"];
$stmt = $db_host->prepare("SELECT * FROM user WHERE id = ?
");
try {
    $stmt->execute([$id]);
    // $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $row = $stmt->fetch();
    echo json_encode($row);
    // print_r($row);

} catch (PDOException $e) {
    echo "資料庫連結失敗<br>";
    echo "Error" . $e->getMessage() . "<br>";
    exit;
}
?>
