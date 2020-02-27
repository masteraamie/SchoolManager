<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | Dashboard</title>
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


    <style>

        #time_table {
            background-color: rgba(19, 19, 19, 0.73);
            width: 130%;
            height: 100%;
            position: fixed;
            z-index: 1000;
            display: none;
        }

    </style>


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


    <div id="time_table">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <a href="javascript:void(0)" class="btn btn-danger pull-right close-btn" id="close_btn"><span
                            class="fa fa-close"></span></a><br>
                <h2 id="day" style="text-align: center;background-color: #ffffff;padding: 20px 0px 20px 0px"></h2>
                <table id="table2excel" class="table table-responsive" style="background-color: #f8fff4">
                    <thead>
                    <tr>
                        <td>Subject</td>
                        <td>Teacher</td>
                        <td>Start Time</td>
                        <td>End Time</td>
                    </tr>
                    </thead>
                    <tbody id="periods">

                    <tr id="period" class="noExl">
                        <td><select id="subject" class="form-control">
                                <?php
                                if (isset($subjects)) {
                                    foreach ($subjects as $c) {
                                        echo '<option value="' . $c["SubjectID"] . '">';
                                        echo $c['Name'];
                                        echo "</option>";
                                    }
                                }
                                ?>
                            </select></td>


                        <td><select id="teacher" class="form-control">
                                <?php
                                if (isset($teachers)) {
                                    foreach ($teachers as $c) {
                                        echo '<option value="' . $c["EmployeeID"] . '">';
                                        echo $c['FirstName'] . " " . $c['MiddleName'] . " " . $c['LastName'];
                                        echo "</option>";
                                    }
                                }
                                ?>
                            </select></td>

                        <td class="noExl">
                            <input id="start_time" type="time" class="form-control">
                        </td>

                        <td class="noExl">
                            <input id="end_time" type="time" class="form-control">
                        </td>

                        <td class="noExl">

                            <input id="set" type="button" class="btn btn-success" value="Set or Update">

                        </td>
                    </tr>

                    </tbody>
                </table>
                <button id="export" class="btn btn-primary pull-right">Export</button>
            </div>
            <div class="col-lg-3"></div>
        </div>
    </div>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Manage Time Table
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Academic</a></li>
                <li class="active">Manage Time Table</li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content">


            <!-- ERROR SUCCESS MESSAGES-->
            <div class="row mt-3">

                <div class="col-lg-12">


                    <?php


                    /*$errors = validation_errors();

                    if($errors) {
                        echo $errors;
                    }

                    if(isset($error)) {
                        echo '<p class="alert alert-danger">';
                        echo '<i class="fa fa-warning"></i> '.$error;
                        echo  '</p>';
                    }

                    if(isset($success))
                    {
                        echo '<p class="alert alert-success">';
                        echo '<i class="fa fa-check-circle"></i> Form Teacher allocated successfully';
                        echo  '</p>';
                    }*/

                    ?>


                </div>

            </div>
            <!-- ERROR SUCCESS MESSAGES-->

            <!--FORM-->
            <form action="" method="post">
                <div class="row mt-4">

                    <div class="box box-success">
                        <div class="box-header"><h3 class="box-title">Time Table Details</h3></div>


                        <div class="box-body">

                            <div class="col-lg-6">

                                <label>Select Class</label>
                                <select id="class" name="class" class="form-control">

                                    <?php

                                    if (isset($classes)) {
                                        foreach ($classes as $c) {
                                            echo '<option value="' . $c["ClassID"] . '">';
                                            echo $c['Name'];
                                            echo "</option>";
                                        }
                                    }

                                    ?>

                                </select><br>


                            </div>

                            <div class="col-lg-6">

                                <label>Select Section</label>
                                <select id="section" name="section" class="form-control">

                                </select><br/>

                            </div>

                            <div class="col-lg-12 mt-3">

                                <input value="Get Week Days" id="get_days" type="button"
                                       class="btn btn-success pull-right">

                            </div>

                        </div>
                    </div>
                </div>
            </form>
            <!--FORM-->


            <!--TABLE-->
            <div class="row" id="days">

                <div class="col-lg-12">


                    <table class="table table-striped mt-4">
                        <thead>
                        <tr>
                            <th>Week Day</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td>Monday</td>
                            <td><a id="monday">Assign/View/Update</a></td>
                        </tr>

                        <tr>
                            <td>Tuesday</td>
                            <td><a id="tuesday">Assign/View/Update</a></td>
                        </tr>

                        <tr>
                            <td>Wednesday</td>
                            <td><a id="wednesday">Assign/View/Update</a></td>
                        </tr>

                        <tr>
                            <td>Thursday</td>
                            <td><a id="thursday">Assign/View/Update</a></td>
                        </tr>

                        <tr>
                            <td>Friday</td>
                            <td><a id="friday">Assign/View/Update</a></td>
                        </tr>

                        <tr>
                            <td>Saturday</td>
                            <td><a id="saturday">Assign/View/Update</a></td>
                        </tr>

                        <tr>
                            <td>Sunday</td>
                            <td><a id="sunday">Assign/View/Update</a></td>
                        </tr>

                        </tbody>
                    </table>

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
<script src="<?= base_url(); ?>assets/js/loadSections.js"></script>
<script src="<?= base_url(); ?>assets/js/timeTable.js"></script>
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
<script src="<?= base_url(); ?>assets/tableExport/dist/jquery.table2excel.js"></script>

<!-- Page script -->
<script>

    $("#export").click(function () {

        $("#table2excel").table2excel({
            exclude: ".noExl",
            name: "Excel Document Name",
            filename: "timetable",
            fileext: ".xls",
            exclude_img: true,
            exclude_links: true,
            exclude_inputs: true
        });

    });


</script>
<!-- Page script -->
<script>
    $(function () {
        //Timepicker
        $(".timepicker").timepicker({
            showInputs: false
        });
    });
</script>
</body>
</html>
