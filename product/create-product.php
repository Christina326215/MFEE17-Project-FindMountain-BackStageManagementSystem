<?php
require_once("../pdo_connect.php");
if (!isset($_SESSION["user"])) {
    echo "您沒有登入";
    header("location:../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新增產品資料</title>

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
                <h3 class="h4 mt-3">新增產品</h3>
                <hr>
                <div class="d-flex justify-content-end">
                    <a href="product-list.php" class="btn btn-success header-btn">回上一頁</a>
                </div>
                <div class="row my-3">
                    <div class="col-12">
                        <form action="productCreate.php" method="post" class="px-5" enctype="multipart/form-data">
                            <div class="mb-2">
                                <label for="name">產品名稱</label>
                                <input class="form-control" type="text" id="name" name="name">
                            </div>
                            <div class="mb-2">
                                <label for="price">產品價格 NT$</label>
                                <input class="form-control" type="text" id="price" name="price">
                            </div>
                            <div class="mb-2">
                                <label for="pic">圖片上傳</label>
                                <input class="form-control" type="file" name="pic">
                            </div>
                            <div class="mb-2">
                                <label for="storage">庫存數量</label>
                                <input class="form-control" type="text" id="storage" name="storage">
                            </div>
                            <div class="mb-2">
                                <label for="sold">已售出數量</label>
                                <input class="form-control" type="text" id="sold" name="sold">
                            </div>
                            <div class="mb-2">
                                <label for="type">產品類型</label>
                                <!-- <input class="form-control" type="text" id="type" name="type"> -->
                                <select name="type" id="type">
                                    <option value="1">鞋子</option>
                                    <option value="2">背包</option>
                                    <option value="3">衣服</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="status">上架狀態</label>
                                <!-- <input class="form-control" type="text" id="status" name="status"> -->
                                <select name="status" id="status">
                                    <option value="1">未上架</option>
                                    <option value="2">已上架</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="level">裝備等級</label>
                                <!-- <input class="form-control" type="text" id="level" name="level"> -->
                                <select name="level" id="level">
                                    <option value="1">初階</option>
                                    <option value="2">中階</option>
                                    <option value="3">高階</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="introduction">產品介紹</label>
                                <!-- <input class="form-control" type="text" id="introduction" name="introduction"> -->
                                <textarea class="form-control" name="introduction" id="introduction"></textarea>
                            </div>
                            <button class="btn btn-info" type="submit">新增</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script> -->
    <script src="//cdn.ckeditor.com/4.16.1/full/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('introduction');
    </script>
</body>

</html>