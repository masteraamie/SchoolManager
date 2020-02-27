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


    <link href="https://fonts.googleapis.com/css?family=Lato|Montserrat|Source+Sans+Pro" rel="stylesheet">


    <style>


        #achievements {
            font-family: "Montserrat", sans-serif;
        }

        #achievements h3 {
            font-size: 35px;
        }

        #achievements .col-lg-4 a {
            display: block;
        }

        #achievements .col-lg-4 p {
            font-family: "Lato", sans-serif;
            color: #3a3839;
        }

        #achievements .col-lg-4 img {
            width: 100%;
        }

        @media only print {
            @page {
                size: auto;   /* auto is the current printer page size */
                margin: 0mm;  /* this affects the margin in the printer settings */
            }

            button {
                display: none !important;
            }
        }

    </style>


</head>

<body>

<!--<div id="fb-root"></div>-->
<!--<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.8&appId=1847243852190281";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>-->


<?php
$this->load->view('frontend/header2');
?>


<div id="achievements">

    <div class="container">

        <!-- Main content -->
        <section class="content">


            <div class="col-lg-12">

                <?php

                $months = array(

                    1 => "January",
                    2 => "February",
                    3 => "March",
                    4 => "April",
                    5 => "May",
                    6 => "June",
                    7 => "July",
                    8 => "August",
                    9 => "September",
                    10 => "October",
                    11 => "November",
                    12 => "December",
                );

                ?>
                <div class="col-lg-12 text-center">
                    <img class="img-fluid" src="<?= base_url("assets/assets/images/logo.png"); ?>">
                </div>
                <br/>

                <div class="col-lg-12">
                    <div class="col-lg-12"><span
                                class="pull-right"><b>Powered By : Elance Technologies Pvt Ltd</b></span>
                    </div>
                    <table class="table table-bordered">
                        <tbody>

                        <tr>
                            <td colspan="2" style="text-align: center;font-weight: bold;font-size: 20px">
                                Student Copy
                            </td>
                        </tr>
                        <tr>
                            <td>Receipt ID <br/> <b><?= $payment[0]['ReceiptID']; ?></b></td>
                            <td>Dated<br/><b><?= $payment[0]['Date']; ?></b></td>
                        </tr>
                        <tr>
                            <td>Student ID <br/><b><?= $student[0]['RegistrationNumber']; ?></b></td>
                            <td>Student Name <br/>
                                <b><?= $student[0]['FirstName'] . " " . $student[0]['MiddleName'] . " " . $student[0]['LastName']; ?></b>
                            </td>
                        </tr>

                        <tr>
                            <td>Class<br/> <b><?php
                                    foreach ($classes as $s) {
                                        if ($s['ClassID'] == $payment[0]['ClassID'])
                                            echo $s['Name'];
                                    } ?></b></td>
                            <td>Section<br/> <b><?php
                                    foreach ($sections as $s) {
                                        if ($s['SectionID'] == $payment[0]['SectionID'])
                                            echo $s['Name'];
                                    } ?></b></td>
                        </tr>


                        <tr>
                            <td>Fee Type<br/> <b><?php

                                    foreach ($categories as $s) {
                                        if ($s['CategoryID'] == $payment[0]['CategoryID'])
                                            echo $s['Name'];
                                    }

                                    ?></b></td>
                            <td>Fee Amount<br/>
                                <b><?= $payment[0]['Amount'] - $payment[0]['LateFee']; ?></b></td>
                        </tr>

                        <tr>
                            <td>Fee Month<br/> <b><?= $months[$payment[0]['Month']]; ?></b></td>
                            <td>Fee Year<br/> <b><?= $payment[0]['Year']; ?></b></td>
                        </tr>

                        <tr>
                            <td>Late Fee (if any)<br/> <b><?= $payment[0]['LateFee']; ?></b></td>
                            <td>Total Amount<br/> <b><i
                                            class="fa fa-rupee"></i><?= $payment[0]['Amount']; ?></b></td>
                        </tr>


                        </tbody>
                    </table>


                    <div style="display:block; border: 0;border: 1px #000 solid;border-style: dashed"></div>
                    <div style="margin-top: 5px" class="col-lg-12 text-center">
                        <img class="img-fluid" src="<?= base_url("assets/assets/images/logo.png"); ?>">
                    </div>


                    <br/>
                    <table class="table table-bordered">
                        <tbody>

                        <tr>
                            <td colspan="2" style="text-align: center;font-weight: bold;font-size: 20px">
                                Office Copy
                            </td>
                        </tr>
                        <tr>
                            <td>Receipt ID <br/> <b><?= $payment[0]['ReceiptID']; ?></b></td>
                            <td>Dated<br/><b><?= $payment[0]['Date']; ?></b></td>
                        </tr>
                        <tr>
                            <td>Student ID <br/><b><?= $student[0]['RegistrationNumber']; ?></b></td>
                            <td>Student Name <br/>
                                <b><?= $student[0]['FirstName'] . " " . $student[0]['MiddleName'] . " " . $student[0]['LastName']; ?></b>
                            </td>
                        </tr>

                        <tr>
                            <td>Class<br/> <b><?php
                                    foreach ($classes as $s) {
                                        if ($s['ClassID'] == $payment[0]['ClassID'])
                                            echo $s['Name'];
                                    } ?></b></td>
                            <td>Section<br/> <b><?php
                                    foreach ($sections as $s) {
                                        if ($s['SectionID'] == $payment[0]['SectionID'])
                                            echo $s['Name'];
                                    } ?></b></td>
                        </tr>


                        <tr>
                            <td>Fee Type<br/> <b><?php

                                    foreach ($categories as $s) {
                                        if ($s['CategoryID'] == $payment[0]['CategoryID'])
                                            echo $s['Name'];
                                    }

                                    ?></b></td>
                            <td>Fee Amount<br/>
                                <b><?= $payment[0]['Amount'] - $payment[0]['LateFee']; ?></b></td>
                        </tr>

                        <tr>
                            <td>Fee Month<br/> <b><?= $months[$payment[0]['Month']]; ?></b></td>
                            <td>Fee Year<br/> <b><?= $payment[0]['Year']; ?></b></td>
                        </tr>

                        <tr>
                            <td>Late Fee (if any)<br/> <b><?= $payment[0]['LateFee']; ?></b></td>
                            <td>Total Amount<br/> <b><i
                                            class="fa fa-rupee"></i><?= $payment[0]['Amount']; ?></b></td>
                        </tr>


                        </tbody>
                    </table>
                    <button class="btn btn-primary pull-right" onclick="window.print()">Print
                        Receipt
                    </button>
                </div>


        </section>
        <!-- /.content -->
    </div>

</div>


<?php
$this->load->view("frontend/footer");
?>
<!--JAVASCRIPT-->
<script src="<?= base_url(); ?>assets/assets/js/jquery.js"></script>

<script src="<?= base_url(); ?>assets/js/feePayment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
        integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
        crossorigin="anonymous"></script>
<script src="<?= base_url(); ?>assets/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/scrollreveal.js/3.1.4/scrollreveal.min.js"></script>
<!--JAVASCRIPT-->

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