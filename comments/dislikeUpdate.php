<?php
require_once "../pdo_connect.php";

$id=$_POST["id"];
echo $id."<br>";
$dislike_status=$_POST["dislike_status_name"];
echo $dislike_status."<br>";
// $comments_id=$_POST["comments_ids"];
// echo $comments_id."<br>";

    if($dislike_status==1){


        $sqlDislike = "UPDATE dislike SET dislike_status = '$dislike_status' WHERE id = '$id' ";
        $stmtDislike = $db_host->prepare($sqlDislike );
        $stmtDislike->execute();
        
        $comments_id=$_POST["comments_ids"];
        echo $comments_id."<br>";

        $sqlComments = "UPDATE comments SET valid = 0 WHERE id = '$comments_id'";
        $stmtComments = $db_host->prepare($sqlComments);
        $stmtComments->execute();

    //header('location: dislike-list.php');

    }else if($dislike_status==2 || $dislike_status==3){

        $sqlDislike = "UPDATE dislike SET dislike_status = '$dislike_status' WHERE id = '$id' ";
        $stmtDislike = $db_host->prepare($sqlDislike );
        $stmtDislike->execute();

        //header('location: dislike-list.php');
    }

try{
    //$stmtDislike->execute();
    // $stmtComments->execute();
    echo "更新成功";

}catch (PDOException $e){
    echo "更新失敗<br>";
    echo "Error: ".$e->getMessage()."<br>";
    exit;
}

$db_host=null; //close conn

header('location: dislike-list.php');
