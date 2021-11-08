<?php
require_once("../pdo_connect.php");
// $stmt = $db_host->prepare("SELECT * FROM product");

if (!isset($_SESSION["user"])) {
    echo "您沒有登入";
    header("location:../login.php");
    exit();
}

$stmt = $db_host->prepare("SELECT product.*, product_status.name AS status_name, product_type.name AS type_name, product_level.name AS level_name 
FROM product
JOIN product_status ON product.status = product_status.id
JOIN product_type ON product.type = product_type.id
JOIN product_level ON product.level = product_level.id
");
try {
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "資料庫連結失敗<br>";
    echo "Error" . $e->getMessage() . "<br>";
    exit;
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>產品管理</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php require("../css.php") ?>
    <style>
        .product-img-edit {
            width: 100px;
            height: 100px;
            margin: 0 auto;
        }

        .read-table th {
            text-align: center;
        }
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
                <h3 class="h4 mt-3">產品管理</h3>
                <hr>
                <div class="d-flex justify-content-end">
                    <!-- <a href="create-product.php" class="btn btn-success header-btn">新增產品</a> -->
                    <button type="button" class="btn btn-outline-danger checkBtn mx-2" data-toggle="modal" data-target=".delete-modal-ml" disabled>
                        刪除勾選項目
                    </button>
                    <button type="button" class="btn btn-success header-btn mx-2" data-toggle="modal" data-target=".bd-example-modal-xl">
                        新增產品
                    </button>
                </div>
                <div class="my-3">
                    <table class="table table-bordered text-center table-striped align-middle" id="product-list">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>產品名稱</th>
                                <th>圖片</th>
                                <th>價格 NT$</th>
                                <th>庫存</th>
                                <th>上架狀態</th>
                                <th>操作</th>
                                <th>
                                    <input type="checkbox" id="checkAll">
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $value) { ?>
                                <tr>
                                    <td class="align-middle"><?= $value["id"] ?></td>
                                    <td class="align-middle"><?= $value["name"] ?></td>
                                    <td>
                                        <figure class="product-img">
                                            <img class="contain-fit" src="img/<?= $value["pic"] ?>" alt="<?= $value["pic"] ?>">
                                        </figure>
                                    </td>
                                    <td class="align-middle"><?= number_format($value["price"]) ?></td>
                                    <td class="align-middle"><?= $value["storage"] ?></td>
                                    <td class="align-middle"><?= $value["status_name"] ?></td>
                                    <td class="align-middle">
                                        <!-- read button trigger modal -->
                                        <button type="button" data-id="<?= $value["id"] ?>" class="read btn btn-outline-success" data-toggle="modal" data-target=".read-example-modal-xl">
                                            查看
                                        </button>
                                        <!-- edit button trigger modal -->
                                        <button type="button" data-id="<?= $value["id"] ?>" class="edit btn btn-outline-info" data-toggle="modal" data-target=".edit-example-modal-xl">
                                            編輯
                                        </button>
                                        <!-- <a role="button" href="productDelete.php?id=<?= $value["id"] ?>" id="delete" class="btn btn-outline-danger mx-1">刪除</a> -->
                                    </td>
                                    <td class="align-middle">
                                        <input data-id="<?= $value["id"] ?>" name="idcheck" type="checkbox" class="checkboxforDel">
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <!-- <div class="d-flex mt-2 justify-content-end">
                            <form action="productDeletePost.php" method="POST">
                                <input type="hidden" id="checkIDList" name="checkIDList" value="">
                                <button id="deletePost" type="submit" class="btn btn-outline-danger mx-1">刪除</button>
                            </form>
                        </div> -->
                    <!-- Modal create-->
                    <div class="modal fade bd-example-modal-xl" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">新增產品</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="productCreate.php" method="post" class="px-5 needs-validation" enctype="multipart/form-data" novalidate>
                                        <div class="form-row">
                                            <div class="mb-2 col-12">
                                                <label for="name">產品名稱</label>
                                                <input class="form-control" type="text" id="name" name="name" required>
                                                <div class="invalid-feedback">
                                                請輸入產品名稱
                                                </div>
                                            </div>
                                            <div class="mb-2 col-md-4">
                                                <label for="price">產品價格 NT$</label>
                                                <input class="form-control" type="text" id="price" name="price" required>
                                                <div class="invalid-feedback">
                                                請輸入產品價格
                                                </div>
                                            </div>
                                            <div class="mb-2 col-md-4">
                                                <label for="storage">庫存數量</label>
                                                <input class="form-control" type="number" id="storage" name="storage" required>
                                                <div class="invalid-feedback">
                                                請輸入庫存數量
                                                </div>
                                            </div>
                                            <div class="mb-2 col-md-4">
                                                <label for="sold">已售出數量</label>
                                                <input class="form-control" type="number" id="sold" name="sold" required>
                                                <div class="invalid-feedback">
                                                請輸入已售出數量
                                                </div>
                                            </div>
                                            <div class="my-2 col-12">
                                                <div class="custom-file">
                                                    <input class="custom-file-input" id="customFile" type="file" name="pic" accept="image/gif, image/jpeg, image/png" required>
                                                    <label class="custom-file-label" for="customFile">產品圖片上傳</label>
                                                </div>
                                                <div class="invalid-feedback">
                                                請上傳產品圖片
                                                </div>
                                            </div>
                                            <div class="my-2 col-md-4">
                                                <label class="mr-2" for="type">產品類型</label>
                                                <select name="type" id="type" class="form-control" required>
                                                    <option selected value="">選擇產品類型</option>
                                                    <option value="1">鞋子</option>
                                                    <option value="2">背包</option>
                                                    <option value="3">衣服</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                請選擇產品類型
                                                </div>
                                            </div>
                                            <div class="my-2 col-md-4">
                                                <label class="mr-2" for="status">上架狀態</label>
                                                <select name="status" id="status" class="form-control" required>
                                                    <option selected value="">選擇上架狀態</option>
                                                    <option value="1">未上架</option>
                                                    <option value="2">已上架</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                請選擇上架狀態
                                                </div>
                                            </div>
                                            <div class="my-2 col-md-4">
                                                <label class="mr-2" for="level">裝備等級</label>
                                                <select name="level" id="level" class="form-control" required>
                                                    <option selected value="">選擇裝備等級</option>
                                                    <option value="1">初階</option>
                                                    <option value="2">中階</option>
                                                    <option value="3">高階</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                請選擇裝備等級
                                                </div>
                                            </div>
                                            <div class="mb-2 col-12">
                                                <label for="introduction">產品介紹</label>
                                                <textarea class="form-control" name="introduction" id="introduction"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-outline-secondary mr-2" data-dismiss="modal" type="button">關閉</button>
                                            <button class="btn btn-success header-btn" type="submit">新增</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end-->
                    <!-- Modal read-->
                    <div class="modal fade read-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!--檢視資料-->
                                    <!-- ID品名圖片價格庫存狀態類別等級 -->
                                    <!-- <label for="id">商品ID</label> -->
                                    <table class="table table-bordered read-table">
                                        <tr>
                                            <th class="align-middle col-2" scope="row">產品ID</th>
                                            <td class="col-4 align-middle">
                                                <input type="text" name="idinfo" class="form-control" id="idinfo" readonly>
                                            </td>
                                            <th class="align-middle col-2" scope="row">上架狀態</th>
                                            <td class="col-4 align-middle">
                                                <select name="statusinfo" id="statusinfo" class="form-control" disabled>
                                                    <option value="1">未上架</option>
                                                    <option value="2">已上架</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">產品類型</th>
                                            <td class="align-middle">
                                                <select name="typeinfo" id="typeinfo" class="form-control" disabled>
                                                    <option value="1">鞋子</option>
                                                    <option value="2">背包</option>
                                                    <option value="3">衣服</option>
                                                </select>
                                            </td>
                                            <th class="align-middle">裝備等級</th>
                                            <td class="align-middle">
                                                <select name="levelinfo" id="levelinfo" class="form-control" disabled>
                                                    <option value="1">初階</option>
                                                    <option value="2">中階</option>
                                                    <option value="3">高階</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">產品價格 NT$</th>
                                            <td class="align-middle">
                                                <input type="text" name="priceinfo" class="form-control" id="priceinfo" readonly>
                                            </td>
                                            <th rowspan="3" class="align-middle">產品圖片</th>
                                            <td rowspan="3" class="text-center"><img src="" alt="" id="picinfo" class="product-info-img"></td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">庫存數量</th>
                                            <td class="align-middle">
                                                <input type="number" name="storageinfo" class="form-control" id="storageinfo" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">已售出數量</th>
                                            <td class="align-middle">
                                                <input type="number" name="soldinfo" class="form-control" id="soldinfo" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="col-2 align-middle">產品介紹</th>
                                            <td colspan="3" class="col-10 p-3" id="introductioninfo">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">關閉</button>
                                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end-->
                    <!-- Modal edit-->
                    <div class="modal fade edit-example-modal-xl" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">編輯產品資料</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="productUpdate.php" method="post" class="px-5" enctype="multipart/form-data">
                                        <div class="form-row">
                                            <input type="hidden" id="idEdit" name="id">
                                            <div class="mb-2 col-12">
                                                <label for="nameEdit">產品名稱</label>
                                                <input class="form-control" type="text" id="nameEdit" name="name">
                                            </div>
                                            <div class="mb-2 col-md-4">
                                                <label for="priceEdit">產品價格 NT$</label>
                                                <input class="form-control" type="text" id="priceEdit" name="price">
                                            </div>
                                            <div class="mb-2 col-md-4">
                                                <label for="storageEdit">庫存數量</label>
                                                <input class="form-control" type="number" id="storageEdit" name="storage">
                                            </div>
                                            <div class="mb-2 col-md-4">
                                                <label for="soldEdit">已售出數量</label>
                                                <input class="form-control" type="number" id="soldEdit" name="sold">
                                            </div>
                                            <div class="my-2 col-md-8 custom-file">
                                                <label for="picEdit" class="custom-file-label">產品圖片上傳</label>
                                                <input class="custom-file-input" id="customFileEdit" type="file" name="pic" accept="image/gif, image/jpeg, image/png">
                                            </div>
                                            <div class="my-2 col-md-4">
                                                <figure class="product-img-edit">
                                                    <input type="hidden" value="" name="old_img" id="oldImg">
                                                    <img class="contain-fit" src="" id="picEdit" alt="">
                                                </figure>
                                            </div>
                                            <div class="mb-2 col-md-4">
                                                <label class="mr-2" for="typeEdit">產品類型</label>
                                                <select name="type" id="typeEdit" class="form-control">
                                                    <option value="1">鞋子</option>
                                                    <option value="2">背包</option>
                                                    <option value="3">衣服</option>
                                                </select>
                                            </div>
                                            <div class="mb-2 col-md-4">
                                                <label class="mr-2" for="statusEdit">上架狀態</label>
                                                <select name="status" id="statusEdit" class="form-control">
                                                    <option value="1">未上架</option>
                                                    <option value="2">已上架</option>
                                                </select>
                                            </div>
                                            <div class="mb-2 col-md-4">
                                                <label class="mr-2" for="levelEdit">裝備等級</label>
                                                <select name="level" id="levelEdit" class="form-control">
                                                    <option value="1">初階</option>
                                                    <option value="2">中階</option>
                                                    <option value="3">高階</option>
                                                </select>
                                            </div>
                                            <div class="mb-2 col-12">
                                                <label for="introductionEdit">產品介紹</label>
                                                <textarea class="form-control" name="introduction" id="introductionEdit"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary mr-2" data-dismiss="modal">取消</button>
                                            <button class="btn btn-success header-btn" type="submit">更新</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end-->
                    <!-- Modal delete warning-->
                    <div class="modal fade delete-modal-ml" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-ml" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">刪除產品</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    是否確認刪除資料？
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success header-btn detail" data-dismiss="modal">關閉</button>
                                    <form action="productDeletePost.php" method="POST">
                                        <input type="hidden" id="checkIDList" name="checkIDList" value="">
                                        <button id="deletePost" type="submit" class="btn btn-danger mx-1">刪除</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end-->
                </div>
            </main>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src=" https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!--bs-custom-file-input-->
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
    <!--axios-->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <!--ckeditor-->
    <script src="https://cdn.ckeditor.com/4.16.1/full/ckeditor.js"></script>
    <!-- <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script> -->

    <script>
        //CKEDITOR
        CKEDITOR.replace('introduction');
        CKEDITOR.replace('introductionEdit');
        //驗證表單
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
        $(document).ready(function() {
            //bs-custom-file-input
            bsCustomFileInput.init()
            //datatable
            $('#product-list').DataTable({
                "infoCallback": function(settings, start, end, max, total, pre) {
                    return " 共有 " + start + " 至 " + end + " 筆產品資料 ";
                },
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                "columnDefs": [{
                        "orderable": false,
                        "targets": [2, 6, 7]
                    },
                    {
                        "orderable": true,
                        "targets": [0, 1, 3, 4, 5]
                    }
                ]
            });
        });
        //ajax
        // $(".read").click(function() {
        //     let id = $(this).data("id")
        //     // console.log(id)
        //     $.ajax({
        //         method: "POST",
        //         url: "api/product.php",
        //         data: {
        //             id: id
        //         },
        //         dataType: "json"
        //     }).done(function(data) {
        //         // console.log(data)
        //         $("#exampleModalLabel1").text(data.name)
        //         $("#idinfo").text(data.id)
        //         $("#statusinfo").text(data.status_name)
        //         $("#typeinfo").text(data.type_name)
        //         $("#levelinfo").text(data.level_name)
        //         $("#priceinfo").text(data.price)
        //         $("#picinfo").attr('src', `img/${data.pic}`)
        //         $("#storageinfo").text(data.storage)
        //         $("#soldinfo").text(data.sold)
        //         $("#introductioninfo").html(data.introduction)
        //     }).fail(function(err) {
        //         console.log(err)
        //     })
        // })
        //axios read
        $(".read").click(function() {
            let id = $(this).data("id")
            let formdata = new FormData();
            formdata.append("id", id);
            axios.post('api/product.php', formdata)
                .then(function(response) {
                    // console.log(response);
                    let data = response.data;
                    // console.log(data)
                    $("#exampleModalLabel1").text(data.name)
                    $("#idinfo").val(data.id)
                    $("#statusinfo").val(data.status)
                    $("#typeinfo").val(data.type)
                    $("#levelinfo").val(data.level)
                    $("#priceinfo").val(data.price)
                    $("#picinfo").attr('src', `img/${data.pic}`)
                    $("#storageinfo").val(data.storage)
                    $("#soldinfo").val(data.sold)
                    $("#introductioninfo").html(data.introduction)
                })
        })
        //axios edit
        $(".edit").click(function() {
            let id = $(this).data("id")
            let formdata = new FormData();
            formdata.append("id", id);
            axios.post('api/productUpdateApi.php', formdata)
                .then(function(response) {
                    // console.log(response);
                    let data = response.data;
                    console.log(data)
                    $("#nameEdit").val(data.name)
                    $("#idEdit").val(data.id)
                    $("#statusEdit").val(data.status)
                    $("#typeEdit").val(data.type)
                    $("#levelEdit").val(data.level)
                    $("#priceEdit").val(data.price)
                    $("#oldImg").val(data.pic)
                    $("#picEdit").attr('src', `img/${data.pic}`)
                    $("#storageEdit").val(data.storage)
                    $("#soldEdit").val(data.sold)
                    CKEDITOR.instances['introductionEdit'].setData(data.introduction)
                })
        })
        //全選
        $("#checkAll").click(function() {
            let checked = $(this).prop("checked")
            $("tbody :checkbox").prop("checked", checked)
            let checkLength = $('.checkboxforDel').filter(':checked').length
            console.log(checkLength)
            if (checkLength > 0) {
                $('.checkBtn').removeAttr('disabled'); //enable input
            } else {
                $('.checkBtn').attr('disabled', true); //disable input
            }
        })
        //防止未勾選資料卻按刪除鍵
        $(".checkboxforDel").click(function() {
            let checkLength = $('.checkboxforDel').filter(':checked').length
            console.log(checkLength)
            if (checkLength > 0) {
                $('.checkBtn').removeAttr('disabled'); //enable input
            } else {
                $('.checkBtn').attr('disabled', true); //disable input
            }
        })
        //checkbox delete
        $("#deletePost").click(function() {
            //console.log("click")
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
    </script>
</body>

</html>