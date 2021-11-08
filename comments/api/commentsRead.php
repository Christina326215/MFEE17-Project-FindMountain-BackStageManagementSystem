<?php
require_once "../../pdo_connect.php";

if (!isset($_SESSION["user"])) {
    echo "您沒有登入";
    header("location:../../login.php");
    exit();
}

$id = $_POST["id"];

// $sql = "SELECT * FROM comments WHERE id = ?";

$sql = "SELECT comments.*, user.id AS users_id, user.name AS users_name, article.name AS article_name
                    FROM comments
                    JOIN article ON comments.article_id = article.id 
                    JOIN user ON comments.user_id = user.id
                    WHERE comments.valid = 1 AND comments.id = ? ";

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

