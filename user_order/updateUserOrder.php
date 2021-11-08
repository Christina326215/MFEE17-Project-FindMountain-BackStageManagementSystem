<?php

require_once ("../pdo_connect.php");
// require_once ("../pdo_connectProUp.php");

$id=$_POST["id"]; //user_order.id
// echo $id;
$addr=$_POST["addr"]; //user_order.addr
$status=$_POST["status_name"]; //user_order.status
$ship=$_POST["ship_name"]; //user_order.ship
$pay_way=$_POST["pay_way_name"]; //user_order.pay_way
$pay_status=$_POST["pay_status_name"]; //user_order.pay_status
$invoice=$_POST["order_invoice_name"]; //user_order.invoice
// $num=$_POST["num"]; //user_order.num

$stmt=$db_host->prepare("UPDATE user_order SET addr='$addr', status='$status', ship='$ship', pay_way='$pay_way', pay_status='$pay_status', invoice='$invoice' WHERE id='$id'
");

try{
    $stmt->execute();
    // while($row=$stmt->fetch()){
    //     var_dump($row);
    //     echo "<br>";
    // }
    echo "資料已更新";
    // print_r($rows);
}
catch (PDOException $e){
    echo "資料庫連結失敗<br>";
    echo "Error: ".$e->getMessage(). "<br>";
    exit;
}

$db_host=null; //close conn
header("location: userOrderList.php");
?>