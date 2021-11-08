<?php
require_once("../pdo_connect.php");

if (!isset($_SESSION["user"])) {
    echo "您沒有登入";
    header("location:../login.php");
    exit();
}

$sql = "SELECT comments.*, user.id AS users_id, user.name AS users_name, article.name AS article_name
                    FROM comments
                    JOIN article ON comments.article_id = article.id 
                    JOIN user ON comments.user_id = user.id
                    WHERE comments.valid = 1";
$stmt = $db_host->prepare($sql);

// $stmtComments = $db_host->prepare("SELECT * FROM comments");
// $stmtUser = $db_host->prepare("SELECT id,name FROM user");
// $stmtArticle = $db_host->prepare("SELECT id,name FROM article");

try {
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // $stmtComments->execute();
    // $rowsComments = $stmtComments->fetchAll(PDO::FETCH_ASSOC);
    // $stmtUser->execute();
    // $rowsUser = $stmtUser->fetchAll(PDO::FETCH_ASSOC);
    // $stmtArticle->execute();
    // $rowsArticle = $stmtArticle->fetchAll(PDO::FETCH_ASSOC);
    //print_r($rows) ;
} catch (PDOException $e) {
    echo "資料庫查詢失敗<br>";
    echo "Error: " . $e->getMessage() . "<br>";
    exit;
}

?>

<!doctype html>
<html lang="en">

