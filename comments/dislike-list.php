<?php
require_once("../pdo_connect.php");

if (!isset($_SESSION["user"])) {
    echo "您沒有登入";
    header("location:../login.php");
    exit();
}

$sql = "SELECT dislike.* , dislike_status.name AS dislike_status_name, dislike_reason.name AS dislike_reason_name ,comments.id AS comments_ids,comments.content AS comments_content FROM dislike
JOIN comments ON dislike.comments_id = comments.id
JOIN dislike_status ON dislike.dislike_status = dislike_status.id
JOIN dislike_reason ON dislike.dislike_reason = dislike_reason.id
WHERE dislike.dislike_valid = 1";
$stmt = $db_host->prepare($sql);

try {
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "資料庫查詢失敗<br>";
    echo "Error: " . $e->getMessage() . "<br>";
    exit;
}

//$db_host = null; //close conn

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
        #uploadForm {
            width: 100%;
        }

        /* img,
        embed {
            margin-top: 20px
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
                        <a role="button" class="btn btn-outline-secondary mr-2" href="/project/comments/comments-list.php">評論列表</a>
                        <a role="button" class="btn btn-secondary" href="/project/comments/dislike-list.php">檢舉列表</a>
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
                        <button type="button" class="btn header-btn text-white dislike mx-2" data-toggle="modal" data-target="#exampleModaldislike" data-id="<?= $value["id"] ?>">新增檢舉</button>
                    </div>
                </div>
                <!-- 檢舉列表 -->
                <div class="my-3">
                    <table id="example" class="table table-striped table-bordered text-center align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>檢舉ID</th>
                                <th>被檢舉的評論ID</th>
                                <th>被檢舉原因</th>
                                <th>被檢舉狀態</th>
                                <th>被檢舉時間</th>
                                <th>操作</th>
                                <th><input type="checkbox" id="checkAll"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $value) { ?>
                                <tr>
                                    <td><?= $value["id"] ?></td>
                                    <td><?= $value["comments_ids"] ?></td>
                                    <td><?= $value["dislike_reason_name"] ?></td>
                                    <td><?= $value["dislike_status_name"] ?></td>
                                    <td><?= $value["dislike_time"] ?></td>
                                    <td>
                                        <button class="btn btn-outline-success read" data-toggle="modal" data-target="#exampleModalread" data-id="<?= $value["id"] ?>">查看</button>

                                        <button class="btn btn-outline-info update" data-toggle="modal" data-target="#exampleModalupdate" data-id="<?= $value["id"] ?>">編輯</button>

                                        <!-- <a class="btn btn-outline-danger" href="dislikeDelete.php?id=<?= $value["id"] ?>">刪除</a> -->
                                    </td>
                                    <td class="align-middle">
                                        <input data-id="<?= $value["id"] ?>" name="idcheck" type="checkbox" class="checkboxforDel">
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
    <!-- delete Modal star-->
    <div class="modal fade delete-modal-ml" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-ml" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">刪除檢舉</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    是否確認刪除資料？
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success header-btn detail" data-dismiss="modal">關閉</button>
                    <form action="dislikeDeletePost.php" method="POST">
                        <input type="hidden" id="checkIDList" name="checkIDList" value="">
                        <button id="deletePost" type="submit" class="btn btn-danger mx-1">刪除</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- delete Modal end-->
    <!-- 新增檢舉評論彈跳視窗開始 -->
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
                    <form action="dislikeCreate.php" class="needs-validation" novalidate method="post">
                        <?php
                        require_once("../pdo_connect.php");

                        $stmtComments = $db_host->prepare("SELECT * FROM comments WHERE valid = 1");

                        try {
                            $stmtComments->execute();
                            $rowsComments = $stmtComments->fetchAll(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                            echo "資料庫查詢失敗<br>";
                            echo "Error: " . $e->getMessage() . "<br>";
                            exit;
                        }

                        ?>
                        <div class="modal-body">
                            <table class="col-md-12 table table-bordered">
                                <tr>
                                    <th class="col-1 align-middle">評論內容</th>
                                    <td colspan="3" class="col-7">
                                        <select class="custom-select" name="comments_id" required>
                                            <option selected value="">請選擇要檢舉的評論內容</option>
                                            <?php foreach ($rowsComments as $value) { ?>
                                                <option value="<?= $value["id"] ?>"><?= $value["content"] ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            請選擇要檢舉的評論內容
                                        </div>
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
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">關閉</button>
                            <button class="btn header-btn text-white my-2" data-toggle="modal" data-target="#exampleModal1">新增</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- 新增檢舉評論彈跳視窗結束 -->
    <!-- 查看檢舉 -->
    <div class="modal fade" id="exampleModalread" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">查看檢舉</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th class=" align-middle col-1">檢舉的id</th>
                                <td colspan="3" class="col-5">
                                    <input type="text" class="form-control" id="idRead" readonly>
                                </td>
                                <th class=" align-middle col-1">檢舉時間</th>
                                <td colspan="3" class="col-5">
                                    <input type="text" class="form-control" id="dislike_time" readonly>
                                </td>
                            </tr>
                            <tr>
                                <th class=" align-middle col-1">被檢舉的評論id</th>
                                <td colspan="3" class="col-5">
                                    <input class="form-control" id="comments_idsRead" readonly>
                                </td>
                                <th class=" align-middle col-1">檢舉狀態</th>
                                <td colspan="3" class="col-5">
                                    <input type="text" class="form-control" id="dislike_status_name" readonly>
                                </td>
                            </tr>
                            <tr>
                                <th class=" align-middle col-1">被檢舉的評論內容</th>
                                <td colspan="3" class="col-5">
                                    <textarea class="form-control" id="comments_content" style="height: 180px" readonly></textarea>
                                </td>
                                <th class=" align-middle col-1">檢舉原因</th>
                                <td colspan="3" class="col-5">
                                    <input type="text" class="form-control" name="user_id" id="dislike_reason_name" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">關閉</button>
                </div>
            </div>
        </div>
    </div>
    <!-- 查看檢舉結束 -->
    <!-- 編輯檢舉 -->
    <div class="modal fade" id="exampleModalupdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <form action="dislikeUpdate.php" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">編輯檢舉</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <!-- dislike id -->
                            <input type="hidden" name="id" id="idUpdatehidden">
                            <!-- comments id -->
                            <input type="hidden" name="comments_ids" id="comments_idUpdatehidden">
                            <tbody>
                                <tr>
                                    <th class=" align-middle col-1">檢舉的id</th>
                                    <td colspan="3" class="col-5">
                                        <input type="text" class="form-control" id="idUpdate" readonly>
                                    </td>
                                    <th class=" align-middle col-1">檢舉時間</th>
                                    <td colspan="3" class="col-5">
                                        <input type="text" class="form-control" id="dislike_timeUpdate" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th class=" align-middle col-1">被檢舉的評論id</th>
                                    <td colspan="3" class="col-5">
                                        <input class="form-control" id="comments_idsUpdate" readonly>
                                    </td>
                                    <th class=" align-middle col-1">檢舉狀態</th>
                                    <td colspan="3" class="col-5">
                                        <select name="dislike_status_name" id="dislike_statusUpdate" class="form-control" required>
                                            <option value="1">檢舉成立</option>
                                            <option value="2">檢舉不成立</option>
                                            <option value="3">被檢舉</option>
                                        </select>

                                    </td>
                                </tr>
                                <tr>
                                    <th class=" align-middle col-1">被檢舉的評論內容</th>
                                    <td colspan="3" class="col-5">
                                        <textarea class="form-control" id="comments_contentUpdate"  style="height: 180px" readonly></textarea>
                                    </td>
                                    <th class=" align-middle col-1">檢舉原因</th>
                                    <td colspan="3" class="col-5">
                                        <input type="text" class="form-control" id="dislike_reason_nameUpdate" readonly>
                                    </td>
                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">關閉</button>
                        <button name="button" class="btn header-btn text-white" type="submit" data-toggle="modal" data-target=".update-modal-ml">更新</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- 編輯檢舉結束 -->
    <!-- update Modal star-->
    <!-- <div class="modal fade update-modal-ml" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-ml" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">刪除檢舉</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    是否確認更新資料？
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success header-btn detail" data-dismiss="modal">關閉</button>
                    <form action="dislikeUpdate.php" method="POST">
                        <input type="hidden" name="id" id="idUpdatehidden"> 
                        <input type="hidden" name="comments_ids" id="comments_idUpdatehidden">
                        <input type="hidden" id="dislike_statusUpdatehidden" name="dislike_status_name">
                        <button type="submit" class="btn btn-danger mx-1">更新</button>
                    </form>
                </div>
            </div>
        </div>
    </div> -->
    <!-- delete Modal end-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src=" https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!--bs-custom-file-input-->
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
    <!--axios-->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <!--ckeditor-->
    <script src="//cdn.ckeditor.com/4.16.1/full/ckeditor.js"></script>
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
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>

    <script>
        function filePreview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#uploadForm+img').remove();
                    $('#uploadForm').after('<img src="' + e.target.result + '" width="450" height="300"/>');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#file").change(function() {
            filePreview(this);
        })

        //  datatable
        $(document).ready(function() {
            $('#example').DataTable({

                "infoCallback": function(settings, start, end, max, total, pre) {
                    return " 共有 " + start + " 至 " + end + " 筆訂單資料 ";
                }, //datatables infoCallback 設定共幾筆筆數

                "lengthMenu": [5, 10, 25, 50, "All"], // datatables lengthMenu 設定頁面筆數
                "columnDefs": [{
                        "orderable": false,
                        "targets": [5, 6]
                    },
                    {
                        "orderable": true,
                        "targets": [0, 1, 4]
                    }
                ]
            });
        });

        //查看檢舉功能
        $(".read").click(function() {
            let id = $(this).data("id");
            let formdata = new FormData();
            formdata.append("id", id);
            axios.post('api/dislikeRead.php', formdata)
                .then(function(response) {
                    console.log(response);
                    let data = response.data
                    console.log(data)
                    $("#idRead").val(data.id)
                    $("#comments_idsRead").val(data.comments_ids)
                    $("#comments_content").val(data.comments_content)
                    $("#dislike_time").val(data.dislike_time)
                    $("#dislike_reason_name").val(data.dislike_reason_name)
                    $("#dislike_status_name").val(data.dislike_status_name)
                })
                .catch(function(err) {
                    console.log(err);
                });
        })

        //編輯檢舉功能
        $(".update").click(function() {
            let id = $(this).data("id");
            let formdata = new FormData();
            formdata.append("id", id);

            axios.post('api/dislikeRead.php', formdata)
                .then(function(response) {
                    console.log(response);
                    let data = response.data
                    console.log(data)
                    $("#idUpdate").val(data.id)
                    $("#comments_idsUpdate").val(data.comments_id)
                    $("#idUpdatehidden").val(data.id)
                    $("#comments_idUpdatehidden").val(data.comments_id)
                    $("#dislike_timeUpdate").val(data.dislike_time)
                    $("#dislike_reason_nameUpdate").val(data.dislike_reason_name)
                    $("#dislike_statusUpdate").val(data.dislike_status)
                    // $("#dislike_statusUpdatehidden").val(data.dislike_status)
                    $("#comments_contentUpdate").val(data.comments_content)
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

        var element = document.getElementById("#dislike_statusUpdatehidden");
        var selected = element.options[element.selectedIndex].value;

        document.getElementById("#idUpdatehidden").innerHTML = selected;
    </script>
</body>

</html>