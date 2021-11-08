<?php
require_once "../pdo_connect.php";

// if(isset($_POST["content"])){
//     $content=$_POST["content"];
// }else{
//     echo "沒有帶資料";
//     exit;
// }

if($_FILES["file"]["error"]==0){
    if(move_uploaded_file($_FILES["file"]["tmp_name"], "./upload/". $_FILES["file"]["name"])){
        echo "Upload success!<br>";
    }else{
        echo "Upload fail!!<br>";
    }

}

$sql="INSERT INTO comments (user_id, pic, content, time, article_id,valid) VALUES (?,?,?,?,?,?)";
$stmt=$db_host->prepare($sql);

$file_name=$_FILES["file"]["name"];
echo $file_name; //把資料上傳到資料庫前，確認叫得出檔名
$user_id=$_POST["user_id"];
echo $user_id;
$article_id=$_POST["article_id"];
$content=$_POST["content"];
$time=date('Y-m-d H:i:s');
$valid=1;

try{
    $stmt->execute([$user_id,$file_name,$content,$time, $article_id,$valid]);
    echo "新資料已建立";

}catch (PDOException $e){
    echo "資料庫連結失敗<br>";
    echo "Error: ".$e->getMessage()."<br>";
    exit;
}

$db_host=null;

header("location:comments-list.php");

?>
