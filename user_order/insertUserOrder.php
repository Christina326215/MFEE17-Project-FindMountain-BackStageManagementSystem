<?php

require_once ("../pdo_connect.php");
// require_once ("../pdo_connectProUp.php");

$time=date('Y-m-d H:i:s'); //user_order.time
$addr=$_POST["addr"]; //user_order.addr
$status=$_POST["status_name"]; //user_order.status
$ship=$_POST["ship_name"]; //user_order.ship
$pay_way=$_POST["pay_way_name"]; //user_order.pay_way
$pay_status=$_POST["pay_way_name"]; //user_order.pay_status
$invoice=$_POST["order_invoice_name"]; //user_order.invoice
$users_id=$_POST["users_id"]; //user_order.users_id
$checkList=$_POST["checkList"];//user_order_detail.product_id && num
$checkListVal=json_decode($checkList);

$stmt=$db_host->prepare("INSERT INTO user_order (time, addr, status, ship, pay_way, pay_status, invoice, user_id) VALUES(?,?,?,?,?,?,?,?)
");

try{
    $stmt->execute([$time, $addr, $status, $ship, $pay_way, $pay_status, $invoice, $users_id]);

    $user_order_id=$db_host->lastInsertId();
    // echo $user_order_id;

    foreach($checkListVal as $list){
        foreach($list as $key=>$val){
            if($key == "product"){
                $product_id=$val;
                // echo $product_id."<br>";
            }
            if($key == "number"){
                $num=$val;
                if($num == ""){
                    echo "in";
                    $num=0;
                    $product_id=0;
                }
                var_dump ("num".$num."<br>");
            }
        }
        $stmt=$db_host->prepare("INSERT INTO user_order_detail(user_order_id, num, product_id) VALUES (?, ?, ?)");
        $stmt->execute([$user_order_id, $num, $product_id]);
    }

    echo "資料已更新";
}
catch (PDOException $e){
    echo "資料庫連結失敗<br>";
    echo "Error: ".$e->getMessage(). "<br>";
    exit;
}

$db_host=null; //close conn
header("location: userOrderList.php");
?>