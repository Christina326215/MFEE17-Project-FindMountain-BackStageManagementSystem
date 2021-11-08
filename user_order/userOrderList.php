<?php
  require_once ("../pdo_connect.php");

  if (!isset($_SESSION["user"])) {
    echo "您沒有登入";
    header("location:../login.php");
    exit();
}
  
  $stmt=$db_host->prepare("SELECT order_ship.name AS ship_name, 
  order_status.name AS status_name, 
  pay_status.name AS pay_status_name, 
  pay_way.name AS pay_way_name, 
  order_invoice.name AS order_invoice_name, 
  user.id AS users_id,
  user_order.* 
  FROM user_order
  JOIN order_ship ON user_order.ship = order_ship.id
  JOIN order_status ON user_order.status = order_status.id
  JOIN order_invoice ON user_order.invoice = order_invoice.id
  JOIN pay_status ON user_order.pay_status = pay_status.id
  JOIN pay_way ON user_order.pay_way = pay_way.id
  JOIN user ON user_order.user_id = user.id
  ");
  $stmt1=$db_host->prepare("SELECT id,name FROM product");
  $stmt2=$db_host->prepare("SELECT id FROM user");


  try{
      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $stmt1->execute();
      $rows1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
      $stmt2->execute();
      $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

  }
  catch (PDOException $e){
      echo "資料庫連結失敗<br>";
      echo "Error: ".$e->getMessage(). "<br>";
      exit;
  }
?>


<!doctype html>
<html lang="en">
  <head>
  	<title>訂單管理</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  
  <!-- plug in style star-->
  <?php require("../css.php") ?>
  <!-- plug in style end-->

  <style>
    .cover-fit{
      width: 70%;
      object-fit:cover;
    }
    .formLabelWD{
      width: 40%;
      }
    .formLabelW{
      width: 20%;
    }
  </style>


  </head>

  <body>
		
  <div class="container-fluid">
    <div class="row">

    <!-- navBar star -->
      <div class="sticky-top navAll col-3 col-lg-2 text-white">
        <?php require("../nav-bar.php") ?>
      </div>
    <!-- navBar end -->

      <main class="col-9 col-lg-10">

    <!-- header star -->
        <?php require("../header.php") ?>
          <h3 class="h4 mt-3">訂單管理</h3>
          <hr>
          <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-outline-danger checkBtn mx-2" data-toggle="modal" data-target=".delete-modal-ml" disabled>
            刪除勾選項目
            </button>
            <!-- add button trigger modal -->
            <button type="button" class="btn btn-success header-btn mx-2" data-toggle="modal" data-target=".add-modal-xl" data-id="<?=$value["id"]?>">
            新增訂單
            </button>
          </div>
    <!-- header end -->

      <!-- user_order列表(data table) star -->
        <div class="my-3">
          <table id="example" class="table table-striped table-bordered text-center" style="width:100%">
            <thead>
              <tr>
                <th>訂單編號</th>
                <th>訂購日期</th>
                <th>運送地址</th>
                <th>運送方式</th>
                <th>訂單狀態</th>
                <th>操作</th>
                <th>
                  <input type="checkbox" id="checkAll">
                </th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($rows as $value) { ?>
              <tr>
                <td class="align-middle"><?=$value["id"]?></td>

                <td class="align-middle"><?=$value["time"]?></td>

                <td class="align-middle"><?=$value["addr"]?></td>

                <td class="align-middle"><?=$value["ship_name"]?></td>

                <td class="align-middle"><?=$value["status_name"]?></td>

                <td class="align-middle"> 
                  <!-- view button trigger modal -->
                  <button type="button" class="btn btn-outline-success viewBtn" data-toggle="modal" data-target=".view-modal-xl" data-id="<?=$value["id"]?>">
                    查看
                  </button>

                  <!-- update button trigger modal -->
                  <button type="button" class="btn btn-outline-info updateBtn" data-toggle="modal" data-target=".update-modal-xl" data-id="<?=$value["id"]?>">
                    編輯
                  </button>

                  <!-- delete checkbox trigger modal -->
                  <td class="align-middle">
                    <input data-id="<?= $value["id"] ?>" name="idcheck" type="checkbox" class="checkboxforDel">
                  </td>

                  <!-- delete button trigger modal -->
                  <!-- <button type="button" class="btn btn-outline-danger deleteBtn" data-toggle="modal" data-target=".delete-modal-ml" data-id="<?=$value["id"]?>">
                    刪除
                  </button> -->
                </td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      <!-- user_order列表(data table)  end -->

      </main>
    </div>
  </div>

<!-- add Modal star-->
  <div class="modal fade add-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">新增訂單</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <!-- order_add star -->
          <form action="insertUserOrder.php" method="post" class="formStyle needs-validation" novalidate>

            <div class="mb-2">
                <label class="formLabelW">會員編號:</label>
                <select class="custom-select" name="users_id" required>
                    <option value="">請選擇你的會員編號</option>
                    <?php foreach ($rows2 as $value) { ?>
                    <option><?=$value["id"]?></option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">
                  請選擇你的會員編號
                </div>
            </div>

              <label class="formLabelW">產品名稱:</label><br>
              <input type="hidden" name="checkList" value="[]" id="checkList">

            <?php foreach ($rows1 as $value) { ?>
            <div class="form-row">
              <div class="col-auto">
                  <input type="checkbox" name="check" class="check checkProduct" value="<?=$value["id"]?>">
              </div>
<!-- here -->
              <div class="col-5">
                <?=$value["name"]?>
                <div class="productCheck"></div>
              </div>
              <div class="col">
                  <input type="number" name="num" class="form-control checkNum num" min=0>
                  <div class="numCheck"></div>
              </div>        
            </div>
            <hr style="background: #6DA77F;">
            <?php } ?>

            <div class="mb-2">
                <label>地址:</label>
                <input type="text" class="form-control" name="addr" required>
                <div class="invalid-feedback">
                  請輸入地址
                </div>
            </div>

            <div class="mb-2">
                <label>訂單狀態:
                <input type="radio" name="status_name" value="1" checked>未處理
                </label>
            </div>

            <div class="mb-2">
                <label>運送方式:
                <input type="radio" name="ship_name" value="1" checked>宅配到府
                <input type="radio" name="ship_name" value="2">超商取貨
                </label>
            </div>

            <div class="mb-2">
                <label>付款方式:
                <input type="radio" name="pay_way_name" value="1" checked>信用卡
                <input type="radio" name="pay_way_name" value="2">貨到付款
                </label>
            </div>

            <div class="mb-2 d-flex justify-content-between">
                <label>發票類型:
                <input type="radio" name="order_invoice_name" value="1" checked>二聯式
                <input type="radio" name="order_invoice_name" value="2">開立統編
                </label>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary detail" data-dismiss="modal">關閉</button>
              <button class="btn btn-success header-btn" type="submit" id="addBtn">新增</button>
            </div>

          </form>
          <!-- order_add end -->
        </div>

      </div>
    </div>
  </div>
<!-- add Modal end-->

<!-- view Modal star-->
  <div class="modal fade view-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">查看訂單</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <!-- view order_read star -->
          <form method="post" class="formStyle">

            <table class="table table-bordered">
              <tbody>

                <tr>
                  <th scope="row" class="col-1">訂單編號</th>
                  <td colspan="2" class="col-2">
                    <input id="id" type="text" class="form-control" readonly>
                  </td>

                  <th class="col-1">訂購日期</th>
                  <td colspan="2" class="col-8">
                    <input id="time" type="text" class="form-control" readonly>
                  </td>

                </tr>

                <tr>
                  <th scope="row" class="col-1">會員編號</th>
                    <td colspan="2" class="col-2">
                      <input id="users_id" type="text" class="form-control" readonly>
                    </td>

                  <th class="col-1">地址</th>
                    <td colspan="2" class="col-8">
                      <input id="addr" type="text" class="form-control" readonly>
                    </td>
                </tr>

                <tr>
                  <th scope="row" class="col-1">付款方式</th>
                    <td colspan="2" class="col-5">
                      <input id="pay_way_name" type="text" class="form-control" readonly>
                    </td>

                  <th class="col-1">付款狀態</th>
                    <td colspan="2" class="col-5">
                      <input id="pay_status_name" type="text" class="form-control" readonly>
                    </td>
                </tr>

                <tr>
                  <th scope="row" class="col-1">訂單狀態</th>
                    <td class="col-3">
                      <input id="status_name" type="text" class="form-control" readonly>
                    </td>

                  <th class="col-1">運送方式</th>
                    <td class="col-3">
                      <input id="ship_name" type="text" class="form-control" readonly>
                    </td>

                  <th class="col-1">發票類型</th>
                    <td class="col-3">
                      <input id="order_invoice_name" type="text" class="form-control" readonly>
                    </td>
                </tr>

              </tbody>
            </table>

            <div class="mb-2 d-flex flex-column">

              <div>
                <table class="table"  id="product_info">
                  <thead>
                    <tr>
                      <th>產品圖片:</th>
                      <th>名稱:</th>
                      <th>數量:</th>
                      <th>價錢:</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>
              </div>
                
            </div>

          </form>
          <!-- view order_read end -->
        </div>

        <div class="modal-footer">
          <label>總計: <span id="total">
          </span></label>
          <button type="button" class="btn btn-outline-secondary detail" data-dismiss="modal">關閉</button>

        </div>
      </div>
    </div>
  </div>
<!-- view Modal end-->

<!-- update Modal star-->
  <div class="modal fade update-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">編輯訂單</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
        <!-- order_update star -->
          <form action="updateUserOrder.php" method="post" class="formStyle">


          <table class="table table-bordered">
              <tbody>

                <tr>
                  <th scope="row" class="col-1">訂單編號</th>
                  <td colspan="2" class="col-2">
                    <input type="text" class="form-control" name="id" id="order_id" readonly>
                  </td>

                  <th class="col-1">訂購日期</th>
                  <td colspan="2" class="col-8">
                    <input type="text" class="form-control" name="time" id="order_time" readonly>
                  </td>

                </tr>

                <tr>
                  <th scope="row" class="col-1">會員編號</th>
                    <td colspan="2" class="col-2">
                      <input type="text" class="form-control" name="users_id" id="user_id" readonly>
                    </td>

                  <th class="col-1">地址</th>
                    <td colspan="2" class="col-8">
                      <!-- <input id="addr" type="text" class="form-control" readonly> -->
                      <input id="order_addr" type="text" class="form-control" name="addr">
                    </td>
                </tr>

                <tr>
                  <th scope="row" class="col-1">付款方式</th>
                    <td colspan="2" class="col-5">
                      <!-- <input id="pay_way_name" type="text" class="form-control" readonly> -->
                      <select name="pay_way_name" id="order_pay_way" class="form-control">
                        <option value="1">信用卡</option>
                        <option value="2">貨到付款</option>
                      </select>
                    </td>

                  <th class="col-1">付款狀態</th>
                    <td colspan="2" class="col-5">
                      <!-- <input id="pay_status_name" type="text" class="form-control" readonly> -->
                      <select name="pay_status_name" id="order_pay_status" class="form-control">
                        <option value="1">已付款</option>
                        <option value="2">未付款</option>
                      </select>
                    </td>
                </tr>

                <tr>
                  <th scope="row" class="col-1">訂單狀態</th>
                    <td class="col-3">
                      <!-- <input id="status_name" type="text" class="form-control" readonly> -->
                      <select name="status_name" id="order_status" class="form-control">
                        <option value="1">未處理</option>
                        <option value="2">處理中</option>
                        <option value="3">已完成</option>
                      </select>
                    </td>

                  <th class="col-1">運送方式</th>
                    <td class="col-3">
                      <!-- <input id="ship_name" type="text" class="form-control" readonly> -->
                      <select name="ship_name" id="order_ship_name" class="form-control">
                        <option value="1">宅配到府</option>
                        <option value="2">超商取貨</option>
                      </select>
                    </td>

                  <th class="col-1">發票類型</th>
                    <td class="col-3">
                      <!-- <input id="order_invoice_name" type="text" class="form-control" readonly> -->
                      <select name="order_invoice_name" id="order_invoice" class="form-control">
                        <option value="1">二聯式</option>
                        <option value="2">開立統編</option>
                      </select>
                    </td>
                </tr>

              </tbody>
            </table>

            <div class="mb-2 d-flex flex-column">

              <div>
                <table class="table"  id="product_detail">
                  <thead>
                    <tr>
                      <th>產品圖片:</th>
                      <th>名稱:</th>
                      <th>數量:</th>
                      <th>價錢:</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>
              </div>
                
            </div>

            <div class="modal-footer">
              <label>總計: <span id="sum">
              </span></label>
              <button type="button" class="btn btn-outline-secondary detail" data-dismiss="modal">關閉</button>
              <button class="btn btn-success header-btn" type="submit">更新</button>
            </div>
          </form>
        <!-- order_update end -->
        </div>

      </div>
    </div>
  </div>
<!-- update Modal end-->

<!-- Modal delete warning-->
  <div class="modal fade delete-modal-ml" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-ml" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">刪除訂單</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          是否確認刪除資料？
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success header-btn detail" data-dismiss="modal">關閉</button>
          <form action="deleteUserOrderPost.php" method="POST">
            <input type="hidden" id="checkIDList" name="checkIDList" value="">
            <button id="deletePost" type="submit" class="btn btn-danger mx-1">刪除</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<!-- end-->

<!-- delete Modal star-->
  <!-- <div class="modal fade delete-modal-ml" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-ml" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">刪除訂單</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          是否確認刪除此筆訂單？
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-success header-btn detail" data-dismiss="modal">關閉</button>
          <a role="button" class="btn btn-danger realDel" href="">刪除</a>

        </div>
      </div>
    </div>
  </div> -->
<!-- delete Modal end-->

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





//===產品&數量複選判斷star==//
          let productInput=$(".checkProduct");
          let numInput=$(".checkNum");
          let checkedCount = $(".checkProduct:checked").length;
          let addNum=$("input[name='check']:checked").closest(".form-row").find(".num").val();

          if(checkedCount<1){
            productInput.prop("required",true);
            event.preventDefault();
            event.stopPropagation();
            $(".productCheck").text("請選擇產品");
            $(".productCheck").css({"color":"#dc3545","font-size":"80%"});
            if(addNum >= 1){
              numInput.prop("required",false);
              $(".numCheck").text("");
            }
            else{
              console.log("num in");
              numInput.prop("required",true);
              event.preventDefault();
              event.stopPropagation();
              $(".numCheck").text("請輸入數量");
              $(".numCheck").css({"color":"#dc3545","font-size":"80%"});
            }
          }

          else{
            productInput.prop("required",false);
            $(".productCheck").text("");
            if(addNum >= 1){
              numInput.prop("required",false);
              $(".numCheck").text("");
            }
            else{
              console.log("num in");
              numInput.prop("required",true);
              event.preventDefault();
              event.stopPropagation();
              $(".numCheck").text("請輸入數量");
              $(".numCheck").css({"color":"#dc3545","font-size":"80%"});
            }
          };
//===產品&數量複選判斷end==//



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

<!-- below script -->
<?php require("order_script.php") ?>
<!-- above script -->

  </body>
</html>