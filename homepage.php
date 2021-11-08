<?php 

    require("homepageSql.php");

    if (!isset($_SESSION["user"])) {
        echo "您沒有登入";
        header("location:login.php");
        exit();
    }    

?>
<!doctype html>
<html lang="en">

<head>
    <title>首頁</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open Sans" />
    <?php require("css.php") ?>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Open Sans';
            color: rgba(0, 0, 0, 0.8);
        }

        h3 {
            font-size: 22px;
            line-height: 31px;
            margin-top: 0px;
        }

        /* ---- grid ---- */

        .grid {
            margin-top: 60px;
            margin-left: auto;
            margin-right: auto;
            max-width: 1500px;
        }

        /* clearfix */
        .grid:after {
            content: '';
            display: block;
            clear: both;
        }

        .element {
            /* height: 140px; */
            margin: 10px 0;
            width: 100%;
            /* background: #F2F2F2; */
            /* border-left: 1px solid rgba(0, 62, 82, 0.1);
            border-right: 1px solid rgba(0, 62, 82, 0.1);
            border-bottom: 1px solid rgba(0, 62, 82, 0.1); */
        }

        /* ---- grid-item ---- */

        .grid-item {
            width: 490px;
            height: 220px;
            float: left;
            /* vertical gutter */
            margin-bottom: 10px;
            padding: 30px;
            background: #F2F2F2;
            border: 1px solid rgba(0, 62, 82, 0.1);
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 62, 82, 0.1), inset 0px 0px 0px 1px rgba(0, 62, 82, 0.1);
        }

        .grid-item--width2 {
            width: 990px;
        }

        .grid-item--height2 {
            height: 260px;
        }

        .grid-item--height3 {
            height: 450px;
            bottom: 100;
        }

        .grid-item--height4 {
            /* height: 800px; */
            height: 850px;
        }

        .grid-item--height5 {
            /* height: 450px; */
            height: 500px;
        }

        .element--height2 {
            height: 280px;
        }

        .title h3 {
            display: inline-block;
        }

        .title h3.right {
            float: right;
        }

        .title:after {
            content: '';
            display: block;
            clear: both;
        }

        .tileControl {
            margin-left: 10px;
            cursor: pointer;
        }

        .expand {
            display: inline-block;
        }

        .grid-item:first-child>.title>h3.up {
            display: none;
        }

        .grid-item:last-child>.title>h3.down {
            display: none;
        }

        @media screen and (max-width: 1490px) {
            .grid {
                max-width: 1000px;
            }
        }

        @media screen and (max-width: 990px) {
            .grid {
                max-width: 500px;
            }

            .grid-item--width2 {
                width: 490px;
            }

            .expand {
                display: none !important;
            }
        }

        .comm{
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            text-align: justify
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="sticky-top navAll col-3 col-lg-2 text-white">
                <?php require("nav-bar.php") ?>
            </div>
            <main class="col-9 col-lg-10">
                <?php require("header.php") ?>
                <div class="grid">
                    <div class="grid-item grid-item--height3 grid-product">
                        <div class="title">
                            <h3 class="pl-2">最新會員</h3>
                            <h3 class="tileControl right down">↓</h3>
                            <h3 class="tileControl right up">↑</h3>
                            <h3 class="tileControl right expand">↔</h3>
                        </div>
                        <div class="element text-center">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">會員名稱</th>
                                        <th scope="col">會員帳號</th>
                                        <th scope="col">等級</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i < 5; $i++) { ?>
                                        <tr>
                                            <td class="col-4"><?= $rowsUser[$i]["name"] ?></td>
                                            <td class="col-4"><?= $rowsUser[$i]["account"] ?></td>
                                            <td class="col-4"><?= $rowsUser[$i]["user_level_name"] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                            <a class="btn btn-success header-btn mt-2" href="/project/mountain_admin/user-list.php">查看更多</a>
                            </div>
                        </div>
                    </div>
                    <div class="connections grid-item grid-item--height4 ">
                        <div class="title">
                            <h3 class="pl-4">最新產品</h3>
                            <h3 class="tileControl right down">↓</h3>
                            <h3 class="tileControl right up">↑</h3>
                            <h3 class="tileControl right expand">↔</h3>
                        </div>
                        <div class="element text-center">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">產品名稱</th>
                                        <th scope="col">圖片</th>
                                        <th scope="col">價格NT$</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i < 5; $i++) { ?>
                                        <tr>
                                            <td class="col-4"><?= $rowsProduct[$i]["name"] ?></td>
                                            <td class="col-4">
                                                <figure class="homepage-img">
                                                    <img src="product/img/<?= $rowsProduct[$i]["pic"] ?>">
                                                </figure>
                                            </td>
                                            <td class="col-4"><?= $rowsProduct[$i]["price"] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                            <a class="btn btn-success header-btn mt-2" href="/project/product/product-list.php">查看更多</a>
                            </div>
                        </div>
                    </div>
                    <div class="grid-item grid-item--height5">
                        <div class="title">
                            <h3 class="pl-4">最新評論</h3>
                            <h3 class="tileControl right down">↓</h3>
                            <h3 class="tileControl right up">↑</h3>
                            <h3 class="tileControl right expand">↔</h3>
                        </div>
                        <div class="element text-center">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">評論文章</th>
                                        <th scope="col">評論內容</th>
                                        <th scope="col">評論時間</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i < 4; $i++) { ?>
                                        <tr>
                                            <td class="col-4"><?= $rowsComments[$i]["article_name"] ?></td>
                                            <td class="col-4">
                                                <div class="comm">
                                                <?= $rowsComments[$i]["content"] ?>
                                                </div>
                                            </td>
                                            <td class="col-4"><?= $rowsComments[$i]["time"] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                            <a class="btn btn-success header-btn mt-2" href="/project/comments/comments-list.php">查看更多</a>
                            </div>
                        </div>
                    </div>
                    <div class="grid-item grid-item--height3">
                        <div class="title">
                            <h3 class="pl-4">最新標籤</h3>
                            <h3 class="tileControl right down">↓</h3>
                            <h3 class="tileControl right up">↑</h3>
                            <h3 class="tileControl right expand">↔</h3>
                        </div>
                        <div class="element text-center">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">標籤圖片</th>
                                        <th scope="col">標籤x軸</th>
                                        <th scope="col">標籤y軸</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i < 2; $i++) { ?>
                                        <tr>
                                            <td class="col-4">
                                                <figure class="homepage-img">
                                                    <img src="tag/img/<?= $rowsTag[$i]["tag_photo_img"] ?>">
                                                </figure>
                                            </td>
                                            <td class="col-4"><?= $rowsTag[$i]["position_x"] ?></td>
                                            <td class="col-4"><?= $rowsTag[$i]["position_y"] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                            <a class="btn btn-success header-btn mt-2" href="/project/tag/tag-list.php">查看更多</a>
                            </div>
                        </div>
                    </div>
                    <div class="grid-item grid-item--height4">
                        <div class="title">
                            <h3 class="pl-4">最新文章</h3>
                            <h3 class="tileControl right down">↓</h3>
                            <h3 class="tileControl right up">↑</h3>
                            <h3 class="tileControl right expand">↔</h3>
                        </div>
                        <div class="element text-center">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">文章圖片</th>
                                        <th scope="col">文章名稱</th>
                                        <th scope="col">文章狀態</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i < 5; $i++) { ?>
                                        <tr>
                                            <td class="col-4">
                                                <figure class="homepage-img">
                                                    <img src="article/img/<?= $rowsArticle[$i]["pic"] ?>">
                                                </figure>
                                            </td>
                                            <td class="col-4"><?= $rowsArticle[$i]["name"] ?></td>
                                            <td class="col-4"><?= $rowsArticle[$i]["article_status_name"] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                            <a class="btn btn-success header-btn mt-2" href="/project/article/article.php">查看更多</a>
                            </div>
                        </div>
                    </div>
                    <div class="grid-item grid-item--height5">
                        <div class="title">
                            <h3 class="pl-4">最新訂單</h3>
                            <h3 class="tileControl right down">↓</h3>
                            <h3 class="tileControl right up">↑</h3>
                            <h3 class="tileControl right expand">↔</h3>
                        </div>
                        <div class="element text-center">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">訂單編號</th>
                                        <th scope="col">運送方式</th>
                                        <th scope="col">訂單狀態</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i < 6; $i++) { ?>
                                        <tr>
                                            <td class="col-4"><?= $rowsUser_order[$i]["id"] ?></td>
                                            <td class="col-4"><?= $rowsUser_order[$i]["ship_ship"] ?></td>
                                            <td class="col-4"><?= $rowsUser_order[$i]["order_status_name"] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                            <a class="btn btn-success header-btn mt-2" href="/project/user_order/userOrderList.php">查看更多</a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <?php require("script.php") ?>
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js"></script>
    <script>
        function initialiseMasonry() {
            return $('.grid').masonry({
                itemSelector: '.grid-item',
                columnWidth: 490,
                gutter: 10
            });
        }

        var $grid = initialiseMasonry();

        // external js: masonry.pkgd.js
        $('.expand').click(function() {
            var gridItem = $(this).closest(".grid-item");
            gridItem.toggleClass('grid-item--width2');
            $grid.masonry('layout');
        })

        $('.up').click(function() {
            var gridItem = $(this).parents(".grid-item");

            var prevGridItem = gridItem.prev();
            if (prevGridItem != null) {
                prevGridItem.before(gridItem);
            }
            $grid.masonry('destroy');
            $grid = initialiseMasonry();
            //$grid.masonry('reloadItems');
        })

        $('.down').click(function() {
            var gridItem = $(this).parents(".grid-item");
            var nextGridItem = gridItem.next(".grid-item");
            if (nextGridItem != null) {
                nextGridItem.after(gridItem);
            }
            $grid.masonry('destroy');
            $grid = initialiseMasonry();
            //$grid.masonry('reloadItems');
        })
    </script>
</body>

</html>