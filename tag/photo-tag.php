<?php
require_once("../pdo_connect.php");

if (!isset($_SESSION["user"])) {
  echo "您沒有登入";
  header("location:../login.php");
  exit();
}

$id = $_GET["id"];

$stmt1 = $db_host->prepare("SELECT * 
FROM tag_photo
JOIN article ON tag_photo.article_id = article.id
WHERE article_id=?");

$stmt2 = $db_host->prepare("SELECT tag.img_id as tag_img_id, tag_photo.*
FROM tag_photo
JOIN tag ON tag_photo.id = tag.img_id");

$stmt3 = $db_host->prepare("SELECT *  
FROM tag_photo 
WHERE article_id=?");

$productQuery = $db_host->prepare("SELECT * FROM product");

try {
  $stmt1->execute([$id]);
  $rows1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
  $stmt2->execute();
  $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
  $stmt3->execute([$id]);
  $rows3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
  $productQuery->execute();
  $products = $productQuery->fetchAll(PDO::FETCH_ASSOC);
  // $products->execute();
  // $rows4 = $products->fetchAll(PDO::FETCH_ASSOC);
  // print_r($rows2);
  // var_dump($rows4);
  // exit();
} catch (PDOException $e) {
  echo "讀取資料失敗";
}
?>

<!doctype html>
<html lang="en">

<head>
  <title>tag list</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php require("../css.php") ?>
  <style>
    .contain-fit {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    .tag-img {
      width: 400px;
      /* height: 300px; */
      object-fit: contain;
    }

    .tagImgAdj {
      width: 100%;
      height: 100%;
      /* max-height: 500px; */
    }

    .tag-content {
      position: absolute;
      padding: 0px 10px;
      background: rgba(0, 201, 87, .7);
      color: #fff;
      transform: translate(-50%, -50%);
      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      -webkit-box-orient: vertical;
      -webkit-line-clamp: 3;
      max-width: 350px;
    }

    .tag-content select {
      max-width: 280px;
    }
  </style>
</head>

<body>
  <div class="container-fluid">
    <div class="py-2 d-none">
      <select class="products" name="product" id="products">
        <option value="0">請選擇</option>
        <?php foreach ($products as $value) { ?>
          <option value="<?= $value["id"] ?>"><?= $value["name"] ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="row">
      <div class="sticky-top navAll col-3 col-lg-2 text-white">
        <?php require("../nav-bar.php") ?>
      </div>

      <main class="col-9 col-lg-10">
        <?php require("../header.php") ?>
        <div class="my-3">
          <div class="d-flex justify-content-end mb-3">
            <button type="button" class="btn btn-outline-danger checkBtn mx-2" data-toggle="modal" data-target=".delete-modal-ml" disabled>
              刪除勾選項目
            </button>
          </div>
          <!-- table 主列表 photo_tag list start -->
          <table class="table table-borderless text-center align-middle table-striped" id="photoTag" style="width:100% ">
            <thead>
              <tr>
                <th>照片</th>
                <th>操作</th>
                <th><input type="checkbox" id="checkAll"></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rows3 as $value1) { ?>
                <tr>
                  <td>
                    <div class="embed-responsive embed-responsive-1by1">
                      <div class="embed-responsive-item">
                        <img class="contain-fit" src="img/<?= $value1["img"] ?>" alt="<?= $value1["img"] ?>">
                      </div>
                    </div>
                  </td>
                  <td class="align-middle">
                    <button type="button" data-toggle="modal" data-target=".bd-example-modal-lg" data-img="<?= $value1["img"] ?>" data-id="<?= $value1["id"] ?>" class="read btn btn-outline-success mx-1">查看</button>
                    <button type="button" data-toggle="modal" data-target="#picModalEdit" data-img="<?= $value1["img"] ?>" data-id="<?= $value1["id"] ?>" class="edit btn btn-outline-info mx-1">編輯</button>
                  </td>
                  <td class="align-middle">
                    <input type="checkbox" data-id="<?= $value1["id"] ?>" name="checkDelete" class="checkboxforDel">
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
          <div class="my-3">
            <!-- table 主列表 photo_tag list end -->


            <!-- 主畫面2 start -->
            <!-- <div class="container">
              <div class="row">
                <?php foreach ($rows1 as $value1) { ?>
                  <div class="col-md-3">
                    <div class="embed-responsive embed-responsive-1by1">
                      <div class="embed-responsive-item">
                        <img class="contain-fit" src="img/<?= $value1["img"] ?>" alt="">
                      </div>
                    </div>
                    <div class="d-flex justify-content-center">
                      <button data-toggle="modal" data-target="#picModalRead" data-img="<?= $value1["img"] ?>" data-id="<?= $value1["id"] ?>" class="btn btn-outline-success read">查看</button>
                      <button data-toggle="modal" data-target="#picModalEdit" data-img="<?= $value1["img"] ?>" data-id="<?= $value1["id"] ?>" class="btn btn-outline-info edit">編輯</button>
                      <button class="btn btn-outline-danger" href="tagDelete.php">刪除
                      </button>
                    </div>
                  </div>
                <?php } ?>
              </div>
              <div id="output"></div>
            </div> -->
            <!-- 主畫面2 end -->

            <!-- Modal Read start -->
            <div class="modal fade bd-example-modal-lg" id="picModalRead" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">查看標籤</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="d-flex justify-content-center">
                      <div class="position-relative" id="tagImgWrap">
                        <figure class="tag-img">
                          <img class="tagImgAdj" id="tagImgRead" src="img/" alt="">
                        </figure>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">關閉</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal Read end -->

            <!-- Modal Edit start -->
            <div class="modal fade bd-example-modal-lg" id="picModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">編輯標籤</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="d-flex justify-content-center">
                      <div class="position-relative" id="tagImgWrapEdit">
                        <figure class="tag-img">
                          <img class="tagImgAdj" id="tagImgEdit" src="img/" alt="">
                        </figure>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">關閉</button>
                    <button type="button" class="btn btn-success header-btn" id="saveEdit">存檔</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal Edit end -->

            <!-- Modal Delete Warning start-->
            <div class="modal fade delete-modal-ml" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-ml" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">刪除照片</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    是否確認刪除照片？
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-success header-btn detail" data-dismiss="modal">關閉</button>
                    <form action="tagDelete.php" method="POST">
                      <input type="hidden" id="checkIDList" name="checkIDList" value="">
                      <button id="deletePost" type="submit" class="btn btn-danger mx-1">刪除</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal Delete Warning end-->
      </main>

    </div>
  </div>
  </div>


  <?php require("../script.php") ?>


  <script>
    // <---***進行標籤tag read start***--->
    let id = 0;
    let productsData = <?= json_encode($products) ?>;
    // console.log(productsData)
    $(".read").click(function() {
      //取得圖片 id
      id = $(this).data("id")
      console.log(id);
      let img = $(this).data("img")
      //設定要編輯的圖片
      $("#tagImgRead").attr("src", "img/" + img);
      let formdata = new FormData();
      formdata.append("img_id", id);
      axios.post('api/loadTag.php', formdata)
        .then(function(response) {
          let tags = response.data;

          tags.forEach((tag) => {
            //依據 api 插入 tag
            let product_id = tag.product_id;
            $("#tagImgWrap").append(`<span
                        data-x="${tag.position_x}"
                        data-y="${tag.position_y}"
                        class='tag-content'>${tag.product_name}</span>`);
            //替剛插入的 tag 設定位置
            let lastTag = $(".tag-content").last();
            $(".tag-content").last().css({
              left: tag.position_x + "%",
              top: tag.position_y + "%"
            })
            // $("#products").clone().appendTo(lastTag);
            lastTag.find("select").val(tag.product_id)
          })
        })
        .catch(function(error) {
          console.log(error)
        });
    })

    function clearTag() {
      //檢查 tag 是空的話就移除 
      $(".tag-content").each(function() {
        if ($(this).text() == "") {
          $(this).remove();
        }
      })
    }
    $('#picModalRead').on('hidden.bs.modal', function(e) {
      //關掉視窗後，清除所有 tag
      clearAllTag();
    })

    function clearAllTag() {
      $(".tag-content").remove();
    }
    $("body").click(function() {
      clearTag()
    })
    // $("#tagImg").click(function(e) {
    //   //阻止氣泡事件
    //   e.stopPropagation();
    //   let width = $(this).width(),
    //     height = $(this).height();
    //   //點下去的位置相對於圖片的位置
    //   let xPos = e.pageX - $(this).offset().left;
    //   let yPos = e.pageY - $(this).offset().top;
    //   let xPercent = (xPos / width) * 100
    //   let yPercent = (yPos / height) * 100
    //   // console.log(xPercent)
    //   $(".tag-content").each(function() {
    //     clearTag()
    //   })
    //   $("#tagImgWrap").append(`<span
    //     data-x="${xPercent}"
    //     data-y="${yPercent}"
    //      class='tag-content' contenteditable></span>`);
    //   $(".tag-content").last().css({
    //     left: xPercent + "%",
    //     top: yPercent + "%"
    //   })
    // })
    // $('#tagImgWrap').on("click", ".tag-content", function(e) {
    //   e.stopPropagation();
    // })

    // $("#save").click(function() {
    //   clearTag()
    //   let tagList = [];
    //   $(".tag-content").each(function() {
    //     tagList.push({
    //       x: $(this).data("x"),
    //       y: $(this).data("y"),
    //       name: $(this).text()
    //     })
    //   })
    // console.log(tagList)
    //   let formdata = new FormData();
    //   formdata.append("img_id", id);
    //   formdata.append("tags", JSON.stringify(tagList));
    //   axios.post('api/saveTag.php', formdata)
    //     .then(function(response) {
    //       console.log(response)
    //     })
    //     .catch(function(error) {
    //       console.log(error)
    //     });
    // })
    // <---***進行標籤tag read end***--->

    // // <---***進行標籤tag edit start***--->
    $(".edit").click(function() {
      //取得圖片 id
      id = $(this).data("id")
      let img = $(this).data("img")
      //設定要編輯的圖片
      $("#tagImgEdit").attr("src", "img/" + img);
      console.log("#tagImgEdit")
      let formdata = new FormData();
      formdata.append("img_id", id);
      axios.post('api/loadTag.php', formdata)
        .then(function(response) {
          let tags = response.data;
          console.log(tags)
          tags.forEach((tag) => {
            //依據 api 插入 tag
            $("#tagImgWrapEdit").append(`<span
                        data-x="${tag.position_x}"
                        data-y="${tag.position_y}"
                        class='tag-content'></span>`);
            //替剛插入的 tag 設定位置
            let lastTag = $(".tag-content").last();
            lastTag.css({
              left: tag.position_x + "%",
              top: tag.position_y + "%"
            })
            $("#products").clone().appendTo(lastTag);
            lastTag.find("select").val(tag.product_id)
          })
        })
        .catch(function(error) {
          console.log(error)
        });
    })

    function clearTag() {
      //檢查 tag 是空的話就移除 
      $(".tag-content").each(function() {
        if ($(this).find("select").val() == 0) {
          $(this).remove();
        }
      })
    }

    const len = 9;
    const ellipsis = document.querySelectorAll('.tag-content');
    ellipsis.forEach((item) => {
      if (item.innerHTML.length > len) {
        let txt = item.innerHTML.substring(0, len) + '...';
        item.innerHTML = txt;
      }
    })

    $('#picModalEdit').on('hidden.bs.modal', function(e) {
      //關掉視窗後，清除所有 tag
      clearAllTag();
    })

    function clearAllTag() {
      $(".tag-content").remove();
    }
    $("body").click(function() {
      clearTag()
    })
    $("#tagImgEdit").click(function(e) {
      //阻止氣泡事件
      e.stopPropagation();
      let width = $(this).width(),
        height = $(this).height();
      //點下去的位置相對於圖片的位置
      let xPos = e.pageX - $(this).offset().left;
      let yPos = e.pageY - $(this).offset().top;
      let xPercent = (xPos / width) * 100
      let yPercent = (yPos / height) * 100
      // console.log(xPercent)
      $(".tag-content").each(function() {
        clearTag()
      })
      $("#tagImgWrapEdit").append(`<span
        data-x="${xPercent}"
        data-y="${yPercent}"
         class='tag-content' contenteditable></span>`);
      let lastTag = $(".tag-content").last();
      lastTag.css({
        left: xPercent + "%",
        top: yPercent + "%"
      })
      $("#products").clone().appendTo(lastTag);

    })
    $('#tagImgWrapEdit').on("click", ".tag-content", function(e) {
      e.stopPropagation();
    })

    $("#saveEdit").click(function() {
      clearTag()
      let tagList = [];
      $(".tag-content").each(function() {
        tagList.push({
          x: $(this).data("x"),
          y: $(this).data("y"),
          product_id: $(this).find("select").val()
        })
      })
      // console.log(tagList)
      let formdata = new FormData();
      formdata.append("img_id", id);
      formdata.append("tags", JSON.stringify(tagList));
      axios.post('api/saveTag.php', formdata)
        .then(function(response) {
          console.log(response)
        })
        .catch(function(error) {
          console.log(error)
        });
    })
    // // <---***進行標籤tag edit end***--->

    //DataTable
    $(document).ready(function() {
      $('#photoTag').DataTable({
        "infoCallback": function(settings, start, end, max, total, pre) {
          return " 共有 " + start + " 至 " + end + " 筆訂單資料 ";
        },
        "lengthMenu": [
          [5, 10, 25, 50, -1],
          [5, 10, 25, 50, "All"]
        ],
        "columnDefs": [{
            "orderable": false,
            "targets": [5]
          },
          {
            "orderable": true,
            "targets": [0, 1, 3, 4]
          }
        ]
      });
    });

    //全選
    $("#checkAll").click(function() {
      let checked = $(this).prop("checked")
      $("tbody :checkbox").prop("checked", checked);
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
      $("input[name='checkDelete']:checked").each(function() {
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