<div class="right-sidebar col-9 col-lg-10">
    <?php require("../header.php") ?>
    <!-- <div class="my-3 d-flex align-content-center justify-content-between"> -->
    <h3 class="h4 mt-3">文章管理</h3>
    <hr>
    <div class="d-flex justify-content-end mb-3">
        <button type="button" class="btn btn-outline-danger checkBtn mx-2" data-toggle="modal" data-target=".delete-modal-ml" disabled>
            刪除勾選項目
        </button>
        <button type="button" class="btn  btn-success header-btn" data-toggle="modal" data-target="#createModal">新增文章</button>
    </div>
    <!-- </div> -->



    <table id="example" class="table table-striped table-bordered text-center" style="width:100%">
        <thead>
            <tr>
                <th class="col-lg-1">文章ID</th>
                <th class="col-lg-2">文章圖片</th>
                <th class="col-lg-2">文章名稱</th>
                <th class="col-lg-4">文章內容</th>
                <th class="col-lg-1">難易度</th>
                <th class="col-lg-1">狀態</th>
                <th class="col-lg-1">操作</th>
                <th> <input type="checkbox" id="checkAll"> </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $value) { ?>
                <tr data-id="<?= $value["id"] ?>">
                    <th scope="row" class="align-middle"><?= $value["id"] ?></th>
                    <td class="align-middle">
                        <div class="imgwrap">
                            <img class="img-fluid img-thumbnail" src="img/<?= $value["pic"] ?>" alt="">
                        </div>
                    </td>
                    <td class="align-middle"><?= $value["name"] ?></td>
                    <td class="table_content align-middle text-justify">
                        <div>
                            <?= $value["content"] ?>
                        </div>
                    </td>
                    <td class="align-middle">
                        <?php
                        switch ($value["level"]) {
                            case 0:
                                echo "未選擇";
                                break;
                            case 1:
                                echo "level 1";
                                break;
                            case 2:
                                echo "level 2";
                                break;
                            case 3:
                                echo "level 3";
                                break;
                        }
                        ?>
                    </td>
                    <td class="align-middle">
                        <?php
                        switch ($value["status"]) {
                            case 0:
                                echo "未上架";
                                break;
                            case 1:
                                echo "已上架";
                                break;
                        }
                        ?>
                    </td>
                    <td class="align-middle">
                        <!-- <input type="checkbox" name="checkbox"> -->
                        <div class="d-flex justify-content-center align-content-between flex-wrap">
                            <a data-id="<?= $value["id"] ?>" type="button" class="check btn btn-outline-success m-1" data-toggle="modal" data-target="#checkModal" data-whatever="@mdo" href="#">查看</a>
                            <a data-id="<?= $value["id"] ?>" type="button" class="update btn btn-outline-info m-1" data-toggle="modal" data-target="#updateModal" data-whatever="@mdo" href="#">編輯</a>
                            <!-- <a data-id="<?= $value["id"] ?>" type="button" class="delete btn btn-outline-danger m-1 " data-toggle="modal" data-target="#deleteModal" data-whatever="@mdo" href="#">刪除</a> -->
                        </div>
                    </td>
                    <td class="align-middle">
                        <input data-id="<?= $value["id"] ?>" name="idcheck" type="checkbox" class="checkboxforDel">
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>