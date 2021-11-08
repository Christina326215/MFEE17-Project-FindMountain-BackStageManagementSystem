<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->

<!-- datatable js -->
  <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
  <!-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script> -->
<!-- axios js -->
  <!-- <script src="https://unpkg.com/axios/dist/axios.min.js"></script> -->
<!-- =========================== above plug in =========================== -->

<!-- jquery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- datatable js -->
<script src=" https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<!-- bootstrap4 js -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<!-- axios -->
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<!-- =========================== above plug in =========================== -->


<script>
    //======Below data table======//
      $(document).ready(function() {
        $('#example').DataTable({
          "infoCallback": function( settings, start, end, max, total, pre ) {
          return " 共有 " + start +" 至 "+ end +" 筆訂單資料 ";},
          "lengthMenu": [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ],
          "columnDefs": [
                { "orderable": false, "targets": [5, 6] },
                { "orderable": true, "targets": [0, 1, 3, 4] }
                ]
          });
        });
    //======Above data table======//


    //======Below axios order_read======//
      $(".viewBtn").click(function() {
        let id = $(this).data("id")

        let formdata = new FormData();
        formdata.append("id", id);

        axios.post('axiosReadUserOrder.php', formdata)
          .then(function(response) {
            let data = response.data;
            let dataLength = data.length;

            $("#id").val(data[0].id)
            $("#users_id").val(data[0].users_id)
            $("#time").val(data[0].time)
            $("#addr").val(data[0].addr)
            $("#status_name").val(data[0].status_name)
            $("#ship_name").val(data[0].ship_name)
            $("#pay_way_name").val(data[0].pay_way_name)
            $("#pay_status_name").val(data[0].pay_status_name)
            $("#order_invoice_name").val(data[0].order_invoice_name)

            let total=0;
            let content="";
            $("#product_info").find("tbody").html(`
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                </tr>
            `)
            for (i = 0; i < dataLength; i++) {
              let subtotal = data[i].user_order_num*data[i].product_price;
              total+=subtotal;
              content+=`
                    <tr>
                      <td class="formLabelWD"><img class="cover-fit" src="img/${data[i].product_pic}"></td>
                      <td class="formLabelW">${data[i].product_name}</td>
                      <td class="formLabelW">${data[i].user_order_num}</td>
                      <td class="formLabelW">${data[i].product_price}</td>
                    </tr>
              `
            }
            $("#product_info").find("tbody").append(content);
            $("#total").text(total);
          })

          .catch(function(error) {
            console.log(error);
          });
      })
    //======Above axios order_read======//

    //======Below axios order_update======//
      $(".updateBtn").click(function() {
        let id = $(this).data("id")

        let formdata = new FormData();
        formdata.append("id", id);

        axios.post('axiosReadUserOrder.php', formdata)
          .then(function(response) {
            let data = response.data;
            let dataLength = data.length;
            $("#order_id").val(data[0].id)
            $("#user_id").val(data[0].users_id)
            $("#order_time").val(data[0].time)
            $("#order_addr").val(data[0].addr)
            $("#order_status").val(data[0].status)
            $("#order_ship_name").val(data[0].ship)
            $("#order_pay_way").val(data[0].pay_way)
            $("#order_pay_status").val(data[0].pay_status)
            $("#order_invoice").val(data[0].invoice)

            //===append product_detail star===// 
            let total=0;
            let content="";
            $("#product_detail").find("tbody").html(`
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                </tr>
            `)
            for (i = 0; i < dataLength; i++) {
              let subtotal = data[i].user_order_num*data[i].product_price;
              total+=subtotal;
              content+=`
                <tr>
                  <td class="formLabelWD"><img class="cover-fit" src="img/${data[i].product_pic}"></td>
                  <td class="formLabelW">${data[i].product_name}</td>
                  <td class="formLabelW">${data[i].user_order_num}</td>
                  <td class="formLabelW">${data[i].product_price}</td>
                </tr>
              `
            }
            $("#product_detail").find("tbody").append(content);
            $("#sum").text(total);
            //===append product_detail end===// 

          })

          .catch(function(error) {
            console.log(error);
          });
      })
    //======Above axios order_update======//

    //======Below checked order_delete======//
      //全選
      $("#checkAll").click(function() {
        let checked = $(this).prop("checked")
        $("tbody :checkbox").prop("checked", checked)

        let checkLength=$('.checkboxforDel').filter(':checked').length
        // console.log(checkLength)
        if (checkLength>0) {
          $('.checkBtn').removeAttr('disabled'); //enable input
        } 
        else {
          $('.checkBtn').attr('disabled', true); //disable input
        }
      })
      //防止未勾選資料卻按刪除鍵
      $(".checkboxforDel").click(function(){
        let checkLength=$('.checkboxforDel').filter(':checked').length
        // console.log(checkLength)
        if (checkLength>0) {
          $('.checkBtn').removeAttr('disabled'); //enable input
        } 
        else {
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
    //======Above checked order_delete======//


    //======Below let product's id and num keep in jason======//
      function checkArr(){
          let checkArr=[];
          $("input[name='check']:checked").each
          (function(){
            let number=$(this).closest(".form-row").find(".num").val()
            checkArr.push({
              product: $(this).val(),
              number: number
            });
          })
          let checkString=JSON.stringify(checkArr)
          $("#checkList").val(checkString)
      }

        $("input[name='check']").click(function(){
          checkArr();
        })
        $("input[name='num']").click(function(){
          checkArr();
        })
    //======Above let product's id and num keep in jason======//

    //======Below verify the product and num added to the order======//
      // $("#addBtn").click(function(){
      //       let addCheck=$("input[name='check']:checked").length;//判斷有多少個方框被勾選
      //       let addNum=$("input[name='check']:checked").closest(".form-row").find(".num").val();//判斷被勾選方框的數量值
      //       // console.log(addCheck);
      //       // console.log(addNum);
      //       if(addCheck == 0){
      // 		    alert("您尚未勾選任何產品");
      // 		    return false;//不要提交表單
      // 	    }
      //       if(addNum == 0){
      // 		    alert("您尚未輸入數量");
      // 		    return false;//不要提交表單
      //       }
      //       else{
      //         return true;//提交表單
      //       }
      //     })
    //======Above verify the product and num added to the order======//

//======================below not used======================//
    //======Below order_delete======//
    // $(".deleteBtn").click(function(){
    //   let id = $(this).data("id")
    //   $(".realDel").attr("href",`deleteUserOrder.php?id=${id}`)
    // })
    //======Above order_delete======//

</script>
