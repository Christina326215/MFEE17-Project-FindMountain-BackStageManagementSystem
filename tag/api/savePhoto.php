<?php
require_once("../../pdo_connect.php");

$selectArticle=$_POST["selectArticle"];

if($_FILES["file"]["error"]==0){
    if(move_uploaded_file($_FILES["file"]["tmp_name"], "../img/". $_FILES["file"]["name"])){
        echo "Upload success!<br>";
    }else{
        echo "Upload fail!!<br>";
    }
}

// print_r($_FILES);
$file_name=$_FILES["file"]["name"];
echo $file_name;
$sql="INSERT INTO tag_photo (img, article_id) VALUES (?, ?)";
$stmt=$db_host->prepare($sql);

try{
    $stmt->execute([$file_name, $selectArticle]);
    echo "新資料已建立";

}catch(PDOException $e){
    echo "資料庫連結失敗<br>";
    echo "Error: ".$e->getMessage(). "<br>";
    exit;
}

header("location: ../tag-list.php");

?>