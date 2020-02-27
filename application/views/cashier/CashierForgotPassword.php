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
    <link href="https://fonts.googleapis.com/css?family=Lato|Montserrat|Source+Sans+Pro" rel="stylesheet">
    <style>

        body {
            font-family: "Montserrat", sans-serif;
            background-image: url("<?=base_url()?>assets/images/loginbg.jpg");
            background-size: cover;
        }

        .form-control {
            border-radius: 0;
        }
    </style>
</head>
<body>
<div class="container">
    <form action="" method="post">
        <div class="row">
            <div class="col-lg-4 offset-lg-4 mt-5" style="background-color: rgba(255,255,255,0.7);padding: 20px;">
                <div class="text-center mb-4 p-0">
                    <a href="#"> <img src="<?= base_url() ?>assets/images/logo.png" style="margin-left: -10px"></a>
                </div>
                <h4 align="center"> Cashier Login</h4>&nbsp;


                <!-- ERROR SUCCESS MESSAGES-->
                <div class="row mt-3">

                    <div class="col-lg-12">


                        <?php

                        $errors = validation_errors();

                        if ($errors) {
                            echo $errors;
                        }


                        ?>


                    </div>

                </div>
                <!-- ERROR SUCCESS MESSAGES-->

                <label>Enter Login ID</label>
                <input type="text" name="username" class="form-control">

                <input type="submit" value="Reset Password" class="btn btn-primary"
                       style="margin-top: 20px;border-radius: 0"><br/>


            </div>
        </div>
    </form>
</div>
<?php
$this->load->view("footer");
?>
</body>
</html>