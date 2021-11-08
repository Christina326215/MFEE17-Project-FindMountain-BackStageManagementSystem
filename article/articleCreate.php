<?php
    require_once("../pdo_connect.php"); 

    //將上傳的圖片存取到對應電腦資料夾中
    if($_FILES["pic"]["error"]==0){
        //要放到upload資料夾 要加"./upload/"路徑 //記得改資料夾權限
        if(move_uploaded_file($_FILES["pic"]["tmp_name"], "./img/". $_FILES["pic"]["name"])){
            echo "Upload success!<br>";
        }else{
            echo "Upload fail!!<br>";
        }
    
    }

    $name=$_POST["name"];
    $status=$_POST["status"];
    $city=$_POST["city"];
    // $season=$_POST["season"];
    $time=$_POST["time"];
    $height=$_POST["height"];
    $level=$_POST["level"];
    $distance=$_POST["distance"];
    $mountain_type=$_POST["mountain_type"];
    $apply=$_POST["apply"];
    $gap=$_POST["gap"];
    $road_status=$_POST["road_status"];
    $traffic=$_POST["traffic"];
    $pic=$_FILES["pic"];
    $content=$_POST["content"];
    // print_r($_FILES);
    $file_name=$_FILES["pic"]["name"];
    // echo $file_name; 

    //季節存入其他資料表
    $season_id=$_POST["season"]; 

    $time_D=$_POST["time_D"];
    $time_H=$_POST["time_H"];
    $time_M=$_POST["time_M"];
    
    $totaltime=($time_D*60*24)+($time_H*60)+$time_M;

    //季節是複選 要存成陣列
    $sel_season=array_filter($_POST["season"]); //複選季節 array_filter()過濾空陣列
    $total_season=implode(",",$sel_season);  //implode() 函數把數組元素組合為一個字符串。 把","加入字串中 把原本為陣列的資料改為字串顯示在系統上

    // echo "total_season:" .$total_season;

    //資料庫中欄位名稱
    $sql="INSERT INTO article (name,status,city,season,time,height,level,distance,mountain_type,apply,gap,road_status,traffic,pic,content) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt=$db_host->prepare($sql); //抓取到資料庫後    


    //要放進資料庫的資料名稱
    try{

        // $stmt->execute([$name,$status,$city,$total_season,$time,$height,$level,$distance,$mountain_type,$apply,$gap,$road_status,$traffic,$file_name,$content]); 
        $stmt->execute([$name,$status,$city,$total_season,$totaltime,$height,$level,$distance,$mountain_type,$apply,$gap,$road_status,$traffic,$file_name,$content]); 
        $article_id=$db_host->lastInsertId();
        // echo $article_id."<br>";

        foreach($season_id as $value){
            // echo $value."<br>";

        $stmt_season=$db_host->prepare("INSERT INTO article_season_id(article_id, season_id) VALUES (?, ?)");
        $stmt_season->execute([$article_id,$value]);

        }

        echo "新資料已建立";
        header("location:article.php?p=1");
    }catch(PDOException $e){
        echo "資料庫連結失敗<br>";
        echo "Error: ".$e->getMessage(). "<br>";
        exit;
    }

    $db_host=null;
    // header("location:article.php");

?>