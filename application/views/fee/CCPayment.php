<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | Fee</title>
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
            <form id="ccavenue" method="post" action="<?= site_url('PaymentController/confirm_payment') ?>">

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
    <!-- /.content-wrapper -->
    <?php
    $this->load->view('footer');
    $this->load->view('settings');
    ?>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="<?= base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>

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
<script>
    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
        //Money Euro
        $("[data-mask]").inputmask();

        //Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function (start, end) {
                $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
        );

        //Date picker
        $('#datepicker').datepicker({
            autoclose: true
        });

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });

        //Colorpicker
        $(".my-colorpicker1").colorpicker();
        //color picker with addon
        $(".my-colorpicker2").colorpicker();

        //Timepicker
        $(".timepicker").timepicker({
            showInputs: false
        });
    });
</script>
</body>
</html>
