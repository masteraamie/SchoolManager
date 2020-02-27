<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Welcome Admin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/datepicker/datepicker3.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/iCheck/all.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/colorpicker/bootstrap-colorpicker.min.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/select2/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>

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
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">


    <?php $this->load->view('sidebar'); ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Fee Payments
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Fee</a></li>
                <li class="active">Fee Payments</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- ERROR SUCCESS MESSAGES-->
            <div class="row mt-3">

                <div class="col-lg-12">


                </div>

            </div>
            <!-- ERROR SUCCESS MESSAGES-->


            <!--FORM-->
            <form method="post" action="">

                <div class="box box-success">
                    <div class="box-header hidden-print"><h3 class="box-title">Payment Receipts</h3></div>


                    <div class="box-body">
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
                            <div class="col-lg-12 mb-5 text-center">
                                <img class="img-fluid" src="<?= base_url("assets/assets/images/logo.png"); ?>">

                            </div>
                            <br/>

                            <div class="col-lg-12">
                                <div class="col-lg-12"><span class="pull-right"><b>Powered By : Elance Technologies Pvt Ltd</b></span>
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
                                <div style="margin-top: 5px" class="col-lg-12 mt-4 text-center">
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

                            </div>

                        </div>
                    </div>

                    <div class="box-footer">
                        <div class="col-lg-12">
                            <button class="btn btn-primary pull-right" onclick="window.print()">Print
                                Receipt
                            </button>
                        </div>
                    </div>
            </form>
            <!--FORM-->


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php
    $this->load->view('footer');
    $this->load->view('settings');
    ?>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="<?= base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="<?= base_url(); ?>assets/js/printReceipt.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?= base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="<?= base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
<!-- InputMask -->
<script src="<?= base_url(); ?>assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?= base_url(); ?>assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?= base_url(); ?>assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="<?= base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- bootstrap color picker -->
<script src="<?= base_url(); ?>assets/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="<?= base_url(); ?>assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="<?= base_url(); ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="<?= base_url(); ?>assets/plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="<?= base_url(); ?>assets/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url(); ?>assets/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url(); ?>assets/dist/js/demo.js"></script>
<!-- Page script -->

</body>
</html>
