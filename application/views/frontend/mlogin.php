<!DOCTYPE html>
<html lang="en">
<head>
    <!--[if IE]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <title>SBS | Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="icon" type="image/png" href="<?= base_url() ?>assets/assets/images/favicon.png">
    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/animation-style.css">
    <link href="https://fonts.googleapis.com/css?family=Lato|Montserrat:300|Source+Sans+Pro" rel="stylesheet">
    <style>


        .form-control {
            border-radius: 0;
        }

        body {
            font-family: "Montserrat", sans-serif;
            background-image: url('http://2.bp.blogspot.com/-O7zb2a3_ECw/UNM_aS7jEFI/AAAAAAAAAKM/o4qt9uo_1HM/s1600/bg.png');
            background-size: cover;
            color: #ffffff;
        }

        label {
            font-weight: 100;
        }

        .form-control {
            height: 60px;
        }

    </style>
</head>
<body>
<div class="container">
    <form action="" method="post">
        <div class="row">
            <div class="col-lg-4 offset-lg-4 mt-5">
                <div class="text-center mb-5 p-0">
                    <a href="#"> <img src="<?= base_url() ?>assets/images/logo.png" style="margin-left: -10px"
                                      class="img-fluid"></a>
                </div>
                <h4 align="center" class="mb-4"> Student Login</h4>

                <input type="text" name="username" class="form-control mb-3" placeholder="Username">

                <input type="password" name="password" class="form-control" placeholder="Password">

                <input type="submit" value="Login" class="btn btn-primary btn-lg"
                       style="margin-top: 20px;border-radius: 0;background-color: #54DCED">


            </div>
        </div>
    </form>
</div>
</body>
</html>