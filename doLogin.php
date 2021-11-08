<?php
require_once("pdo_connect.php");


// $account = "mountain";
$account = $_POST["account"];
// $password = password_hash('12345', PASSWORD_DEFAULT);
$password = $_POST["password"];
// $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
// echo $account;
// echo $password;
// $hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $db_host->prepare("SELECT * FROM log_in WHERE account = ? AND password=?");
$stmt->execute([$account, $password]);

try {
    //檢查符合Select語句的行數返回1
    $count = $stmt->rowCount();
    echo $count;
    if ($count > 0) {
        $data = array(
            "status" => 1,
            "msg" => "login sucess"
        );

        $row = $stmt->fetch();
        $user = array( //如果登入成功將以下資料存到SESSION
            "account" => $row["account"],
            "id" => $row["id"]
        );
        $_SESSION["user"] = $user;
        header("location: homepage.php");
    } else {
        //沒有匹配的行數執行 返回0
        echo $count;
        $data = array(
            "status" => 2,
            "msg" => "login fail"
        );
    }

    echo json_encode($data);
} catch (PDOException $e) {
    // echo "資料庫連結失敗<br>";
    // echo "Eroor: ".$e->getMessage(). "<br>";
    $data = array(
        "staus" => 0,
        "message" => $e->getMessage()
    );
    echo json_encode($data);
    exit;
}


// try {
//     $stmt->execute([$account, $password]);
//     $loginStatus = $stmt->rowCount();
//     if ($loginStatus === 0) {
//         if (isset($_SESSION["error"])) {
//             $times = $_SESSION["error"]["times"] + 1;
//         } else {
//             $times = 1;
//         }
//         $dataError = array(
//             "message" => "您的帳號或密碼錯誤",
//             "times" => $times
//         );
//         $_SESSION["error"] = $dataError;
//         header("location: login.php");
//     } else {
//         while ($row = $stmt->fetch()) {
//             $dataUser = array(
//                 "account" => $row["account"],
//                 "password" => $row["password"],
//             );
//             unset($_SESSION["error"]); //登入後可以清掉error
//             $_SESSION["account"] = $dataUser;
//             // echo "使用者登入完成";
//             header("location:user-list.php");
//         }
//     }
// } catch (PDOException $e) {
//     echo "資料庫連結失敗";
//     echo "Error:" . $e->getMessage() . "<br>";
//     exit;
// }
