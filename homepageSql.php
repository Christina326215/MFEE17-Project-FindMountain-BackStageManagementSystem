<?php

require_once("pdo_connect.php");


if (!isset($_SESSION["user"])) {
    echo "您沒有登入";
    header("location:login.php");
    exit();
}



//product
// $stmt = $db_host->prepare("SELECT * FROM product");
$stmtProduct = $db_host->prepare("SELECT product.*, product_status.name AS status_name, product_type.name AS type_name, product_level.name AS level_name 
FROM product
JOIN product_status ON product.status = product_status.id
JOIN product_type ON product.type = product_type.id
JOIN product_level ON product.level = product_level.id
ORDER BY id DESC ");
try {
    $stmtProduct->execute();
    $rowsProduct = $stmtProduct->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "資料庫連結失敗<br>";
    echo "Error" . $e->getMessage() . "<br>";
    exit;
}

//User
$stmtUser = $db_host->prepare("SELECT user.name,user.account, user_level.name AS user_level_name
FROM user
JOIN user_level ON user.level = user_level.id
WHERE user.valid = 1
ORDER BY user.id DESC ");
try {
    $stmtUser->execute();
    $rowsUser = $stmtUser->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "資料庫連結失敗<br>";
    echo "Error" . $e->getMessage() . "<br>";
    exit;
}

//Comments
$stmtComments = $db_host->prepare("SELECT comments.content,comments.time, article.name AS article_name
FROM comments
JOIN article ON comments.article_id = article.id
WHERE comments.valid = 1
ORDER BY comments.id DESC ");
try {
    $stmtComments->execute();
    $rowsComments = $stmtComments->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "資料庫連結失敗<br>";
    echo "Error" . $e->getMessage() . "<br>";
    exit;
}


//User_order
$stmtUser_order = $db_host->prepare("SELECT user_order.id, order_ship.name AS ship_ship, order_status.name AS order_status_name
FROM user_order
JOIN order_ship ON user_order.ship = order_ship.id
JOIN order_status ON user_order.status = order_status.id
ORDER BY user_order.id DESC ");
try {
    $stmtUser_order->execute();
    $rowsUser_order = $stmtUser_order->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "資料庫連結失敗<br>";
    echo "Error" . $e->getMessage() . "<br>";
    exit;
}

//article
$stmtArticle = $db_host->prepare("SELECT article.pic, article.name , article_status.name AS article_status_name
FROM article
JOIN article_status ON article.status = article_status.id
ORDER BY article.id DESC ");
try {
    $stmtArticle->execute();
    $rowsArticle = $stmtArticle->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "資料庫連結失敗<br>";
    echo "Error" . $e->getMessage() . "<br>";
    exit;
}

//tag
$stmtTag = $db_host->prepare("SELECT tag.position_x, tag.position_y , tag_photo.img AS tag_photo_img 
FROM tag
JOIN tag_photo ON tag.img_id = tag_photo.id
ORDER BY tag.id DESC ");
try {
    $stmtTag->execute();
    $rowsTag = $stmtTag->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "資料庫連結失敗<br>";
    echo "Error" . $e->getMessage() . "<br>";
    exit;
}



?>