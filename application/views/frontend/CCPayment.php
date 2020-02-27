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
$this->load->view('frontend/header');
?>


<div id="achievements" class="pb-5">

    <div class="container">

        <!-- Main content -->
        <section class="content">
            <!-- ERROR SUCCESS MESSAGES-->
            <div class="row mt-3">

                <div class="col-lg-12">
                    <?php


                    $errors = validation_errors();

                    if ($errors) {
                        echo $errors;
                    }

                    else
                    {
                    if (isset($success)) {
                        echo '<p class="alert alert-success">';
                        echo '<i class="fa fa-check-circle"></i> Fee Payment Created Successfully . Your Receipt ID is : ' . $receipt;
                        echo '</p>';
                    }

                    ?>

                </div>

            </div>
            <!-- ERROR SUCCESS MESSAGES-->


            <!--FORM-->
            <form id="ccavenue" method="post" action="<?= site_url('FrontendController/cc_avenue_payment') ?>">

                <div class="box box-success">
                    <div class="box-header"><h3 class="box-title">Payment Details</h3></div>


                    <div class="box-body">
                        <div class="col-lg-6">

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


                            <table class="table table-bordered">
                                <tbody>

                                <tr>
                                    <td>Receipt ID <br/> <b><?= $receipt; ?></b></td>
                                    <td>Dated<br/><b><?= $payment['Date']; ?></b></td>
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
                                                if ($s['ClassID'] == $payment['ClassID'])
                                                    echo $s['Name'];
                                            } ?></b></td>
                                    <td>Section<br/> <b><?php
                                            foreach ($sections as $s) {
                                                if ($s['SectionID'] == $payment['SectionID'])
                                                    echo $s['Name'];
                                            } ?></b></td>
                                </tr>


                                <tr>
                                    <td>Fee Type<br/> <b><?php

                                            foreach ($categories as $s) {
                                                if ($s['CategoryID'] == $payment['CategoryID'])
                                                    echo $s['Name'];
                                            }

                                            ?></b></td>
                                    <td>Fee Amount<br/>
                                        <b><?= $payment['Amount'] - $payment['LateFee']; ?></b></td>
                                </tr>

                                <tr>
                                    <td>Fee Month<br/> <b><?= $months[$payment['Month']]; ?></b></td>
                                    <td>Fee Year<br/> <b><?= $payment['Year']; ?></b></td>
                                </tr>

                                <tr>
                                    <td>Late Fee (if any)<br/> <b><?= $payment['LateFee']; ?></b></td>
                                    <td>Total Amount<br/> <b><i
                                                    class="fa fa-rupee"></i><?= $payment['Amount']; ?></b></td>
                                </tr>


                                </tbody>
                            </table>

                            <input type=hidden name="merchant_id" value="<?= $Merchant_Id ?>">
                            <input type="hidden" name="amount" value="<?= $total ?>">
                            <input type="hidden" name="order_id" value="<?= $Order_Id ?>">
                            <input type="hidden" name="redirect_url" value="<?php echo $Redirect_Url; ?>">
                            <input type="hidden" name="TxnType" value="A">
                            <input type="hidden" name="actionID" value="TXN">
                            <input type="hidden" name="Checksum" value="<?php echo $Checksum; ?>">
                            <input type="hidden" name="billing_name"
                                   value="<?= $student[0]['FirstName'] . " " . $student[0]['MiddleName'] . " " . $student[0]['LastName'] ?>">
                            <input type="hidden" name="billing_address" value="<?= $student[0]['Address']; ?>"/>
                            <input type="hidden" name="billing_tel" value="<?= $student[0]['Contact']; ?>"/>
                            <input type="hidden" name="billing_email" value="<?= $student[0]['Email']; ?>"/>
                            <input type="hidden" name="currency" value="INR">
                            <input type="submit" class="btn btn-primary pull-right" value="Pay Now"/>
                        </div>
                    </div>
            </form>
            <!--FORM-->


            <?php

            }
            ?>
            <!--TABLE-->

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