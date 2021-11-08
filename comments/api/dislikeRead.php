<?php
require_once "../../pdo_connect.php";

if (!isset($_SESSION["user"])) {
    echo "您沒有登入";
    header("location:../../login.php");
    exit();
}

$id = $_POST["id"];

$sql = "SELECT dislike.* , dislike_status.name AS dislike_status_name, dislike_reason.name AS dislike_reason_name ,comments.id AS comments_ids,comments.content AS comments_content FROM dislike
JOIN comments ON dislike.comments_id = comments.id
JOIN dislike_status ON dislike.dislike_status = dislike_status.id
JOIN dislike_reason ON dislike.dislike_reason = dislike_reason.id
WHERE dislike.id = ? ";

$stmt = $db_host->prepare($sql);
$stmt->execute([$id]);

try {
    $row = $stmt->fetch();
    echo json_encode($row);
} catch (PDOException $e) {
    echo "資料庫查詢失敗<br>";
    echo "Error: " . $e->getMessage() . "<br>";
    exit;
}

$db_host = null; //close conn

?>

