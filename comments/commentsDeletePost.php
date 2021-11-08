<?php
require_once "../pdo_connect.php";

$idList=$_POST["checkIDList"];
    $idList=json_decode($idList, true);
    // print_r($idList);
    // echo "<br>";

    foreach($idList as $idArr){
        foreach($idArr as $key=>$value){
            $id= $value;
            // echo $id;
            $stmt=$db_host->prepare("UPDATE comments SET valid=0 WHERE id = $id");
            $stmt1=$db_host->prepare("DELETE FROM dislike WHERE comments_id = $id");
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
    header("location: comments-list.php");
?>
 