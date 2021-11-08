<?php
require_once("../../pdo_connect.php");

// $account = 'adam';
// $password = password_hash('12345', PASSWORD_DEFAULT);
$account = $_POST["account"];
$password = md5($_POST["password"]);
$sql = "SELECT * FROM log_in WHERE account = ? AND password=?";
$stmt = $db_host->prepare($sql);
$stmt->execute([$account, $password]);


try {
    $count = $stmt->rowCount();
    $row = $stmt->fetch();
    $password = $_POST['$password'];
    if (password_verify('12345', $password)) {
        echo 'Password is valid!';
    } else {
        echo 'Invalid password.';
    }
    if ($count > 0) {
        $data = array(
            "status" => 1,
            "msg" => "登入成功"
        );
        $user = array(
            "id" => $row["id"],
            "account" => $row["account"],
            "name" => $row["name"],
            "email" => $row["email"],
            "phone" => $row["phone"],
        );
        $_SESSION["user"] = $user;
    } else {
        $data = array(
            "status" => 2,
            "msg" => "登入失敗"
        );
    }
    echo json_encode($data);
} catch (PDOException $e) {
    echo "資料庫連結失敗<br>";
    echo "Eroor: " . $e->getMessage() . "<br>";
    exit;
}
