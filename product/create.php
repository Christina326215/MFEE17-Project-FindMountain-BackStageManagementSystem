<?php
require_once("../pdo_connect.php");
if (!isset($_SESSION["user"])) {
    echo "您沒有登入";
    header("location:../login.php");
    exit();
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>test</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <button type="button" class="btn btn-success header-btn" data-toggle="modal" data-target=".bd-example-modal-xl">
        新增產品
    </button>
    <!-- Modal create-->
    <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">新增產品</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
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
                            <input class="form-control-file" type="file" name="pic">
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
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="//cdn.ckeditor.com/4.16.1/full/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('introduction');

    </script>
</body>

</html>