<head>
    <title>評論管理</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php require("../css.php") ?>

    <style>
        #uploadForm1 {
            width: 200px;
            margin-top: 20px;
        }

        #uploadForm1 img {
            width: 100%;
        }

        .picture {
            width: 300px;
            margin-top: 20px;
        }

        .picture img {
            width: 100%;
        }

        embed {
            margin-top: 20px
        }

        .comments-img {
            width: 100px;
            height: 100px;
            margin: 0 auto;
        }

        .contain-fit {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }


        a {
            text-decoration: none
        }

        /* .topTitle {
            display: flex;
            text-decoration: none;
            margin: 5px 5px;
            padding: 5px 10px;
            border: 1px solid green;
            border-radius: 3px;
        } */
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="sticky-top navAll col-3 col-lg-2 text-white">
                <?php require("../nav-bar.php") ?>
            </div>
            <main class="col-9 col-lg-10">
                <?php require("../header.php") ?>

                <h3 class="h4 mt-3">評論管理</h3>

                <hr>

                <div class="d-flex justify-content-between">

                    <div class="d-flex">
                        <a role="button" class="btn btn-secondary mr-2" href="/project/comments/comments-list.php">評論列表</a>
                        <a role="button" class="btn btn-outline-secondary" href="/project/comments/dislike-list.php">檢舉列表</a>
                        <!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#comments" role="tab" aria-controls="home" aria-selected="true">評論列表</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#dislike" role="tab" aria-controls="profile" aria-selected="false">檢舉列表</a>
                                </li>
                            </ul> -->
                    </div>
                    <div>
                        <!-- delete button trigger modal -->
                        <button type="button" class="btn btn-outline-danger checkBtn mx-2" data-toggle="modal" data-target=".delete-modal-ml" disabled>
                            刪除勾選項目
                        </button>
                        <button type="button" class="btn header-btn text-white mx-2 addComments" data-toggle="modal" data-target="#exampleModalcreate">新增評論</button>
                    </div>
                </div>

                <!-- 評論列表 -->
                <!-- <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="comments" role="tabpanel" aria-labelledby="home-tab"> -->
                <div class="my-3">
                    <table id="example" class="table table-striped table-bordered text-center align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>評論ID</th>
                                <th>會員姓名</th>
                                <th>文章名稱</th>
                                <th>評論圖片</th>
                                <th>評論時間</th>
                                <th>操作</th>
                                <th><input type="checkbox" id="checkAll"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $value) { ?>
                                <tr>
                                    <td><?= $value["id"] ?></td>
                                    <td><?= $value["users_name"] ?></td>
                                    <td><?= $value["article_name"] ?></td>
                                    <td>
                                        <figure class="comments-img">
                                            <!-- <img src="upload/<?= $value["pic"] ?>" alt="<?= $value["pic"] ?>" width="150" height="100"> -->
                                            <img class="contain-fit" src="upload/<?= $value["pic"] ?>" alt="<?= $value["pic"] ?>">
                                        </figure>
                                    </td>
                                    <td><?= $value["time"] ?></td>
                                    <td>
                                        <button class="btn read btn-outline-success" data-toggle="modal" data-target="#exampleModalread" data-id="<?= $value["id"] ?>">查看</button>

                                        <button class="btn update btn-outline-info" data-toggle="modal" data-target="#exampleModalupdate" data-id="<?= $value["id"] ?>">編輯</button>
                                    </td>
                                    <td class="align-middle">
                                        <input data-id="<?= $value["id"] ?>" name="idcheck" type="checkbox" class="checkboxforDel">
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
        </div>
        <!-- <div class="tab-pane fade" id="dislike" role="tabpanel" aria-labelledby="profile-tab">...</div> -->
    </div>
    </main>
    <!-- </div>
    </div> -->


    <!-- delete Modal star-->
    <div class="modal fade delete-modal-ml" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-ml" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">刪除評論</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    是否確認刪除資料？
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success header-btn detail" data-dismiss="modal">關閉</button>
                    <form action="commentsDeletePost.php" method="POST">
                        <input type="hidden" id="checkIDList" name="checkIDList" value="">
                        <button id="deletePost" type="submit" class="btn btn-danger mx-1">刪除</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- delete Modal end-->
    <!-- 新增評論彈出視窗開始 -->
    <div class="modal fade" id="exampleModalcreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <form method="post" class="needs-validation" name="formAdd" enctype="multipart/form-data" novalidate action="commentsCreate.php">
                <?php
                require_once("../pdo_connect.php");

                $stmtComments = $db_host->prepare("SELECT * FROM comments");
                $stmtUser = $db_host->prepare("SELECT id,name FROM user WHERE valid=1");
                $stmtArticle = $db_host->prepare("SELECT id,name FROM article");

                try {
                    $stmtComments->execute();
                    $rowsComments = $stmtComments->fetchAll(PDO::FETCH_ASSOC);
                    $stmtUser->execute();
                    $rowsUser = $stmtUser->fetchAll(PDO::FETCH_ASSOC);
                    $stmtArticle->execute();
                    $rowsArticle = $stmtArticle->fetchAll(PDO::FETCH_ASSOC);
                    //print_r($rows) ;
                } catch (PDOException $e) {
                    echo "資料庫查詢失敗<br>";
                    echo "Error: " . $e->getMessage() . "<br>";
                    exit;
                }

                ?>

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">新增評論</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row" class="col-1 align-middle">會員姓名</th>
                                    <td colspan="3" class="col-5">
                                        <select class="custom-select" name="user_id" id="inputGroupSelect01" required>
                                            <option selected value="">請選擇你的會員姓名</option>
                                            <?php foreach ($rowsUser as $value) { ?>
                                                <option value="<?= $value["id"] ?>"><?= $value["name"] ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            請選擇會員姓名
                                        </div>
                                    </td>
                                    <th class="col-1 align-middle">文章名稱</th>
                                    <td colspan="3" class="col-5">
                                        <select class="custom-select" name="article_id" required>
                                            <option selected value="">請選擇文章名稱</option>
                                            <?php foreach ($rowsArticle as $value) { ?>
                                                <option value="<?= $value["id"] ?>"><?= $value["name"] ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            請選擇文章名稱
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row" class="col-1 align-middle ">照片</th>
                                    <td colspan="3" class="col-5 m-auto">
                                        <div class="mb-2">
                                            <input type="file" name="file" id="file" style="width:100%">
                                        </div>
                                        <div id="uploadForm1" class="">
                                        </div>
                                    </td>
                                    <th class="col-1 align-middle">評論內容</th>
                                    <td colspan="3" class="col-5 align-middle">
                                        <textarea class="form-control wishContent area" placeholder="請留下您想輸入的評論內容．．．留言不得超過100字" id="" style="height: 300px" name="content" required maxlength="100">
                                        </textarea>
                                        <span class="wordsNum">0/100</span>
                                        <div class="invalid-feedback">
                                            請留下您想輸入的評論內容
                                        </div>

                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">關閉</button>
                        <button name="button" class="btn header-btn text-white create" type="submit" id="create">新增</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- 新增評論彈出視窗結束 -->
    <!-- 查看評論彈跳視窗開始 -->
    <div class="modal fade" id="exampleModalread" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">查看評論</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th class=" align-middle col-1">評論ID</th>
                                <td colspan="5" class="col-5">
                                    <input class="form-control" id="id" readonly>
                                </td>

                                <th class="align-middle col-1">評論時間</th>
                                <td colspan="5" class="col-5">
                                    <input class="form-control" id="time" readonly>
                                </td>
                            </tr>
                            <tr>
                                <th class=" align-middle col-1">會員姓名</th>
                                <td colspan="5" class="col-5">
                                    <input class="form-control" id="users_name" readonly>
                                </td>
                                <th class=" align-middle col-1">文章名稱</th>
                                <td colspan="5" class="col-5">
                                    <input class="form-control" id="article_name" readonly>
                                </td>
                            </tr>

                            <tr>
                                <th class=" align-middle col-1">照片</th>
                                <td colspan="5" class="col-5 align-middle">
                                    <figure class="picture m-auto">
                                        <img src="" alt="" id="pic" class="">
                                    </figure>
                                </td>
                                <th class=" align-middle col-1">評論內容</th>
                                <td colspan="5" class="col-5 align-middle">
                                    <textarea class="form-control" id="content" style="height: 200px" readonly></textarea>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">關閉</button>
                    <button class="btn header-btn text-white my-2 dislike" data-toggle="modal" data-target="#exampleModaldislike" id="dislike">檢舉</button>
                </div>
            </div>
        </div>
    </div>
    <!-- 查看評論結束 -->
    <!-- 編輯評論彈出視窗開始 -->
    <div class="modal fade" id="exampleModalupdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <form method="post" class="needs-validation" name="formAdd" id="articleAdd" enctype="multipart/form-data" novalidate action="commentsUpdate.php">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">編輯評論</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class=" align-middle col-1">評論ID</th>
                                    <td colspan="5" class="col-5">
                                        <input type="hidden" name="id" id="idUpdatehidden">
                                        <input type="text" class="form-control" id="idUpdate" readonly>
                                    </td>

                                    <th class="align-middle col-1">評論時間</th>
                                    <td colspan="5" class="col-5">
                                        <input class="form-control" id="timeUpdate" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th class=" align-middle col-1">會員姓名</th>
                                    <td colspan="5" class="col-5">
                                        <input type="text" class="form-control" name="users_name" id="user_nameUpdate" readonly>
                                    </td>
                                    <th class=" align-middle col-1">文章名稱</th>
                                    <td colspan="5" class="col-5">
                                        <input class="form-control" name="article_name" id="article_nameUpdate" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th class=" align-middle col-1 m-auto">照片</th>
                                    <td colspan="5" class="col-5 align-middle m-auto">
                                        <input type="file" name="pic" id="file" accept=".png, .jpg, .jpeg" style="width:100%">
                                        <input type="hidden" name="old_img" id="old_imgUpdate">
                                        <div class="picture">
                                            <img src="" alt="" id="picUpdate">
                                        </div>
                                    </td>
                                    <th class=" align-middle col-1">評論內容</th>
                                    <td colspan="5" class="col-5 align-middle">
                                        <textarea class="form-control wishContent edit" placeholder="Leave a comment here" id="contentUpdate" style="height: 200px" name="content" maxlength="100" required></textarea>
                                        <span class="wordsNum">0/100</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">關閉</button>
                        <button name="button" class="btn header-btn text-white" type="submit">更新</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- 編輯評論彈出視窗結束 -->
    <!-- 檢舉評論彈跳視窗開始 -->
    <div class="modal fade" id="exampleModaldislike" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">檢舉評論</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="dislikeCreate.php" method="post">
                        <table class="col-md-12 table table-bordered">
                            <tr>
                                <th class="col-1 align-middle">評論ID</th>
                                <td colspan="3" class="col-7">
                                    <input type="text" class="form-control" id="idDislike" readonly>
                                    <input type="hidden" name="comments_id" id="idDislikehidden">
                                </td>
                            </tr>
                            <tr>
                                <th class="col-1 align-middle">檢舉原因</th>
                                <td colspan="3" class="col-7">
                                    <select class="custom-select" name="dislike_reason" required>
                                        <option selected value="">請選擇檢舉原因</option>
                                        <option value="1">垃圾內容</option>
                                        <option value="2">騷擾內容</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        請選擇檢舉原因
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">關閉</button>
                            <button class="btn header-btn text-white my-2" data-toggle="modal" data-target="#exampleModal1">檢舉</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- 檢舉評論彈跳視窗結束 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src=" https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!--bs-custom-file-input-->
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
    <!--axios-->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        function filePreview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#uploadForm1 img').remove();
                    $('#uploadForm1').append('<img src="' + e.target.result + '" />');

                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#file").change(function() {
            filePreview(this);
        })
    </script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {

                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        } else {
                            // alert("新增完成");
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        // $("textarea").on("keyup", function() {
        //     var textLength = $("textarea").val().length;
        //     var numLength = 500 - textLength;
        //     $(".takeTip span").text(numLength);
        // })


        $(".addComments").click(function() {
            var userDesc = "";
            console.log(userDesc);

            //判斷字數
            var len;

            len = checkStrLengths(userDesc, 100);

            console.log(len);
            //顯示字數
            $(".wordsNum").html(len + '/100');
        })

        $(".area").val("");

        //封裝一個限制字數方法
        var checkStrLengths = function(str, maxLength) {
            var maxLength = maxLength;
            var result = 0;
            if (str && str.length > maxLength) {
                result = maxLength;
            } else {
                result = str.length;
            }
            return result;
        }

        $(".wishContent").on('input propertychange', function() {

            //獲取輸入內容
            var userDesc = $(this).val();

            //判斷字數
            var len;
            if (userDesc) {
                len = checkStrLengths(userDesc, 100);
            } else {
                len = 0
            }

            //顯示字數
            $(".wordsNum").html(len + '/100');
        });

        //監聽輸入
    </script>


    <script>
        //  datatable
        $(document).ready(function() {
            $('#example').DataTable({

                "infoCallback": function(settings, start, end, max, total, pre) {
                    return " 共有 " + start + " 至 " + end + " 筆訂單資料 ";
                }, //datatables infoCallback 設定共幾筆筆數

                "lengthMenu": [5, 10, 25, 50, "All"], // datatables lengthMenu 設定頁面筆數
                "lengthMenu": [5, 10, 25, 50, "All"], // datatables lengthMenu 設定頁面筆數
                "columnDefs": [{
                        "orderable": false,
                        "targets": [2, 3, 5, 6]
                    },
                    {
                        "orderable": true,
                        "targets": [0, 1, 3, 4]
                    }
                ]
            });
        });

        //查看評論
        $(".read").click(function() {
            let id = $(this).data("id");
            let formdata = new FormData();
            formdata.append("id", id);

            axios.post('api/commentsRead.php', formdata)
                .then(function(response) {
                    console.log(response);
                    let data = response.data
                    //console.log(data)
                    $("#id").val(data.id)
                    $("#users_name").val(data.users_name)
                    $("#time").val(data.time)
                    $("#article_name").val(data.article_name)
                    $("#pic").attr('src', `upload/${data.pic}`)
                    $("#content").val(data.content)
                    $("#idDislike").val(data.id)
                    $("#idDislikehidden").val(data.id)
                    //console.log(data.article_name)
                })
                .catch(function(err) {
                    console.log(err);
                });
        })

        //編輯評論
        $(".update").click(function() {
            let id = $(this).data("id");
            let formdata = new FormData();
            formdata.append("id", id);

            axios.post('api/commentsRead.php', formdata)
                .then(function(response) {
                    console.log(response);
                    let data = response.data
                    console.log(data)
                    $("#idUpdatehidden").val(data.id)
                    $("#idUpdate").val(data.id)
                    $("#user_nameUpdate").val(data.users_name)
                    $("#timeUpdate").val(data.time)
                    $("#article_nameUpdate").val(data.article_name)
                    $("#picUpdate").attr('src', `upload/${data.pic}`)
                    $("#old_imgUpdate").val(data.pic)
                    $("#contentUpdate").val(data.content)

                    var userDesc = data.content;
                    console.log(userDesc);

                    //判斷字數
                    var len;
                    if (userDesc) {
                        len = checkStrLengths(userDesc, 100);
                    } else {
                        len = checkStrLengths(userDesc, 100);
                    }
                    console.log(len);
                    //顯示字數
                    $(".wordsNum").html(len + '/100');
                })
                .catch(function(err) {
                    console.log(err);
                });
        })

        //查看評論彈跳視窗關閉，檢舉評論彈跳視窗跳出
        $("#dislike").on("click", function() {
            $("#exampleModalread").modal("hide");
            $("#exampleModaldislike").modal("show");
        });

        $(".dislike").click(function() {
            let id = $(this).data("id");
            let formdata = new FormData();
            formdata.append("id", id);

            axios.post('api/commentsRead.php', formdata)
                .then(function(response) {
                    console.log(response);
                    let data = response.data
                    console.log(data)
                    $("#idUpdate").val(data.id)
                    $("#user_nameUpdate").val(data.users_name)
                    // $("#timeUpdate").val(data.time)
                    $("#article_nameUpdate").val(data.article_name)
                    // $("#picUpdate").attr('src', `upload/${data.pic}`)
                    $("#contentUpdate").val(data.content)
                })
                .catch(function(err) {
                    console.log(err);
                });
        })


        //全選
        $("#checkAll").click(function() {
            let checked = $(this).prop("checked")
            $("tbody :checkbox").prop("checked", checked)

            let checkLength = $('.checkboxforDel').filter(':checked').length
            // console.log(checkLength)
            if (checkLength > 0) {
                $('.checkBtn').removeAttr('disabled'); //enable input
            } else {
                $('.checkBtn').attr('disabled', true); //disable input
            }

        })
        //防止未勾選資料卻按刪除鍵
        $(".checkboxforDel").click(function() {
            let checkLength = $('.checkboxforDel').filter(':checked').length
            // console.log(checkLength)
            if (checkLength > 0) {
                $('.checkBtn').removeAttr('disabled'); //enable input
            } else {
                $('.checkBtn').attr('disabled', true); //disable input
            }
        })
        //checkbox delete
        $("#deletePost").click(function() {
            //   console.log("click")
            let checkArr = [];
            $("input[name='idcheck']:checked").each(function() {
                let id = $(this).data("id")
                checkArr.push({
                    id: id
                });
            })
            let checkString = JSON.stringify(checkArr)
            console.log(checkString)
            $("#checkIDList").val(checkString)
        })

        // $(".create").click(function(){
        //     alert("新增完成");
        // })
    </script>
</body>

</html>