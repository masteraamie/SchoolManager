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


        <form action="<?= base_url("FrontendController/payment_confirmation") ?>" method="post">
            <div class="row">

                <input name="amount" id="amount" type="hidden" class="form-control"><br>
                <input name="student" type="hidden" id="student" value="<?= $_SESSION['std_ID']; ?>"
                       class="form-control">
                <div class="box box-success" style="padding: 20px;">
                    <div class="box-header"><h3 class="box-title">Fee Payment for Academic Year <?= date("Y"); ?></h3>
                    </div>


                    <div class="box-body">

                        <div class="col-lg-12">

                            <br/>
                            <label>Student Name</label>
                            <input name="student2" disabled value="<?= $_SESSION['std_Name']; ?>" class="form-control">

                            <br/>

                            <label>Registration Number</label>
                            <input name="register" disabled value="<?= $_SESSION['std_username']; ?>"
                                   class="form-control">

                            <br/>
                            <label>Select Fee Category</label>
                            <select name="category" id="category" class="form-control">

                                <?php
                                echo '<option value="0">';
                                echo "Select a Fee Type";
                                echo "</option>";
                                if (isset($categories)) {

                                    foreach ($categories as $c) {
                                        echo '<option value="' . $c["CategoryID"] . '">';
                                        echo $c['Name'];
                                        echo "</option>";
                                    }
                                }

                                ?>

                            </select><br/>

                            <label>Fee Amount ( in Rupees )</label>

                            <input name="amount2" id="amount2" disabled type="text" class="form-control"><br>

                            <label>Fee For Year</label>
                            <input name="year2" disabled id="year2" class="form-control">
                            <input name="year" type="hidden" id="year" class="form-control">
                            <br/>


                            <label>Fee For Month</label>
                            <input name="month2" disabled id="month2" class="form-control">
                            <input name="month" type="hidden" id="month" class="form-control">
                            <br/>

                        </div>
                        <div class="col-lg-12">
                            <input type="submit" id="btn_pay" value="Pay Fee" class="btn btn-success pull-right">
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