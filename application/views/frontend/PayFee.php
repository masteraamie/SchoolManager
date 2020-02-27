<!DOCTYPE html>
<html lang="en">
<head>

    <!--[if IE]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <title>Srinagar British School</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="icon" type="image/png" href="<?= base_url(); ?>assets/assets/images/favicon.png">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/assets/css/master.css">

    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/select2/select2.min.css">

    <link href="https://fonts.googleapis.com/css?family=Lato|Montserrat|Source+Sans+Pro" rel="stylesheet">


    <style>

        #achievements {
            font-family: "Montserrat", sans-serif;
        }

        #achievements h3 {
            font-size: 35px;
        }

    </style>


</head>

<body>


<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.8&appId=1847243852190281";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>


<?php
$this->load->view('frontend/header');
?>


<div id="achievements">

    <div class="container">


        <form action="" method="post">
            <div class="row">

                <div class="box box-success" style="padding: 20px;">
                    <div class="box-header"><h3 class="box-title">Student Fee Payment</h3></div>


                    <div class="box-body">

                        <div class="col-lg-12">

                            <label>Student Login ID</label>
                            <input name="username" class="form-control">
                            <br/>

                            <label>Password</label>
                            <input name="password" autocomplete="OFF" type="password" class="form-control">
                            <br/>

                        </div>


                        <div class="col-lg-12">
                            <input type="submit" value="Pay Fee" class="btn btn-success pull-right">
                        </div>
                    </div>
                </div>
            </div>


        </form>
        <!--FORM-->
    </div>

</div>


<?php
$this->load->view("frontend/footer");
?>
<!--JAVASCRIPT-->
<script src="<?= base_url(); ?>assets/assets/js/jquery.js"></script>

<script src="<?= base_url(); ?>assets/js/feePayment.js"></script>
<script src="<?= base_url(); ?>assets/js/disable.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
        integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
        crossorigin="anonymous"></script>
<script src="<?= base_url(); ?>assets/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/scrollreveal.js/3.1.4/scrollreveal.min.js"></script>
<!--JAVASCRIPT-->
<script src="<?= base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();
    });
</script>
<script>


    $(document).ready(function () {


        /***
         * SCROLL ANIMATIONS
         * **/


        window.sr = ScrollReveal({reset: true});

        sr.reveal("#events .card .col-lg-4", {duration: 2000, origin: 'left'});
        sr.reveal("#events .card .col-lg-8", {duration: 2000, origin: 'left'});
        sr.reveal("#latest_visits .card", {duration: 2000, origin: 'left'});
        /***
         * SCROLL ANIMATIONS
         * **/


    });


</script>


</body>

</html>