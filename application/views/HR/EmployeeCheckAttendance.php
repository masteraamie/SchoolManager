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

        .show_attendance {
            background-color: rgba(19, 19, 19, 0.73);
            width: 100%;
            height: 100%;
            position: fixed;
            z-index: 1000;
            display: none;
        }

        .table td {
            padding-left: 10px;
        }

    </style>


</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">


    <?php $this->load->view('sidebar'); ?>


    <div class="show_attendance">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <a href="javascript:void(0)" class="btn btn-warning pull-right close-btn"><span
                            class="fa fa-close"></span></a><br>
                <h2 id="get_mem" style="text-align: center;background-color: #ffffff;padding: 20px 0px 20px 0px"></h2>
                <table class="table table-responsive" style="background-color: #f8fff4">
                    <thead>
                    <tr>
                        <td>Date</td>
                        <td>Status</td>
                    </tr>
                    </thead>
                    <tbody id="attend">

                    </tbody>
                </table>
            </div>
            <div class="col-lg-3"></div>
        </div>
    </div>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Employee Attendance
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">HR</a></li>
                <li class="active">Employee Attendance</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- ERROR SUCCESS MESSAGES-->
            <div class="row mt-3">

                <div id="error" class="col-lg-12">


                </div>

            </div>
            <!-- ERROR SUCCESS MESSAGES-->

            <!--FORM-->
            <form action="" method="post" enctype="multipart/form-data">

                <?php
                $months = array('1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April',
                    '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November'
                , '12' => 'December');
                ?>

                <div class="col-lg-6">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="box box-primary">
                                <div class="box-heading"><h3 class="box-title"> Select Type</h3></div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="radio" id="daily" checked name="check"> Daily
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="radio" id="monthly" name="check"> Monthly
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="box box-primary">
                                <div class="box-heading"><h3 class="box-title"> Select Employee Details</h3></div>
                                <div class="box-body">

                                    <div class="col-lg-12">
                                        <label>Select Employee</label>
                                        <select id="employee" name="employee" class="form-control select2">
                                            <?php
                                            foreach ($employees as $k => $n) {
                                                echo "<option value='" . $n['EmployeeID'] . "'>";
                                                echo $n['FirstName'] . " " . $n['MiddleName'] . " " . $n['LastName'];
                                                echo "</option>";
                                            }
                                            ?>
                                        </select><br/><br/>
                                    </div>

                                    <div class="col-lg-12 daily">
                                        <label>Select Day</label>
                                        <select name="day" id="day" class="form-control">
                                            <?php
                                            for ($i = 1; $i < 31; $i++) {
                                                if ($i == date('d'))
                                                    echo "<option selected>";
                                                else
                                                    echo "<option>";

                                                echo $i;
                                                echo "</option>";
                                            }
                                            ?>
                                        </select><br/>
                                    </div>

                                    <div class="col-lg-12 monthly">
                                        <label>Select Month</label>
                                        <select name="month" id="month" class="form-control">
                                            <?php
                                            for ($i = 1; $i < 12; $i++) {
                                                if ($i == date('m'))
                                                    echo "<option value='$i' selected>";
                                                else
                                                    echo "<option value='$i'>";
                                                echo $months[$i];
                                                echo "</option>";
                                            }
                                            ?>
                                        </select><br/>
                                    </div>

                                    <div id="yearly" class="col-lg-12">
                                        <label>Select Year</label>
                                        <select name="year" id="year" class="form-control">
                                            <?php
                                            $y = date("Y");
                                            for ($i = 2016; $i <= $y; $i++) {
                                                if ($i == $y)
                                                    echo "<option selected>";
                                                else
                                                    echo "<option>";
                                                echo $i;
                                                echo "</option>";
                                            }
                                            ?>
                                        </select><br/>
                                    </div>

                                    <div class="col-lg-12">
                                        <input type="button" value="Get Details" id="get_det"
                                               class="btn btn-success pull-right">
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
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
<script src="<?= base_url(); ?>assets/js/getEmployeeAttendance.js"></script>
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
    });
</script>

</body>
</html>
