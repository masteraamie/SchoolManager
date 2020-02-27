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


    <?php $this->load->view('accountant_sidebar'); ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Fee Payment
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Fee</a></li>
                <li class="active">Fee Payment</li>
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

                    ?>


                </div>

            </div>
            <!-- ERROR SUCCESS MESSAGES-->

            <!--FORM-->
            <form action="<?= base_url("AccountantController/last_payment_confirmation") ?>" method="post">
                <div class="row mt-4">

                    <div class="box box-success">
                        <div class="box-header"><h3 class="box-title">Last Fee Payment</h3></div>

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


                        <div class="box-body">

                            <div class="col-lg-6">

                                <label>Select Student ( Registration Number )</label>
                                <select name="student" id="student" class="form-control select2">

                                    <?php

                                    if (isset($students)) {
                                        foreach ($students as $c) {
                                            echo '<option value="' . $c["StudentID"] . '">';
                                            echo $c['FirstName'] . " " . $c['MiddleName'] . " " . $c['LastName'];
                                            echo " ( " . $c['RegistrationNumber'] . " )";
                                            echo "</option>";
                                        }
                                    }

                                    ?>

                                </select><br/><br/>

                                <label>Select Fee Category</label>
                                <select name="category" id="category" class="form-control">

                                    <?php

                                    if (isset($categories)) {
                                        foreach ($categories as $c) {
                                            echo '<option value="' . $c["CategoryID"] . '">';
                                            echo $c['Name'];
                                            echo "</option>";
                                        }
                                    }

                                    ?>

                                </select><br/>

                                <label>Fee For Year</label>
                                <select name="year" class="form-control">
                                    <?php

                                    for ($i = 2016; $i <= date('Y'); $i++) {
                                        echo "<option value='" . $i . "'>";
                                        echo $i;
                                        echo "</option>";
                                    }

                                    ?>
                                </select>
                            </div>

                            <div class="col-lg-6">
                                <label>Fee Amount ( in Rupees )</label>
                                <input name="amount" id="amount" type="hidden" class="form-control"><br>
                                <input name="amount2" id="amount2" disabled type="text" class="form-control"><br>

                                <label>Fee For Month</label>
                                <select name="month" class="form-control">
                                    <?php

                                    foreach ($months as $k => $m) {
                                        echo "<option value='" . $k . "'>";
                                        echo $m;
                                        echo "</option>";
                                    }

                                    ?>
                                </select>
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


            <!--TABLE-->
            <div class="row">


            </div>
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
<script src="<?= base_url(); ?>assets/js/confirm.js"></script>

<script src="<?= base_url(); ?>assets/js/feePayment.js"></script>
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
<script>
    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

    });
</script>
</body>
</html>
