<?php
require_once("../pdo_connect.php");

$stmt1 = $db_host->prepare("SELECT * FROM article");

try {
    $stmt1->execute();
    $rows1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    // print_r($rows1);
} catch (PDOException $e) {
    echo "資料查詢連結失敗<br>";
    echo "Error: " . $e->getMessage() . "<br>";
    exit;
}

if (!isset($_SESSION["user"])) {
    echo "您沒有登入";
    header("location:../login.php");
    exit();
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>標籤管理</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php require("../css.php") ?>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="sticky-top navAll col-3 col-lg-2 text-white">
                <?php require("../nav-bar.php") ?>
            </div>
            <main class="col-9 col-lg-10">
                <?php require("../header.php") ?>
                <h3 class="h4 mt-3">標籤管理</h3>
                <hr>
                <div class="d-flex justify-content-end">
                <a role="button" href="" class="btn btn-success header-btn mx-2" data-toggle="modal" data-target="#picModal">上傳照片</a>
                </div>

                <!-- table文章列表start -->
                <div class="my-3">
                <table class="table table-bordered text-center align-middle table-striped" id="articleList" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>文章名稱</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows1 as $value1) { ?>
                            <tr>
                                <td class="align-middle"><?= $value1["id"] ?></td>
                                <td class="align-middle"><?= $value1["name"] ?></td>
                                <td class="align-middle d-flex justify-content-center align-items-center">
                                    <div>
                                        <a role="button" class="btn btn-outline-success mx-1 btn-sm" href="photo-tag.php?id=<?= $value1["id"] ?>">文章標籤</a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                </div>
                <!-- table文章列表end -->

                <!-- Modal 上傳照片 start -->
                <div class="modal fade" id="picModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">上傳照片</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="m-3">
                                    <form action="api/savePhoto.php" method="post" enctype="multipart/form-data">
                                        <!-- 選擇照片 -->
                                        <div class="form-group">
                                            <h6><label for="">Step1.選擇檔案：</label></h6>
                                            <input type="file" name="file" class="form-control-file">
                                        </div>

                                        <!-- 選擇文章 -->
                                        <div class="mt-5">
                                            <div class="form-group">
                                                <h6>Step2.選擇文章：</h6>
                                                <select name="selectArticle" class="form-control form-control-sm">
                                                    <?php foreach ($rows1 as $valueArticle) { ?>
                                                        <option value="<?= $valueArticle['id'] ?>"><?= $valueArticle['name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <br>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">關閉</button>
                                            <button type="submit" class="btn btn-success header-btn">送出</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal 上傳照片 end -->
            </main>
        </div>
    </div>
    </div>


    <?php require("../script.php") ?>

    <script>
        $(document).ready(function() {
            $('#articleList').DataTable({
                "infoCallback": function(settings, start, end, max, total, pre) {
                    return " 共有 " + start + " 至 " + end + " 筆訂單資料 ";
                },
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ]
            });
        });
    </script>


</body>

</html>