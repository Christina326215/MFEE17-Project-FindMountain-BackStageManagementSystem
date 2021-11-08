<?php
require_once("../../pdo_connect.php");
$tags=$_POST["tags"];
$img_id=$_POST["img_id"];


$tags=json_decode($tags, true);

//刪除既有的 tag
$sql = "DELETE FROM `tag` WHERE `img_id` = ?";
$sth = $db_host->prepare($sql);
$sth->execute([$img_id]);

foreach($tags AS $value){
    $sql="INSERT INTO tag ( position_x , position_y, product_id, img_id) VALUES (?,?,?, ?)";
    $stmt = $db_host->prepare($sql);
    
    try{
        $stmt->execute([$value["x"], $value["y"], $value["product_id"], $img_id]);
        $row=$stmt->fetch();
    }catch(PDOException $e){
        $data=array(
            "error"=>$e
        );
        // echo json_encode($data);
        exit;
    }
}


echo json_encode($tags);


?>