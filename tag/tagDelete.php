<?php
    require_once("../pdo_connect.php");
    $idList=$_POST["checkIDList"];
    $idList=json_decode($idList, true);
    // print_r($idList);
    // echo "<br>";

    foreach($idList as $idArr){
        foreach($idArr as $key=>$value){
            $id= $value;
            // echo $id;
            $stmt=$db_host->prepare("DELETE FROM tag_photo WHERE id = $id");
            $stmt1=$db_host->prepare("DELETE FROM tag WHERE img_id = $id");
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
    header("location: tag-list.php");
    // header('location: photo-tag.php?id='.$id);
?>