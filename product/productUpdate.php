<?php
    require_once("../pdo_connect.php");

    if (!isset($_SESSION["user"])) {
        echo "您沒有登入";
        header("location:../login.php");
        exit();
    }

    // if($_FILES["pic"]["error"]==0){
    //     if(move_uploaded_file($_FILES["pic"]["tmp_name"], "img/".$_FILES["pic"]["name"])){
    //         echo "upload success<br>";
    //     }else{
    //         echo "upload fail<br>";
    //     }
    // }
    if ($_FILES["pic"]["error"] == 0) {
        //要放到upload資料夾 要加"./upload/"路徑 //記得改資料夾權限
        if (move_uploaded_file($_FILES["pic"]["tmp_name"], "img/" . $_FILES["pic"]["name"])) {
            echo "Upload success!<br>";
            $file_name=$_FILES["pic"]["name"];
        } else {
            echo "Upload fail!!<br>";
        }
    }else{
        $file_name=$_POST["old_img"];
    }

    // $sql="UPDATE product SET name=?, price=?, pic=?, storage=?, sold=?, type=?, status=?, level=?, introduction=? WHERE id = ?";

    $id= $_POST["id"];
    $name=$_POST["name"];
    $price=$_POST["price"];
    // $pic=$_FILES["pic"]["name"];
    $pic=$file_name;
    $storage=$_POST["storage"];
    $sold=$_POST["sold"];
    $type= $_POST["type"];
    $status=$_POST["status"];
    $level=$_POST["level"];
    $introduction=$_POST["introduction"];

    // echo $id, $name, $price, $pic, $storage, $sold, $type, $status, $level, $introduction;
    $sql="UPDATE product SET name=?, price=?, pic=?, storage=?, sold=?, type=?, status=?, level=?, introduction=? WHERE id = ?";
    $stmt= $db_host->prepare($sql);
    // print_r($stmt);


    try{
        $stmt->execute([$name, $price, $pic, $storage, $sold, $type, $status, $level, $introduction, $id]);
        // $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
        $row=$stmt->fetch();
        // print_r($rows);
        echo "修改資料完成";
        header("location: product-list.php");
    }catch (PDOException $e){
        echo "修改資料失敗<br>";
        echo "Error".$e->getMessage()."<br>";
        exit;
    }
    $db_host=null;
?>