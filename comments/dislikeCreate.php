<?php
require_once "../pdo_connect.php";

if(isset($_POST["dislike_reason"])){
    $dislike_reason=$_POST["dislike_reason"];
}else{
    echo "沒有帶資料";
    exit;
}

$sql = "INSERT INTO dislike (comments_id, dislike_reason, dislike_status, dislike_time,dislike_valid) VALUES (?,?,?,?,?)";
$stmt = $db_host->prepare($sql);

$dislike_reason=$_POST["dislike_reason"];
$dislike_status=3;
$dislike_time=date('Y-m-d H:i:s');
$id=$_POST["comments_id"];
$dislike_valid=1;

try{
    $stmt->execute([$id, $dislike_reason, $dislike_status, $dislike_time,$dislike_valid]);
    echo "新資料已建立";

}catch (PDOException $e){
    echo "資料庫連結失敗<br>";
    echo "Error: ".$e->getMessage()."<br>";
    exit;
}

$db_host=null; //close conn

header("location:dislike-list.php");


?>