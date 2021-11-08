<?php

require_once ("../pdo_connect.php");
// require_once ("../pdo_connectProUp.php");

if (!isset($_SESSION["user"])) {
    echo "您沒有登入";
    header("location:../login.php");
    exit();
}

$id=$_POST["id"];
// echo ($id);

$stmt3=$db_host->prepare("SELECT order_ship.name AS ship_name,
order_status.name AS status_name,
pay_status.name AS pay_status_name,
pay_way.name AS pay_way_name,
order_invoice.name AS order_invoice_name,
user.id AS users_id,
user_order_detail.num AS user_order_num,
product.name AS product_name,
product.pic AS product_pic,
product.price AS product_price,
user_order.* 
FROM user_order
JOIN order_ship ON user_order.ship = order_ship.id
JOIN order_status ON user_order.status = order_status.id
JOIN pay_status ON user_order.pay_status = pay_status.id
JOIN pay_way ON user_order.pay_way = pay_way.id  
JOIN order_invoice ON user_order.invoice = order_invoice.id
JOIN user ON user_order.user_id = user.id
JOIN user_order_detail ON user_order.id = user_order_detail.user_order_id
JOIN product ON user_order_detail.product_id = product.id
WHERE user_order.id='$id'
");

$stmt3->execute();

try{

    $row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
    // $row3 = $stmt3->fetch();
    echo json_encode($row3);
}
catch (PDOException $e){
    echo "資料庫連結失敗<br>";
    echo "Error: ".$e->getMessage(). "<br>";
    exit;
}

$db_host=null;
?>