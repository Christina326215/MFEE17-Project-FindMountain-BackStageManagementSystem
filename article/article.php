<?php
    require_once("../pdo_connect.php");

    // if (!isset($_GET["p"])) {
    //     $p = 1;
    // } else {
    //     $p = $_GET["p"]; //設定頁碼抓取依據get p
    // }
    
    if (!isset($_SESSION["user"])) {
        echo "您沒有登入";
        header("location:../login.php");
        exit();
    }

    //join  as後面新名字
    $stmt = $db_host->prepare("SELECT article.*, article_status.name AS status_name, article_level.name AS level_name, article_mountain_type.name AS mountain_type_name ,article_apply.name AS apply_name
    FROM article
    JOIN article_status ON article.status = article_status.id
    JOIN article_level ON article.level = article_level.id
    JOIN article_mountain_type ON article.mountain_type = article_mountain_type.id
    JOIN article_apply ON article.apply = article_apply.id
    ");
    
    //季節id
    $stmt_article_season = $db_host->prepare("SELECT * FROM article_season"); //article_season先撈出來

    

    try {
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $stmt_article_season->execute();
        $rows_article_season = $stmt_article_season->fetchAll(PDO::FETCH_ASSOC);  //article_season先撈出來
    } catch (PDOException $e) {
        echo "資料庫連結失敗<br>";
        echo "Error" . $e->getMessage() . "<br>";
        exit;
    }

    // $id = $_GET["id"];
    // $stmt_article_season_id = $db_host->prepare("SELECT * FROM article_season_id WHERE article_id=?");
    // $stmt_article_season_id->execute([$id]);
    // $rows_article_season_id = $stmt_article_season_id->fetchAll(PDO::FETCH_ASSOC);
    
    // $article_season = array();
    // foreach ($rows_article_season_id as $value) {
    //     array_push($article_season, $value["season_id"]);
    // }

?>



<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>文章管理</title>
    <!-- !b5 -->
    <!-- <link rel="stylesheet" href="/article/css/bootstrap.css"> -->
    <!-- b4.3 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/8efbf3e62f.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="article.css">
    <?php require("../css.php") ?>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- 左側側邊欄開始 -->
            <div class="sticky-top navAll col-3 col-lg-2 text-white">
                <?php require("../nav-bar.php") ?>
            </div>
            <!-- 左邊側邊欄結束 -->
            <!-- 新增彈出視窗開始 -->
            <?php
            require("article-create.php");
            ?>
            <!-- 新增彈出視窗結束 -->
            <!-- checkbox刪除彈出視窗開始 -->
            <?php
            require("article-checkbox-del.php");
            ?>
            <!-- checkbox刪除彈出視窗結束 -->
            <!-- 查詢彈出視窗開始 -->
            <?php
            require("article-check.php");
            ?>
            <!-- 查詢彈出視窗結束 -->
            <!-- 編輯彈出視窗開始 -->
            <?php
            require("article-update.php");
            ?>
            <!-- 編輯彈出視窗結束 -->
            <!-- 刪除彈出視窗開始 -->
            <?php
            require("article-delete.php");
            ?>
            <!-- 刪除彈出視窗結束 -->
            <!-- 右邊表格開始 -->
            <?php
            require("article-rightbar.php");
            ?>
            <!-- 右邊表格結束 -->
            <!-- 下列表開始 -->
            
        
            <!-- 下列表結束 -->
        </div>
        <!-- 右邊欄結束 -->
    </div>
    <?php require("javascript.php"); ?>
</body>

</html>