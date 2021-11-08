<?php
require_once("pdo_connect.php");
if (isset($_SESSION["log_in"])) {
    header("location: mountain_admin/user-list.php");
}
?>

<!doctype html>
<html lang="zh-tw">

<head>
    <title>後台登入</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!--vegas-->
    <link rel="stylesheet" href="/project/vegas/vegas.css">
    <style>
        body {
            color: #111;
            font-family: Rubik, -apple-system, BlinkMacSystemFont, segoe ui, 微軟正黑體, microsoft jhenghei, sans-serif;
        }

        .bg-pic {
            /* background: #6DA77F; */
            height: 100vh;
        }

        .w-50-l {
            width: 50%;
        }

        .form-control {
            border-radius: 20px;
        }

        .btn-css {
            border: 1px solid #6DA77F;
            color: #6DA77F;
        }

        .btn-css:hover {
            background: #6DA77F;
            color: #f5f5f5;
        }

        .logobox {
            width: 100%;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        .logo {
            width: 100%;
            height: 150px;
            background: rgba(245, 245, 245, .5);
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
    </style>
</head>

<body>
    <div class="">
        <div class="d-flex">
            <div class="w-50-l bg-pic p-3 position-relative">
                <div class="position-absolute logobox">
                    <figure class="logo">
                        <img src="/project/logoHome.svg" alt="logo">
                    </figure>
                </div>
            </div>
            <div class="w-50-l p-5 align-self-center">
                <?php if (isset($_SESSION["error"]) && $_SESSION["error"]["times"] > 3) : ?>
                    <h3 class="">後台管理登入</h3>
                    <div class="text-danger">您輸入次數過多，請稍後再重新操作</div>
                <?php else : ?>
                    <form action="doLogin.php" method="post" id="form">
                        <h3 class="text-center pb-5">後台管理登入</h3>
                        <div class="mb-2">
                            <label for="account">帳號</label>
                            <input type="text" name="account" id="account" class="form-control" placeholder="Account">
                        </div>
                        <div class="mb-2">
                            <label for="password">密碼</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        </div>
                        <?php if (isset($_SESSION["error"])) : ?>
                            <div class="mb-2">
                                <small class="text-danger"><?php echo $_SESSION["error"]["message"] ?>, 登入錯誤次數 <?php echo $_SESSION["error"]["times"] ?></small>
                            </div>
                        <?php endif; ?>

                        <button class="btn btn-css" id="btnLogin" type="submit">登入</button>
                    </form>
                <?php endif; ?>
            </div>

        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!--vegas-->
    <script src="http://zeptojs.com/zepto.min.js"></script>
    <script src="/project/vegas/vegas.min.js"></script>
    <script>
        //vegas
        $(".bg-pic").vegas({
            timer: false,
            delay: 3200,
            autoplay: true,
            loop: true,
            slides: [{
                    src: "/project/vegas/img/pic1.webp"
                },
                {
                    src: "/project/vegas/img/pic2.webp"
                },
                {
                    src: "/project/vegas/img/pic3.webp"
                },
                {
                    src: "/project/vegas/img/pic4.jpeg"
                }
            ],
            transition: 'fade2'
        });
        // $("#login").click(function() {
        //     let account = $("#account").val()
        //     let password = $("#password").val()
        //     let formdata = new FormData();
        //     formdata.append("account", account);
        //     formdata.append("password", password);

        //     axios.post('api/do-login.php', formdata)
        //         .then(function(response) {
        //             // console.log(response);
        //             let status = response.data.status;
        //             if (status === 1) {
        //                 location.href = ""
        //             } else if (status === 2) {
        //                 $("#login-error").text("帳號密碼錯誤")
        //             }

        //         })
        //         .catch(function(error) {
        //             console.log(error);
        //         });
        // })
    </script>
</body>

</html>