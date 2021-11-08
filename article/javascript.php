<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
<script>
    //點擊上列表格 出現對應編輯內容 未完成
    // $("#articleForm tr").on("click", function() {
    //     let id = $(this).data("id");
    //     console.log(id);
    //     $(".articleEdit").toggleClass("open");
    // })


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

    //create監聽輸入
    $(".createContent").on('input propertychange', function() {

        //獲取輸入內容
        var userDesc = $(this).val();

        //判斷字數
        var len;
        if (userDesc) {
            len = checkStrLengths(userDesc, 3000);
        } else {
            len = 0
        }

        //顯示字數
        $(".createNum").html(len + '/3000');
    });

    //update監聽輸入
    $(".updateContent").on('input propertychange', function() {
        //獲取輸入內容
        var userDesc = $(this).val();

        //判斷字數
        var len;
        if (userDesc) {
            len = checkStrLengths(userDesc, 3000);
        } else {
            len = 0;
        }

        //顯示字數
        $(".updateNum").html(len + '/3000');

    });


    $(document).ready(function() {
        //bs-custom-file-input
        bsCustomFileInput.init();

        //  datatable
        $('#example').DataTable({

            "infoCallback": function(settings, start, end, max, total, pre) {
                return " 共有 " + start + " 至 " + end + " 筆訂單資料 ";
            }, //datatables infoCallback 設定共幾筆筆數

            "lengthMenu": [5, 10, 25, 50, "All"], // datatables lengthMenu 設定頁面筆數
            "columnDefs": [{
                    "orderable": false,
                    "targets": [1, 3, 6, 7]
                },
                {
                    "orderable": true,
                    "targets": [0, 2, 4, 5]
                }
            ],
        });
    });



    //檢查輸入空白驗證
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {

                    //季節複選判斷
                    let seasonInput = $(".form-check-input");
                    let checkedCount = $(".form-check-input:checked").length;
                    // let defaultCheck1=$("#defaultCheck1");
                    // console.log(checkedCount);
                    // console.log(seasonInput);
                    if (checkedCount < 1) {
                        // console.log(defaultCheck1);
                        seasonInput.prop("required", true);
                        event.preventDefault();
                        event.stopPropagation();
                        $(".season").text("請選擇最適季節");
                        $(".season").css({
                            "color": "#dc3545",
                            "font-size": "80%"
                        });

                        // console.log("1");
                    } else {
                        // seasonInput.setCustomValidity('');
                        // console.log("2");
                        seasonInput.prop("required", false);
                        $(".season").text("");
                    };

                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();



    //查看彈出視窗
    $(".check").click(function() {
        let id = $(this).data("id");
        // console.log(id);

        let formdata = new FormData(); //填充表格數據
        formdata.append("id", id);

        //用axios抓json格式
        //axios 用get或post都可以 沒有參數的話用get 有其他參數的話用post
        axios.post('api/articleCheck.php', formdata)
            .then(function(response) {
                // console.log(response.data);
                let data = response.data;
                // console.log(data);
                // console.log(data.status_name);
                $("#checkName").val(data.name);
                $("#checkStatus").val(data.status);
                $("#checkCity").val(data.city);
                // $("#checkTime").val(data.time);
                $("#checkHeight").val(data.height);
                $("#checkLevel").val(data.level);
                $("#checkDistance").val(data.distance);
                $("#checkMountain_type").val(data.mountain_type);
                $("#checkApply").val(data.apply);
                $("#checkGap").val(data.gap);
                $("#checkRoad_status").val(data.road_status);
                $("#checkTraffic").val(data.traffic);
                $("#checkPic").attr('src', `img/${data.pic}`)
                $("#checkContent").val(data.content);
                // $("#deletearticle").text(data.name);
                // $("#deleteid").text(data.id);

                let total_D = (data.time) / 1440; //分鐘換算總天數
                let $int_D = Math.floor(total_D); //天數取整數
                let total_H = (total_D - $int_D) * 24 //剩下的小時數
                let $int_H = Math.floor(total_H); //小時取整數
                let total_M = (total_H - $int_H) * 60 //剩下的分鐘數
                let $int_M = Math.round(total_M) //分鐘取整數

                // console.log($int_D);
                // console.log($int_H);
                // console.log($int_M);

                $("#checkTime_D").val($int_D);
                $("#checkTime_H").val($int_H);
                $("#checkTime_M").val($int_M);

                //笨方法 待問
                $season_item = data.season;
                let content = "";
                if (/1/.test($season_item)) {
                    // console.log("1");
                    content += `春季 `
                }
                if (/2/.test($season_item)) {
                    // console.log("2");
                    content += `夏季 `
                }
                if (/3/.test($season_item)) {
                    // console.log("3");
                    content += `秋季 `
                }
                if (/4/.test($season_item)) {
                    // console.log("4");
                    content += `冬季 `
                }
                // console.log(content);
                $("#checkSeason").text(content);


            })
            .catch(function(error) {
                console.log(error);
            });
    })

    //更新彈出視窗
    $(".update").click(function() {
        let id = $(this).data("id");
        // console.log(id);

        let formdata = new FormData(); //填充表格數據
        formdata.append("id", id);

        //用axios抓json格式
        //axios 用get或post都可以 沒有參數的話用get 有其他參數的話用post
        axios.post('api/articleCheck.php', formdata)
            .then(function(response) {
                // console.log(response.data);
                let data = response.data;
                // console.log(data);
                // console.log(data.status_name);
                $("#updateName").val(data.name);
                $("#updateStatus").val(data.status);
                $("#updateCity").val(data.city);
                // $("#updateTime").val(data.time);
                $("#updateHeight").val(data.height);
                $("#updateLevel").val(data.level);
                $("#updateDistance").val(data.distance);
                $("#updateMountain_type").val(data.mountain_type);
                $("#updateApply").val(data.apply);
                $("#updateGap").val(data.gap);
                $("#updateRoad_status").val(data.road_status);
                $("#updateTraffic").val(data.traffic);
                // $("#updatePic").attr('src', `img/${data.pic}`)
                $("#updateshowPic").attr('src', `img/${data.pic}`);
                $("#updateOldpic").val(data.pic);
                $("#updateContent").val(data.content);
                $("#updateId").val(data.id);
                // console.log(data.id);


                $season_item = data.season;
                $(".form-check-input").prop("checked", false); //點擊外部按鈕時要先清空先前的

                if (/1/.test($season_item)) {
                    $("#updateSeson_sp").prop("checked", true);
                }
                if (/2/.test($season_item)) {
                    $("#updateSeson_su").prop("checked", true);
                }
                if (/3/.test($season_item)) {
                    $("#updateSeson_au").prop("checked", true);
                }
                if (/4/.test($season_item)) {
                    $("#updateSeson_wi").prop("checked", true);
                }



                let total_D = (data.time) / 1440; //分鐘換算總天數
                let $int_D = Math.floor(total_D); //天數取整數
                let total_H = (total_D - $int_D) * 24 //剩下的小時數
                let $int_H = Math.floor(total_H); //小時取整數
                let total_M = (total_H - $int_H) * 60 //剩下的分鐘數
                let $int_M = Math.round(total_M) //分鐘取整數

                // console.log($int_D);
                // console.log($int_H);
                // console.log($int_M);

                $("#updateTime_D").val($int_D);
                $("#updateTime_H").val($int_H);
                $("#updateTime_M").val($int_M);


                //封裝一個限制字數方法
                // var checkStrLengths = function(str, maxLength) {
                //     var maxLength = maxLength;
                //     var result = 0;
                //     if (str && str.length > maxLength) {
                //         result = maxLength;
                //     } else {
                //         result = str.length;
                //     }
                //     return result;
                // }

                //update監聽輸入
                // $(".updateContent").on('input propertychange', function() {

                //獲取輸入內容
                var userDesc = data.content;

                //判斷字數
                var len;
                if (userDesc) {
                    len = checkStrLengths(userDesc, 3000);
                } else {
                    len = 0;
                }

                //顯示字數
                $(".updateNum").html(len + '/3000');
                // });

            })
            .catch(function(error) {
                console.log(error);
            });
    })


    //刪除彈出視窗
    $(".delete").click(function() {
        let id = $(this).data("id");
        // console.log(id);
        let delbtn = "";
        $(".realdel").html(``) //點擊外部按鈕時要先清空先前的cone
        delbtn += `
            <a role="button" id="delete" class="btn btn-danger mx-1" href="articleDelete.php?id=${id}">刪除</a>
            `
        $(".realdel").append(delbtn);
        // console.log(delbtn);
    })


    //checkbox刪除
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
</script>