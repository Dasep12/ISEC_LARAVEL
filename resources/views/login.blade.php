<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Isecurity | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/dist/fontawesome-free/css/all.min.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap-3.3.7/css/bootstrap.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/icon.png">

    

    <style type="text/css">
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            /* background-color: #f5f5f5;*/
            background-image: url('./assets/dist/img/bg-login-2.jpg');
            background-size: cover;
        }
        .alert { padding: 5px 10px !important; }
        .logo { width: 70%; height: auto; }
        .form-bg {
            margin: auto;
        }
        .form-container{
            /*background: linear-gradient(#E9374C,#D31128);*/
            /*background: linear-gradient(#b16262,#fb0103);*/
            position: relative;
            background: rgb(38 49 74 / 66%);
            font-family: 'Roboto', sans-serif;
            font-size: 0;
            padding: 0 15px;
            /*border: 1px solid #DC2036;*/
            border: transparent;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }
        .form-container .form-icon{
            color: #fff;
            font-size: 13px;
            text-align: center;
            text-shadow: 0 0 20px rgba(0,0,0,0.2);
            width: 50%;
            padding: 70px 0;
            vertical-align: top;
            display: inline-block;
        }
        .form-container .form-icon i{
            font-size: 124px;
            margin: 0 0 15px;
            display: block;
        }
        .form-container .form-icon .signup a{
            color: #fff;
            text-transform: capitalize;
            transition: all 0.3s ease;
        }
        .form-container .form-icon .signup a:hover{ text-decoration: underline; }
        .form-container .form-horizontal{
            /*background: rgba(255,255,255,0.99);*/
            /* background: linear-gradient(#f76262,#fb0103);*/
            background: linear-gradient(#9497d3b3,#fb010305);
            width: 50%;
            padding: 60px 30px;
            margin: -20px 0;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
            display: inline-block;
        }
        .form-container .title{
            /*color: #454545;*/
            color: #fff;
            font-size: 23px;
            font-weight: 900;
            text-align: center;
            text-transform: capitalize;
            letter-spacing: 0.5px;
            margin: 0 0 30px 0;
        }
        .form-horizontal .form-group{
            background-color: rgba(255,255,255,0.15);
            margin: 0 0 15px;
            /*border: 1px solid #b5b5b5;*/
            border: 1px solid #ffffff;
            border-radius: 20px;
        }
        .form-horizontal .input-icon{
            /*color: #b5b5b5;*/
            color: #fff;
            font-size: 15px;
            text-align: center;
            line-height: 38px;
            height: 35px;
            width: 40px;
            vertical-align: top;
            display: inline-block;
        }
        .form-horizontal .form-control{
            /*color: #b5b5b5;*/
            color: #ffffff;
            background-color: transparent;
            font-size: 14px;
            letter-spacing: 1px;
            width: calc(100% - 55px);
            height: 33px;
            padding: 2px 10px 0 0;
            box-shadow: none;
            border: none;
            border-radius: 0;
            display: inline-block;
            transition: all 0.3s;
        }
        .form-control:active, .form-control:focus {
            background-color: transparent;
        }
        .form-horizontal .form-control:focus{
            box-shadow: none;
            border: none;
        }
        .form-horizontal .form-control::placeholder{
            /*color: #b5b5b5;*/
            color: #ffffff;
            font-size: 13px;
            text-transform: capitalize;
        }
        .form-control:-webkit-autofill,
        .form-control:-webkit-autofill:hover,
        .form-control:-webkit-autofill:focus,
        .form-control:-webkit-autofill:active {
            transition: background-color 5000s ease-in-out 0s;
            -webkit-text-fill-color: #fff !important;
        }
        .form-horizontal .btn{
            padding: 10px 0;
            color: #ffffff;
            /*background: #E9374C;*/
            background: rgb(148 151 211 / 58%);
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            width: 100%;
            margin: 0 0 10px 0;
            border: none;
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        .form-horizontal .btn:hover,
        .form-horizontal .btn:focus{
            color: #fff;
            background-color: #45486a;
            /*box-shadow: 0 0 5px rgba(0,0,0,0.5);*/
            box-shadow: 0 0 5px #ffffff;
        }
        .form-horizontal .forgot-pass{
            font-size: 12px;
            text-align: center;
            display: block;
        }
        .form-horizontal .forgot-pass a{
            color: #999;
            transition: all 0.3s ease;
        }
        .form-horizontal .forgot-pass a:hover{
            color: #777;
            text-decoration: underline;
        }
        .head-logos {
            position: absolute;
            top: 0;
            left: 0;
            display: flex;
            padding: 10px;
        }
            .head-logos img {
                display: block;
                width: 100%;
                max-width: 100%;
                height: 40px;
                padding-left: 10px;
            }
        .field-icon {
            float: right;
            /* margin-left: -25px;
            margin-top: -25px; */
            position: relative;
            z-index: 2;
        }
            .field-icon i {
                position: absolute;
                top: 10px;
                right: 10px;
                font-size: 15px;
                color: #ffffff;
            }
        @media only screen and (max-width:576px){
            .form-container{ padding-bottom: 15px; }
            .form-container .form-icon{
                width: 100%;
                padding: 20px 0;
            }
            .form-container .form-horizontal{
                width: 100%;
                margin: 0;
            }
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="form-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-offset-2 col-lg-8 col-md-offset-2 col-md-8">
                    <div class="form-container">
                        <div class="head-logos">
                            <img src="./assets/dist/img/daihatsu-sahabatku.png">
                            <img src="./assets/dist/img/i-care.png">
                            <img src="./assets/dist/img/logo_admcomunity.png">
                        </div>

                        <div class="form-icon">
                            <!-- <i class="fa fa-user-circle"></i> -->
                            <img class="logo" src="./assets/dist/img/img-login-1.png">
                            <!-- <span class="signup"><a href="">Don't have account? Signup</a></span> -->
                        </div>

                        <form class="form-horizontal" onsubmit="return cek()" action="{{ URL::route('auth.login') }}" method="post">
                            @csrf
                            
                            @if($msg = Session::get('error'))  
                                <div class="mt-3 alert alert-danger">       
                                  <h5>{{ $msg }}</h5>
                                </div>        
                            @else

                            @endif

                            <h3 class="title">Security Big Data Analytic</h3>
                            <div class="form-group">
                                <span class="input-icon"><i class="fa fa-envelope"></i></span>
                                <input class="form-control" type="text" id="username" name="username" placeholder="Username">
                            </div>

                            <div class="form-group">
                                <span class="input-icon"><i class="fa fa-lock"></i></span>
                                <input class="form-control" type="password" name="password" id="password" placeholder="Password">
                                <span toggle="#password-field" class="field-icon toggle-password">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                    <!-- <svg fill="#000000" height="15px" width="15px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 612 612" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M609.608,315.426c3.19-5.874,3.19-12.979,0-18.853c-58.464-107.643-172.5-180.72-303.607-180.72 S60.857,188.931,2.393,296.573c-3.19,5.874-3.19,12.979,0,18.853C60.858,423.069,174.892,496.147,306,496.147 S551.143,423.069,609.608,315.426z M306,451.855c-80.554,0-145.855-65.302-145.855-145.855S225.446,160.144,306,160.144 S451.856,225.446,451.856,306S386.554,451.855,306,451.855z"></path> <path d="M306,231.67c-6.136,0-12.095,0.749-17.798,2.15c5.841,6.76,9.383,15.563,9.383,25.198c0,21.3-17.267,38.568-38.568,38.568 c-9.635,0-18.438-3.541-25.198-9.383c-1.401,5.703-2.15,11.662-2.15,17.798c0,41.052,33.279,74.33,74.33,74.33 s74.33-33.279,74.33-74.33S347.052,231.67,306,231.67z"></path> </g> </g> </g></svg> -->
                                </span>
                            </div>

                            <button class="btn signin" type="submit">Login</button>
                            <!-- <span class="forgot-pass"><a href="#">Forgot Username/Password?</a></span> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="assets/dist/js/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <!-- <script src="assets/dist/js/adminlte.min.js"></script> -->

    <script>
        function cek() {
            if (document.getElementById("username").value == "") {
                alert("isi username");
                $("#username").focus();
                return false;
            } 
            else if (document.getElementById("password").value == "") {
                alert("isi password");
                $("#password").focus();
                return false;
            }
            return;
        }

        $(".toggle-password").click(function() {
            $(this).children('i').toggleClass("fa-eye fa-eye-slash");

            var input = $("#password");
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>
</body>

</html>