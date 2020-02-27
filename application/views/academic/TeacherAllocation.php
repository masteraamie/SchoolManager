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
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">


    <?php $this->load->view('sidebar'); ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Allocate Form Teacher
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Academic</a></li>
                <li class="active">Allocate Form Teacher</li>
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
                        echo '<i class="fa fa-warning"></i> ' . $error;
                        echo '</p>';
                    }

                    if (isset($success)) {
                        echo '<p class="alert alert-success">';
                        echo '<i class="fa fa-check-circle"></i> Form Teacher allocated successfully';
                        echo '</p>';
                    }

                    ?>


                </div>

            </div>
            <!-- ERROR SUCCESS MESSAGES-->

            <!--FORM-->
            <form action="" method="post">
                <div class="row mt-4">

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


                        <label>Select Teacher</label>
                        <select name="teacher" class="form-control">

                            <?php

                            if (isset($teachers)) {
                                foreach ($teachers as $c) {
                                    echo '<option value="' . $c["EmployeeID"] . '">';
                                    echo $c['FirstName'] . " " . $c['MiddleName'] . " " . $c['LastName'];
                                    echo "</option>";
                                }
                            }

                            ?>

                        </select>

                    </div>

                    <div class="col-lg-6">

                        <label>Select Section</label>
                        <select id="section" name="section" class="form-control">

                        </select><br/>

                    </div>

                    <div class="col-lg-12 mt-3">

                        <input value="Allocate Teacher" type="submit" class="btn btn-success pull-right">

                    </div>
                </div>
            </form>
            <!--FORM-->


            <!--TABLE-->
            <div class="row">

                <div class="col-lg-12">


                    <?php
                    if (!empty($teacher_allocation)) { ?>

                        <table class="table table-striped mt-4">
                            <thead>
                            <tr>
                                <th>Class</th>
                                <th>Section</th>
                                <th>Teacher</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach ($teacher_allocation as $s) {
                                echo "<tr>";

                                echo "<td>";

                                foreach ($classes as $c) {
                                    if ($c['ClassID'] == $s['ClassID'])
                                        echo $c['Name'];
                                }
                                echo "</td>";

                                echo "<td>";
                                foreach ($sections as $c) {
                                    if ($c['SectionID'] == $s['SectionID'])
                                        echo $c['Name'];
                                }
                                echo "</td>";

                                echo "<td>";
                                foreach ($teachers as $c) {
                                    if ($c['EmployeeID'] == $s['TeacherID'])
                                        echo $c['FirstName'] . " " . $c['MiddleName'] . " " . $c['LastName'];
                                }
                                echo "</td>";


                                $url = site_url('AcademicController/delete_teacher_allocation/' . $s["ClassID"] . '/' . $s['SectionID'] . '/' . $s['TeacherID']);
                                echo '<td><a href="' . $url . '">';
                                echo '<i class="fa fa-remove"></i>';
                                echo "</a></td>";

                                echo "</tr>";
                            }

                            ?>
                            </tbody>
                        </table>

                    <?php } else {
                        echo "<tr>";
                        echo "No Teachers Allocated";
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
<script src="<?= base_url(); ?>assets/js/loadSections.js"></script>
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
