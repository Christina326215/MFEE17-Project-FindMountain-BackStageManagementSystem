<?php
require_once("../pdo_connect.php");

if (!isset($_SESSION["user"])) {
    echo "您沒有登入";
    header("location:../login.php");
    exit();
}

$stmt1 = $db_host->prepare("SELECT user_level.name AS level_name, user.* 
FROM user
JOIN user_level ON user.level = user_level.id
WHERE valid=1
ORDER BY id ASC
");


try {
    $stmt1->execute();
    $rows1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    // echo "123";
} catch (PDOException $e) {
    echo "資料庫連結失敗<br>";
    echo "Error: " . $e->getMessage() . "<br>";
    exit;
}

?>

<!doctype html>
<html lang="zh-tw">

<head>
    <title>會員管理</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php require("../css.php") ?>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class=" navAll col-3 col-lg-2 text-white sticky-top">
                <?php require("../nav-bar.php") ?>
            </div>
            <main class="col-9 col-lg-10">
                <?php require("../header.php") ?>
                <h3 class="h4 mt-3">會員管理</h3>
                <hr>
                <div class="d-flex justify-content-end">
                    <div></div>
                    <!-- <a href="user-create.php" class="btn btn-info">新增會員</a> -->
                    <button type="button" class="btn btn-outline-danger mx-2 checkBtn" data-toggle="modal" data-target=".delete-Modal-ml" disabled>
                        刪除勾選項目
                    </button>
                    <button type="button" class="btn btn-success addbtn watch mx-2 header-btn" data-toggle="modal" data-target=".create-Modal">
                        新增會員
                    </button>
                </div>
                <!-- 會員列表 -->
                <div class="my-3">
                    <table id="userlist" class="table table-striped table-bordered text-center align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>會員ID</th>
                                <th>姓名</th>
                                <th>帳號</th>
                                <th>電話</th>
                                <th>操作</th>
                                <th>
                                    <input type="checkbox" id="checkAll">
                                </th>
                            </tr>
                        </thead>
                        <?php foreach ($rows1 as $value) { ?>
                            <tr>
                                <td class="align-middle"><?= $value["id"] ?></td>
                                <td class="align-middle"><?= $value["name"] ?></td>
                                <td class="align-middle"><?= $value["account"] ?></td>
                                <td class="align-middle"><?= $value["phone"] ?></td>
                                <td class="align-middle">
                                    <!-- <input type="checkbox" class="input"> -->
                                    <button type="button" class="btn btn-outline-success addbtn watch" data-toggle="modal" data-target=".view-Modal" data-id="<?= $value["id"] ?>">
                                        查看
                                    </button>
                                    <button type="button" class="btn btn-outline-info addbtn edit" data-toggle="modal" data-target=".edit-Modal" data-id="<?= $value["id"] ?>">
                                        編輯
                                    </button>

                                    <!-- <a role="button" href="user-update.php?id=<?= $value["id"] ?>" class="btn btn-outline-info">編輯</a>
                                    <a role="button" href="deleteUser.php?id=<?= $value["id"] ?>" class="btn btn-outline-danger">刪除</a> -->
                                </td>
                                <td class="align-middle">
                                    <input type="checkbox" name="idcheck" type="checkbox" class="checkboxforDel" data-id="<?= $value["id"] ?>">
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>

                <!-- 查看 -->
                <?php  ?>
                <div class="modal fade view-Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">會員資料</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th scope="row">會員ID</th>
                                            <td>
                                                <input class="form-control" type="text" id="id" readonly>
                                            </td>

                                            <th>帳號</th>
                                            <td colspan="3">
                                                <input class="form-control" type="mail" id="account" readonly>
                                            </td>

                                            <!-- <th>密碼</th>
                                            <td>
                                                <input class="form-control" type="text" id="password" readonly>
                                            </td> -->
                                        </tr>
                                        <tr>
                                            <th scope="row">姓名</th>
                                            <td>
                                                <input class="form-control" type="text" id="name" readonly>
                                            </td>
                                            <th>手機</th>
                                            <td>
                                                <input class="form-control" type="tel" id="phone" readonly>
                                            </td>
                                            <th>生日</th>
                                            <td>
                                                <input class="form-control" type="date" id="birthday" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">地址</th>
                                            <td colspan="3" class="col-7">
                                                <input class="form-control" type="text" id="addr" readonly>
                                            </td>
                                            <th>會員等級</th>
                                            <td>
                                                <select class="custom-select" id="level" disabled>
                                                    <option value="1">肉腳</option>
                                                    <option value="2">山友</option>
                                                    <option value="3">山神</option>
                                                </select>
                                            </td>
                                    </tbody>
                                </table>
                                <!-- <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <td class="align-middle" id="id"></td>
                                            <th>帳號</th>
                                            <td class="align-middle" id="account"></td>
                                        </tr>
                                        <tr>
                                            <th>姓名</th>
                                            <td class="align-middle" id="name"></td>
                                            <th>密碼</th>
                                            <td class="align-middle" id="password"></td>
                                        </tr>
                                        <tr>
                                            <th>生日</th>
                                            <td class="align-middle" id="birthday"></td>
                                            <th>手機</th>
                                            <td class="align-middle" id="phone"></td>
                                        </tr>
                                        <tr>
                                            <th>被檢舉</th>
                                            <td class="align-middle" id="report">0</td>
                                            <th>會員等級</th>
                                            <td class="align-middle" id="level"></td>
                                        </tr>
                                        <tr>
                                            <th>地址</th>
                                            <td colspan="3" class="align-middle" id="addr"></td>

                                        </tr>
                                    </tbody>
                                </table> -->
                            </div>
                            <div class="modal-footer">
                                <!-- <button type="submit" class="btn btn-primary">新增</button> -->
                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">關閉</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 新增會員 -->
                <div class="modal fade create-Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <form method="post" class="needs-validation" name="formAdd" enctype="multipart/form-data" action="createUser.php" novalidate>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">新增員資料</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body edit-modal">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th scope="row" class="col-1">帳號</th>
                                                <td colspan="3" class="col-7">
                                                    <input class="form-control" type="email" id="account" name="account" pattern="^[a-zA-Z0-9]{1,63}+@[a-zA-Z0-9]{2,63}{1,64}$" placeholder="email" required>
                                                    <div class=" invalid-feedback">
                                                        請輸入Email
                                                    </div>
                                                </td>
                                                <th class="col-1">密碼</th>
                                                <td class="col-3">
                                                    <input class="form-control" type="password" id="password" name="password" placeholder="8-15字元密碼" minlength="8" required>
                                                    <div class="invalid-feedback">
                                                        請輸入密碼
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">姓名</th>
                                                <td>
                                                    <input class="form-control" type="text" id="name" name="name" required>
                                                    <div class="invalid-feedback">
                                                        請輸入姓名
                                                    </div>
                                                </td>
                                                <th>手機</th>
                                                <td>
                                                    <input class="form-control" type="num" id="phone" name="phone" pattern="^09[0-9]{8}$" required>
                                                    <div class="invalid-feedback">
                                                        請輸入電話
                                                    </div>
                                                </td>
                                                <th>生日</th>
                                                <td>
                                                    <input class="form-control" type="date" id="birthday" name="birthday" required>
                                                    <div class="invalid-feedback">
                                                        請輸入生日日期
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">地址</th>
                                                <td colspan="3" class="col-7">
                                                    <input class="form-control" type="text" id="addr" name="addr" required>
                                                    <div class="invalid-feedback">
                                                        請輸入地址
                                                    </div>
                                                </td>
                                                <th>會員等級</th>
                                                <td>
                                                    <select class="form-control" name="level" id="level">
                                                        <option value="1">肉腳</option>
                                                        <option value="2">山友</option>
                                                        <option value="3">山神</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        請選擇會員等級
                                                    </div>
                                                </td>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <div class="my-3">
                                        <a href="user-list.php" class="btn btn-outline-secondary" type="button">關閉</a>
                                        <button class="btn btn-success header-btn" type="submit">新增</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- 編輯 -->
                <div class="modal fade edit-Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <form method="post" class="needs-validation" name="formAdd" enctype="multipart/form-data" novalidate action="updateUser.php">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">更改會員資料</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body edit-modal">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th scope="row">會員ID</th>
                                                <td>
                                                    <input class="form-control-plaintext" type="text" id="editid" readonly>
                                                    <input type="hidden" id="edit_id_hidden" name="id">
                                                </td>

                                                <th>帳號</th>
                                                <td>
                                                    <input class="form-control-plaintext" type="mail" id="editaccount" readonly>
                                                    <input type="hidden" id="edit_account_hidden" name="account">
                                                    <!-- 因為上面account的readonly讓使用者無法更改但可將資料submit   -->
                                                </td>

                                                <th>密碼</th>
                                                <td>
                                                    <input class="form-control" type="password" id="editpassword" name="password" placeholder="請輸入8-15字元密碼">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">姓名</th>
                                                <td>

                                                    <input class="form-control" type="text" id="editname" name="name" required>
                                                </td>
                                                <th>手機</th>
                                                <td>
                                                    <input class="form-control" type="tel" id="editphone" name="phone" required>
                                                </td>
                                                <th>生日</th>
                                                <td>
                                                    <input class="form-control" type="date" id="editbirthday" name="birthday" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">地址</th>
                                                <td colspan="3" class="col-7">
                                                    <input class="form-control" type="text" id="editaddr" name="addr" required>
                                                </td>
                                                <th>會員等級</th>
                                                <td>
                                                    <select class="form-control" id="editlevel" name="level">
                                                        <option value="1">肉腳</option>
                                                        <option value="2">山友</option>
                                                        <option value="3">山神</option>
                                                    </select>
                                                </td>
                                        </tbody>
                                    </table>

                                </div>
                                <div class="modal-footer">
                                    <div class="my-3">
                                        <a href="user-list.php" class="btn btn-outline-secondary" type="button">關閉</a>
                                        <button class="btn btn-success header-btn" type="submit">更新</button>

                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- 刪除 -->
                <div class="modal fade delete-Modal-ml" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-ml">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">刪除會員</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                是否確認刪除會員資料？
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success header-btn detail" data-dismiss="modal">關閉</button>
                                <form action="deleteUserPost.php" method="POST">
                                    <input type="hidden" id="checkIDList" name="checkIDList" value="">
                                    <button id="deletePost" type="submit" class="btn btn-danger mx-1">刪除</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </main>

        </div>

    </div>

    <?php require("script.php") ?>

    <script>
        // $("#example").DataTable();
        $(document).ready(function() {
            $('#userlist').DataTable({

                "infoCallback": function(settings, start, end, max, total, pre) {
                    return " 共有 " + start + " 至 " + end + " 筆訂單資料 ";
                },

                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                "columnDefs": [{
                        "orderable": false,
                        "targets": [4, 5]
                    },
                    {
                        "orderable": true,
                        "targets": [0, 1, 2, 3]
                    }
                ]

            });
        });

        //全選
        $("#checkAll").click(function() {
            let checked = $(this).prop("checked")
            $("tbody :checkbox").prop("checked", checked)
            let checkLength = $('.checkboxforDel').filter(':checked').length
            // console.log(checkLength);
            if (checkLength > 0) {
                $('.checkBtn').removeAttr('disabled'); //enable input
            } else {
                $('.checkBtn').attr('disabled', true); //disable input
            }
        })
        //防止未勾選資料卻按刪除鍵
        $(".checkboxforDel").click(function() {
            let checkLength = $('.checkboxforDel').filter(':checked').length
            // console.log(checkLength);
            if (checkLength > 0) {
                $('.checkBtn').removeAttr('disabled'); //enable input
            } else {
                $('.checkBtn').attr('disabled', true); //disable input
            }
        })

        //刪除功能
        $("#deletePost").click(function() {
            console.log("click")
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

        //查看功能
        $(".watch").click(function() {
            let id = $(this).data("id");
            let formdata = new FormData();
            formdata.append("id", id);

            axios.post('api/user.php', formdata)
                .then(function(response) {
                    console.log(response);
                    let data = response.data
                    $("#id").val(data.id)
                    $("#account").val(data.account)
                    $("#password").val(data.password)
                    $("#birthday").val(data.birthday)
                    $("#phone").val(data.phone)
                    $("#name").val(data.name)
                    $("#level").val(data.level)
                    $("#addr").val(data.addr)
                })
                .catch(function(err) {
                    console.log(err);
                });

        })
        //編輯功能
        $(".edit").click(function() {
            let id = $(this).data("id");
            let formdata = new FormData();
            formdata.append("id", id);

            axios.post('api/edit_user.php', formdata)
                .then(function(response) {
                    console.log(response);

                    let data = response.data
                    console.log(data);
                    $("#editid").val(data.id)
                    $("#edit_id_hidden").val(data.id)
                    $("#editaccount").val(data.account)
                    $("#edit_account_hidden").val(data.account)
                    // $("#editpassword").val(data.password)
                    $("#editbirthday").val(data.birthday)
                    $("#editphone").val(data.phone)
                    $("#editname").val(data.name)
                    $("#editlevel").val(data.level)
                    $("#editaddr").val(data.addr)
                })
                .catch(function(err) {
                    console.log(err);
                });

        })
    </script>

</body>

</html>
