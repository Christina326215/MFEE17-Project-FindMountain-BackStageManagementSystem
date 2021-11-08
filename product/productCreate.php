<?php
    require_once("../pdo_connect.php");

    if (!isset($_SESSION["user"])) {
        echo "您沒有登入";
        header("location:../login.php");
        exit();
    }

    // $file_name=$_FILES["pic"]["name"];
    if($_FILES["pic"]["error"]==0){
        if(move_uploaded_file($_FILES["pic"]["tmp_name"], "img/".$_FILES["pic"]["name"])){
            echo "upload success<br>";
        }else{
            echo "upload fail<br>";
        }
    }
    
    $sql="INSERT INTO product (name, price, pic, storage, sold, type, status, level, introduction) VALUES (?,?,?,?,?,?,?,?,?)";
    $stmt=$db_host->prepare($sql);

    $name=$_POST["name"];
    $price=$_POST["price"];
    $pic=$_FILES["pic"]["name"];
    $storage=$_POST["storage"];
    $sold=$_POST["sold"];
    $type= $_POST["type"];
    $status=$_POST["status"];
    $level=$_POST["level"];
    $introduction=$_POST["introduction"];


    try{
        $stmt->execute([$name, $price, $pic, $storage, $sold, $type, $status, $level, $introduction]);
        // echo "新資料已建立";
        header("location:product-list.php");
    }catch (PDOException $e){
        echo "資料連結失敗<br>";
        echo "Error".$e->getMessage()."<br>";
        exit;
    }
    $db_host=null;
?>