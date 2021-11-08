<?php
require_once("../pdo_connect.php");

if (!isset($_SESSION["user"])) {
    echo "您沒有登入";
    header("location:../login.php");
    exit();
}

// $stmt = $db_host->prepare("SELECT * FROM product");
$id=$_GET["id"];
$stmt = $db_host->prepare("SELECT * FROM product WHERE id = ?
");
try {
    $stmt->execute([$id]);
    // $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $row=$stmt->fetch();
    // print_r($row);

} catch (PDOException $e) {
    echo "資料庫連結失敗<br>";
    echo "Error" . $e->getMessage() . "<br>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>更新產品資料</title>
    <style>
        .product-img-edit{
            width: 200px;
            height: 200px;
        }
        form label{
            color: #006000;
        }
    </style>
    <?php require("../css.php") ?>

</head>

<body>
<div class="container-fluid">
        <div class="row">
            <div class="sticky-top navAll col-3 col-lg-2 text-white">
                <?php require("../nav-bar.php") ?>
            </div> 
            <!--name price pic storage sold type status level introduction-->

            <main class="col-lg-10">
            <?php require("../header.php") ?>
                <h3 class="h4 mt-3">編輯產品</h3>
                <hr>
                <div class="d-flex justify-content-end">
                    <a href="product-list.php" class="btn btn-success header-btn">回上一頁</a>
                </div>
                <div class="row my-3">
                    <div class="col-12">
                    <?php //foreach ($rows as $value) { ?>
                        <form action="productUpdate.php" method="post" class="px-5" enctype="multipart/form-data">
                        <div class="mb-2">
                                <!-- <label for="name">產品ID</label> -->
                                <input type="hidden"id="id" name="id" value="<?=$row["id"]?>">
                            </div>
                        <div class="mb-2">
                                <label for="name">產品名稱</label>
                                <input class="form-control" type="text" id="name" name="name" value="<?=$row["name"]?>">
                            </div>
                            <div class="mb-2">
                                <label for="price">產品價格 NT$</label>
                                <input class="form-control" type="text" id="price" name="price" value="<?=$row["price"]?>">
                            </div>
                            <div class="mb-2">
                                <label for="pic">圖片上傳</label>
                                <input class="form-control-file" type="file" name="pic" value="<?=$row["pic"]?>">
                                <figure class="product-img-edit">
                                    <input type="hidden" value="<?=$row["pic"]?>" name="old_img">
                                    <img class="contain-fit" src="img/<?=$row["pic"]?>" alt="">
                                </figure>
                            </div>
                            <div class="mb-2">
                                <label for="storage">庫存數量</label>
                                <input class="form-control" type="text" id="storage" name="storage" value="<?=$row["storage"]?>">
                            </div>
                            <div class="mb-2">
                                <label for="sold">已售出數量</label>
                                <input class="form-control" type="text" id="sold" name="sold" value="<?=$row["sold"]?>">
                            </div>
                            <div class="mb-2">
                                <label for="type">產品類型</label>
                                <!-- <input class="form-control" type="text" id="type" name="type"> -->
                                <?php if ($row["type"] == 1) { ?>
                                    <select name="type" id="type" >
                                    <option value="1" selected>鞋子</option>
                                    <option value="2">背包</option>
                                    <option value="3">衣服</option>
                                    </select>
                                <?php } ?>
                                <?php if ($row["type"] == 2) { ?>
                                    <select name="type" id="type" >
                                    <option value="1">鞋子</option>
                                    <option value="2" selected>背包</option>
                                    <option value="3">衣服</option>
                                    </select>
                                <?php } ?>
                                <?php if ($row["type"] == 3) { ?>
                                    <select name="type" id="type" >
                                    <option value="1">鞋子</option>
                                    <option value="2">背包</option>
                                    <option value="3" selected>衣服</option>
                                    </select>
                                <?php } ?>
                            </div>
                            <div class="mb-2">
                                <label for="status">上架狀態</label>
                                <!-- <input class="form-control" type="text" id="status" name="status"> -->
                                <?php if ($row["status"] == 1) { ?>
                                    <select name="status" id="status">
                                    <option value="1" selected>未上架</option>
                                    <option value="2">已上架</option>
                                    </select>
                                <?php } ?>
                                <?php if ($row["status"] == 2) { ?>
                                    <select name="status" id="status">
                                    <option value="1">未上架</option>
                                    <option value="2" selected>已上架</option>
                                    </select>
                                <?php } ?>
                            </div>
                            <div class="mb-2">
                                <label for="level">裝備等級</label>
                                <!-- <input class="form-control" type="text" id="level" name="level"> -->
                                <?php if ($row["level"] == 1) { ?>
                                    <select name="level" id="level" >
                                    <option value="1" selected>初階</option>
                                    <option value="2">中階</option>
                                    <option value="3">高階</option>
                                    </select>
                                <?php } ?>
                                <?php if ($row["level"] == 2) { ?>
                                    <select name="level" id="level" >
                                    <option value="1">初階</option>
                                    <option value="2" selected>中階</option>
                                    <option value="3">高階</option>
                                    </select>
                                <?php } ?>
                                <?php if ($row["level"] == 3) { ?>
                                    <select name="level" id="level" >
                                    <option value="1">初階</option>
                                    <option value="2">中階</option>
                                    <option value="3" selected>高階</option>
                                    </select>
                                <?php } ?>
                            </div>
                            <div class="mb-2">
                                <label for="introduction">產品介紹</label>
                                <!-- <input class="form-control" type="text" id="introduction" name="introduction" value="<?=$row["introduction"]?>"> -->
                                <?php //print_r($row["introduction"])?>
                                <textarea class="form-control" name="introduction" id="introduction" ><?=$row["introduction"]?></textarea>
                            </div>

                            <button class="btn btn-info" type="submit">更新</button>
                        </form>
                        <?php //} ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <script src="//cdn.ckeditor.com/4.16.1/full/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('introduction');
    </script>
</body>

</html>