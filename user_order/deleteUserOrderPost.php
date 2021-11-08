<?php

require_once ("../pdo_connect.php");
$idList=$_POST["checkIDList"];
$idList=json_decode($idList, true);

foreach($idList as $idArr){
    foreach($idArr as $key=>$value){
        $id= $value;
        // echo $id;
        $stmt=$db_host->prepare("DELETE FROM user_order WHERE user_order.id='$id'");

        $stmt1=$db_host->prepare("DELETE FROM user_order_detail WHERE user_order_detail.user_order_id='$id'");
        try{
            $stmt->execute();
            $stmt1->execute();
            echo "資料已刪除";
        }catch(PDOException $e){
            echo "資料庫連結失敗<br>";
            echo "Error" . $e->getMessage() . "<br>";
            exit;
        }
    }
    // print_r($idArr);
    
}

$db_host=null; //close conn
header("location: userOrderList.php");
?>