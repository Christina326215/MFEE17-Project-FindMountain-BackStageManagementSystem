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

            $sql="DELETE FROM article WHERE id='$id'";
            $stmt=$db_host->prepare($sql);
            $stmt_season=$db_host->prepare("DELETE FROM article_season_id WHERE article_season_id.article_id='$id' ");





            // $stmt=$db_host->prepare("DELETE FROM product WHERE id = $id");
            try{
                $stmt->execute();

                $stmt_season->execute();

                echo "資料已刪除";
            }catch(PDOException $e){
                echo "資料庫連結失敗<br>";
                echo "Error" . $e->getMessage() . "<br>";
                exit;
            }
        }
        // print_r($idArr);
        
    }
    header("location: article.php");
?>