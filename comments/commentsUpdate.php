<?php
require_once "../pdo_connect.php";

$old_img=$_POST["old_img"];
//echo $old_img;
$id=$_POST["id"];
echo $id ."<br>";
$content=$_POST["content"];
//echo $content;
$pic=$_FILES["pic"];
//$file_name=$_FILES["pic"]["name"];
// echo $file_name;

if ($_FILES['pic']['error'] == 0){
    #如果有選擇圖片就使用新上傳的圖片
    $filename=$_FILES['pic']['name'];
    #上傳圖片
    if(move_uploaded_file($_FILES['pic']['tmp_name'], './upload/'.$filename)){
        echo "success";
    }else{
        echo "fail";
    }
  } else {
    //echo $_FILES['pic']['error'];
    #如果沒有選擇圖片就使用原本資料庫的圖片
    $filename=$old_img;
  }

// $sql = "UPDATE comments SET content=?, pic=? WHERE id = ?";
// $sql = "UPDATE comments SET pic='$filename',content='$content' WHERE id = '$id'";
$stmt = $db_host->prepare("UPDATE comments SET pic='$filename', content='$content' WHERE id = '$id'");

try{
    $stmt->execute();
    echo "更新成功";

}catch (PDOException $e){
    echo "更新失敗<br>";
    echo "Error: ".$e->getMessage()."<br>";
    exit;
}

$db_host=null; //close conn

header('location: comments-list.php');
