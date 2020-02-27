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
                Fee Allocation
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Fee</a></li>
                <li class="active">Fee Allocation</li>
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

                    if (isset($error)) {
                        echo '<p class="alert alert-danger">';
                        echo '<i class="fa fa-warning"></i> Fee for this class already allocated';
                        echo '</p>';
                    }

                    if (isset($success)) {
                        echo '<p class="alert alert-success">';
                        echo '<i class="fa fa-check-circle"></i> Fee Allocation added successfully';
                        echo '</p>';
                    }

                    ?>


                </div>

            </div>
            <!-- ERROR SUCCESS MESSAGES-->

            <!--FORM-->
            <form action="" method="post">
                <div class="row mt-4">

                    <div class="box box-success">
                        <div class="box-header"><h3 class="box-title">Fee Allocation Details</h3></div>


                        <div class="box-body">

                            <div class="col-lg-6">

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

                                <label>Fee Amount ( in Rupees )</label>
                                <input name="amount" id="amount" type="text" class="form-control"><br>
                            </div>
                            <div class="col-lg-6">
                                <label id="lbl_select">Select Class</label>
                                <select name="class" id="selection" class="form-control select2">

                                    <?php

                                    if (isset($classes)) {
                                        foreach ($classes as $c) {
                                            echo '<option value="' . $c["ClassID"] . '">';
                                            echo $c['Name'];
                                            echo "</option>";
                                        }
                                    }

                                    ?>

                                </select><br/><br/>


                                <label>Select Type</label>
                                <select name="type" id="type" class="form-control">
                                    <option>Monthly</option>
                                    <option>Yearly</option>
                                </select>


                            </div>

                            <div class="col-lg-12">
                                <input type="button" id="btn_allocate" value="Allocate or Update Fee"
                                       class="btn btn-success pull-right">


                            </div>
                        </div>
                    </div>
                </div>


            </form>
            <!--FORM-->


            <!--TABLE-->
            <div class="row">

                <div class="col-lg-12">

                    <label class="form-control">General Fees</label>
                    <?php
                    if (!empty($allocations)) { ?>

                        <table class="table table-striped mt-4">
                            <thead>
                            <tr>
                                <th>Fee Category</th>
                                <th>Class</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach ($allocations as $c) {
                                echo "<tr>";

                                echo "<td>";
                                foreach ($categories as $s) {
                                    if ($c['CategoryID'] == $s['CategoryID'])
                                        echo $s['Name'];
                                }
                                echo "</td>";

                                echo "<td>";
                                foreach ($classes as $s) {
                                    if ($c['ClassID'] == $s['ClassID'])
                                        echo $s['Name'];
                                }
                                echo "</td>";

                                echo "<td>";
                                echo $c['Amount'];
                                echo "</td>";


                                echo "<td>";
                                echo $c['Type'];
                                echo "</td>";


                                $url = site_url('FeeController/delete_fee_allocate/' . $c["ClassID"]);
                                echo '<td><a name="remove" href="' . $url . '">';
                                echo '<i class="fa fa-remove"></i>';
                                echo "</a></td>";


                                echo "</tr>";
                            }

                            ?>
                            </tbody>
                        </table>

                    <?php } else {
                        echo "<tr>";
                        echo "No Fee Allocations created";
                        echo "</tr>";
                    }
                    ?>
                    <label class="form-control">Bus Fees</label>

                    <?php
                    if (!empty($bus_allocations)) { ?>

                        <table class="table table-striped mt-4">
                            <thead>
                            <tr>
                                <th>Fee Category</th>
                                <th>Stop</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach ($bus_allocations as $c) {
                                echo "<tr>";

                                echo "<td>";
                                foreach ($categories as $s) {
                                    if ($c['CategoryID'] == $s['CategoryID'])
                                        echo $s['Name'];
                                }
                                echo "</td>";

                                echo "<td>";
                                foreach ($stops as $s) {
                                    if ($c['StopID'] == $s['StopID'])
                                        echo $s['Name'];
                                }
                                echo "</td>";

                                echo "<td>";
                                echo $c['Amount'];
                                echo "</td>";


                                echo "<td>";
                                echo $c['Type'];
                                echo "</td>";


                                $url = site_url('FeeController/delete_fee_allocate/' . $c["StopID"]);
                                echo '<td><a name="remove" href="' . $url . '">';
                                echo '<i class="fa fa-remove"></i>';
                                echo "</a></td>";


                                echo "</tr>";
                            }

                            ?>
                            </tbody>
                        </table>

                    <?php } else {
                        echo "<tr>";
                        echo "No Fee Allocations created";
                        echo "</tr>";
                    }
                    ?>

                </div>

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

<script>

    var classes = <?php

        $count = count($classes);
        $i = 0;
        foreach ($classes as $c) {
            if ($i == 0) {
                echo "[" . $c['ClassID'] . ",";

            } else if ($i == $count - 1) {
                echo $c['ClassID'];
            } else {
                echo $c['ClassID'] . ",";
            }
            $i++;
        }

        echo "]"

        ?>;

    var classNames = <?php

        $count = count($classes);
        $i = 0;
        foreach ($classes as $c) {
            if ($i == 0) {
                echo "['" . $c['Name'] . "',";

            } else if ($i == $count - 1) {
                echo "'" . $c['Name'] . "'";
            } else {
                echo "'" . $c['Name'] . "',";
            }
            $i++;
        }

        echo "]"

        ?>;


    var stops = <?php

        $count = count($stops);
        $i = 0;
        foreach ($stops as $c) {
            if ($i == 0) {
                echo "[" . $c['StopID'] . ",";

            } else if ($i == $count - 1) {
                echo $c['StopID'];
            } else {
                echo $c['StopID'] . ",";
            }
            $i++;
        }

        echo "]"

        ?>;

    var stopNames = <?php

        $count = count($stops);
        $i = 0;
        foreach ($stops as $c) {
            if ($i == 0) {
                echo "['" . $c['Name'] . "',";

            } else if ($i == $count - 1) {
                echo "'" . $c['Name'] . "'";
            } else {
                echo "'" . $c['Name'] . "',";
            }
            $i++;
        }

        echo "]"

        ?>;


</script>


<script src="<?= base_url(); ?>assets/js/feeAllocate.js"></script>
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
<script>
    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

    });
</script>
</body>
</html>
