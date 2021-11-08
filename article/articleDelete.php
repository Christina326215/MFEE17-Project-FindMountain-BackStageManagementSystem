<?php
    require_once("../pdo_connect.php"); 

    $id=$_GET["id"];
    echo ($id);

    //資料庫中欄位名稱
    //刪除articel
    $sql="DELETE FROM article WHERE id='$id'";
    $stmt=$db_host->prepare($sql);
    
    //刪除article_season_id
    $stmt_season=$db_host->prepare("DELETE FROM article_season_id WHERE article_season_id.article_id='$id' ");

    //要放進資料庫的資料名稱
    try{
        //不要忘記加$id!! 雖然不能改id 但執行時還是要放進去
        $stmt->execute();
        $stmt_season->execute();
        // $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "刪除資料完成";
        // header("location:article.php?p=1");
    }catch (PDOException $e){
        echo "資料刪除失敗<br>";
        echo "Error: ".$e->getMessage()."<br>";
        exit;
    }
    
     header('location: user-list.php');

    $db_host=null;

?>