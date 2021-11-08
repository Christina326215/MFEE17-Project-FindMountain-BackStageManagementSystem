<?php
    require_once("../../pdo_connect.php");
    //將重新上傳的圖片存取到對應電腦資料夾中

    if (!isset($_SESSION["user"])) {
        echo "您沒有登入";
        header("location:../../login.php");
        exit();
    }

    $id=$_POST["id"]; //透過post抓id 對應axios 

    //方法一
    //join  as後面新名字
    $stmt = $db_host->prepare("SELECT article.*, article_status.name AS status_name, article_level.name AS level_name, article_mountain_type.name AS mountain_type_name ,article_apply.name AS apply_name
    FROM article
    JOIN article_status ON article.status = article_status.id
    JOIN article_level ON article.level = article_level.id
    JOIN article_mountain_type ON article.mountain_type = article_mountain_type.id
    JOIN article_apply ON article.apply = article_apply.id
    WHERE article.id = ? ");


    
    // JOIN article_season_id ON article.id= article_season_id.article_id
    // JOIN article_season ON article_season_id.id=
    

    try{
        $stmt->execute([$id]);
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        //抓單筆資料不能用fetchall不然會變抓整個物件
    }catch (PDOException $e){
        echo "資料庫更新失敗<br>";
        echo "Error: ".$e->getMessage()."<br>";
        exit;
    }

    // var_dump($rows);
    //轉成json格式
    echo json_encode($row);
    


?>
