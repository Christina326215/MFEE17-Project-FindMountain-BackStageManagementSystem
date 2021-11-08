<?php
    require_once("../../pdo_connect.php");

    $id= $_POST["id"];
    $stmt = $db_host->prepare("SELECT product.*
    , product_status.name AS status_name, product_type.name AS type_name, product_level.name AS level_name 
    FROM product
    JOIN product_status ON product.status = product_status.id
    JOIN product_type ON product.type = product_type.id
    JOIN product_level ON product.level = product_level.id
    WHERE product.id = ? ");
    // echo $id
    $stmt->execute([$id]);
    try{
        $row=$stmt->fetch();
        echo json_encode($row);
    }catch (PDOException $e){
        echo "資料連結失敗<br>";
        echo "Error".$e->getMessage()."<br>";
        exit;
    }
    $db_host=null;
?>